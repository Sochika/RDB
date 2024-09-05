<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Spatie\Permission\Traits\HasRoles;

class StaffDoc extends Authenticatable
{
  use HasFactory, Notifiable;
  protected $table = 'staff_doc';

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'staff_id',
    'document',

  ];

  public function staff()
  {
    return $this->hasOne(Staff::class);
  }
}
