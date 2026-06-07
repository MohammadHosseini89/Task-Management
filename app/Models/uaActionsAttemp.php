<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class uaActionsAttemp extends Model
{
    use HasFactory;

    protected $fillable = [
        'action',
        'user_name',
        'email',
    ];

    
}
