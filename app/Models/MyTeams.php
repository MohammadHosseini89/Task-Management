<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MyTeams extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_name',
        'email',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function asssignusertoteam(User $user, $team_name, $position)
    {
        $asssignusertoteam = new static;
        $asssignusertoteam->team_name = $team_name;
        $asssignusertoteam->position_name = $position;
        $asssignusertoteam->user_id = $user->id;
        $asssignusertoteam->email = $user->email;
        $asssignusertoteam->save();
    }
}
