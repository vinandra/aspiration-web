@extends('layouts.app')

@section('content')
        <style>
            thead{
                background-color: #00b4d8;
                text-align: center;
                color: whitesmoke;
            }
        </style>
        {{-- page heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Akun Penduduk</h1>
        </div>
        @if (session('success'))
        <script>
            Swal.fire({
                title: "Berhasil!",
                text:  "{{ session()->get('success') }}",
                icon:  "success"
            });
        </script>
        @endif
        {{-- tabel --}}
    
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="" style="overflow-x: auto;">
                            <div class="table-responsive" style="min-width: 100%;">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Nik</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    @if (count($users) < 1)
                                        <tbody>
                                            <tr>
                                                <td colspan="11">
                                                    <p class="pt-3 text-center"> tidak ada data</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    @else
                                    <tbody>
                                        @foreach ($users as $item)
                                            <tr>
                                                <td>{{ $loop->iteration + $users->firstItem() - 1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->nik }}</td>
                                                <td>
                                                    @if ($item->status == 'approved')
                                                        <span class="badge badge-success">Aktif</span>
                                                    @else
                                                        <span class="badge badge-danger">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex" style="gap: 10px;">
                                                        @if ($item->status == 'approved')
                                                            <button type="button"  class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmationReject-{{ $item->id }}">
                                                                Non-aktifkan Akun
                                                            </button>
                                                        @else
                                                            <button type="button"  class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#confirmationApprove-{{ $item->id }}">
                                                                Aftikan Akun
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>  
                                            @include('pages.account-list.confirmation-approve')
                                            @include('pages.account-list.confirmation-reject')
                                        @endforeach
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
    
                    </div>
                    @if ($users->lastPage() > 1)
                        <div class="card-footer">
                            {{ $users->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
@endsection