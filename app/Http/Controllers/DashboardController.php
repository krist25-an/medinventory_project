<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index()
  {
    // Get total medicines
    $totalMedicines = Medicine::count();

    // Get low stock medicines (where stock is less than minimum stock)
    $lowStockMedicines = Medicine::whereColumn('stok', '<', 'stok_min')->count();

    // Get transactions in (Masuk) this month
    $transactionsIn = Transaction::where('tipe', 'masuk')
      ->whereMonth('created_at', Carbon::now()->month)
      ->count();

    // Get transactions out (Keluar) this month
    $transactionsOut = Transaction::where('tipe', 'keluar')
      ->whereMonth('created_at', Carbon::now()->month)
      ->count();

    $recentTransactions = Transaction::orderBy('created_at', 'desc')->limit(10)->with('medicine')->get();

    return view('dashboard', compact(
      'totalMedicines',
      'lowStockMedicines',
      'transactionsIn',
      'transactionsOut',
      'recentTransactions'
    ));
  }
}
