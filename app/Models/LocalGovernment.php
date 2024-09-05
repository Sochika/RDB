<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalGovernment extends Model
{
  use HasFactory;
  protected $table = 'local_governments';

  protected $fillable = ['state_id', 'name'];

  public function state()
  {
    return $this->belongsTo(States::class);
  }
}
