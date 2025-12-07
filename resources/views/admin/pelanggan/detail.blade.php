@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h3>Detail Pelanggan: {{ $pelanggan->nama }}</h3>

    {{-- Form Upload File Pendukung --}}
    <div class="card mb-4">
        <div class="card-header">Upload File Pendukung</div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('uploads.store.ref') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ref_table" value="pelanggan">
                <input type="hidden" name="ref_id" value="{{ $pelanggan->id }}">

                <div class="form-group">
                    <input type="file" class="form-control" name="filename[]" multiple required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>

    {{-- Daftar File Pendukung --}}
    <div class="card">
        <div class="card-header">Daftar File Pendukung</div>
        <div class="card-body">
            <div class="row">
                @foreach($pelangganFiles as $file)
                    <div class="col-md-3 text-center mb-3">
                        @php
                            $ext = pathinfo($file->filename, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif']))
                            <img src="{{ asset('storage/images/' . $file->filename) }}" class="img-fluid mb-1" style="max-height:150px;">
                        @else
                            <div class="border p-2 mb-1">{{ $file->filename }}</div>
                        @endif

                        <form method="POST" action="{{ route('uploads.destroy', $file->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
