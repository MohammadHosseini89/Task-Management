<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'done_or_not',
    ];
}
