<?php

namespace App\Http\Livewire;

use App\Models\MyTeams;
use App\Models\User;
use Livewire\Component;

class TeamsAssignComponent extends Component
{
    public function render()
    {
        $users = User::all();
        $teams = MyTeams::all();
        
        return view('livewire.teams-assign-component', [
            'users' => $users,
            'teams' => $teams,
        ]);
    }
}
