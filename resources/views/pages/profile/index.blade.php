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
            <form action="/profile/{{ auth()->user()->id }}" method="post">
                @csrf
                @method('POST')
                <div class="card">
                    <div class="card-body">
                        {{-- Nama --}}
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" name="name" id="name" 
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- email --}}
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" inputmode="numeric" name="email" id="email" 
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}" readonly>
                            @error('email')
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
