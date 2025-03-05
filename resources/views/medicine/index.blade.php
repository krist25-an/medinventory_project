@extends('layouts.dashboard')

@section('title')
  Obat
@endsection

@section('content')
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
      <div class="page-header mb-0">
        <h3 class="fw-bold">Obat</h3>
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
        </ul>
      </div>
      <div class="ms-md-auto py-2 py-md-0">
        <a href="{{ route('medicines.create') }}" class="btn btn-primary btn-round">Tambah Obat</a>
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
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Kadaluarsa</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($medicines as $medicine)
                    <tr>
                      <td><a class="text-decoration-underline"
                          href="{{ route('medicines.show', $medicine->id) }}">{{ $medicine->nama }}</a></td>
                      <td>{{ 'Rp' . number_format($medicine->harga) }}</td>
                      <td class="{{ $medicine->stok <= $medicine->stok_min ? 'text-danger fw-bold' : '' }}">
                        {{ $medicine->stok . ' ' . $medicine->satuan }}
                      </td>
                      <td>{{ $medicine->expired->format('l d M Y') }}</td>
                      <td>
                        <!-- Edit Button -->
                        <a href="{{ route('medicines.edit', $medicine->id) }}" class="btn btn-sm btn-primary">
                          <i class="fas fa-edit"></i> Edit
                        </a>

                        <!-- Delete Button -->
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-name="{{ $medicine->nama }}"
                          data-id="{{ $medicine->id }}">
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

    // Delete Medicine
    document.addEventListener('DOMContentLoaded', function() {
      const deleteButtons = document.querySelectorAll('.delete-btn');

      deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
          const medicineId = this.getAttribute('data-id');
          const medicineName = this.getAttribute('data-name');

          Swal.fire({
            title: 'Apakah anda yakin?',
            text: `Obat '${medicineName}' akan dihapus dari aplikasi ini. Anda tidak akan bisa mengembalikan lagi!`,
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
              form.action = `{{ url('medicines') }}/${medicineId}`;
              form.style.display = 'none';

              // Add CSRF and DELETE method inputs
              const csrfInput = document.createElement('input');
              csrfInput.name = '_token';
              csrfInput.value = '{{ csrf_token() }}';
              csrfInput.type = 'hidden';
              form.appendChild(csrfInput);

              const methodInput = document.createElement('input');
              methodInput.name = '_method';
              methodInput.value = 'DELETE';
              methodInput.type = 'hidden';
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
