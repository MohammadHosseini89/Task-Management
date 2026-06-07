<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'storage_path',
        'file_extension',
        'user_name',
        'email',
        'attached_in',
    ];
    
    
}
