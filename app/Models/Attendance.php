<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use App\Models\Staff;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

  use HasFactory;
  protected $table = 'attendances';

  protected $fillable = [
    'staff_id',
    'attendance_date',
    'clock_in_time',
    'clock_out_time',
    'comment',
    'status',
    'minutes_of_lateness',
    'created_by'
  ];

  // public function beatBranch()
  // {
  //   return $this->belongsTo(Staff::class);
  // }


  public function staff()
  {
    return $this->belongsTo(Staff::class);
  }
  // Define relationships or additional methods as needed
}
