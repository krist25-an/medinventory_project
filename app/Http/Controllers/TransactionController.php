<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
  // Display a list of transactions based on tipe (in or out)
  public function index($tipe)
  {
    if (!in_array($tipe, ['masuk', 'keluar'])) {
      abort(404);
    }

    $transactions = Transaction::where('tipe', $tipe)->get();

    return view('transactions.index', compact('transactions', 'tipe'));
  }

  // Show the form to create a transaction (in or out)
  public function create($tipe)
  {
    if (!in_array($tipe, ['masuk', 'keluar'])) {
      abort(404);
    }

    $medicines = Medicine::all();
    return view('transactions.form', compact('tipe', 'medicines'));
  }

  // Store a new transaction (in or out)
  public function store(Request $request, $tipe)
  {
    if (!in_array($tipe, ['masuk', 'keluar'])) {
      abort(404);
    }

    $request->validate([
      'medicine_id' => 'required|exists:medicines,id',
      'jumlah' => 'required|integer|min:1',
      'keterangan' => 'nullable|string',
    ]);


    $medicine = Medicine::findOrFail($request->medicine_id);

    if ($tipe == 'keluar' && $medicine->stok < $request->jumlah) {
      return redirect()->back()->with('error', 'Stok tidak mencukupi!');
    }

    Transaction::create([
      'medicine_id' => $request->medicine_id,
      'jumlah' => $request->jumlah,
      'keterangan' => $request->keterangan,
      'tipe' => $tipe,
    ]);

    // Update medicine stock
    $medicine->stok += $tipe == 'masuk' ? $request->jumlah : -$request->jumlah;
    $medicine->save();

    return redirect()->route('transactions.index', $tipe)->with('success', 'Transaksi berhasil ditambahkan!');
  }

  // Show a single transaction
  public function show($tipe, Transaction $transaction)
  {
    if ($transaction->tipe !== $tipe) {
      abort(404);
    }

    return view('transactions.show', compact('transaction', 'tipe'));
  }

  // Show the form to edit a transaction
  public function edit($tipe, Transaction $transaction)
  {
    if ($transaction->tipe !== $tipe) {
      abort(404);
    }

    $transaction = Transaction::with('medicine')->where('id', $transaction->id)->first();

    $medicines = Medicine::all();
    return view('transactions.form', compact('transaction', 'tipe', 'medicines'));
  }

  // Update a transaction
  public function update(Request $request, $tipe, Transaction $transaction)
  {
    if ($transaction->tipe !== $tipe) {
      abort(404);
    }

    $request->validate([
      'medicine_id' => 'required|exists:medicines,id',
      'jumlah' => 'required|integer|min:1',
      'keterangan' => 'nullable|string',
    ]);

    $medicine = Medicine::findOrFail($request->medicine_id);

    // Reverse the previous transaction effect
    $medicine->stok += $tipe == 'masuk' ? -$transaction->jumlah : $transaction->jumlah;

    if ($tipe == 'keluar' && $medicine->stok < $request->jumlah) {
      return redirect()->back()->with('error', 'Stok tidak mencukupi!');
    }

    // Update transaction
    $transaction->update([
      'medicine_id' => $request->medicine_id,
      'jumlah' => $tipe == 'masuk' ? $request->jumlah : -$request->jumlah,
      'keterangan' => $request->keterangan,
    ]);

    // Update stock again
    $medicine->stok += $tipe == 'masuk' ? $request->jumlah : -$request->jumlah;
    $medicine->save();

    return redirect()->route('transactions.index', $tipe)->with('success', 'Transaksi berhasil diperbarui!');
  }

  // Delete a transaction
  public function destroy($tipe, Transaction $transaction)
  {
    if ($transaction->tipe !== $tipe) {
      abort(404);
    }

    $medicine = $transaction->medicine;
    $medicine->stok += $tipe == 'masuk' ? -$transaction->jumlah : $transaction->jumlah;
    $medicine->save();

    $transaction->delete();

    return redirect()->route('transactions.index', $tipe)->with('success', 'Transaksi berhasil dihapus!');
  }
}
