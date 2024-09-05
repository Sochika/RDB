<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  use HasFactory;

  protected $table = 'roles';
  protected $fillable = [
    'name',
    'description',
    'guard_name',
    'salary',
    'level'
    // other designation-related fields
  ];

  public function staff()
  {
    return $this->hasMany(Staff::class);
  }
}
