@extends('admin/layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Notifikasi sukses / error --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-header">{{ __('Upload File or Images') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('uploads.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('File') }}</label>

                            <div class="col-md-6">
                                <input type="file" class="form-control" name="filename[]" required multiple>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Upload') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Preview file yang sudah diupload --}}
            <hr>
            <h4>Daftar File Uploaded</h4>
            <div class="row">
                @foreach($files as $file)
                    <div class="col-md-3 text-center mb-3">
                        @php
                            $ext = pathinfo($file->filename, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif']))
                            <img src="{{ asset('storage/images/' . $file->filename) }}" class="img-fluid mb-1" style="max-height:150px;">
                        @else
                            <div class="border p-2 mb-1">{{ $file->filename }}</div>
                        @endif

                        <small>{{ date('d M Y H:i', strtotime($file->created_at)) }}</small>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
@endsection
