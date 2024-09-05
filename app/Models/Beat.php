<?php
// app/Models/Beat.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beat extends Model
{
  use HasFactory;

  protected $table = 'beats';

  protected $fillable = [
    'name',
    'email',
    'phone_number',
    'onboard_date',
    'join_date',
  ];

  public function beatBranches()
  {
    return $this->hasMany(BeatBranch::class, 'beat_id');
  }

  public function staff()
  {
    return $this->belongsToMany(Staff::class, 'staff_beats', 'beat_id', 'staff_id')->withTimestamps();
  }



  // public function operatives()
  // {
  //   return $this->hasMany(BeatOperative::class, 'beat_id');
  // }
  // public function staff()
  // {
  //     return $this->belongsToMany(Staff::class, 'staff_beat', 'beat_id', 'staff_id')->withTimestamps();
  // }

  // Define relationships if needed
  // public function someRelation()
  // {
  //     return $this->belongsTo(SomeModel::class);
  // }

  // Additional methods or relationships can be defined here
}
