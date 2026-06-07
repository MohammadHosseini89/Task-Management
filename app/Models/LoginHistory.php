<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoginHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'login_time',
        'ip_address',
        'session_id',
        'logout_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function logLoginHistory(User $user, $ipAddress, $sessionId)
    {
        $loginHistory = new static;
        $loginHistory->user_id = $user->id;
        $loginHistory->login_time = now();
        $loginHistory->ip_address = $ipAddress;
        $loginHistory->session_id = $sessionId;
        $loginHistory->save();
    }
    
}
