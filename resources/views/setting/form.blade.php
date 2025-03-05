@extends('layouts.dashboard')

@section('title')
  {{ isset($medicine) ? 'Edit Transaksi Setting' : 'Tambah Transaksi Setting' }}
@endsection

@section('content')
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold">{{ isset($medicine) ? 'Edit Transaksi Setting' : 'Tambah Transaksi Setting' }}</h3>
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
          <a href="{{ route('settings.index') }}">Pengaturan</a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="#">
            {{ isset($setting) ? 'Edit Pengaturan' : 'Tambah Pengaturan' }}
          </a>
        </li>
      </ul>
    </div>

    <div class="row">
      <div class="card">
        <div class="card-body">
          <form action="{{ isset($setting) ? route('settings.update', $setting->id) : route('settings.store') }}"
            method="POST">
            @csrf
            @if (isset($setting))
              @method('PUT')
            @endif

            <!-- Key -->
            <div class="form-group">
              <label for="key">Key</label>
              <input type="text" name="key" id="key" class="form-control @error('key') is-invalid @enderror"
                value="{{ old('key', $setting->key ?? '') }}" readonly required>
              @error('key')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Name -->
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $setting->name ?? '') }}" readonly required>
              @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Value -->
            <div class="form-group">
              <label for="value">Value</label>
              <textarea name="value" id="value" rows="7" class="form-control @error('value') is-invalid @enderror"
                required>
                {{ old('value', $setting->value ?? '') }}
              </textarea>

              {{-- <input type="text" name="value" id="value"
                class="form-control @error('value') is-invalid @enderror"
                value="{{ old('value', $setting->value ?? '') }}" required> --}}
              @error('value')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                {{ isset($setting) ? 'Perbarui Pengaturan' : 'Tambahkan Pengaturan' }}
              </button>
              <a href="{{ route('settings.index') }}" class="btn btn-secondary">Batal</a>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
@endsection
