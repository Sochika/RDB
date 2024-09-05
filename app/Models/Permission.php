<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
  protected $fillable = ['name'];
  protected $table = 'permissions_u';

  public function offices()
  {
    return $this->belongsToMany(Office::class);
  }
}
