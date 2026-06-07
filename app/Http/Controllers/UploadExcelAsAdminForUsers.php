<?php

namespace App\Http\Controllers;

use App\Models\User;
use League\Csv\Reader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UploadExcelAsAdminForUsers extends Controller
{
    public function userupload(Request $request)
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
            try {
                $user = new User;
                $user->name = $row['name'];
                $user->email = $row['email'];
                $user->phone = $row['phone'];
                $user->status = 'active';
                $user->jobid = $row['jobid'];
                $user->is_superuser = $row['is_superuser'];
                $user->route1 = $row['route1'];
                $user->route2 = $row['route2'];
                $user->route3 = $row['route3'];
                $user->route4 = $row['route4'];
                $user->route5 = $row['route5'];
                $user->route6 = $row['route6'];
                $user->route7 = $row['route7'];
                $user->route9 = $row['route9'];
                $user->route10 = $row['route10'];
                $user->route11 = $row['route11'];
                $user->route12 = $row['route12'];
                $user->route13 = $row['route13'];
                $user->route14 = $row['route14'];
                $user->route15 = $row['route15'];
                $user->route16 = $row['route16'];
                $user->route17 = $row['route17'];
                $user->route18 = $row['route18'];
                $user->is_reserve1 = $row['is_reserve1'];
                $user->is_reserve2 = $row['is_reserve2'];
                $user->is_reserve3 = $row['is_reserve3'];
                $user->is_reserve4 = $row['is_reserve4'];
                $user->is_reserve5 = $row['is_reserve5'];
                $user->is_reserve6 = $row['is_reserve6'];
                $user->is_reserve7 = $row['is_reserve7'];
                $user->is_reserve8 = $row['is_reserve8'];
                $user->is_reserve9 = $row['is_reserve9'];
                $user->is_reserve10 = $row['is_reserve10'];
                $user->string_reserve1 = $row['string_reserve1'];
                $user->string_reserve2 = $row['string_reserve2'];
                $user->string_reserve3 = $row['string_reserve3'];
                $user->string_reserve4 = $row['string_reserve4'];
                $user->string_reserve5 = $row['string_reserve5'];
                $user->email_verified_at = $row['email_verified_at'] === 'NULL' ? null : $row['email_verified_at'];
                $user->password = Hash::make($row['password']);
                $user->remember_token = $row['remember_token'];
                $user->created_at = now();
                $user->updated_at = now();
                $user->save();
            } catch (\Illuminate\Database\QueryException $ex) {
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
            Storage::putFileAs('csv', $file, 'users.csv');
        // Redirect back with a success message
        return back()->with('success', 'CSV file uploaded to DB Successfully.');
    }
}
