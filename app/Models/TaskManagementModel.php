<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskManagementModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'fail_label_for_system',
        'success_label_for_system',
        'uuid',
        'is_cancel',
        'is_complete',
        'is_fail',
        'is_success',
        'searchable',
        'user_id',
        'creator',
        'current_status',
        'label_for_system',
        'label_for_system2',
        'pending_for',
        'visibletousers',
        'visibletoteams',
        'createdbyteam',
        'raisedbyuser',
        'issue',
        'impact',
        'rc',
        'solution',
        'solution2',
        'solution3',
        'latest_update',
        'due_date',
        'progress',
        'owner',
        'current_processor',
        'owner_team',
        'support',
        'description',
        'feedback',
        'priority',
        'complete_description',
        'cancel_description',
        'fail_description',
        'complete_date',
        'cancel_date',
        'fail_date',
        'string_reserve1',
        'string_reserve2',
        'string_reserve3',
        'string_reserve4',
        'string_reserve5',
        'string_reserve6',
        'string_reserve7',
        'string_reserve8',
        'string_reserve9',
        'string_reserve10',
        'text_reserve1',
        'text_reserve2',
        'text_reserve3',
        'text_reserve4',
        'text_reserve5',
        'text_reserve6',
        'text_reserve7',
        'text_reserve8',
        'text_reserve9',
        'text_reserve10',        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(MyTeams::class);
    }
}
