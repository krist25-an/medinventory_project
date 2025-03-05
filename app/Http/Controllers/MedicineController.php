<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Transaction;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
  /**
   * Menampilkan daftar obat.
   */
  public function index()
  {
    $medicines = Medicine::all();
    return view('medicine.index', compact('medicines'));
  }

  public function create()
  {

    return view('medicine.form');
  }

  /**
   * Menyimpan obat baru ke database.
   */
  public function store(Request $request)
  {
    $request->validate([
      'nama' => 'required|string|max:255',
      'deskripsi' => 'nullable|string',
      'stok' => 'required|integer|min:0',
      'stok_min' => 'required|integer|min:0',
      'harga' => 'nullable|numeric|min:0',
      'satuan' => 'required|string|max:50',
      'expired' => 'required|date',
    ]);

    try {
      Medicine::create($request->all());
      return redirect()->route('medicines.index')->with('success', 'Obat berhasil ditambahkan!');
    } catch (\Exception $e) {
      return redirect()->back()->withInput()->with('error', 'Gagal menambahkan obat: ' . $e->getMessage());
    }
  }

  /**
   * Menampilkan detail obat berdasarkan ID.
   */
  public function show($id)
  {
    $medicine = Medicine::findOrFail($id);
    $transactions = Transaction::where('medicine_id', $id)->orderBy('created_at', 'desc')->get();

    return view('medicine.show', compact('medicine', 'transactions'));
  }

  public function edit($id)
  {
    $medicine = Medicine::findOrFail($id);

    return view('medicine.form', compact('medicine'));
  }

  /**
   * Memperbarui data obat yang sudah ada.
   */
  public function update(Request $request, Medicine $medicine)
  {
    $request->validate([
      'nama' => 'required|string|max:255',
      'deskripsi' => 'nullable|string',
      'stok' => 'required|integer|min:0',
      'stok_min' => 'required|integer|min:0',
      'harga' => 'nullable|numeric|min:0',
      'satuan' => 'required|string|max:50',
      'expired' => 'required|date',
    ]);

    try {
      $medicine->update($request->all());
      return redirect()->route('medicines.index')->with('success', 'Obat berhasil diperbarui!');
    } catch (\Exception $e) {
      return redirect()->back()->withInput()->with('error', 'Gagal memperbarui obat: ' . $e->getMessage());
    }
  }

  /**
   * Menghapus obat dari database.
   */
  public function destroy(Medicine $medicine)
  {
    try {
      $medicine->delete();
      return redirect()->route('medicines.index')->with('success', 'Obat berhasil dihapus!');
    } catch (\Exception $e) {
      return redirect()->back()->with('error', 'Gagal menghapus obat: ' . $e->getMessage());
    }
  }
}
