@extends('layouts.dashboard')

@section('title')
  {{ isset($medicine) ? 'Edit Transaksi Obat' : 'Tambah Transaksi Obat' }}
@endsection

@section('content')
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold">{{ isset($medicine) ? 'Edit Transaksi Obat' : 'Tambah Transaksi Obat' }}</h3>
      <ul class="breadcrumbs">
        <li class="nav-home">
          <a href="{{ route('dashboard') }}">
            <i class="icon-home"></i>
          </a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="{{ route('transactions.index', $tipe) }}">Transaksi</a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="#">
            {{ isset($medicine) ? 'Edit Transaksi Obat' : 'Tambah Transaksi Obat' }}
          </a>
        </li>
      </ul>
    </div>

    <div class="row">
      <div class="card">
        <div class="card-body">
          <form
            action="{{ isset($transaction) ? route('transactions.update', ['tipe' => $tipe, 'transaction' => $transaction->id]) : route('transactions.store', $tipe) }}"
            method="POST">
            @csrf
            @if (isset($transaction))
              @method('PUT')
            @endif

            <!-- Tipe Transaksi (Masuk/Keluar) -->
            <div class="form-group">
              <label for="tipe">Tipe Transaksi</label>
              <select name="tipe" id="tipe" class="form-control @error('tipe') is-invalid @enderror" disabled
                required>
                <option value="masuk" {{ old('tipe', $transaction->tipe ?? '') == 'masuk' ? 'selected' : '' }}>Masuk
                </option>
                <option value="keluar" {{ old('tipe', $transaction->tipe ?? '') == 'keluar' ? 'selected' : '' }}>
                  Keluar</option>
              </select>
              @error('tipe')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Nama Obat -->
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="medicine_id">Nama Obat</label>
                  <select name="medicine_id" id="medicine_id"
                    class="form-control @error('medicine_id') is-invalid @enderror" required>
                    <option value="" disabled selected>Pilih Obat</option>
                    @foreach ($medicines as $medicine)
                      <option value="{{ $medicine->id }}" data-stok={{ $medicine->stok }}
                        {{ old('medicine_id', $transaction->medicine_id ?? '') == $medicine->id ? 'selected' : '' }}>
                        {{ $medicine->nama }}
                      </option>
                    @endforeach
                  </select>
                  @error('medicine_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="sisa_stok">Sisa Stok</label>
                  <input type="number" name="sisa_stok" id="sisa_stok"
                    class="form-control @error('jumlah') is-invalid @enderror"
                    value="{{ old('sisa_stok', $transaction->medicine->stok ?? '') }}" required readonly>
                  @error('sisa_stok')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror

                </div>
              </div>
            </div>

            <!-- Jumlah -->
            <div class="form-group">
              <label for="jumlah">Jumlah</label>
              <input type="number" name="jumlah" id="jumlah"
                class="form-control @error('jumlah') is-invalid @enderror"
                value="{{ old('jumlah', $transaction->jumlah ?? '') }}" required>
              @error('jumlah')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Keterangan -->
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $transaction->keterangan ?? '') }}</textarea>
              @error('keterangan')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                {{ isset($transaction) ? 'Perbarui Transaksi' : 'Tambahkan Transaksi' }}
              </button>
              <a href="{{ route('transactions.index', $tipe) }}" class="btn btn-secondary">Batal</a>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const medicineSelect = document.getElementById("medicine_id");
      const stokInput = document.getElementById("sisa_stok");

      medicineSelect.addEventListener("change", function() {
        const selectedOption = this.options[this.selectedIndex];
        const stok = selectedOption.getAttribute("data-stok");
        stokInput.value = stok ? stok : "";
      });
    });
  </script>
@endsection
