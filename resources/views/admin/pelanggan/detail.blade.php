@extends('admin.layouts.app')
@section('title', 'Detail Pelanggan')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Pelanggan</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between w-100">
        <h1 class="h4">Detail Pelanggan</h1>
        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

{{-- Card Data Pelanggan --}}
<div class="card shadow border-0 mb-4">
    <div class="card-header">
        <h5 class="mb-0">Informasi Pelanggan</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th>First Name</th><td>{{ $pelanggan->first_name }}</td></tr>
            <tr><th>Last Name</th><td>{{ $pelanggan->last_name }}</td></tr>
            <tr><th>Birthday</th><td>{{ $pelanggan->birthday }}</td></tr>
            <tr><th>Gender</th><td>{{ $pelanggan->gender }}</td></tr>
            <tr><th>Email</th><td>{{ $pelanggan->email }}</td></tr>
            <tr><th>Phone</th><td>{{ $pelanggan->phone }}</td></tr>
        </table>
    </div>
</div>

{{-- Card Upload File Pendukung --}}
<div class="card shadow border-0 mb-4">
    <div class="card-header">
        <h5 class="mb-0">File Pendukung</h5>
    </div>

    <div class="card-body">
        {{-- FORM UPLOAD --}}
        <form action="{{ route('multipleuploads.storeForRef') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Hidden untuk ref --}}
            <input type="hidden" name="ref_table" value="pelanggan">
            <input type="hidden" name="ref_id" value="{{ $pelanggan->id }}">

            <div class="mb-3">
                <label class="form-label">Upload File Pendukung</label>
                <input type="file" name="filename[]" class="form-control" multiple required>
                <small class="text-muted">Boleh upload beberapa file. Format: jpg, png, pdf, doc, docx.</small>
            </div>

            <button type="submit" class="btn btn-primary">Upload File</button>
        </form>

        <hr>

        {{-- LIST FILE YANG SUDAH ADA --}}
        <h6 class="mb-3">Daftar File</h6>

        @if ($pelangganFiles->count() == 0)
            <p class="text-muted">Belum ada file diupload.</p>
        @else
            <ul class="list-group">
                @foreach ($pelangganFiles as $file)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            {{-- Jika file gambar --}}
                            @if (preg_match('/\.(jpg|jpeg|png)$/i', $file->filename))
                                <img src="{{ asset('storage/images/' . $file->filename) }}" 
                                     width="70" height="70" class="rounded me-2" style="object-fit:cover;">
                            @endif

                            {{ $file->filename }}
                        </div>

                        <form action="{{ route('multipleuploads.destroy', $file->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif

    </div>
</div>

@endsection
