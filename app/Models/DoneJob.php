<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoneJob extends Model
{
    use HasFactory;
    protected $fillable = [
        'jobname',
        'status',
    ];
}
