<?php

namespace App\Http\Controllers;

use App\Models\Guarantor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class GuarantorController extends Controller
{
  /**
   * Show the form for creating a new guarantor.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('guarantors.create'); // Adjust the view path if needed
  }

  /**
   * Store a newly created guarantor in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // Validate the request data
    $request->validate([
      'guarantor_first_name' => 'required|string|max:255',
      'guarantor_middle_name' => 'nullable|string|max:255',
      'guarantor_last_name' => 'required|string|max:255',
      'guarantor_phone_number' => 'required|string|max:20',
      'guarantor_gender' => 'required|string',
      'guarantor_email' => 'nullable|email',
      'addressGuarantor' => 'required|string|max:255',
      'areaGuarantor' => 'required|string|max:255',
      'cityGuarantor' => 'required|string|max:255',
      'avatarGuarantor' => 'nullable|image|mimes:jpeg,png,gif|max:2048',
      'credentialGuarantor' => 'nullable|mimes:jpeg,png,gif,pdf|max:2048',
    ]);

    // Handle file uploads
    $avatarPath = $request->file('avatarGuarantor') ?
      $request->file('avatarGuarantor')->store('guarantors/avatars', 'public') : null;

    $credentialPath = $request->file('credentialGuarantor') ?
      $request->file('credentialGuarantor')->store('guarantors/credentials', 'public') : null;


    // Create a new guarantor record
    // Guarantor::create([
    //   'first_name' => $request->input('guarantor_first_name'),
    //   'middle_name' => $request->input('guarantor_middle_name'),
    //   'last_name' => $request->input('guarantor_last_name'),
    //   'phone_number' => $request->input('guarantor_phone_number'),
    //   'gender' => $request->input('guarantor_gender'),
    //   'email' => $request->input('guarantor_email'),
    //   'address' => $request->input('addressGuarantor'),
    //   'area' => $request->input('areaGuarantor'),
    //   'city' => $request->input('cityGuarantor'),
    //   'avatar' => $avatarPath,
    //   'credential' => $credentialPath,
    // ]);

    // return redirect()->route('guarantors.index')->with('success', 'Guarantor added successfully!');

    // Create a new Guarantor record
    $guarantor = new Guarantor();
    $guarantor->staff_id = $request->input('operative_id');
    $guarantor->first_name = $request->input('guarantor_first_name');
    $guarantor->middle_name = $request->input('guarantor_middle_name');
    $guarantor->last_name = $request->input('guarantor_last_name');
    $guarantor->phone_number = $request->input('guarantor_phone_number');
    $guarantor->gender = $request->input('guarantor_gender');
    $guarantor->email = $request->input('guarantor_email');
    $guarantor->address = $request->input('addressGuarantor') . ' ' . $request->input('cityGuarantor');
    $guarantor->area = $request->input('areaGuarantor');
    // $guarantor->city = $request->input('cityGuarantor');
    $guarantor->avatar = $avatarPath;
    $guarantor->ID_document = $credentialPath;
    $guarantor->created_by = Auth::user()->id; // Assuming you're using Laravel's built-in auth system
    $guarantor->save();

    return redirect()->back()->with('success', 'Guarantor added successfully.');
  }

  public function destroy($id)
  {
    $guarantor = Guarantor::findOrFail($id);
    $guarantor->delete();

    // Optionally, handle file deletion from storage if necessary
    // Storage::disk('public')->delete($guarantor->avatar);
    // Storage::disk('public')->delete($guarantor->credential);

    return redirect()->back()->with('success', 'Guarantor deleted successfully.');
  }
}
