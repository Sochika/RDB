<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
  public function index()
  {
    return view('radius.dashboard');
  }

  public function cancel(Request $request)
  {
    // dd($request->all());
    if ($request->staff_id != 0) {
      $staff = Staff::where('id', $request->staff_id)->first();
      $staff->beat_id = null;
      $staff->beat_branch_id = null;
      $staff->shifts_id = null;
      $staff->save();
    }
    $shift = Shift::find($request->shift_id);
    if ($shift) {

      // $shift->main_assign = 0;
      $shift->comment = $request->comment;
      $shift->expires = $request->date ?? Carbon::today()->format('Y-m-d');
      $shift->rate = $request->rating;
      $shift->ended_by = Auth::user()->id;

      $shift->save(); // Or update the status as necessary
      return response()->json(['success' => true]);
    }
    return response()->json(['success' => false]);
  }


  public function delete(Request $request)
  {
    // dd($request->all());
    if ($request->staff_id != 0) {
      $staff = Staff::where('id', $request->staff_id)->first();
      $staff->beat_id = null;
      $staff->beat_branch_id = null;
      $staff->shifts_id = null;
      $staff->save();
    }
    $shift = Shift::find($request->shift_id);
    if ($shift) {


      $shift->delete();
      return response()->json(['success' => true]);
    }
    return response()->json(['success' => false]);
  }
}
