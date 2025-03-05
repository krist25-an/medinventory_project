@extends('layouts.dashboard')

@section('title')
  {{ isset($medicine) ? 'Edit Obat' : 'Tambah Obat' }}
@endsection

@section('content')
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold">{{ isset($medicine) ? 'Edit Obat' : 'Tambah Obat' }}</h3>
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
          <a href="{{ route('medicines.index') }}">Obat</a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="#">
            {{ isset($medicine) ? 'Edit Obat' : 'Tambah Obat' }}
          </a>
        </li>
      </ul>
    </div>

    <div class="row">
      <div class="card">
        <div class="card-body">
          <form action="{{ isset($medicine) ? route('medicines.update', $medicine->id) : route('medicines.store') }}"
            method="POST">
            @csrf
            @if (isset($medicine))
              @method('PUT')
            @endif

            <!-- Nama Obat -->
            <div class="form-group">
              <label for="nama">Nama Obat</label>
              <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                value="{{ old('nama', $medicine->nama ?? '') }}" required>
              @error('nama')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Deskripsi -->
            <div class="form-group">
              <label for="deskripsi">Deskripsi</label>
              <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" required>{{ old('deskripsi', $medicine->deskripsi ?? '') }}</textarea>
              @error('deskripsi')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Stok -->
            <div class="form-group">
              <label for="stok">Stok</label>
              <input type="number" name="stok" id="stok" class="form-control @error('stok') is-invalid @enderror"
                value="{{ old('stok', $medicine->stok ?? '') }}" required>
              @error('stok')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Stok Minimum -->
            <div class="form-group">
              <label for="stok_min">Stok Minimum</label>
              <input type="number" name="stok_min" id="stok_min"
                class="form-control @error('stok_min') is-invalid @enderror"
                value="{{ old('stok_min', $medicine->stok_min ?? '') }}" required>
              @error('stok_min')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Harga -->
            <div class="form-group">
              <label for="harga">Harga</label>
              <input type="number" name="harga" id="harga"
                class="form-control @error('harga') is-invalid @enderror"
                value="{{ old('harga', $medicine->harga ?? '') }}" required>
              @error('harga')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Satuan -->
            <div class="form-group">
              <label for="satuan">Satuan</label>
              <input type="text" name="satuan" id="satuan"
                class="form-control @error('satuan') is-invalid @enderror"
                value="{{ old('satuan', $medicine->satuan ?? '') }}" required>
              @error('satuan')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Tanggal Kedaluwarsa -->
            <div class="form-group">
              <label for="expired">Tanggal Kedaluwarsa</label>
              <input type="date" name="expired" id="expired"
                class="form-control @error('expired') is-invalid @enderror"
                value="{{ old('expired', isset($medicine) ? $medicine->expired->format('Y-m-d') : '') }}" required>
              @error('expired')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                {{ isset($medicine) ? 'Perbarui Obat' : 'Tambahkan Obat' }}
              </button>
              <a href="{{ route('medicines.index') }}" class="btn btn-secondary">Batal</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
