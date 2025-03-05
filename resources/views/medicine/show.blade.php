@extends('layouts.dashboard')

@section('content')
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold">Detail Obat</h3>
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
            Detail Obat
          </a>
        </li>
      </ul>
    </div>

    <!-- Medicine Details -->
    <div class="card mb-4">
      <div class="card-header">
        Informasi Obat
      </div>
      <div class="card-body">
        <table class="table">
          <tr>
            <th>Nama Obat</th>
            <td>{{ $medicine->nama }}</td>
          </tr>
          <tr>
            <th>Deskripsi</th>
            <td>{{ $medicine->deskripsi }}</td>
          </tr>
          <tr>
            <th>Stok</th>
            <td>{{ $medicine->stok }}</td>
          </tr>
          <tr>
            <th>Stok Minimum</th>
            <td>{{ $medicine->stok_min }}</td>
          </tr>
          <tr>
            <th>Harga</th>
            <td>Rp {{ number_format($medicine->harga, 0, ',', '.') }}</td>
          </tr>
          <tr>
            <th>Satuan</th>
            <td>{{ $medicine->satuan }}</td>
          </tr>
          <tr>
            <th>Tanggal Kedaluwarsa</th>
            <td>{{ $medicine->expired->format('d M Y') }}</td>
          </tr>
        </table>
      </div>
    </div>
    <!-- Transaction History -->
    <div class="card">
      <div class="card-header">
        Riwayat Transaksi
      </div>
      <div class="card-body">
        @if ($transactions->isEmpty())
          <p class="text-muted">Belum ada transaksi untuk obat ini.</p>
        @else
          <table id="transaction-datatables" class="display table table-striped table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Jumlah</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($transactions as $index => $transaction)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $transaction->created_at->format('d M Y') }}</td>
                  <td>
                    <span class="badge {{ $transaction->tipe == 'masuk' ? 'badge-success' : 'badge-danger' }}">
                      {{ ucfirst($transaction->tipe) }}
                    </span>
                  </td>
                  <td>{{ $transaction->jumlah }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>

    <!-- Back Button -->
    <div class="mt-3">
      <a href="{{ route('medicines.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $("#transaction-datatables").DataTable({});
  </script>
@endsection
