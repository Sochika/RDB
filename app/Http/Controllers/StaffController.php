<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\StaffResource;
use App\Models\Role;
use App\Models\Staff;
use App\Models\StaffDoc;
use App\Models\States;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\Attendance;
use App\Models\Beat;
use App\Models\Shift;
use App\Models\ShiftType;
use App\Models\Guarantor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
  public function index()
  {
    $staffs = Staff::whereNull('graduated')->get();
    $operativesAssigned = Staff::whereNull('graduated')->where('beat_id', '<>', NULL)->get();

    // Filter the staff members based on the number of shifts
    $filteredStaffs = 0;
    // $filteredStaffs = $staffs->filter(function ($staff) {
    //   return $staff->shifts->count() > 3;
    // });
    $states = States::get();
    $roles = Role::get();
    return view('radius.staffs', compact('staffs', 'operativesAssigned', 'roles', 'states'));
  }


  public function store(Request $request)
  {
    dd($request);
    // Validate incoming request data
    // dd($request->all());
    //   $validatedData = $request->validate([
    //     'first_name' => 'required|string|max:255',
    //     'middle_name' => 'nullable|string|max:255',
    //     'last_name' => 'required|string|max:255',
    //     'email' => 'nullable|email|max:255',
    //     'phone_number' => 'nullable|string|max:255',
    //     'gender' => 'nullable|string',
    //     'address' => 'nullable|string|max:255',
    //     'area' => 'required|string|max:255',
    //     'city' => 'nullable|string|max:255',
    //     'state' => 'required|string|max:255',
    //     'date_of_birth' => 'required|date',
    //     'hire_date' => 'required|date',
    //     'credentials' => 'nullable',
    //     'avatar' => 'nullable|image|max:2048',
    //     'role_id' => 'required|integer|exists:roles,id',
    // ]);


    // dd($request->all());

    if (Staff::where('first_name', $request->first_name)
      ->where('middle_name', $request->middle_name ?? '')
      ->where('last_name', $request->last_name)
      ->exists()
    ) {
      return back()->withErrors(['name_combination' => 'This Operative Exist in the Database.']);
    }

    // dd($validatedData);
    $lonnlat = Helpers::getCoordinatesFromMapbox($request->Address1 . ' ' . $request->city . ' ' . $request->state, true);
    // return redirect()->back()->with('success', 'Beat created successfully.');
    // if ($lonnlat['success']) {
    //   // return response()->json([
    //   $latitude = $lonnlat['latitude'];
    //   $longitude = $lonnlat['longitude'];
    //   // ]);
    // } else {
    //   return redirect()->back()->with([
    //     'error' => $lonnlat['message'],
    //   ], 400);
    // }


    // $lonnlat = getCoordinatesFromMapbox($address, $accessToken);

    if ($lonnlat) {
      $latitude = $lonnlat['latitude'];
      $longitude = $lonnlat['longitude'];
    } else {
      return redirect()->back()->with([
        'error' => $lonnlat['message'],
      ], 400);
    }
    $request['latitude'] = $latitude;
    $request['longitude'] = $longitude;
    // Add the 'created_by' field
    $request['created_by'] = 1;
    // $request['gender'] = $request->gender == 'male' ? 'male' : 'female';
    $hireDate = $request->input('hire_date');

    // Parse the hire_date using Carbon
    $hireDate = Carbon::parse($hireDate);

    // Get the date six months ago from today
    $sixMonthsAgo = Carbon::now()->subMonths(6);
    $oneYearAgo = Carbon::now()->subMonths(12);
    if ($hireDate->greaterThan($sixMonthsAgo)) {
      # code...
      $request['role_id'] = 1;
    } elseif ($hireDate->greaterThan($oneYearAgo)) {
      # code...
      $request['role_id'] = 2;
    } else {
      # code...
      $request['role_id'] = 3;
    }

    // $request['gender'] = $request->gender;

    // Create a new staff record
    // $staff = Staff::create($request->all());
    $staff = new Staff();

    $staff->first_name = $request->first_name;
    $staff->middle_name = $request->middle_name;
    $staff->last_name = $request->last_name;
    $staff->email = $request->email;
    $staff->phone_number = $request->phone_number;
    $staff->address = $request->address;
    $staff->area = $request->area;
    $staff->city = $request->city;
    $staff->state = $request->state;
    $staff->date_of_birth = $request->date_of_birth;
    $staff->gender = $request->gender;
    $staff->hire_date = $request->hire_date;
    $staff->role_id = $request['role_id'];
    $staff->latitude = $request->latitude;
    $staff->longitude = $request->longitude;
    $staff->created_by = Auth::user()->id;
    if ($request->file('avatar')) {
      $image = $request->file('avatar');
      $avatarPath = $request->first_name . time() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('images'), $avatarPath);
      $staff->avatar = $avatarPath;
      // if ($request->hasFile('avatar')) {
      //   $avatarPath = $request->file('avatar')->store('avatars', 'public');
      //   $staff->update(['avatar' => $avatarPath]);
    }
    $staff->save();


    // Handle credentials file uploads
    if ($request->hasFile('credentials')) {
      foreach ($request->file('credentials') as $credential) {
        // Generate a unique file name
        $credentialFileName = $request->input('first_name') . '_' . $request->input('last_name') . '_' . time() . '.' . $credential->extension();

        // Store the file in the 'public/credentials' directory and get the file path
        $filePath = $credential->storeAs('credentials', $credentialFileName, 'public');

        // Create a new StaffDoc entry with the stored file path
        StaffDoc::create([
          'staff_id' => $staff->id,
          'document' => $filePath
        ]);
      }
    }


    if ($request->input('guarantor1_fname') && $request->input('guarantor1_lname')) {

      // Handle file uploads
      $guarantor1AvatarPath = $request->file('guarantor1_avatar') ?
        $request->file('guarantor1_avatar')->store('guarantors/avatars', 'public') : null;

      $guarantor1CredentialPath = $request->file('guarantor1_ID') ?
        $request->file('guarantor1_ID')->store('guarantors/credentials', 'public') : null;

      $guarantor = new Guarantor();
      $guarantor->staff_id = $staff->id;
      $guarantor->first_name = $request->input('guarantor1_fname');
      $guarantor->middle_name = $request->input('guarantor1_mname');
      $guarantor->last_name = $request->input('guarantor1_lname');
      $guarantor->phone_number = $request->input('guarantor1_phone');
      $guarantor->gender = $request->input('guarantor1_gender');
      $guarantor->email = $request->input('guarantor1_email');
      $guarantor->address = $request->input('guarantor1_address') . ' ' . $request->input('guarantor1_city');
      $guarantor->area = $request->input('guarantor1_area');
      // $guarantor->city = $request->input('cityGuarantor');
      $guarantor->avatar = $guarantor1AvatarPath;
      $guarantor->ID_document = $guarantor1CredentialPath;
      $guarantor->created_by = Auth::user()->id; // Assuming you're using Laravel's built-in auth system
      $guarantor->save();
    }

    if ($request->input('guarantor2_fname') && $request->input('guarantor2_lname')) {

      // Handle file uploads
      $guarantor2AvatarPath = $request->file('guarantor2_avatar') ?
        $request->file('guarantor2_avatar')->store('guarantors/avatars', 'public') : null;

      $guarantor2CredentialPath = $request->file('guarantor2_ID') ?
        $request->file('guarantor2_ID')->store('guarantors/credentials', 'public') : null;

      $guarantor = new Guarantor();
      $guarantor->staff_id = $staff->id;
      $guarantor->first_name = $request->input('guarantor2_fname');
      $guarantor->middle_name = $request->input('guarantor2_mname');
      $guarantor->last_name = $request->input('guarantor2_lname');
      $guarantor->phone_number = $request->input('guarantor2_phone');
      $guarantor->gender = $request->input('guarantor2_gender');
      $guarantor->email = $request->input('guarantor2_email');
      $guarantor->address = $request->input('guarantor2_address') . ' ' . $request->input('guarantor2_city');
      $guarantor->area = $request->input('guarantor2_area');
      // $guarantor->city = $request->input('cityGuarantor');
      $guarantor->avatar = $guarantor2AvatarPath;
      $guarantor->ID_document = $guarantor2CredentialPath;
      $guarantor->created_by = Auth::user()->id; // Assuming you're using Laravel's built-in auth system
      $guarantor->save();
    }

    // Handle avatar file upload

    // if ($request->hasFile('avatar')) {
    //   $avatarPath = $request->file('avatar')->store('avatars', 'public');
    //   $staff->update(['avatar' => $avatarPath]);
    // }

    // Redirect back with a success message
    return redirect()->back()->with('success', $request->first_name . ' added successfully.');
  }

  public function update(Request $request, $id)
  {
    // Validate the incoming request
    $request->validate([
      'first_name' => 'required|string|max:255',
      'middle_name' => 'nullable|string|max:255',
      'last_name' => 'required|string|max:255',
      'email' => 'nullable|email|max:255',
      'phone_number' => 'nullable|string|max:255',
      'address' => 'nullable|string|max:255',
      'area' => 'nullable|string|max:255',
      'city' => 'nullable|string|max:255',
      'state' => 'nullable|string|max:255',
      'date_of_birth' => 'nullable|date',
      'gender' => 'nullable|string',
      'hire_date' => 'nullable|date',
      'role_id' => 'required|integer',
      'avatar' => 'nullable|image|mimes:jpg,jpeg,png',
      'credentials.*' => 'nullable|file|mimes:pdf,doc,docx'
    ]);

    // Check if the staff with the same name already exists
    if (Staff::where('first_name', $request->first_name)
      ->where('middle_name', $request->middle_name ?? '')
      ->where('last_name', $request->last_name)
      ->where('id', '!=', $id)
      ->exists()
    ) {
      return back()->withErrors(['name_combination' => 'This Operative exists in the database.']);
    }

    // Get coordinates from Mapbox
    $lonnlat = Helpers::getCoordinatesFromMapbox($request->address . ' ' . $request->city . ' ' . $request->state, true);

    if (isset($lonnlat['latitude']) && isset($lonnlat['longitude'])) {
      $latitude = $lonnlat['latitude'];
      $longitude = $lonnlat['longitude'];
    } else {
      return redirect()->back()->with('error', $lonnlat['message'])->withInput();
    }

    // Find the staff record and update it
    $staff = Staff::findOrFail($id);
    $staff->fill($request->except(['avatar', 'credentials']));
    $staff->latitude = $latitude;
    $staff->longitude = $longitude;
    $staff->created_by = Auth::user()->id;

    // Handle avatar file upload
    if ($request->hasFile('avatar')) {
      $image = $request->file('avatar');
      $avatarPath = $request->first_name . time() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('images'), $avatarPath);
      $staff->avatar = $avatarPath;
    }

    $staff->save();

    // Handle credentials file uploads
    if ($request->hasFile('credentials')) {
      // Delete existing documents
      StaffDoc::where('staff_id', $staff->id)->delete();

      foreach ($request->file('credentials') as $credential) {
        $credentialFileName = $request->first_name . '_' . $request->last_name . '_' . time() . '.' . $credential->extension();
        $filePath = $credential->storeAs('credentials', $credentialFileName, 'public');
        StaffDoc::create([
          'staff_id' => $staff->id,
          'document' => $filePath
        ]);
      }
    }

    // Redirect back with a success message
    return redirect()->back()->with('success', $request->first_name . ' profile updated successfully.');
  }

  public function stafform()
  {
    $states = States::get();
    $roles = Role::get();
    $shift = Shift::get();
    return view('radius.staffForm', compact('roles', 'states', 'shift'));
  }



  public function tablex()
  {
    // Retrieve all staff records
    $staff = Staff::all();

    // Optionally, transform the data if needed
    $staffData = $staff->map(function ($staff) {
      return [
        'id' => $staff->id,
        'full_name' => $staff->first_name . ' ' . $staff->last_name,
        'role' => $staff->role->name,
        'phone_number' => $staff->phone_number,
        'gender' => $staff->gender,
        'avatar' => $staff->avatar,
        'date_of_birth' => $staff->date_of_birth,
        'beat' => $staff->beat->name ?? '',
        'beat_address' => $staff->beatbranch,
        'hire_date' => Carbon::parse($staff->hire_date)->diffForHumans(),
        'address' => $staff->address,
        'area' => $staff->area,
        'shift' => $staff->shifts,
        'callRep' => $staff->callRep,
        'status' => $staff->status,
        'graduated' => $staff->graduated,
      ];
    });

    return new StaffResource($staffData);
  }

  public function view($id)
  {
    $roles = Role::all();
    $shiftypes = ShiftType::all();
    $shifts = Shift::all();
    $beats = Beat::all();
    // $attendanceData = Attendance::where('staff_id', $id)->get();
    // Get the current year
    $currentYear = Carbon::now()->year;

    // Fetch attendance records for the current year
    $attendanceRecords = Attendance::where('staff_id', $id)
      ->whereYear('attendance_date', $currentYear) // Filter by the current year
      ->orderBy('attendance_date')
      ->get();

    // Initialize an empty array for the formatted data
    $attendanceData = [];

    foreach ($attendanceRecords as $record) {
      $date = Carbon::parse($record->attendance_date);
      $month = $date->format('F'); // Get the full month name (e.g., 'January')
      $formattedDate = $date->format('Y-m-d');
      $lateness = $record->minutes_of_lateness > 0;

      // Ensure the month key exists in the array
      if (!isset($attendanceData[$month])) {
        $attendanceData[$month] = [];
      }

      // Add the record to the appropriate month and date
      $attendanceData[$month][$formattedDate] = ['lateness' => $lateness];
    }

    // Output or use $attendanceData as needed
    // dd($attendanceData);
    $staff = Staff::where('id', $id)->first();
    return view('radius.operatives.view-operative-attendance', compact('staff', 'roles', 'shifts', 'beats', 'shiftypes', 'attendanceData'));
  }


  public function activity($id)
  {
    $roles = Role::all();
    $shiftypes = ShiftType::all();
    $shifts = Shift::where('staff_id', $id)->orderBy('created_at', 'desc')->get();
    $beats = Beat::all();
    $staff = Staff::where('id', $id)->first();
    return view('radius.operatives.view-operative-activity', compact('staff', 'roles', 'shifts', 'beats', 'shiftypes'));
  }

  public function guarantors($id)
  {
    $roles = Role::all();
    $shiftypes = ShiftType::all();
    $shifts = Shift::where('staff_id', $id)->orderBy('created_at', 'desc')->get();
    $beats = Beat::all();
    $staff = Staff::where('id', $id)->first();
    $guarantors = Staff::where('id', $id)->first();
    return view('radius.operatives.view-operative-guarantors', compact('staff', 'roles', 'shifts', 'beats', 'shiftypes', 'guarantors'));
  }
  public function upload(Request $request)
  {
    $request->validate([
      'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imageName = time() . '.' . $request->image->extension();
    $request->image->move(public_path('images'), $imageName);

    return back()
      ->with('success', 'Image uploaded successfully.')
      ->with('image', $imageName);
  }

  public function staffAssign(Request $request)
  {
    // Query shifts for the staff member where 'expires' is null or hasn't expired
    $current_shifts = Shift::where('staff_id', $request->staff_id)
      ->where(function ($query) {
        $query->whereNull('expires')
          ->orWhere('expires', '>=', Carbon::now());
      })
      ->get();

    // Count the number of shifts for the staff member
    $shift_num = $current_shifts->count();

    // Check if the staff member already has two assignments
    if ($shift_num >= 2) {
      return redirect()->back()->with('error', $request->full_name . ' already has two assignments.');
    }

    // Check if there is an existing main assignment
    $shift_exit = $current_shifts->where('main_assign', 1);
    if ($shift_exit->isNotEmpty() && $request->main_assign) {
      return redirect()->back()->with('error', $request->full_name . ' already has a main assignment. Please cancel one before assigning another.');
    }

    // Check if requested time is within existing main shift period
    $requested_time_carbon = null;
    // dd($shift_exit->first()->shift_type_id);
    if ($shift_exit->isNotEmpty()) {
      $oldhours = ShiftType::where('id', $shift_exit->first()->shift_type_id)->first()->hours;
      $newhours = ShiftType::where('id', $request->shift_type_id)->first()->hours;
    }
    // $shift_exit->first()->shift_type_id;
    // dd($hours);
    if ($shift_exit->isNotEmpty() && $newhours < 24 && $oldhours < 24) {
      $main_shift_start = Carbon::parse($shift_exit->first()->shift_start);
      $main_shift_ends = Carbon::parse($shift_exit->first()->shift_end);
      $requested_time = Carbon::parse($request->shift_start)->format('H:i');
      $requested_time_carbon = Carbon::createFromFormat('H:i', $requested_time);

      if ($requested_time_carbon->between($main_shift_start, $main_shift_ends)) {
        return redirect()->back()->with('error', $request->full_name . ' already has a main assignment in between these times.');
      }
    }

    // dd($shift_exit->first()->start_date);



    // dd($oldhours / 24);
    // dd(($daysDifference / ($oldhours / 24)) % 2);

    // dd((ceil($daysDifference / ($oldhours / 24))) < 0);
    // dd($daysDifference % ($oldhours / 24) > 0);
    // dd($newhours != $oldhours);
    // dd($shift_exit->isNotEmpty());
    if ($shift_exit->isNotEmpty()) {
      $date1 = Carbon::parse($shift_exit->first()->start_date);
      $date2 = Carbon::parse($request->shift_start);

      $daysDifference = $date1->diffInDays($date2);
      if (($newhours != $oldhours) || ($daysDifference % ($oldhours / 24)) > 0 || ((ceil($daysDifference / ($oldhours / 24)) % 2) < 0)) {
        return redirect()->back()->with('error', $request->full_name . ' Shift will conflict with this assignment.');
      }
    }


    // dd($shift_num);

    // Update staff details
    $staff = Staff::find($request->staff_id);
    if (!$staff) {
      return redirect()->back()->withErrors(['staff_id' => 'Staff member not found']);
    }

    // Assign new shift
    $shift_type = ShiftType::where('id', $request->shift_type_id)->first();
    $shift = new Shift();
    $shift->staff_id = $request->staff_id;
    $shift->beat_id = $request->beat_id;
    $shift->beat_branch_id = $request->beat_branch_id;
    $shift->shift_start = Carbon::parse($request->shift_start)->format('H:i');
    $shift->shift_end = $request->shift_end ?? Carbon::parse($request->shift_start)->addHours((int) $shift_type->hours)->format('H:i');;
    $shift->shift_type_id = $request->shift_type_id;
    $shift->main_assign = $request->main_assign ? 1 : 0;
    $shift->shift_date_start = Carbon::parse($request->shift_start)->format('Y-m-d');
    $shift->start_date = Carbon::parse($request->shift_start)->format('Y-m-d');
    if (isset($request->expires)) {
      $shift->expires = $request->expires;
    }
    $shift->created_by = Auth::user()->id;
    $shift->save();

    // Update staff shifts_id if main_assign is true
    if ($request->main_assign) {
      $staff->beat_id = $request->beat_id;
      $staff->beat_branch_id = $request->beat_branch_id;
      $staff->shifts_id = $shift->id;
      $staff->save();
    }

    return redirect()->back()->with('success', $request->full_name . ' assigned successfully.');
  }

  public function graduate(Request $request)
  {
    // dd($request->all());
    if ($request->staff_id != 0) {
      $staff = Staff::where('id', $request->staff_id)->first();


      $shifts = Shift::where('staff_id', $request->staff_id)->get();

      foreach ($shifts as $shift) {
        $shift->comment = $request->comment ?? '';
        $shift->expires = $request->graduation_date ?? Carbon::today()->format('Y-m-d');
        $shift->rate = $request->rating ?? 1;
        $shift->save(); // Save each updated shift
      }
      $staff->beat_id = null;
      $staff->beat_branch_id = null;
      $staff->shifts_id = null;
      $staff->graduated = $request->graduation_date ?? Carbon::today()->format('Y-m-d');
      $staff->save();
      return response()->json(['success' => true]);
    }
    return response()->json(['success' => false]);
  }

  public function ungraduate(Request $request)
  {
    // dd($request->all());
    if ($request->staff_id != 0) {
      $staff = Staff::where('id', $request->staff_id)->first();
      $staff->graduated = null;
      $staff->save();
      return response()->json(['success' => true]);
    }
    return response()->json(['success' => false]);
  }

  public function delete(Request $request)
  {
    // Ensure the staff_id is valid and not zero
    if ($request->staff_id == 0) {
      return response()->json(['success' => false]);
    }
    $staff = Staff::findOrFail($request->staff_id)->first();
    // dd($staff->last_name);
    $staff->status = 'on';
    $staff->save();
    return redirect('operatives')->with('success', $request->full_name . ' deleted successfully.');


    // Wrap the shift updates and staff deletion in a transaction
    // DB::beginTransaction();

    // try {
    //   // Delete all shifts and attendance records associated with the staff member
    //   Shift::where('staff_id', $request->staff_id)->delete();
    //   Attendance::where('staff_id', $request->staff_id)->delete();

    //   // Find the staff member and delete
    //   $staff = Staff::findOrFail($request->staff_id);
    //   $staff->delete();

    //   // Commit the transaction
    //   DB::commit();

    //   // Redirect to 'operatives' with a success message
    //   return redirect('operatives')->with('success', $request->full_name . ' deleted successfully.');
    // } catch (\Exception $e) {
    //   // Rollback the transaction if something goes wrong
    //   DB::rollBack();

    //   // Log the error or handle it as needed
    //   return redirect('operatives')->with('error', 'An error occurred while deleting operative, contact SUCH.');
    // }
  }

  public function staffGraduated()
  {


    // Main query to get staff graduated


    $staffGraduated = Staff::whereNotNull('graduated')->get();
    // dd($staffGraduated);


    return view('radius.operatives.graduated', compact('staffGraduated'));
  }
}
