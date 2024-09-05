<?php
// app/Models/ShiftType.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftType extends Model
{
  use HasFactory;

  protected $table = 'shift_types';

  protected $fillable = [
    'name',
    'hours',
    'description',
  ];

  public function shifts()
  {
    return $this->hasMany(Shift::class);
  }
}
