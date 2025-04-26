@extends('layouts.app')

@section('content')
    {{-- page heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Penduduk</h1>
    </div>

    <div class="row">
        <div class="col">
            <form action="/resident/{{ $resident->id }}" method="post">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        {{-- NIK --}}
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="number" inputmode="numeric" name="nik" id="nik" 
                                class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $resident->nik) }}">
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama --}}
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" name="name" id="name" 
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$resident->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="form-group">
                            <label for="gender">Jenis Kelamin</label>
                            <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                                <option></option>
                                <option value="male" {{ old('gender',$resident->gender) == 'male' ? 'selected' : '' }}>Laki - Laki</option>
                                <option value="female" {{ old('gender',$resident->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="form-group">
                            <label for="birth_date">Tanggal Lahir</label>
                            <input type="date" name="birth_date" id="birth_date" 
                                class="form-control @error('birth_date') is-invalid @enderror" value="{{ old('birth_date',$resident->birth_date) }}">
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tempat Lahir --}}
                        <div class="form-group">
                            <label for="birth_place">Tempat Lahir</label>
                            <input type="text" name="birth_place" id="birth_place" 
                                class="form-control @error('birth_place') is-invalid @enderror" value="{{ old('birth_place',$resident->birth_place) }}">
                            @error('birth_place')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror"
                                cols="30" rows="5">{{ old('address',$resident->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Agama --}}
                        
                        <div class="form-group">
                            <label for="religion">Agama</label>
                            <select name="religion" id="religion" 
                                class="form-control @error('religion') is-invalid @enderror">
                                <option></option>
                                <option value="islam" {{ old('religion',$resident->religion) == 'islam' ? 'selected' : '' }}>Islam</option>
                                <option value="kristen_protestan" {{ old('religion',$resident->religion) == 'kristen_protestan' ? 'selected' : '' }}>kristen Protestan</option>
                                <option value="kristen_katholik" {{ old('religion',$resident->religion) == 'kristen_katholik' ? 'selected' : '' }}>Kristen Katholik</option>
                                <option value="hindu" {{ old('religion',$resident->religion) == 'hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="buddha" {{ old('religion',$resident->religion) == 'buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="konghucu" {{ old('religion',$resident->religion) == 'konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                            @error('marital_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        {{-- Status Perkawinan --}}
                        <div class="form-group">
                            <label for="marital_status">Status Perkawinan</label>
                            <select name="marital_status" id="marital_status" 
                                class="form-control @error('marital_status') is-invalid @enderror">
                                <option></option>
                                <option value="single" {{ old('marital_status',$resident->marital_status) == 'single' ? 'selected' : '' }}>Belum Menikah</option>
                                <option value="married" {{ old('marital_status',$resident->marital_status) == 'married' ? 'selected' : '' }}>Menikah</option>
                                <option value="divorced" {{ old('marital_status',$resident->marital_status) == 'divorced' ? 'selected' : '' }}>Cerai</option>
                                <option value="widowed" {{ old('marital_status',$resident->marital_status) == 'widowed' ? 'selected' : '' }}>Janda/Duda</option>
                            </select>
                            @error('marital_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Pekerjaan --}}
                        <div class="form-group">
                            <label for="occupation">Pekerjaan</label>
                            <input type="text" name="occupation" id="occupation" 
                                class="form-control @error('occupation') is-invalid @enderror" value="{{ old('occupation',$resident->occupation) }}">
                            @error('occupation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Telepon --}}
                        <div class="form-group">
                            <label for="phone">Telepon</label>
                            <input type="number" name="phone" id="phone" 
                                class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone',$resident->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status Penduduk --}}
                        <div class="form-group">
                            <label for="status">Status Penduduk</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                <option></option>
                                <option value="active" {{ old('status',$resident->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="moved" {{ old('status',$resident->status) == 'moved' ? 'selected' : '' }}>Pindah</option>
                                <option value="deceased" {{ old('status',$resident->status) == 'deceased' ? 'selected' : '' }}>Almarhum</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-end" style="gap: 10px">
                            <a href="/resident" class="btn btn-outline-secondary">Kembali</a>
                            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
