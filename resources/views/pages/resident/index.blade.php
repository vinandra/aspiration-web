@extends('layouts.app')

@section('content')
        {{-- page heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Penduduk</h1>
            <a href="/resident/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
        </div>
        {{-- tabel --}}
    <style>
        thead{
            background-color: #00b4d8;
            text-align: center;
            color: whitesmoke;
        }
        .tombol{
            background-color: #00b4d8;
            color: whitesmoke;
        }
    </style>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tempat Tinggal lahir</th>
                                        <th>Alamat</th>
                                        <th>Agama</th>
                                        <th>Status Perkawinan</th>
                                        <th>Pekerjaan</th>
                                        <th>Telepon</th>
                                        <th>Status Penduduk</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                @if (count($residents) < 1)
                                    <tbody>
                                        <tr>
                                            <td colspan="11">
                                                <p class="pt-3 text-center"> tidak ada data</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                @else
                                <tbody>
                                    @foreach ($residents as $item)
                                        <tr>
                                            <td>{{ $loop->iteration + $residents->firstItem() - 1 }}</td>
                                            <td>{{ $item->nik }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->gender }}</td>
                                            <td>{{ $item->birth_place }}, {{ $item->birth_date }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td>{{ $item->religion }}</td>
                                            <td>{{ $item->marital_status }}</td>
                                            <td>{{ $item->occupation }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td class="tombol">
                                                <div class="d-flex align-item-center" style="gap: 10px;">
                                                    <a href="/resident/{{ $item->id }}" class="d-inline-block  btn btn-sm btn-warning">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <button type="button"  class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationDelete-{{ $item->id }}">
                                                        <i class="fas fa-eraser"></i>
                                                    </button>
                                                    @if (!is_null($item->user_id))
                                                    <button type="button"  class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailAccount-{{ $item->id }}">
                                                        Lihat Akun
                                                    </button>
                                                    @include('pages.resident.detail-account')
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>  
                                        @include('pages.resident.confirmation-delete')
                                        
                                    @endforeach
                                </tbody>
                                @endif
                            </table>
                        </div>
    
                    </div>
                    <div class="card-footer">
                        {{ $residents->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
@endsection