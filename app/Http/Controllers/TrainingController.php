<?php

namespace App\Http\Controllers;

use App\Models\BeatLead;
use App\Models\LeadDetail;
use App\Models\Notes;
use App\Models\Recruit;
use App\Models\States;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TrainingController extends Controller
{

  public function index()
  {
    $states = States::get();

    $leads = BeatLead::where('created_by', Auth::user()->id);
    $leadOnboarded = BeatLead::whereNotNull('onboard_date')->whereNotNull('beat_id')->get();
    $leadTerminated = '??';
    $leadsFailed = BeatLead::where('approve', 2)->count();
    $weekLeads = BeatLead::whereBetween('lead_date', [
      Carbon::now()->startOfWeek(),
      Carbon::now()->endOfWeek()
    ])->get();
    $level = 2;
    return view('radius.admin.index', compact('leads', 'leadOnboarded', 'states', 'leadTerminated', 'leadsFailed', 'weekLeads', 'level'));
  }


  public function leads()
  {
    $states = States::get();

    $leads = BeatLead::all();
    $myleads = BeatLead::where('created_by', Auth::user()->id);
    $leadOnboarded = BeatLead::whereNotNull('onboard_date')->whereNotNull('beat_id')->get();
    $myleadOnboarded = BeatLead::where('created_by', Auth::user()->id)->whereNotNull('onboard_date')->whereNotNull('beat_id')->get();
    $leadTerminated = '??';
    $myleadTerminated = 0;
    $leadsFailed = BeatLead::where('approve', 2)->count();
    $myleadsFailed = BeatLead::where('created_by', Auth::user()->id)->where('approve', 2)->count();
    $weekLeads = BeatLead::whereBetween('lead_date', [
      Carbon::now()->startOfWeek(),
      Carbon::now()->endOfWeek()
    ])->get();
    $level = 2;
    return view('radius.admin.lead', compact('leads', 'myleads', 'leadOnboarded', 'myleadOnboarded', 'states', 'leadTerminated', 'myleadTerminated',  'leadsFailed', 'myleadsFailed', 'weekLeads', 'level'));
  }


  public function operatives()
  {
    $states = States::get();

    $leads = BeatLead::all();
    $myleads = BeatLead::where('created_by', Auth::user()->id)->get();
    $leadOnboarded = BeatLead::whereNotNull('onboard_date')->whereNotNull('beat_id')->get();
    $myleadOnboarded = BeatLead::where('created_by', Auth::user()->id)->whereNotNull('onboard_date')->whereNotNull('beat_id')->get();
    $leadTerminated = '??';
    $myleadTerminated = 0;
    $leadsFailed = BeatLead::where('approve', 2)->count();
    $myleadsFailed = BeatLead::where('created_by', Auth::user()->id)->where('approve', 2)->count();
    $weekLeads = BeatLead::whereBetween('lead_date', [
      Carbon::now()->startOfWeek(),
      Carbon::now()->endOfWeek()
    ])->get();
    $level = 2;
    return view('radius.training.operatives', compact('leads', 'myleads', 'leadOnboarded', 'myleadOnboarded', 'states', 'leadTerminated', 'myleadTerminated',  'leadsFailed', 'myleadsFailed', 'level'));
  }


  public function allRecruits()
  {
    $states = States::get();

    $recruits = Recruit::where('approve', 1)->get();
    $myrecruits = Recruit::where('created_by', Auth::user()->id)->get();
    $recruitOnboarded = Recruit::whereNotNull('staff_id')->get();
    $myrecruitOnboarded = Recruit::where('created_by', Auth::user()->id)->whereNotNull('staff_id')->get();
    $recruitTerminated = '??';
    $myrecruitTerminated = 0;
    $recruitsFailed = Recruit::where('approve', 2)->count();
    $myrecruitsFailed = Recruit::where('created_by', Auth::user()->id)->where('approve', 2)->count();
    $weekrecruits = Recruit::whereBetween('recruit_date', [
      Carbon::now()->startOfWeek(),
      Carbon::now()->endOfWeek()
    ])->get();
    $level = 2;
    return view('radius.admin.recruits', compact('recruits', 'myrecruits', 'recruitOnboarded', 'myrecruitOnboarded', 'states', 'recruitTerminated', 'myrecruitTerminated',  'recruitsFailed', 'myrecruitsFailed', 'level'));
  }

  public function recruits()
  {
    $states = States::get();

    $recruits = Recruit::where('approve', 1)->get();
    $recruitsApproved = Recruit::where('approve', 1)->whereNotNull('staff_id')->get();
    $recruitsGraduated = '??';
    $recruitsFailed = Recruit::where('approve', 2)->count();
    $weekRecruits = Recruit::whereBetween('recruit_date', [
      Carbon::now()->startOfWeek(),
      Carbon::now()->endOfWeek()
    ])->get();
    $level = 2;
    return view('radius.training.recruit', compact('recruits', 'recruitsApproved', 'states', 'recruitsGraduated', 'recruitsFailed', 'weekRecruits', 'level'));
  }


  public function recruitSave(Request $request)
  {


    $request->validate([
      'first_name' => 'required|string|max:255',
      'middle_name' => 'nullable|string|max:255',
      'last_name' => 'required|string|max:255',
      'phone_number' => 'nullable|string|max:255',
      'email' => 'nullable|string|max:255',
      'area' => 'nullable|string|max:255',
      'city' => 'nullable|string|max:255',
      'state' => 'nullable|string|max:255',
      'gender' => 'nullable|string',
      'recruit_date' => 'nullable|date',

    ]);
    if (Recruit::where('first_name', $request->first_name)
      ->where('middle_name', $request->middle_name ?? '')
      ->where('last_name', $request->last_name)
      ->where('gender', $request->gender)
      ->exists()
    ) {
      return redirect()->back()->with('error', 'This Recruit Exist in the Database. Please visit the Office');
    }
    $recruit = new Recruit();
    $recruit->first_name = $request->first_name;
    $recruit->middle_name = $request->middle_name;
    $recruit->last_name = $request->last_name;
    $recruit->phone_number = $request->phone_number;
    $recruit->email = $request->email;
    $recruit->sourced_area = $request->sourced_area;
    $recruit->area = $request->area;
    $recruit->city = $request->city;
    $recruit->state = $request->state;
    $recruit->gender = $request->gender;
    $recruit->recruit_date = $request->recruit_date;
    $recruit->created_by = $request->created_by == 'none' || $request->created_by == '' ? Auth::user()->id : $request->created_by;
    $recruit->referral = $request->referral;

    $recruit->save();

    return redirect()->back()->with('success', $request->first_name . ' saved successfully.');

    // return view('radius.market.recruit');
  }

  public function recruitForm()
  {

    $staffs = User::all();
    $states = States::get();
    return view('radius.admin.recruitForm', compact('states', 'staffs'));
  }

  public function beatSave(Request $request)
  {

    // $request->validate([
    //   'first_name' => 'required|string|max:255',
    //   'middle_name' => 'nullable|string|max:255',
    //   'last_name' => 'required|string|max:255',
    //   'phone_number' => 'nullable|string|max:255',
    //   'email' => 'nullable|string|max:255',
    //   'area' => 'nullable|string|max:255',
    //   'city' => 'nullable|string|max:255',
    //   'state' => 'nullable|string|max:255',
    //   'gender' => 'nullable|string',
    //   'recruit_date' => 'nullable|date',

    // ]);

    $lead = new BeatLead();
    $lead->contact_name = $request->contact_name;
    $lead->companyName = $request->companyName;
    $lead->address = $request->address;
    $lead->phone_number = $request->phone_number;
    $lead->email = $request->email;
    $lead->area = $request->area;
    $lead->city = $request->city;
    $lead->state = $request->state;
    $lead->type = $request->type;
    $lead->lead_date = $request->lead_date;
    $lead->created_by = $request->created_by == 'none' || $request->created_by == '' ? Auth::user()->id : $request->created_by;
    $lead->beat_id = $request->beat_id;
    $lead->agreed_num_operatives = $request->agreed_num_operatives;
    $lead->referral = $request->referral;
    $lead->save();

    if ($request->note || $request->num_operative) {
      $lead_Detail = new Notes();
      $lead_Detail->user_id = $request->created_by == 'none' || $request->created_by == '' ? Auth::user()->id : $request->created_by;
      $lead_Detail->office_id = Auth::user()->office->id;
      $lead_Detail->lead_id = $lead->id;
      $lead_Detail->num_operatives = $request->num_operative;
      $lead_Detail->amount = $request->amount;
      $lead_Detail->note = $request->note ?? '';
      $lead_Detail->save();
    }



    return redirect()->back()->with('success', $request->companyName ?? $request->contact_name . ' saved successfully.');
    // return view('radius.market.beat');
  }

  public function beatForm()
  {
    $states = States::get();
    $staffs = User::all();
    return view('radius.admin.leadForm', compact('states', 'staffs'));
  }

  public function getWeekRecruits(Request $request)
  {
    $week = $request->input('week');

    // Convert the week string to a date range
    $startOfWeek = Carbon::parse($week)->startOfWeek();
    $endOfWeek = Carbon::parse($week)->endOfWeek();

    // Fetch recruits for the selected week
    $weekRecruits = Recruit::all();

    return response()->json(['weekRecruits' => $weekRecruits]);
  }

  public function getWeekLeads(Request $request)
  {
    $week = $request->input('week');

    // Convert the week string to a date range
    $startOfWeek = Carbon::parse($week)->startOfWeek();
    $endOfWeek = Carbon::parse($week)->endOfWeek();

    // Fetch recruits for the selected week
    $weekLeads = BeatLead::whereBetween('lead_date', [$startOfWeek, $endOfWeek])->get();

    return response()->json(['weekLeads' => $weekLeads]);
  }

  public function saveNote(Request $request)
  {
    $record = [
      'read' => $request->input('read_' . $request->recruit_id),
      'write' => $request->input('write_' . $request->recruit_id),
      'communication' => $request->input('communication_' . $request->recruit_id),
      'exposure' => $request->input('exposure_' . $request->recruit_id),
      'form_given' => $request->has('form_given') ? 1 : 0,
      'form_returned' => $request->has('form_returned') ? 1 : 0,
    ];

    // Convert the array to JSON
    $jsonRecord = json_encode($record);

    // Check if a note already exists for the current office and recruit
    // $note = Notes::where('office_id', Auth::user()->id)
    //   ->where('recruit_id', $request->recruit_id)
    //   ->first();

    // if (isset($request->note_id)) {
    $note = Notes::find($request->note_id);
    // }

    if ($note) {
      // If the note exists, update it
      $note->record = $jsonRecord;
      $note->approve = $request->form_given ?? 0;
      $note->note = $request->input('additional_info_' . $request->recruit_id);
    } else {
      // If no note exists, create a new one
      $note = new Notes();
      $note->user_id = Auth::user()->id;
      $note->office_id = Auth::user()->id;
      $note->recruit_id = $request->recruit_id;
      $note->record = $jsonRecord;
      $note->approve = $request->form_given ?? 0;
      $note->note = $request->input('additional_info_' . $request->recruit_id);
    }

    // Save or update the note
    $note->save();

    // Return with a success message
    return redirect()->back()->with('success', $note->recruit->first_name . $note->recruit->last_name . ' updated successfully.');
  }
}
