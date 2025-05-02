@extends('layouts.app')

@section('content')
        {{-- page heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Semua Notifikasi</h1>
            {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
        </div>

        <div class="row">
            @foreach (auth()->user()->notifications as $notification)
            <div class="col-12 mb-2">
                <div class="card">
                    <div class="card-body" style="background-color: rgba(115, 194, 251, {{ is_null(
                    $notification->read_at) ? '0.15' : '0.0' }});">
                        <div class="row">
                            <div class="col-1">
                                {{ $loop->iteration }}
                            </div>
                            <div class="col-9">
                                {{ $notification->data['message'] }}
                            </div>
                            <div class="col-2">
                                @if (is_null($notification->read_at))
                                    <form action="/notification/{{ $notification->id }}/read" method="post" >
                                    @csrf
                                    @method('POST')
                                        <button type="submit" class="btn btn-primary btn-sm btn-block">Tandai sudah dibaca</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            @endforeach
        </div>
@endsection