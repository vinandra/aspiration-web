@extends('layouts.app')

@section('content')
    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ auth()->user()->role_id == \App\Models\Role::ROLE_ADMIN ? 'Aduan Warga' : 'Aduan' }}</h1>
        @if (isset(auth()->user()->resident))
            <a href="/complaint/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Buat Aspirasi
            </a>
        @endif
    </div>

    {{-- SweetAlert Notifications --}}
    @if (session('success'))
        <script>
            Swal.fire({
                title: "Berhasil!",
                text: "{{ session()->get('success') }}",
                icon: "success"
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: "Terjadi Kesalahan",
                text: "{{ session()->get('error') }}",
                icon: "error"
            });
        </script>
    @endif

    {{-- Data Table --}}
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    @if (auth()->user()->role_id == \App\Models\Role::ROLE_ADMIN)
                                        <th>Nama Penduduk</th>
                                    @endif
                                    <th>Judul</th>
                                    <th>Isi Aspirasi</th>
                                    <th>Status</th>
                                    <th>Foto (optional)</th>
                                    <th>Tanggal Laporan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($complaints as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + $complaints->firstItem() - 1 }}</td>
                                        @if (auth()->user()->role_id == \App\Models\Role::ROLE_ADMIN)
                                            <td>{{$item->resident->name}}</td>
                                        @endif
                                        <td>{{ $item->title }}</td>
                                        <td>{!! wordwrap($item->content, 50, "<br>\n") !!}</td>
                                        <td>
                                            <span class="badge badge-{{ $item->status_color }}">{{ $item->status_label }}</span>
                                        </td>
                                        <td>
                                            @if ($item->photo_proof)
                                                @php
                                                    $filePath = 'storage/' . $item->photo_proof;
                                                @endphp
                                                <a href="{{ asset($filePath) }}" target="_blank" rel="noopener noreferrer">
                                                    <img src="{{ asset($filePath) }}" alt="foto" style="max-width:300px;">
                                                </a>
                                            @else
                                                Tidak Ada
                                            @endif
                                        </td>
                                        <td>{{ $item->report_date_label }}</td>
                                        <td>
                                            @if (auth()->user()->role_id == \App\Models\Role::ROLE_USER && isset(auth()->user()->resident) && $item->status == 'new')
                                                <div class="d-flex align-items-center" style="gap: 10px;">
                                                    <a href="/complaint/{{ $item->id }}" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationDelete-{{ $item->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            @elseif (auth()->user()->role_id == \App\Models\Role::ROLE_ADMIN)
                                                <div>
                                                    <form id="formChangeStatus-{{ $item->id }}" action="/complaint/update-status/{{ $item->id }}" method="POST">
                                                        @csrf
                                                        <div class="form-group">
                                                            <select name="status" class="form-control" style="min-width:180px;" onchange="document.getElementById('formChangeStatus-{{ $item->id }}').submit();">
                                                                <option value="new" {{ $item->status == 'new' ? 'selected' : '' }}>Baru</option>
                                                                <option value="processing" {{ $item->status == 'processing' ? 'selected' : '' }}>Sedang Diproses</option>
                                                                <option value="completed" {{ $item->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                                            </select>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>

                                    {{-- Modal Delete --}}
                                    @include('pages.complaint.confirmation-delete')

                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center pt-3">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $complaints->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
