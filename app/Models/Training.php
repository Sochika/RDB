<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'trainer',
        'location',
        'link',
        'for',
        'start_date',
        'end_date',
    ];

    // Additional methods or relationships can be defined here
}
