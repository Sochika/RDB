<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Shift;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
  public function index()
  {
    // // Get the current date and time
    // $current_date = Carbon::now()->toDateString();
    // $current_time = Carbon::now()->toTimeString();
    // $thirty_minutes_from_now = Carbon::now()->addMinutes(30)->toTimeString();


    $currentDateTime = Carbon::now();
    // $currentTime = $currentDateTime->format('H:i:s');

    // // Create a Carbon instance for the current time
    // $currentTimeInstance = Carbon::createFromFormat('H:i:s', $currentTime);
    // // $thirty_minutes_from_now = Carbon::createFromFormat('H:i:s', $currentTime)->addMinutes(30);




    // Build the query
    $staffsUnMarked = $this->operativeOnShifts()
      ->whereNotIn('staff.id', function ($query) use ($currentDateTime) {
        $query->select('attendances.staff_id')
          ->from('attendances')
          ->whereDate('attendances.attendance_date', $currentDateTime->toDateString());
      })
      ->select(
        'staff.id as id',
        'staff.first_name as first_name',
        'staff.last_name as last_name',
        'staff.phone_number as phone_number',
        'staff.date_of_birth as date_of_birth',
        'staff.area as area',
        'staff.hire_date as hire_date',
        'staff.role_id',
        'shifts.shift_type_id as shift_type_id',
        'shifts.shift_start as shift_start',
        'shifts.shift_end as shift_end',
        'beat_branches.name as beat_branch_name',
        'beat_branches.address as beat_branch_address',
        'shift_types.name as shift_type_name',
        'shift_types.hours as shift_type_hours'
      )
      ->distinct()
      ->orderBy('shifts.shift_type_id')
      ->orderBy('shifts.shift_start', 'desc')
      ->get();




    $staffsMarked = Attendance::query()
      ->join('staff', 'attendances.staff_id', '=', 'staff.id')
      ->join('users', 'attendances.created_by', '=', 'users.id')
      ->join('shifts', 'shifts.staff_id', '=', 'staff.id')
      ->join('beat_branches', 'shifts.beat_branch_id', '=', 'beat_branches.id')
      ->join('shift_types', 'shifts.shift_type_id', '=', 'shift_types.id')
      ->whereNull('staff.graduated')
      ->whereNull('shifts.expires')
      ->whereDate('attendances.attendance_date', $currentDateTime->toDateString())
      ->select(
        'staff.id as id',
        'staff.first_name as first_name',
        'staff.last_name as last_name',
        'staff.phone_number as phone_number',
        'staff.date_of_birth as date_of_birth',
        'staff.area as area',
        'staff.hire_date as hire_date',
        'staff.role_id',
        'shifts.shift_type_id as shift_type_id',
        'shifts.shift_start as shift_start',
        'shifts.shift_end as shift_end',
        'beat_branches.name as beat_branch_name',
        'beat_branches.address as beat_branch_address',
        'shift_types.name as shift_type_name',
        'shift_types.hours as shift_type_hours',
        'attendances.comment as comment',
        'attendances.status as status',
        'attendances.minutes_of_lateness as minutes_of_lateness',
        'users.name as seatRep'
      )
      ->distinct()
      ->orderBy('shifts.shift_type_id')
      ->orderBy('shifts.shift_start', 'asc')
      ->get();

    // $tt = $currentDateTime->toDateString();
    // dd($currentDateTime);
    // dd(Auth::user()->id);

    return view('radius.attendance.index', compact('staffsUnMarked', 'staffsMarked'));
  }

  public function filterByDate(Request $request)
  {
    $date = $request->input('date');
    $date = Carbon::parse($date);
    // Fetch the staffs who are unmarked for the selected date
    $staffsUnMarked =  $this->operativeOnShifts($date)
      ->whereNotIn('staff.id', function ($query) use ($date) {
        $query->select('attendances.staff_id')
          ->from('attendances')
          ->whereDate('attendances.attendance_date', $date->toDateString());
      })
      ->select(
        'staff.id as id',
        'staff.first_name as first_name',
        'staff.last_name as last_name',
        'staff.phone_number as phone_number',
        'staff.date_of_birth as date_of_birth',
        'staff.area as area',
        'staff.hire_date as hire_date',
        'staff.role_id',
        'shifts.shift_type_id as shift_type_id',
        'shifts.shift_start as shift_start',
        'shifts.shift_end as shift_end',
        'beat_branches.name as beat_branch_name',
        'beat_branches.address as beat_branch_address',
        'shift_types.name as shift_type_name',
        'shift_types.hours as shift_type_hours'
      )
      ->distinct()
      ->orderBy('shifts.shift_type_id')
      ->orderBy('shifts.shift_start', 'desc')
      ->get();
    return view('radius.attendance.partials.staffs_table', compact('staffsUnMarked'));
  }



  public function markAttendance(Request $request)
  {
    $date = $request->date ? Carbon::parse($request->date) : Carbon::now();

    foreach ($request->attendance as $staffId => $present) {
      Attendance::updateOrCreate(
        ['staff_id' => $staffId, 'date' => $date->format('Y-m-d')],
        ['present' => $present]
      );
    }

    return redirect()->back()->with('success', 'Attendance marked successfully.');
  }

  public function mark(Request $request)
  {
    // Log request data for debugging
    Log::debug('Request Data:', $request->all());

    // Validate the incoming request data
    $validatedData = $request->validate([
      'staff_id' => 'required|exists:staff,id',
      'date' => 'required|date',
      'present' => 'required|boolean',
    ]);

    // Extract data from the request
    $staffId = $validatedData['staff_id'];
    $comment = $request->input("comment");
    $lateness = $request->input("lateness");
    $present = $validatedData['present'];
    $clock_in = now()->toTimeString();
    // dd(Auth::user()->id);

    try {
      // Create or update the attendance record for today
      Attendance::updateOrCreate(
        ['staff_id' => $staffId, 'attendance_date' => $validatedData['date']],
        [
          'clock_in_time' => $clock_in,
          'status' => $lateness ? 'late' : 'on_time',
          'comment' => $comment,
          'minutes_of_lateness' => $lateness,
          'present' => $present,
          'created_by' => Auth::user()->id
        ]
      );

      return response()->json(['success' => true]);
    } catch (\Exception $e) {
      // Log the exception and return a JSON error response
      Log::error($e->getMessage());
      return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
    }
  }



  public function showMonthlyAttendance($staffId, $month = null)
  {
    $staff = Staff::findOrFail($staffId);
    $month = $month ? Carbon::parse($month) : Carbon::now();
    $attendances = Attendance::where('staff_id', $staffId)
      ->whereMonth('attendance_date', $month->format('m'))
      ->whereYear('attendance_date', $month->format('Y'))
      ->get();

    return view('radius.attendance.monthly', compact('staff', 'attendances', 'month'));
  }
  public function offOperative()
  {
    // Get the current date and time
    // $current_date = Carbon::now()->toDateString();
    // $current_time = Carbon::now()->toTimeString(); //add a day to current_time if shifts.shift_end <= shifts.shift_start and current_time is is equal to or greater than 12am

    // $thirty_minutes_from_now = Carbon::now()->addMinutes(30)->toTimeString();


    // $current_time = Carbon::now();
    // $thirty_minutes_from_now = Carbon::now()->addMinutes(30);


    // $currentDateTime = Carbon::now();
    // $currentTime = $currentDateTime->format('H:i:s');

    // // Create a Carbon instance for the current time
    // $currentTimeInstance = Carbon::createFromFormat('H:i:s', $currentTime);

    // Main query to get staff in the specified shifts
    $staffInShifts = $this->operativeOnShifts()->pluck('staff.id');




    // Main query to get staff not in the specified shifts
    $staffNotInShifts = Staff::whereNull('graduated')
      ->whereNotIn('staff.id', $staffInShifts)

      ->leftJoin('shifts', 'staff.id', '=', 'shifts.staff_id')->whereNull('shifts.expires')
      ->leftJoin('beat_branches', 'shifts.beat_branch_id', '=', 'beat_branches.id')
      ->leftJoin('shift_types', 'shifts.shift_type_id', '=', 'shift_types.id')
      ->select(
        'staff.id as id',
        'staff.first_name as first_name',
        'staff.last_name as last_name',
        'staff.phone_number as phone_number',
        'staff.area as area',
        'staff.date_of_birth as date_of_birth',
        'staff.hire_date as hire_date',
        'staff.role_id',
        'shifts.shift_type_id as shift_type_id',
        'shifts.shift_start as shift_start',
        'shifts.shift_end as shift_end',
        'beat_branches.name as beat_branch_name',
        'beat_branches.address as beat_branch_address',
        'shift_types.name as shift_type_name',
        'shift_types.hours as shift_type_hours'
      )
      ->orderBy('shifts.shift_type_id')
      ->orderBy('shifts.shift_start', 'asc')
      ->get();

    return view('radius.freeStaffs', compact('staffNotInShifts'));
  }

  public function fetchStaffData(Request $request)
  {
    $date = $request->input('date') ?? Carbon::now();

    // Get staff currently in shifts at the adjusted date and time
    $staffInShifts = $this->operativeOnShifts($date)
      ->pluck('staff.id');

    // Main query to get staff not in the specified shifts
    $staffNotInShifts = Staff::whereNull('graduated')
      ->whereNotIn('staff.id', $staffInShifts)
      ->leftJoin('shifts', 'staff.id', '=', 'shifts.staff_id')->whereNull('shifts.expires')
      ->leftJoin('beat_branches', 'shifts.beat_branch_id', '=', 'beat_branches.id')
      ->leftJoin('shift_types', 'shifts.shift_type_id', '=', 'shift_types.id')
      ->select(
        'staff.id as id',
        'staff.first_name as first_name',
        'staff.last_name as last_name',
        'staff.phone_number as phone_number',
        'staff.area as area',
        'staff.date_of_birth as date_of_birth',
        'staff.hire_date as hire_date',
        'staff.role_id',
        'shifts.shift_type_id as shift_type_id',
        'shifts.shift_start as shift_start',
        'shifts.shift_end as shift_end',
        'beat_branches.name as beat_branch_name',
        'beat_branches.address as beat_branch_address',
        'shift_types.name as shift_type_name',
        'shift_types.hours as shift_type_hours'
      )->orderBy('shifts.shift_type_id')
      ->orderBy('shifts.shift_start', 'asc')->get(); // Add get() to execute the query

    // Map the staff data to an array format
    $staffData = $staffNotInShifts->map(function ($staff) {
      return [
        'id' => $staff->id,
        'first_name' => $staff->first_name,
        'last_name' => $staff->last_name,
        'phone_number' => $staff->phone_number,
        'area' => $staff->area,
        'age' => \Carbon\Carbon::parse($staff->date_of_birth)->age,
        'employed' => \Carbon\Carbon::parse($staff->hire_date)->diffForHumans(),
        'beat_branch_name' => $staff->beat_branch_name,
        'shift_start' => $staff->shift_start ? date('h:i A', strtotime($staff->shift_start)) : '--',
        'shift_type_name' => $staff->shift_type_name,
      ];
    });

    return response()->json(['staffNotInShifts' => $staffData]);
  }


  public function downloadCsv(Request $request)
  {
    $date = $request->input('date') ?? Carbon::now();
    // $currentDateTime = \Carbon\Carbon::parse($date);

    // Create a Carbon instance for the current time
    // $currentTimeInstance = Carbon::createFromFormat('H:i:s', $currentTime)->addMinutes(30);


    // Get staff currently in shifts at the adjusted date and time
    $staffInShifts = $this->operativeOnShifts($date)->pluck('staff.id');


    $staffNotInShifts = Staff::whereNull('graduated')
      ->whereNotIn('staff.id', $staffInShifts)
      ->leftJoin('shifts', 'staff.id', '=', 'shifts.staff_id')->whereNull('shifts.expires')
      ->leftJoin('beat_branches', 'shifts.beat_branch_id', '=', 'beat_branches.id')
      ->leftJoin('shift_types', 'shifts.shift_type_id', '=', 'shift_types.id')
      ->select(
        'staff.id as id',
        'staff.first_name as first_name',
        'staff.last_name as last_name',
        'staff.phone_number as phone_number',
        'staff.area as area',
        'staff.date_of_birth as date_of_birth',
        'staff.hire_date as hire_date',
        'staff.role_id',
        'shifts.shift_type_id as shift_type_id',
        'shifts.shift_start as shift_start',
        'shifts.shift_end as shift_end',
        'beat_branches.name as beat_branch_name',
        'beat_branches.address as beat_branch_address',
        'shift_types.name as shift_type_name',
        'shift_types.hours as shift_type_hours'
      )->orderBy('shifts.shift_type_id')
      ->orderBy('shifts.shift_start', 'asc')->get();

    $csvData = $staffNotInShifts->map(function ($staff) {
      return [
        'ID' => $staff->id,
        'First Name' => $staff->first_name,
        'Last Name' => $staff->last_name,
        'Phone Number' => $staff->phone_number,
        'Area' => $staff->area,
        'Age' => \Carbon\Carbon::parse($staff->date_of_birth)->age,
        'Employed' => \Carbon\Carbon::parse($staff->hire_date)->diffForHumans(),
        'Beat Branch Name' => $staff->beat_branch_name,
        'Shift Start' => $staff->shift_start ? date('h:i A', strtotime($staff->shift_start)) : '--',
        'Shift Type Name' => $staff->shift_type_name,
      ];
    });

    $filename = "staff_not_in_shifts_{$date}.csv";

    return response()->stream(function () use ($csvData) {
      $handle = fopen('php://output', 'w');
      fputcsv($handle, array_keys($csvData->first())); // Write header row

      foreach ($csvData as $row) {
        fputcsv($handle, $row); // Write data rows
      }

      fclose($handle);
    }, 200, [
      'Content-Type' => 'text/csv',
      'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ]);
  }


  public function fetchAttendanceData(Request $request)
  {
    // Validate the date parameter
    $request->validate([
      'date' => 'required|date',
    ]);

    // Get the date from the request
    $date = $request->input('date');
    $formattedDate = Carbon::parse($date)->format('Y-m-d');

    // Fetch the staff data based on the selected date
    // $staffsMarked = Staff::whereDate('shift_date', $formattedDate)->get(); // Adjust 'shift_date' to your actual column name

    $staffsMarked = Attendance::query()
      ->join('staff', 'attendances.staff_id', '=', 'staff.id')
      ->join('users', 'attendances.created_by', '=', 'users.id')
      ->join('shifts', 'shifts.staff_id', '=', 'staff.id')
      ->join('beat_branches', 'shifts.beat_branch_id', '=', 'beat_branches.id')
      ->join('shift_types', 'shifts.shift_type_id', '=', 'shift_types.id')
      ->whereNull('staff.graduated')
      ->whereNull('shifts.expires')
      ->whereDate('attendances.attendance_date', $formattedDate)
      ->select(
        'staff.id as id',
        'staff.first_name as first_name',
        'staff.last_name as last_name',
        'staff.phone_number as phone_number',
        'staff.date_of_birth as date_of_birth',
        'staff.area as area',
        'staff.hire_date as hire_date',
        'staff.role_id',
        'shifts.shift_type_id as shift_type_id',
        'shifts.shift_start as shift_start',
        'shifts.shift_end as shift_end',
        'beat_branches.name as beat_branch_name',
        'beat_branches.address as beat_branch_address',
        'shift_types.name as shift_type_name',
        'shift_types.hours as shift_type_hours',
        'attendances.comment as comment',
        'attendances.status as status',
        'attendances.minutes_of_lateness as minutes_of_lateness',
        'users.name as seatRep'
      )
      ->distinct()
      ->orderBy('shifts.shift_type_id')
      ->orderBy('shifts.shift_start', 'asc')->get();

    // Return the data as JSON
    return response()->json(['staffsMarked' => $staffsMarked]);
  }

  public function operativeOnShifts($date = null)
  {
    // $current_date = Carbon::now()->toDateString();
    // $current_time = Carbon::now()->toTimeString(); //add a day to current_time if shifts.shift_end <= shifts.shift_start and current_time is is equal to or greater than 12am


    // $current_time = Carbon::now();
    // $thirty_minutes_from_now = Carbon::now()->addMinutes(30);


    $currentDateTime = isset($date) ? Carbon::parse($date) : Carbon::now();
    $currentTime = $currentDateTime->format('H:i:s');

    // Create a Carbon instance for the current time
    $currentTimeInstance = Carbon::createFromFormat('H:i:s', $currentTime);

    return Shift::query()
      ->join('staff', 'shifts.staff_id', '=', 'staff.id')
      ->join('beat_branches', 'shifts.beat_branch_id', '=', 'beat_branches.id')
      ->join('shift_types', 'shifts.shift_type_id', '=', 'shift_types.id')
      ->whereNull('staff.graduated')
      ->whereNull('shifts.expires')

      ->where(function ($query) use ($currentTimeInstance, $currentDateTime) {
        $query->whereHas('shiftType', function ($query) use ($currentTimeInstance, $currentDateTime) {
          $query->where(function ($query) use ($currentTimeInstance) {
            // Shifts with hours < 24
            $query->where('shift_types.hours', '<', 24)
              ->where(function ($query) use ($currentTimeInstance) {
                // Shifts that do not cross midnight
                $query->where(function ($query) use ($currentTimeInstance) {
                  $query->whereTime('shifts.shift_start', '<=', $currentTimeInstance->format('H:i:s'))
                    ->whereTime('shifts.shift_end', '>', $currentTimeInstance->format('H:i:s'));
                })
                  // Shifts that cross midnight

                  // ->orWhere(function ($query) use ($currentTimeInstance) {
                  //   $query->whereTime('shifts.shift_start', '<=', $currentTimeInstance->format('H:i:s'))
                  //     ->whereTime('shifts.shift_end', '<', $currentTimeInstance->format('H:i:s'))
                  //     ->whereRaw('shifts.shift_start > shifts.shift_end');
                  // });

                  // Shifts that cross midnight
                  ->orWhere(function ($query) use ($currentTimeInstance) {
                    $query->whereTime('shifts.shift_start', '<=', $currentTimeInstance->format('H:i:s'))
                      ->where(function ($query) use ($currentTimeInstance) {
                        $query->where(function ($query) use ($currentTimeInstance) {
                          $query->whereRaw('TIME_TO_SEC(shifts.shift_end) > TIME_TO_SEC(shifts.shift_start)')
                            ->whereTime('shifts.shift_end', '>', $currentTimeInstance->format('H:i:s'));
                        })
                          ->orWhere(function ($query) use ($currentTimeInstance) {
                            $query->whereRaw('TIME_TO_SEC(shifts.shift_end) < TIME_TO_SEC(shifts.shift_start)')
                              ->whereRaw('ADDTIME(shifts.shift_end, "24:00:00") > ?', [$currentTimeInstance->format('H:i:s')]);
                          });
                      });
                  });
              });
          })
            // Shifts with hours >= 24
            ->orWhere('shift_types.hours', '>=', 24)
            ->whereRaw('MOD(
                CEIL(
                    TIMESTAMPDIFF(
                        HOUR,
                        CONCAT(shifts.shift_date_start, " ", shifts.shift_start),
                        ?
                    ) / shift_types.hours
                ),
                2
            ) = 1', [$currentDateTime]);
        });
      });
  }
}
