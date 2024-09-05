<?php
// app/Models/StaffBeat.php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class StaffBeat extends Pivot
{
  protected $table = 'staff_beat';

  protected $fillable = [
    'staff_id',
    'beat_id',
    'shift_start',
    'shift_end',
    'shift_type_id',
  ];

  public function staff()
  {
    return $this->belongsTo(Staff::class, 'staff_id');
  }

  public function beatBranch()
  {
    return $this->belongsTo(BeatBranch::class, 'beat_branch_id');
  }

  public function beat()
  {
    return $this->belongsTo(Beat::class, 'beat_id');
  }
}
