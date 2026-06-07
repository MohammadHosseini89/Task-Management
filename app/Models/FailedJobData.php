<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedJobData extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'connection',
        'queue',
        'payload',
        'exception',
        'failed_at',
    ];
}
