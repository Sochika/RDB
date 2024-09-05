<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalSettings extends Model
{
  protected $table = 'settings';

  protected $fillable = [
    'title', 'value', 'user_id',
  ];

  // Define relationships or additional methods as needed
}
