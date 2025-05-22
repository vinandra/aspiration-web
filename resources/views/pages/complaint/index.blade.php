@extends('layouts.app')

@section('content')
    @php
        $adminLikeRoles = [
            \App\Models\Role::ROLE_ADMIN,
            \App\Models\Role::ROLE_KASI_PEMBANGUNAN,
            \App\Models\Role::ROLE_KASI_KESEJAHTERAAN_SOSIAL,
            \App\Models\Role::ROLE_KASI_PEMERINTAHAN_KETENTRAMAN,
            \App\Models\Role::ROLE_SEKRETARIS_LURAH,
            \App\Models\Role::ROLE_LURAH,
        ];
    @endphp

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ in_array(auth()->user()->role_id, $adminLikeRoles) ? 'Aduan Warga' : 'Aduan' }}</h1>
        @if (isset(auth()->user()->resident))
            <a href="/complaint/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Buat Aspirasi
            </a>
        @endif
    </div>

    <!-- Filter Section - Hanya untuk admin -->
    @if (in_array(auth()->user()->role_id, $adminLikeRoles))
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Filter Aduan</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="/complaint">
                        <div class="form-group">
                            <label for="filter">Tampilkan:</label>
                            <select name="filter" id="filter" class="form-control" onchange="this.form.submit()">
                                <option value="all" {{ request('filter', 'all') == 'all' ? 'selected' : '' }}>
                                    Semua Aduan
                                </option>
                                <option value="registered" {{ request('filter') == 'registered' ? 'selected' : '' }}>
                                    Pengguna Terdaftar Saja
                                </option>
                                <option value="anonymous" {{ request('filter') == 'anonymous' ? 'selected' : '' }}>
                                    Pengguna Anonim Saja
                                </option>
                            </select>
                        </div>
                    </form>
                    
                    <!-- Info Filter -->
                    <div class="alert alert-info mt-2 mb-0">
                        <small>
                            <i class="fas fa-info-circle"></i>
                            @if(request('filter') == 'registered')
                                Menampilkan hanya aduan dari <strong>pengguna terdaftar</strong>
                            @elseif(request('filter') == 'anonymous') 
                                Menampilkan hanya aduan dari <strong>pengguna anonim</strong>
                            @else
                                Menampilkan <strong>semua aduan</strong> (terdaftar + anonim)
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <style>
        thead {
            background-color: #00b4d8;
            text-align: center;
            color: whitesmoke;
        }
    </style>

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

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    @if (in_array(auth()->user()->role_id, $adminLikeRoles))
                                        <th>Nama Penduduk</th>
                                        <th>Tipe</th>
                                    @endif
                                    <th>Judul</th>
                                    <th>Isi Aspirasi</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Foto (optional)</th>
                                    <th>Tanggal Laporan</th>
                                    <th>Aksi</th>
                                    @if (in_array(auth()->user()->role_id, $adminLikeRoles))
                                        <th>Teruskan</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($complaints as $item)
                                    @php
                                        $canView = false;
                                        $currentRole = auth()->user()->role_id;

                                        if ($currentRole == \App\Models\Role::ROLE_ADMIN) {
                                            $canView = true;
                                        } elseif ($currentRole == \App\Models\Role::ROLE_USER && isset(auth()->user()->resident)) {
                                            $canView = isset($item->resident_id) && $item->resident_id == auth()->user()->resident->id;
                                        } elseif (isset($item->forwarded_to) && $item->forwarded_to == $currentRole) {
                                            $canView = true;
                                        } elseif (!isset($item->forwarded_to) && in_array($currentRole, $adminLikeRoles)) {
                                            $canView = true;
                                        }
                                    @endphp

                                    @if ($canView)
                                        <tr>
                                            <td>{{ $loop->iteration + $complaints->firstItem() - 1 }}</td>
                                            @if (in_array(auth()->user()->role_id, $adminLikeRoles))
                                                <td>{{ $item->complainant_name ?? ($item->resident->name ?? 'Unknown') }}</td>
                                                <td>
                                                    @if(isset($item->source_type))
                                                        @if($item->source_type == 'registered')
                                                            <span class="badge badge-success">
                                                                <i class="fas fa-user-check"></i> Terdaftar
                                                            </span>
                                                        @else
                                                            <span class="badge badge-warning">
                                                                <i class="fas fa-user-secret"></i> Anonim
                                                            </span>
                                                        @endif
                                                    @else
                                                        <span class="badge badge-success">
                                                            <i class="fas fa-user-check"></i> Terdaftar
                                                        </span>
                                                    @endif
                                                </td>
                                            @endif
                                            <td>{{ $item->title }}</td>
                                            <td>{!! wordwrap($item->content, 50, "<br>\n") !!}</td>
                                            <td>
                                                <span class="badge badge-secondary">{{ $item->kategori }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $item->status_color }}">{{ $item->status_label }}</span>
                                            </td>
                                            <td>
                                                @if ($item->photo_proof)
                                                    @php 
                                                        $filePath = str_starts_with($item->photo_proof, 'aspirasi_proofs/') 
                                                            ? 'storage/' . $item->photo_proof 
                                                            : 'storage/' . $item->photo_proof; 
                                                    @endphp
                                                    <a href="{{ asset($filePath) }}" target="_blank" rel="noopener noreferrer">
                                                        <img src="{{ asset($filePath) }}" alt="foto" style="max-width:300px;">
                                                    </a>
                                                @else
                                                    Tidak Ada
                                                @endif
                                            </td>
                                            <td>{{ $item->report_date_label ?? \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                                            <td>
                                                @if ($currentRole == \App\Models\Role::ROLE_USER && $item->status == 'new')
                                                    <div class="d-flex align-items-center" style="gap: 10px;">
                                                        <a href="{{ url('/complaint/' . $item->id . '/edit') }}" class="btn btn-sm btn-warning">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationDelete-{{ $item->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                @elseif (in_array($currentRole, $adminLikeRoles))
                                                    @if(isset($item->source_type) && $item->source_type == 'anonymous')
                                                        <!-- Form untuk aspirasi tampung -->
                                                        <form id="formChangeStatusAspirasi-{{ $item->id }}" action="/complaint/update-status-aspirasi/{{ $item->id }}" method="POST">
                                                            @csrf
                                                            <select name="status" class="form-control" style="min-width:180px;" onchange="document.getElementById('formChangeStatusAspirasi-{{ $item->id }}').submit();">
                                                                <option value="new" {{ $item->status == 'new' ? 'selected' : '' }}>Baru</option>
                                                                <option value="processing" {{ $item->status == 'processing' ? 'selected' : '' }}>Sedang Diproses</option>
                                                                <option value="completed" {{ $item->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                                            </select>
                                                        </form>
                                                    @else
                                                        <!-- Form untuk complaint biasa -->
                                                        <form id="formChangeStatus-{{ $item->id }}" action="/complaint/update-status/{{ $item->id }}" method="POST">
                                                            @csrf
                                                            <select name="status" class="form-control" style="min-width:180px;" onchange="document.getElementById('formChangeStatus-{{ $item->id }}').submit();">
                                                                <option value="new" {{ $item->status == 'new' ? 'selected' : '' }}>Baru</option>
                                                                <option value="processing" {{ $item->status == 'processing' ? 'selected' : '' }}>Sedang Diproses</option>
                                                                <option value="completed" {{ $item->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                                            </select>
                                                        </form>
                                                    @endif
                                                @endif
                                                
                                                @if (auth()->user()->role_id == \App\Models\Role::ROLE_ADMIN && (!isset($item->source_type) || $item->source_type == 'registered'))
                                                    <form action="/complaint/{{ $item->id }}/{{ $item->is_published ? 'unpublish' : 'publish' }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm {{ $item->is_published ? 'btn-danger' : 'btn-success' }}">
                                                            {{ $item->is_published ? 'Unpublish' : 'Publish' }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                            
                                            @if (in_array(auth()->user()->role_id, $adminLikeRoles))
                                            <td class="text-center">
                                                @if(!isset($item->source_type) || $item->source_type == 'registered')
                                                    @php
                                                        $canForward = false;
                                                        $nextForwardOptions = [];

                                                        switch ($currentRole) {
                                                            case \App\Models\Role::ROLE_ADMIN:
                                                                if (!$item->forwarded_to) {
                                                                    $canForward = true;
                                                                    $nextForwardOptions = [
                                                                        \App\Models\Role::ROLE_KASI_PEMBANGUNAN => 'KASI Pembangunan',
                                                                        \App\Models\Role::ROLE_KASI_KESEJAHTERAAN_SOSIAL => 'KASI Kesejahteraan Sosial',
                                                                        \App\Models\Role::ROLE_KASI_PEMERINTAHAN_KETENTRAMAN => 'KASI Pemerintahan Ketentraman',
                                                                        \App\Models\Role::ROLE_SEKRETARIS_LURAH => 'Sekretaris Lurah',
                                                                        \App\Models\Role::ROLE_LURAH => 'Lurah',
                                                                    ];
                                                                }
                                                                break;
                                                            case \App\Models\Role::ROLE_KASI_PEMBANGUNAN:
                                                            case \App\Models\Role::ROLE_KASI_KESEJAHTERAAN_SOSIAL:
                                                            case \App\Models\Role::ROLE_KASI_PEMERINTAHAN_KETENTRAMAN:
                                                                if ($item->forwarded_to == $currentRole) {
                                                                    $canForward = true;
                                                                    $nextForwardOptions = [
                                                                        \App\Models\Role::ROLE_SEKRETARIS_LURAH => 'Sekretaris Lurah',
                                                                        \App\Models\Role::ROLE_LURAH => 'Lurah',
                                                                    ];
                                                                }
                                                                break;
                                                            case \App\Models\Role::ROLE_SEKRETARIS_LURAH:
                                                                if ($item->forwarded_to == $currentRole) {
                                                                    $canForward = true;
                                                                    $nextForwardOptions = [
                                                                        \App\Models\Role::ROLE_LURAH => 'Lurah',
                                                                    ];
                                                                }
                                                                break;
                                                        }
                                                    @endphp

                                                    @if ($item->forwarded_to)
                                                        @php
                                                            $forwardLabel = \App\Models\Role::getRoleName($item->forwarded_to);
                                                        @endphp
                                                        <span class="badge badge-info d-block mb-1">{{ $forwardLabel }}</span>
                                                    @endif

                                                    @if ($canForward && count($nextForwardOptions) > 0)
                                                        <form action="/complaint/forward/{{ $item->id }}" method="POST" id="forwardForm-{{ $item->id }}">
                                                            @csrf
                                                            <select name="forward_to" class="form-control" onchange="document.getElementById('forwardForm-{{ $item->id }}').submit();">
                                                                <option value="">Pilih</option>
                                                                @foreach ($nextForwardOptions as $key => $label)
                                                                    <option value="{{ $key }}">{{ $label }}</option>
                                                                @endforeach
                                                            </select>
                                                        </form>
                                                    @endif
                                                @else
                                                    <span class="badge badge-secondary">Tidak dapat diteruskan</span>
                                                @endif
                                            </td>
                                            @endif
                                        </tr>

                                        @if((!isset($item->source_type) || $item->source_type == 'registered') && $currentRole == \App\Models\Role::ROLE_USER)
                                            @include('pages.complaint.confirmation-delete')
                                        @endif
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="{{ in_array(auth()->user()->role_id, $adminLikeRoles) ? '11' : '9' }}" class="text-center pt-3">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $complaints->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
                