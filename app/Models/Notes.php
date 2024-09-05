<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
  use HasFactory;
  protected $table = 'user_notes';

  protected $dates = [

    'created_at',

  ];

  protected $fillable = [
    'user_id',
    'office_id',
    'lead_id',
    'recruit_id',
    'num_operatives',
    'amount',
    'note',
    'onboard',
  ];
}
