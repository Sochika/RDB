<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeatOperative extends Model
{
  use HasFactory;

  protected $table = 'staff_beat';

  public function staff()
  {
    return $this->belongsToMany(Staff::class, 'staff_id');
  }
  public function beatBranch()
  {
    return $this->belongsToMany(BeatBranch::class, 'beat_branch_id');
  }

  // Additional methods or relationships can be defined here
}
