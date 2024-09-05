<?php
// app/Models/BeatBranch.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeatBranch extends Model
{
  use HasFactory;

  protected $table = 'beat_branches';

  protected $fillable = [
    'beat_id',
    'name',
    'phone_number',
    'address',
    'area',
    'city',
    'state',
    'country',
    'latitude',
    'longitude',
  ];

  public function beat()
  {
    return $this->belongsTo(Beat::class, 'beat_id');
  }

  public function staff()
  {
    return $this->hasMany(Staff::class);
  }



  public function shifts()
  {
    return $this->hasMany(Shift::class)->whereNull('expires');
  }

  // public function getNearbyStaff($dist = 10) // Distance in kilometers (0.01 km ~ 10 meters)
  // {
  //   $distance = $dist * 0.001;
  //   $latitude = $this->latitude;
  //   $longitude = $this->longitude;

  //   return Staff::select('*')
  //     ->selectRaw(
  //       '( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) AS distance',
  //       [$latitude, $longitude, $latitude]
  //     )
  //     ->having('distance', '<=', $distance)
  //     ->orderBy('distance')
  //     ->get();
  // }

  public function getNearbyStaff($dist = 10) // Distance in kilometers (0.01 km ~ 10 meters)
  {
    $distance = $dist * 0.001; // Convert meters to kilometers

    $latitude = $this->latitude;
    $longitude = $this->longitude;

    return Staff::select('*')
      ->selectRaw(
        '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) as distance',
        [$latitude, $longitude, $latitude]
      )
      ->having('distance', '<=', $distance)
      ->orderBy('distance')
      ->get();
  }
}
