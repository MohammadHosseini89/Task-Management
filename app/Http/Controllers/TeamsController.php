<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MyTeams;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    public function assignUserToTeam(Request $request)
    {
        $team_id = $request->input('team');


        if (strlen($request->input('new_team_name')) >= 2) {
            $team = $request->input('new_team_name');
        } else {
            $team = $request->input('team');
        }

        if (strlen($request->input('new_position_name')) >= 2) {
            $position = $request->input('new_position_name');
        } else {
            $position = $request->input('position');
        }

        $user = User::findOrFail($request->input('user'));



        if ($user) {
            // Check if the team exists for the user
            $teamupdate = MyTeams::where('user_id', $user->id)->first();

            if ($teamupdate) {

                // Update the existing team
                if ($team !== 'new_team') {
                    $teamupdate->team_name = $team;
                }
                if ($position !== 'new_position') {
                    $teamupdate->position_name = $position;
                }
                $teamupdate->updated_at = now();
                $teamupdate->save();
            } else {
                // Create a new team
                if ($team !== 'new_team' && $position !== 'new_position') {
                    $team = new MyTeams;
                    $team->team_name = $team;
                    $team->position_name = $position;
                    $team->email = $user->email;
                    $team->user_id = $user->id;
                    $team->created_at = now();
                    $team->updated_at = now();
                    $team->save();
                }
            }
        }

        return redirect()->back()->with('success', 'User assigned to team successfully.');
    }
}
