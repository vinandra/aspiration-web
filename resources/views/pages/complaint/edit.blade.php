@extends('layouts.app')

@section('content')
    {{-- page heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Aspirasi</h1>
    </div>

    <div class="row">
        <div class="col">
            <form action="/complaint/{{ $complaint->id }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        {{-- NIK --}}
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" name="title" id="title" 
                                class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $complaint->title) }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Isi Aspirasi</label>
                            <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror"
                                cols="30" rows="5">{{ old('content', $complaint->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama --}}
                        <div class="form-group">
                            <label for="photo_proof">Foto (optional)</label>
                            <input type="file" name="photo_proof" id="photo_proof" 
                                class="form-control @error('photo_proof') is-invalid @enderror" value="{{ old('photo_proof') }}">
                            @error('photo_proof')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                <option value="Pembangunan" {{ old('kategori', $complaint->kategori) == 'Pembangunan' ? 'selected' : '' }}>Pembangunan</option>
                                <option value="Kesejahteraan Sosial" {{ old('kategori', $complaint->kategori) == 'Kesejahteraan Sosial' ? 'selected' : '' }}>Kesejahteraan Sosial</option>
                                <option value="Ketentraman dan Ketertiban Umum" {{ old('kategori', $complaint->kategori) == 'Ketentraman dan Ketertiban Umum' ? 'selected' : '' }}>Ketentraman dan Ketertiban Umum</option>
                                <option value="Pengelolaan Teknologi Informasi" {{ old('kategori', $complaint->kategori) == 'Pengelolaan Teknologi Informasi' ? 'selected' : '' }}>Pengelolaan Teknologi Informasi</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end" style="gap: 10px">
                            <a href="/complaint" class="btn btn-outline-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
