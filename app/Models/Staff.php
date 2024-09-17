<?php

namespace App\Models;

// use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\ExcludeDeletedScope;

class Staff extends Model
{
  use HasFactory;

  protected $table = 'staff';

  protected $dates = [
    'hire_date',
    'created_at',
    'deleted_at'
  ];

  protected $fillable = [
    'user_id',
    'first_name',
    'middle_name',
    'last_name',
    'avatar',
    'email',
    'phone_number',
    'staff_no',
    'date_of_birth',
    'address',
    'area',
    'city',
    'state',
    'country',
    'latitude',
    'longitude',
    'role_id',
    'department_id',
    'beat_id',
    'beat_branch_id',
    'shifts_id',
    'graduated',
    'hire_date',
    'created_by',
  ];

  // protected static function booted()
  // {
  //   // Apply the ExcludeDeletedScope to exclude records where delete = 0
  //   static::addGlobalScope(new ExcludeDeletedScope);
  // }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function role()
  {
    return $this->belongsTo(Role::class, 'role_id');
  }

  public function department()
  {
    return $this->belongsTo(Department::class, 'department_id');
  }

  public function beat()
  {
    return $this->belongsTo(Beat::class, 'beat_id');
  }

  public function beatBranch()
  {
    return $this->belongsTo(BeatBranch::class, 'beat_branch_id');
  }

  public function shifts()
  {
    return $this->belongsTo(Shift::class, 'shifts_id');
  }

  // public function beats()
  // {
  //   return $this->belongsToMany(Beat::class, 'staff_beat', 'staff_id', 'beat_id')->withTimestamps();
  // }
  public function shiftss()
  {
    return $this->hasMany(Shift::class);
  }


  public function beatBranches()
  {
    return $this->belongsToMany(BeatBranch::class, 'staff_beat', 'staff_id', 'beat_branch_id')->withTimestamps();
  }

  public function callRep()
  {
    return $this->hasMany(Attendance::class, 'staff_id');
  }

  //   public function beat()
  // {
  //     return $this->belongsTo(Beat::class);
  // }

  public function shiftType()
  {
    return $this->belongsTo(ShiftType::class);
  }
  public function shiftsWithNoExpires()
  {
    return $this->shiftss()->withNoExpires()->get();
  }
  public function attendances()
  {
    return $this->hasMany(Attendance::class);
  }

  public function guarantors()
  {
    return $this->hasMany(Guarantor::class);
  }
}
