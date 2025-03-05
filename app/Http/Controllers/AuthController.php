<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController
{
  public function showLogin()
  {
    return view('auth.login');
  }

  public function login(Request $request)
  {

    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
      return redirect()->route('dashboard')->with('success', 'Login Successfully');
    }

    return back()->withErrors(['error' => 'Invalid credentials'])->withInput();
  }

  public function showRegister()
  {
    return view('auth.register');
  }

  public function register(Request $request)
  {
    // Validate input fields
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:6',
      'confirm_password' => 'required|string|same:password', // Ensure confirm_password matches password
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    // $defaultRole = 'staff';
    // $user->assignRole($defaultRole);

    Auth::login($user);

    return redirect()->route('dashboard')->with('success', 'User registered successfully');
  }

  public function logout()
  {
    Auth::logout();
    return redirect('/login');
  }
}