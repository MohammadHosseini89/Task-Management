<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ViewTasksLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'observe_that',
        'user_id',
        'user_name',
        'email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public static function logUserObserveTask(User $user , $observe_that)
    {
        $logUserObserveTask = new static;
        $logUserObserveTask->$observe_that;
        $logUserObserveTask->user_id = $user->id;
        $logUserObserveTask->user_name = $user->name;
        $logUserObserveTask->email = $user->email;
        $logUserObserveTask->save();
    }
}
