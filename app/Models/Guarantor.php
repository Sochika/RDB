<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantor extends Model
{
  use HasFactory;
  protected $table = 'guarators';

  // Define the fillable attributes
  protected $fillable = [
    'staff_id',
    'first_name',
    'middle_name',
    'last_name',
    'phone_number',
    'email',
    'address',
    'avatar',
    'ID_document',
    'verified',
  ];

  // Define the relationship to the Staff model
  public function staff()
  {
    return $this->belongsTo(Staff::class);
  }
}
