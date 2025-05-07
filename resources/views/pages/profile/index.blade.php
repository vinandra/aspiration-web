@extends('layouts.app')

@section('content')
    {{-- page heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Profile</h1>
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
    <div class="row">
        <div class="col">
            <form action="/profile/{{ auth()->user()->id }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')  <!-- Changed POST to PUT -->
                <div class="card">
                    <div class="card-body">
                        {{-- Foto Profil --}}
                        <div class="form-group">
                            <label for="photo">Foto Profil</label>
                            <div class="d-flex align-items-center">
                                <!-- Menampilkan Foto Profil -->
                                <img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('template/img/undraw_profile.svg') }}" 
                                     alt="Profile Photo" class="img-profile rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                <!-- Input untuk mengubah Foto Profil -->
                                <input type="file" name="photo" id="photo" 
                                    class="form-control @error('photo') is-invalid @enderror mt-2 ml-3" accept="image/*">
                            </div>
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- Nama --}}
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" name="name" id="name" 
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- NIK --}}
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="nik" inputmode="numeric" name="nik" id="nik" 
                                class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', auth()->user()->nik) }}" readonly>
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end" style="gap: 10px">
                            <a href="/dashboard" class="btn btn-outline-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
@endsection
