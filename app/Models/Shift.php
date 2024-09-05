<?php

// app/Models/Shift.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
  use HasFactory;

  protected $table = 'shifts';

  protected $fillable = [
    'staff_id',
    'beat_id',
    'shift_start',
    'beat_branch_id',
    'shift_start',
    'shift_end',
    'shift_on',
    'shift_type_id',
    'shift_date_start',
    'main_assign',
    'expires',
  ];

  public function staff()
  {
    return $this->belongsTo(Staff::class, 'staff_id');
  }

  // public function beat()
  // {
  //   return $this->belongsTo(Beat::class, 'beat_id');
  // }

  // public function shiftType()
  // {
  //   return $this->belongsTo(ShiftType::class, 'shift_type_id');
  // }

  public function beat()
  {
    return $this->belongsTo(Beat::class);
  }

  public function beatBranch()
  {
    return $this->belongsTo(BeatBranch::class);
  }


  public function shiftType()
  {
    return $this->belongsTo(ShiftType::class);
  }
  public function scopeWithNoExpires($query)
  {
    return $query->whereNull('expires');
  }
}
