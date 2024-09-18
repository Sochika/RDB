<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
  protected $fillable = ['name', 'level', 'description'];

  protected $table = 'offices';
  public function users()
  {
    return $this->belongsToMany(User::class);
  }

  public function permissions()
  {
    return $this->belongsToMany(Permission::class);
  }
}
