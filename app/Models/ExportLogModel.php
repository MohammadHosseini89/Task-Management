<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExportLogModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'email',
        'export_type',
        'session_id',
        'file_name_export',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function LogUserExportCSV($task_management_model_id, User $user, $export_type, $sessionId, $file_name_export)
    {
        $logUserExportCSVHistory = new static;
        $logUserExportCSVHistory->task_management_model_id = $task_management_model_id;
        $logUserExportCSVHistory->user_id = $user->id;
        $logUserExportCSVHistory->user_name = $user->name;
        $logUserExportCSVHistory->email = $user->email;
        $logUserExportCSVHistory->export_type = $export_type;
        $logUserExportCSVHistory->session_id = $sessionId;
        $logUserExportCSVHistory->file_name_export = $file_name_export;
        $logUserExportCSVHistory->save();
    }
}
