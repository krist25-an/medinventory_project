<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::middleware('guest')->group(function () {
  Route::get('register', [AuthController::class, 'showRegister'])
    ->name('register');

  Route::post('register', [AuthController::class, 'register']);

  Route::get('login', [AuthController::class, 'showLogin'])
    ->name('login');

  // Route::get('login', function () {
  //   return view('auth.login');
  // })
  //   ->name('login');

  Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
  Route::post('logout', [AuthController::class, 'logout'])
    ->name('logout');
});

Route::get('/', function () {
  return redirect(route('dashboard'));
});


Route::middleware('auth')->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
  Route::resource('users', UserController::class)->names('users');
  Route::resource('medicines', MedicineController::class)->names('medicines');

  Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
  Route::get('/settings/{setting}/edit', [SettingController::class, 'edit'])->name('settings.edit');
  Route::put('/settings/{setting}', [SettingController::class, 'update'])->name('settings.update');

  Route::get('/transactions/{tipe}', [TransactionController::class, 'index'])->name('transactions.index');
  Route::get('/transactions/{tipe}/create', [TransactionController::class, 'create'])->name('transactions.create');
  Route::post('/transactions/{tipe}', [TransactionController::class, 'store'])->name('transactions.store');
  Route::get('/transactions/{tipe}/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
  Route::get('/transactions/{tipe}/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
  Route::put('/transactions/{tipe}/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
  Route::delete('/transactions/{tipe}/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
});