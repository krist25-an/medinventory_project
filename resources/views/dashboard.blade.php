@extends('layouts.dashboard')

@section('title')
  Dashboard
@endsection

@section('content')
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
      <div class="">
        <h3 class="fw-bold"> Dashboard </h3>
        <h6 class="op-7">Sistem Inventory Obat Puskesmas</h6>
      </div>
      <div class="ms-md-auto py-2 py-md-0">
        <h5 class="op-7">{{ now()->format('F Y') }}</h5>
      </div>
    </div>

    <div class="row mt-2">
      <!-- Total Medicines -->
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-primary bubble-shadow-small">
                  <i class="fas fa-capsules"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Jumlah Obat</p>
                  <h4 class="card-title">{{ number_format($totalMedicines) }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Low Stock Medicines -->
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-danger bubble-shadow-small">
                  <i class="fas fa-exclamation-triangle"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Stok Rendah</p>
                  <h4 class="card-title">{{ number_format($lowStockMedicines) }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Transactions In (Masuk) This Month -->
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-success bubble-shadow-small">
                  <i class="fas fa-arrow-down"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Transactions Masuk</p>
                  <h4 class="card-title">{{ number_format($transactionsIn) }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Transactions Out (Keluar) This Month -->
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-warning bubble-shadow-small">
                  <i class="fas fa-arrow-up"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Transactions Keluar</p>
                  <h4 class="card-title">{{ number_format($transactionsOut) }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h6 class="fw-bold">Transaksi Terbaru</h6>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="basic-datatables" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Nama Obat</th>
                    <th>Tipe</th>
                    <th>Jumlah</th>
                    <th>Total Stok</th>
                    <th>Tanggal</th>
                    <th>Catatan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($recentTransactions as $transaction)
                    <tr>
                      <td>{{ $transaction->medicine->nama }}</td>
                      <td>
                        <span class="badge {{ $transaction->tipe == 'masuk' ? 'badge-success' : 'badge-danger' }}">
                          {{ ucfirst($transaction->tipe) }}
                        </span>
                      </td>
                      <td class="{{ $transaction->jumlah <= 0 ? 'text-danger fw-bold' : '' }}">
                        {{ $transaction->jumlah . ' ' . $transaction->medicine->satuan }}
                      </td>
                      <td
                        class="{{ $transaction->medicine->stok <= $transaction->medicine->stok_min ? 'text-danger fw-bold' : '' }}">
                        {{ $transaction->medicine->stok . ' ' . $transaction->medicine->satuan }}
                      </td>
                      <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                      <td>{{ $transaction->keterangan ?? '-' }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
