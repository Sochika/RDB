<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\GlobalSettings;
use App\Models\ShiftType;
// use GlobalSettings;
use Illuminate\Http\Request;


class SettingsController extends Controller
{
  public function index()
  {
    $staff_radius = GlobalSettings::where('title', 'staff_radius')->first();
    $roles = Role::orderBy('level', 'asc')->get();
    $shift_types = ShiftType::get();
    return view('radius.settings', compact('staff_radius', 'roles', 'shift_types'));
  }

  public function setRoles(Request $request)
  {

    // dd($request->input('role_id'));

    // $validatedData = $request->validate([

    //   'name' => 'required|string|max:255',
    //   'salary' => 'required|integer',
    //   'level' => 'required|integer',
    //   'description' => 'nullable|string|max:255',

    // ]);
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
      // return response()->json(['success' => false, 'message' => 'Role not found'], 404);
    } else {
      Role::create([
        'name' => $request->input('name'),
        'guard_name' => 'radius_' . $request->input('name'),
        'salary' => $request->input('salary'),
        'level' => $request->input('level'),
        'description' => $request->input('description')
        // Add other fields here
      ]);
      // Role::create($request->all());
      // return redirect()->route('settings')->with('success', 'Role created successfully.');
      return back()->with('success', $request->input('name') . ' Role created successfully.');
    }
  }

  public function deleteRole($id)
  {


    // Role::where('id', $id)->delete();

    // return back()->with('success', 'Role deleted successfully.');
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
}
