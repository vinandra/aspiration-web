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
                                    @endif
                                    <th>Judul</th>
                                    <th>Isi Aspirasi</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Foto (optional)</th>
                                    <th>Tanggal Laporan</th>
                                    <th>Aksi</th>
                                    <th>Teruskan</th>
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
                                            $canView = $item->resident_id == auth()->user()->resident->id;
                                        } elseif ($item->forwarded_to == $currentRole) {
                                            $canView = true;
                                        }
                                    @endphp

                                    @if ($canView)
                                        <tr>
                                            <td>{{ $loop->iteration + $complaints->firstItem() - 1 }}</td>
                                            @if (in_array(auth()->user()->role_id, $adminLikeRoles))
                                                <td>{{ $item->resident->name }}</td>
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
                                                    @php $filePath = 'storage/' . $item->photo_proof; @endphp
                                                    <a href="{{ asset($filePath) }}" target="_blank" rel="noopener noreferrer">
                                                        <img src="{{ asset($filePath) }}" alt="foto" style="max-width:300px;">
                                                    </a>
                                                @else
                                                    Tidak Ada
                                                @endif
                                            </td>
                                            <td>{{ $item->report_date_label }}</td>
                                            <td>
                                                @if ($currentRole == \App\Models\Role::ROLE_USER && $item->status == 'new')
                                                    <div class="d-flex align-items-center" style="gap: 10px;">
                                                        <a href="/complaint/{{ $item->id }}" class="btn btn-sm btn-warning">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationDelete-{{ $item->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                @elseif (in_array($currentRole, $adminLikeRoles))
                                                    <form id="formChangeStatus-{{ $item->id }}" action="/complaint/update-status/{{ $item->id }}" method="POST">
                                                        @csrf
                                                        <select name="status" class="form-control" style="min-width:180px;" onchange="document.getElementById('formChangeStatus-{{ $item->id }}').submit();">
                                                            <option value="new" {{ $item->status == 'new' ? 'selected' : '' }}>Baru</option>
                                                            <option value="processing" {{ $item->status == 'processing' ? 'selected' : '' }}>Sedang Diproses</option>
                                                            <option value="completed" {{ $item->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                                        </select>
                                                    </form>
                                                @endif
                                                @if (auth()->user()->role_id == \App\Models\Role::ROLE_ADMIN)
                                                    <form action="/complaint/{{ $item->id }}/{{ $item->is_published ? 'unpublish' : 'publish' }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm {{ $item->is_published ? 'btn-danger' : 'btn-success' }}">
                                                            {{ $item->is_published ? 'Unpublish' : 'Publish' }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td class="text-center">
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
                                            </td>
                                        </tr>

                                        @include('pages.complaint.confirmation-delete')
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center pt-3">Tidak ada data</td>
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
