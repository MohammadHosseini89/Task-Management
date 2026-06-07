<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagsForRaisedby extends Model
{
    use HasFactory;
    protected $fillable = [
        'raisedby_tags',
    ];
    
}
