@extends('layouts.dashboard')

@section('title')
  Transaksi Obat {{ $tipe }}
@endsection

@section('content')
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
      <div class="page-header mb-0">
        <h3 class="fw-bold">Transaksi Obat {{ Str::ucfirst($tipe) }}</h3>
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
            <a href="#">{{ 'Obat ' . Str::ucfirst($tipe) }}</a>
          </li>
        </ul>
      </div>
      <div class="ms-md-auto py-2 py-md-0">
        <a href="{{ route('transactions.create', $tipe) }}" class="btn btn-primary btn-round">
          Tambah Transaksi
        </a>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table id="basic-datatables" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Total Stok</th>
                    <th>Tanggal</th>
                    <th>Catatan</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($transactions as $transaction)
                    <tr>
                      <td>{{ $transaction->medicine->nama }}</td>
                      <td class="{{ $transaction->jumlah <= 0 ? 'text-danger fw-bold' : '' }}">
                        {{ $transaction->jumlah . ' ' . $transaction->medicine->satuan }}
                      </td>
                      <td
                        class="{{ $transaction->medicine->stok <= $transaction->medicine->stok_min ? 'text-danger fw-bold' : '' }}">
                        {{ $transaction->medicine->stok . ' ' . $transaction->medicine->satuan }}
                      </td>
                      <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                      <td>{{ $transaction->keterangan ?? '-' }}</td>
                      <td>
                        <!-- Edit Button -->
                        <a href="{{ route('transactions.edit', ['tipe' => $tipe, 'transaction' => $transaction->id]) }}"
                          class="btn btn-sm btn-primary">
                          <i class="fas fa-edit"></i> Edit
                        </a>

                        <!-- Delete Button -->
                        <button tipe="button" class="btn btn-sm btn-danger delete-btn"
                          data-name="{{ $transaction->medicine->nama }}" data-id="{{ $transaction->id }}">
                          <i class="fas fa-trash"></i> Hapus
                        </button>
                      </td>
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

@section('script')
  <script>
    $("#basic-datatables").DataTable({});

    // Delete Transaction
    document.addEventListener('DOMContentLoaded', function() {
      const deleteButtons = document.querySelectorAll('.delete-btn');

      deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
          const transactionId = this.getAttribute('data-id');
          const medicineName = this.getAttribute('data-name');

          Swal.fire({
            title: 'Apakah anda yakin?',
            text: `Transaksi '${medicineName}' akan dihapus. Anda tidak akan bisa mengembalikan lagi!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
          }).then((result) => {
            if (result.isConfirmed) {
              // Create a hidden form to submit the delete request
              const form = document.createElement('form');
              form.method = 'POST';
              form.action = `{{ url('transactions') }}/{{ $tipe }}/${transactionId}`;
              form.style.display = 'none';

              // Add CSRF and DELETE method inputs
              const csrfInput = document.createElement('input');
              csrfInput.name = '_token';
              csrfInput.value = '{{ csrf_token() }}';
              csrfInput.tipe = 'hidden';
              form.appendChild(csrfInput);

              const methodInput = document.createElement('input');
              methodInput.name = '_method';
              methodInput.value = 'DELETE';
              methodInput.tipe = 'hidden';
              form.appendChild(methodInput);

              // Append the form to the body and submit it
              document.body.appendChild(form);
              form.submit();
            }
          });
        });
      });
    });
  </script>
@endsection
