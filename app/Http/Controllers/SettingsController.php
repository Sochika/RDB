<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Role;
use App\Models\GlobalSettings;
use App\Models\Office;
use App\Models\ShiftType;
use App\Models\Zones;
// use GlobalSettings;
use Illuminate\Http\Request;


class SettingsController extends Controller
{
  public function index()
  {
    $staff_radius = GlobalSettings::where('title', 'staff_radius')->first();
    $roles = Role::orderBy('level', 'asc')->get();
    $offices = Office::orderBy('level', 'asc')->get();
    $shift_types = ShiftType::get();
    $zones = Zones::get();
    $areas = Area::get();
    return view('radius.settings', compact('staff_radius', 'roles', 'shift_types', 'offices', 'zones', 'areas'));
  }

  public function setRoles(Request $request)
  {


    if ($request->input('role_id')) {
      $role = Role::find($request->input('role_id'));
      // dd($role);
      if ($role) {
        $role->update([
          'name' => $request->input('name'),
          'guard_name' => 'radius_' . $request->input('name'),
          'salary' => $request->input('salary'),
          'level' => $request->input('level'),
          'description' => $request->input('description')
        ]);
        return back()->with('success', $request->input('name') . ' Role updated successfully.');
      }
      return back()->with('error', $request->input('name') . ' Role not updated/ not found.');
    } else {
      Role::create([
        'name' => $request->input('name'),
        'guard_name' => 'radius_' . $request->input('name'),
        'salary' => $request->input('salary'),
        'level' => $request->input('level'),
        'description' => $request->input('description')
        // Add other fields here
      ]);

      return back()->with('success', $request->input('name') . ' Role created successfully.');
    }
  }

  public function deleteRole($id)
  {
    $role = Role::find($id);

    // Check if the role exists
    if ($role) {
      // Delete the role
      $role->delete();

      // Return a success response
      return response()->json(['success' => true, 'message' => 'Role deleted successfully']);
    }

    // Return an error response if the role does not exist
    return response()->json(['success' => false, 'message' => 'Role not found'], 404);
  }

  public function setShifts(Request $request)
  {


    // $validatedData = $request->validate([

    //   'name' => 'required|string|max:255',
    //   'salary' => 'required|integer',
    //   'name' => 'required|string|max:255',
    //   'description' => 'nullable|string|max:255',

    // ]);
    if ($request->input('shift_id')) {
      $shiftType = ShiftType::find($request->input('shift_id'));
      if ($shiftType) {
        $shiftType->update([
          'name' => $request->input('shift_name'),
          'hours' => $request->input('shift_hours'),
          'description' => $request->input('description')
        ]);
        return back()->with('success', $request->input('shift_name') . ' Shift updated successfully.');
      }
      return back()->with('error', $request->input('shift_name') . ' Shift: something sent wrong.');
    } else {

      ShiftType::create([
        'name' => $request->input('shift_name'),
        'hours' => $request->input('shift_hours'),
        'description' => $request->input('description')
        // Add other fields here
      ]);
      // Role::create($request->all());
      // return redirect()->route('settings')->with('success', 'Role created successfully.');
      return back()->with('success', $request->input('shift_name') . ' Shift created successfully.');
    }
  }


  public function setBeatView(Request $request)
  {



    $staff_radius = GlobalSettings::where('title', 'staff_radius')->first();
    $staff_radius->value = $request->staffs_distance;
    $staff_radius->save();
    $view_off_beats = GlobalSettings::where('title', 'view_off_beats')->first();
    $view_off_beats->value = $request->view_off_beats;
    $view_off_beats->save();
    // Role::create($request->all());
    // return redirect()->route('settings')->with('success', 'Role created successfully.');
    return back()->with('success', 'Beat Settings updated successfully.');
  }

  public function setOffices(Request $request)
  {

    // dd($request->input('role_id'));

    // $validatedData = $request->validate([

    //   'name' => 'required|string|max:255',
    //   'salary' => 'required|integer',
    //   'level' => 'required|integer',
    //   'description' => 'nullable|string|max:255',

    // ]);
    // dd($request->input('office_id'));
    if ($request->input('office_id')) {
      $office = Office::find($request->input('office_id'));
      // dd($office);
      if ($office) {
        $office->update([
          'name' => $request->input('office'),

          'level' => $request->input('office_level'),
          'description' => $request->input('office_description')
        ]);
        return back()->with('success', $request->input('office') . ' Office updated successfully.');
      }
      return back()->with('error', $request->input('name') . ' Office not updated/ not found.');
    } else {
      Office::create([
        'name' => $request->input('office'),

        'level' => $request->input('office_level'),
        'description' => $request->input('office_description')
        // Add other fields here
      ]);
      return back()->with('success', $request->input('name') . ' Office created successfully.');
    }
  }

  public function deleteOffice($id)
  {



    $role = Office::find($id);

    // Check if the role exists
    if ($role) {
      // Delete the role
      $role->delete();

      // Return a success response
      return response()->json(['success' => true, 'message' => 'Office deleted successfully']);
    }

    // Return an error response if the role does not exist
    return response()->json(['success' => false, 'message' => 'Office not found'], 404);
  }


  public function setZones(Request $request)
  {



    if ($request->input('zone_id')) {
      $zone = Zones::find($request->input('zone_id'));
      if ($zone) {
        $zone->update([
          'name' => $request->input('zone_name'),

          'description' => $request->input('description_zone')
        ]);
        return back()->with('success', $request->input('zone_name') . ' Zone updated successfully.');
      }
      return back()->with('error', $request->input('zone_name') . ' Zone: something sent wrong.');
    } else {

      Zones::create([
        'name' => $request->input('zone_name'),

        'description' => $request->input('description_zone')
        // Add other fields here
      ]);
      // Role::create($request->all());
      // return redirect()->route('settings')->with('success', 'Role created successfully.');
      return back()->with('success', $request->input('zone_name') . ' Zone created successfully.');
    }
  }

  public function setArea(Request $request)
  {



    if ($request->input('area_id')) {
      $area = Area::find($request->input('shift_id'));
      if ($area) {
        $area->update([
          'name' => $request->input('area_name'),

          'description' => $request->input('area_description')
        ]);
        return back()->with('success', $request->input('area_name') . ' Area updated successfully.');
      }
      return back()->with('error', $request->input('area_name') . ' Area: something sent wrong.');
    } else {

      Area::create([
        'name' => $request->input('area_name'),
        'zone_id' => $request->input('zone_id'),
        'description' => $request->input('area_description')
        // Add other fields here
      ]);

      return back()->with('success', $request->input('area_name') . ' Area created successfully.');
    }
  }
}
