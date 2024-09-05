<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckShiftEnd extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'shifts:check-shift-end';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Check if shift_end for each staff has passed and update the shift_on column in shifts table';


  /**
   * Execute the console command.
   */
  public function handle()
  {
    $current_time = Carbon::now();

    // Get shifts with shift_types.hours as 24
    $shifts24 = DB::table('shifts')
      ->join('shift_types', 'shifts.shift_type_id', '=', 'shift_types.id')
      ->where('shift_types.hours', 24)
      ->select('shifts.id', 'shift_types.shift_date_start', 'shifts.shift_on')
      ->get();

    foreach ($shifts24 as $shift) {
      $shift_start = Carbon::parse($shift->shift_date_start);
      $shift_end = $shift_start->copy()->addHours(24);

      if ($shift_end->lessThanOrEqualTo($current_time)) {
        // Toggle the shift_on status
        DB::table('shifts')
          ->where('id', $shift->id)
          ->update(['shift_on' => !$shift->shift_on]);
      }
    }

    // Get shifts with shift_types.hours as 12
    $shifts12 = DB::table('shifts')
      ->join('shift_types', 'shifts.shift_type_id', '=', 'shift_types.id')
      ->where('shift_types.hours', 12)
      ->select('shifts.id', 'shifts.shift_start', 'shifts.shift_end', 'shifts.shift_on')
      ->get();

    foreach ($shifts12 as $shift) {
      $shift_start = Carbon::parse($shift->shift_start);
      $shift_end = Carbon::parse($shift->shift_end);

      // Adjust shift_end if it is less than shift_start (spans over midnight)
      if ($shift_end->lessThan($shift_start)) {
        $shift_end->addDay();
      }

      // Check if current time is within the shift start and end time
      if ($current_time->between($shift_start, $shift_end)) {
        // Set shift_on status to true when on duty
        DB::table('shifts')
          ->where('id', $shift->id)
          ->update(['shift_on' => true]);
      } else {
        // Set shift_on status to false when off duty
        DB::table('shifts')
          ->where('id', $shift->id)
          ->update(['shift_on' => false]);
      }
    }

    // Get shifts with shift_types.hours as null or empty
    $shiftsNullOrEmpty = DB::table('shifts')
      ->join('shift_types', 'shifts.shift_type_id', '=', 'shift_types.id')
      ->whereNull('shift_types.hours')
      ->orWhere('shift_types.hours', '')
      ->select('shifts.id', 'shifts.shift_start', 'shifts.shift_end', 'shifts.shift_on')
      ->get();

    foreach ($shiftsNullOrEmpty as $shift) {
      $shift_start = Carbon::parse($shift->shift_start);
      $shift_end = Carbon::parse($shift->shift_end);

      // Adjust shift_end if it is less than shift_start (spans over midnight)
      if ($shift_end->lessThan($shift_start)) {
        $shift_end->addDay();
      }

      // Check if current time is within the shift period
      if ($current_time->lessThanOrEqualTo($shift_end)) {
        // Set shift_on status to true if current time is before or within shift_end
        DB::table('shifts')
          ->where('id', $shift->id)
          ->update(['shift_on' => true]);
      } else {
        // Set shift_on status to false if current time is past shift_end
        DB::table('shifts')
          ->where('id', $shift->id)
          ->update(['shift_on' => false]);
      }
    }

    $this->info('Shifts updated successfully.');
    return 0;
  }
}
