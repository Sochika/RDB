<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruit extends Model
{
  protected $table = 'recruits';

  protected $dates = [
    'recruit_date',
    'created_at',
    'deleted_at'
  ];

  protected $fillable = [
    'first_name',
    'middle_name',
    'last_name',
    'phone_number',
    'gender',
    'area',
    'sourced_area',
    'city',
    'state',
    'referral',
    'note',
    'table',
    'approve',
    'recruit_date',
    'created_by',
    'office_id',
    'staff_id',
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'created_by');
  }
  // A recruit can have many notes
  public function notes()
  {
    return $this->hasMany(Notes::class, 'recruit_id');
  }

  // public function notes()
  // {
  //   return $this->belongsTo(Notes::class, 'recruit_id');
  // }
}
