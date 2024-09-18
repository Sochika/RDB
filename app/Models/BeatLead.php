<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Prompts\Note;

class BeatLead extends Model
{
  use HasFactory;
  protected $table = 'beat_leads';

  protected $dates = [
    'lead_date',
    'created_at',
    'deleted_at'
  ];

  protected $fillable = [
    'contact_name',
    'companyName',
    'address',
    'area',
    'city',
    'state',
    'phone_number',
    'email',
    'type',
    'agreed_num_operatives',
    'beat_id',
    'created_by',
    'referral',
    'approve',
    'onboard_date',
  ];

  public function leadDetails()
  {
    return $this->hasMany(Notes::class, 'lead_id', 'id');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'created_by');
  }
}
