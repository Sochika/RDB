<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Beat;
use App\Models\BeatBranch;
use App\Models\Role;
use App\Models\States;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helpers\Helpers;
use App\Models\GlobalSettings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AttendanceController;



class BeatController extends Controller
{
  public function index()
  {

    // $operativesClose = Staff::where distance(x, y, reference_x, reference_y) <= 10;

    $staff_radius = GlobalSettings::where('title', 'staff_radius')->first()->value;
    // $staff_radius_num = (num)$staff_radius;
    $beats = Beat::orderBy('status')->orderBy('name', 'asc')->get();
    $states = States::get();
    $roles = Role::get();
    $attendances = new AttendanceController();
    $onDuties = $attendances->operativeOnShifts()->select('staff.id as operative_id', 'beat_branches.id as beatLocation_id')
      ->get()
      ->mapWithKeys(function ($item) {
        return [$item['operative_id'] => $item['beatLocation_id']];
      })->toArray();
    // dd($onDuties);
    return view('radius.beats.beats', compact('roles', 'states', 'beats', 'staff_radius', 'onDuties'));

    // return view('radius.beats');
  }

  public function addBeat()
  {

    // $operativesClose = Staff::where distance(x, y, reference_x, reference_y) <= 10;

    $staff_radius = GlobalSettings::where('title', 'staff_radius')->first()->value;
    // $staff_radius_num = (num)$staff_radius;
    $beats = Beat::all();
    $states = States::get();
    $roles = Role::get();
    return view('radius.beats.beat_add', compact('roles', 'states', 'beats', 'staff_radius'));
  }

  public function editBeat(Request $request, $id)
  {

    // $operativesClose = Staff::where distance(x, y, reference_x, reference_y) <= 10;

    $staff_radius = GlobalSettings::where('title', 'staff_radius')->first()->value;
    // $staff_radius_num = (num)$staff_radius;
    $beat = Beat::where('id', $id)->first();
    // dd($beat->beatBranches[0]->name);
    $states = States::get();
    $roles = Role::get();
    return view('radius.beats.beat_edit', compact('roles', 'states', 'beat', 'staff_radius'));
  }

  public function show()
  {

    // $operativesClose = Staff::where distance(x, y, reference_x, reference_y) <= 10;

    // $staff_radius = GlobalSettings::where('title', 'staff_radius')->first()->value;
    // // $staff_radius_num = (num)$staff_radius;
    // $beats = Beat::all();
    // $states = States::get();
    // $roles = Role::get();
    // return view('radius.beats.beat_add', compact('roles', 'states', 'beats', 'staff_radius'));
  }


  public function store(Request $request)
  {
    $lonnlat = Helpers::getCoordinatesFromMapbox($request->Address1 . ' ' . $request->city . ' ' . $request->state . ' State');
    // return redirect()->back()->with('success', 'Beat created successfully.');
    if (isset($lonnlat['latitude'])) {
      // return response()->json([
      $latitude = $lonnlat['latitude'];
      $longitude = $lonnlat['longitude'];
      // ]);
    } else {
      return redirect()->back()->with([
        'error' => $lonnlat['message'],
      ], 400);
    }
    // if (isset($lonnlat['error'])) {
    //   return redirect()->back()->with('error', $lonnlat['error']);
    // }
    //  else {
    //   dd($lonnlat);
    // }

    // dd($request->all());
    // $request->validate([
    //   'name' => 'required|string|max:255',
    //   'phone_number' => 'required|string|max:15',
    //   'email' => 'required|email|max:255',
    //   'onboard_date' => 'required|date',
    //   'address' => 'required|string|max:255',
    //   'area' => 'required|string|max:255',
    //   'city' => 'required|string|max:255',
    //   'state' => 'required|string|max:255',
    // ]);
    // dd($request->first_name);

    $beat = Beat::create([
      'name' => $request->companyName ?? $request->first_name . ' ' . $request->last_name,
      'email' => $request->email,
      'phone_number' => $request->phone_number,
      'type' => $request->type,
      'onboard_date' => $request->onboard_date,
    ]);

    $beatBranch = new BeatBranch();
    $beatBranch->beat_id = $beat->id;
    $beatBranch->name = $request->companyName . ' ' . $request->area ?? $request->first_name . ' ' . $request->last_name;
    $beatBranch->first_name = $request->first_name;
    $beatBranch->last_name = $request->last_name;
    $beatBranch->address = $request->Address1;
    $beatBranch->area = $request->area;
    $beatBranch->landmark = $request->landmark;
    $beatBranch->city = $request->city;
    $beatBranch->state = $request->state;
    $beatBranch->latitude = $latitude;
    $beatBranch->longitude = $longitude;
    $beatBranch->save();


    return redirect()->back()->with('success', $request->companyName . ' Beat created successfully.');
  }


  public function beatBranchstore(Request $request)
  {
    $lonnlat = Helpers::getCoordinatesFromMapbox($request->Address1 . ' ' . $request->city . ' ' . $request->state . ' State');
    // return redirect()->back()->with('success', 'Beat created successfully.');
    if (isset($lonnlat['latitude'])) {
      // return response()->json([
      $latitude = $lonnlat['latitude'];
      $longitude = $lonnlat['longitude'];
      // ]);
    } else {
      return redirect()->back()->with([
        'error' => $lonnlat['message'],
      ], 400);
    }



    $beatBranch = new BeatBranch();
    $beatBranch->beat_id = $request->beat_id;
    $beatBranch->name = $request->companyName . ' ' . $request->area ?? $request->first_name . ' ' . $request->last_name;
    $beatBranch->first_name = $request->first_name;
    $beatBranch->last_name = $request->last_name;
    $beatBranch->address = $request->Address1;
    $beatBranch->area = $request->area;
    $beatBranch->landmark = $request->landmark;
    $beatBranch->city = $request->city;
    $beatBranch->state = $request->state;
    $beatBranch->latitude = $latitude;
    $beatBranch->longitude = $longitude;
    $beatBranch->save();



    return redirect()->back()->with('success', $request->companyName . ' ' . $request->area . ' Beat added successfully.');
  }



  // Function to get staff within a certain distance (10 meters in this case)
  private function getStaffWithinDistance($referenceLat, $referenceLng, $distanceInMeters = 10)
  {
    // Convert distance to kilometers
    $distanceInKm = $distanceInMeters / 1000;

    // Haversine formula
    $haversine = "(6371 * acos(cos(radians($referenceLat))
                    * cos(radians(latitude))
                    * cos(radians(longitude) - radians($referenceLng))
                    + sin(radians($referenceLat))
                    * sin(radians(latitude))))";

    return Staff::select('*')
      ->selectRaw("{$haversine} AS distance")
      ->having('distance', '<=', $distanceInKm)
      ->orderBy('distance', 'asc')
      ->get();
  }


  public function getBeatBranch($beatId)
  {
    // Retrieve all staff records
    $beatBranches = BeatBranch::where('beat_id', $beatId)->get();

    return response()->json($beatBranches);
  }

  public function update(Request $request, $id)
  {
    $lonnlat = Helpers::getCoordinatesFromMapbox($request->Address1 . ' ' . $request->city . ' ' . $request->state . ' State');
    // return redirect()->back()->with('success', 'Beat created successfully.');
    if (isset($lonnlat['latitude'])) {
      // return response()->json([
      $latitude = $lonnlat['latitude'];
      $longitude = $lonnlat['longitude'];
      // ]);
    } else {
      return redirect()->back()->with([
        'error' => $lonnlat['message'],
      ], 400);
    }
    // if (isset($lonnlat['error'])) {
    //   return redirect()->back()->with('error', $lonnlat['error']);
    // }
    //  else {
    //   dd($lonnlat);
    // }

    // dd($request->all());
    // $request->validate([
    //   'name' => 'required|string|max:255',
    //   'phone_number' => 'required|string|max:15',
    //   'email' => 'required|email|max:255',
    //   'onboard_date' => 'required|date',
    //   'address' => 'required|string|max:255',
    //   'area' => 'required|string|max:255',
    //   'city' => 'required|string|max:255',
    //   'state' => 'required|string|max:255',
    // ]);
    // dd($request->first_name);

    Beat::where('id', $id)->update([
      'name' => $request->companyName ?? $request->first_name . ' ' . $request->last_name,
      'email' => $request->email,
      'phone_number' => $request->phone_number,
      'type' => $request->type,
      'onboard_date' => $request->onboard_date,
    ]);

    $beatBranch = BeatBranch::where('beat_id', $id)->first();
    $beatBranch->name = $request->companyName . ' ' . $request->area ?? $request->first_name . ' ' . $request->last_name;
    $beatBranch->first_name = $request->first_name;
    $beatBranch->last_name = $request->last_name;
    $beatBranch->address = $request->Address1;
    $beatBranch->area = $request->area;
    $beatBranch->landmark = $request->landmark;
    $beatBranch->city = $request->city;
    $beatBranch->state = $request->state;
    $beatBranch->latitude = $latitude;
    $beatBranch->longitude = $longitude;
    $beatBranch->longitude = Auth::user()->id;
    $beatBranch->save();



    return redirect()->route('beats')->with('success', $request->companyName . ' Beat updated successfully.');

    // return redirect()->back()->with('success', $request->companyName . ' Beat updated successfully.');
  }
  // Usage example
  // $referenceLat = 40.7128; // Replace with your reference latitude
  // $referenceLng = -74.0060; // Replace with your reference longitude
  // $distanceInMeters = 10; // Distance in meters

  // $staffWithinDistance = getStaffWithinDistance($referenceLat, $referenceLng, $distanceInMeters);

  // foreach ($staffWithinDistance as $staff) {
  //     echo "Name: {$staff->name}, Distance: {$staff->distance} km\n";
  // }


  // private function getLonLag($address)
  // {
  //   $url = 'https://nominatim.openstreetmap.org/search?q=' . $address . '&format=json'; // Replace with your URL
  //   $jsonData = Http::get($url);
  //   // return $url;

  //   // Fetch JSON data from URL
  //   // $jsonData = file_get_contents($url);
  //   if ($jsonData->successful()) {
  //     // Get the JSON data and decode it to an array
  //     $data = $jsonData->json();
  //     // return $data;
  //     if (count($data) === 0) {
  //       return ['error' => 'Invalid Address'];
  //     } else {
  //       return ['lat' => $data[0]['lat'], 'lon' => $data[0]['lon']];
  //     }

  //     // Do something with the data
  //     // return response()->json($data);
  //   } else {
  //     // Handle error
  //     return response()->json(['error' => 'Invalid Address']);
  //   }

  //   // if ($jsonData === false) {
  //   //   // Handle error
  //   //   echo "Failed to fetch data.";
  //   // } else {
  //   //   // Decode JSON data to PHP array or object
  //   //   $data = json_decode($jsonData, true);

  //   //   // Check if JSON decoding was successful
  //   //   if (json_last_error() === JSON_ERROR_NONE) {
  //   //     // Use the data
  //   //     return ['lat' => $data[0]['lat'], 'lon' => $data[0]['lon']];
  //   //     // var_dump($data);
  //   //   } else {
  //   //     // Handle JSON decode error
  //   //     echo "Failed to decode JSON: " . json_last_error_msg();
  //   //   }
  //   // }
  // }

  public function getBeatStaffclose(Request $request, $id)
  {
    // Retrieve all staff records
    $beat = Beat::findOrFail($id)->first();
    // dd($beat);
    $staff_radius = GlobalSettings::where('title', 'staff_radius')->first()->value;

    return view('radius.beats.close-operatives', compact('beat', 'staff_radius'));
  }

  function getStaffNearby($beatBranchId, $radius = 10)
  {
    $branch = BeatBranch::findOrFail($beatBranchId);

    $staffNearby = Staff::select(DB::raw("
            id, name, phone_number, address, latitude, longitude,
            ( 6371 * acos( cos( radians(?) ) *
              cos( radians( latitude ) )
              * cos( radians( longitude ) - radians(?) )
              + sin( radians(?) ) *
              sin( radians( latitude ) ) )
            ) AS distance
        ", [$branch->latitude, $branch->longitude, $branch->latitude]))
      ->having('distance', '<', $radius)
      ->orderBy('distance')
      ->get();

    return $staffNearby;
  }
}
