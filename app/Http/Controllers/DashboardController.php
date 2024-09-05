<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Beat;
use App\Models\Staff;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index()
  {
    $allStaffs = Staff::whereNull('graduated');
    $staffs = $allStaffs->get();
    $maleStaffs = $allStaffs->where('gender', 'male')->get();
    $beats = Beat::where('status', 'on')->get();
    // dd($staffs);
    return view('radius.dashboard', compact('staffs', 'beats', 'maleStaffs'));
  }
}
