<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUnauthorizedHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'route_name',
        'email',
        'ip_address',
        'session_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function logUserUnauthorizedHistory(User $user, $ipAddress, $sessionId, $uaroute)
    {
        $logUserUnauthorizedHistory = new static;
        $logUserUnauthorizedHistory->user_id = $user->id;
        $logUserUnauthorizedHistory->user_name = $user->name;
        $logUserUnauthorizedHistory->email = $user->email;
        $logUserUnauthorizedHistory->ip_address = $ipAddress;
        $logUserUnauthorizedHistory->session_id = $sessionId;
        $logUserUnauthorizedHistory->route_name = $uaroute;
        $logUserUnauthorizedHistory->save();
    }
}
