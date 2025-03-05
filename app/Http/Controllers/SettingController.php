<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $settings = Setting::all();
    return view('setting.index', compact('settings'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Setting $setting)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $setting = Setting::findOrFail($id);
    return view('setting.form', compact('setting'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Setting $setting)
  {
    $validated = $request->validate([
      'key' => 'required|string',
      'value' => 'required|string',
    ]);

    $setting->key = $request->key;
    $setting->value = $request->value;

    $setting->update();

    return redirect()->route('settings.index')->with('success', 'Setting updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Setting $setting)
  {
    //
  }
}
