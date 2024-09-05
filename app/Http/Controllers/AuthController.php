<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
  public function showLoginForm()
  {
    return view('content.authentications.auth-login-basic');
  }
  // content/authentications/auth-login-basic.blade.php

  public function login(Request $request)
  {
    // Handle login logic
  }

  public function showRegistrationForm()
  {
    return view('auth.register');
  }

  public function showAddminForm()
  {
    return view('auth.addmin');
  }

  public function register(Request $request)
  {
    // Handle registration logic
  }
  public function store(Request $request): RedirectResponse
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));

    // Auth::login($user);

    return redirect(route('registera', [], false))->with('success', 'User registered successfully!');
  }
}
