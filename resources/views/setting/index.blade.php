@extends('layouts.dashboard')

@section('title')
  Setting - {{ env('APP_NAME') }}
@endsection

@section('content')
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
      <div class="page-header mb-0">
        <h3 class="fw-bold">Pengaturan</h3>
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
          </li>
        </ul>
      </div>
      {{-- <div class="ms-md-auto py-2 py-md-0">
        <a href="{{ route('setting.create', $tipe) }}" class="btn btn-primary btn-round">
          Tambah Transaksi
        </a>
      </div> --}}
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            Daftar Pengaturan
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Nama Pengaturan</th>
                    <th>Value</th>
                    <th>Action</th>
                  </tr>
                </thead>
                @foreach ($settings as $setting)
                  <tr>
                    <td>{{ $setting->name }}</td>
                    <td>{{ $setting->value }}</td>
                    <td>
                      <a href="{{ route('settings.edit', $setting->id) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Edit
                      </a>
                    </td>
                  </tr>
                @endforeach
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
