<?php

namespace App\Http\Controllers;

use League\Csv\Reader;
use Illuminate\Http\Request;
use App\Models\TagsForRaisedby;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class UploadExcelAsAdminForRaisedBy extends Controller
{
    public function raisedbyupload(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        // Get the uploaded file
        $file = $request->file('csv_file');

        // Read the CSV file using League\Csv\Reader
        $csv = Reader::createFromPath($file->getPathname(), 'r');
        $csv->setHeaderOffset(0);

        $headers = $csv->getHeader();

        // Loop through each row and insert the data into the User model
        foreach ($csv as $row) {
            $existed_raisedby = TagsForRaisedby::where('raisedby_tags', $row['raisedbytags'])->first();
            
            if (!$existed_raisedby) {
                try {
                    $raisedby_new = new TagsForRaisedby();
                    $raisedby_new->raisedby_tags = $row['raisedbytags'];
                    $raisedby_new->created_at = now();
                    $raisedby_new->updated_at = now();
                    $raisedby_new->save();
                } catch (QueryException $ex) {
                    // Check if the exception was caused by a duplicate entry error
                    if ($ex->errorInfo[1] == 1062) {
                        // Handle the duplicate entry error here (e.g. log an error message)
                        continue; // Move on to the next user
                    } else {
                        // Rethrow the exception if it was caused by some other error
                        throw $ex;
                    }
                }
            }
        }
        Storage::putFileAs('csv', $file, 'Raisedby.csv');
        // Redirect back with a success message
        return back()->with('success', 'CSV file uploaded to DB Successfully.');
    }
}
