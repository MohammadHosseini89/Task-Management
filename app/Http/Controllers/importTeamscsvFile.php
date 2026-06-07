<?php

namespace App\Http\Controllers;

use App\Models\User;
use League\Csv\Reader;
use App\Models\MyTeams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class importTeamscsvFile extends Controller
{

    public function import(Request $request)
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

        // Loop through each row and insert or update the data into the MyTeams model regarding to User
        foreach ($csv as $row) {
            // Find the user associated with the email
            $user = User::where('email', $row['email'])->first();

            if ($user) {
                // Check if the team exists for the user
                $team = MyTeams::where('user_id', $user->id)->first();

                if ($team) {
                    // Update the existing team
                    $team->team_name = $row['team'];
                    $team->position_name = $row['position'];
                    if (strlen($row['create_access']) >= 2) {
                        $team->raisedby_access = $row['create_access'];
                    }
                    $team->updated_at = now();
                    $team->save();
                } else {
                    // Create a new team
                    $team = new MyTeams;
                    $team->team_name = $row['team'];
                    $team->position_name = $row['position'];
                    if (strlen($row['create_access']) >= 2) {
                        $team->raisedby_access = $row['create_access'];
                    }
                    $team->email = $row['email'];
                    $team->user_id = $user->id;
                    $team->created_at = now();
                    $team->updated_at = now();
                    $team->save();
                }
            } else {
                // If the user does not exist, do not create the team
                continue;
            }
        }

        return back()->with('success', 'CSV file uploaded to DB Successfully.');
    }
}
