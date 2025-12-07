@extends('admin.layouts.app')
@section('title', 'list pelanggan')
@section('content')

{{-- content --}}
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
                <a href="#">
                    <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Data Pelanggan</h1>
            <p class="mb-0">List data seluruh pelanggan</p>
        </div>
        <div>
            <a href="{{ route('pelanggan.create') }}" class="btn btn-success text-white">
                <i class="far fa-question-circle me-1"></i> Tambah Pelanggan
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">

                    {{-- FILTER & SEARCH --}}
                    <form method="GET" action="{{ route('pelanggan.index') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-2">
                                <select name="gender" class="form-select" onchange="this.form.submit()">
                                    <option value="">All</option>
                                    <option value="Male" {{ request('gender')=='Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ request('gender')=='Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                           value="{{ request('search') }}" placeholder="Search">

                                    <button type="submit" class="input-group-text">
                                        <svg class="icon icon-xxs" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 
                                                0 1110.89 3.476l4.817 4.817a1 1 0 
                                                01-1.414 1.414l-4.816-4.816A6 6 
                                                0 012 8z" clip-rule="evenodd">
                                            </path>
                                        </svg>
                                    </button>

                                    @if(request('search'))
                                        <a href="{{ request()->fullUrlWithQuery(['search'=> null]) }}"
                                           class="btn btn-outline-secondary ml-3">
                                            Clear
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>

                    {{-- TABEL --}}
                    <table id="table-pelanggan" class="table table-centered table-nowrap mb-0 rounded">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Birthday</th>
                                <th>Gender</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th class="rounded-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataPelanggan as $index => $item)
                                <tr>
                                    <td>{{ $dataPelanggan->firstItem() + $index }}</td>
                                    <td>{{ $item->first_name }}</td>
                                    <td>{{ $item->last_name }}</td>
                                    <td>{{ $item->birthday }}</td>
                                    <td>{{ $item->gender }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }}</td>

                                    <td>
                                        {{-- BTN DETAIL (PENTING) --}}
                                        <a href="{{ route('pelanggan.detail', $item->pelanggan_id) }}"
                                           class="btn btn-primary btn-sm mb-1">
                                            <svg class="icon icon-xs me-2" fill="none" stroke-width="1.5"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 
                                                    0 8.268 2.943 9.542 7-1.274 4.057-5.064 
                                                    7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                                            </svg>
                                            Detail
                                        </a>

                                        {{-- BTN EDIT --}}
                                        <a href="{{ route('pelanggan.edit', $item->pelanggan_id) }}"
                                            class="btn btn-info btn-sm mb-1">
                                            Edit
                                        </a>

                                        {{-- BTN DELETE --}}
                                        <form action="{{route('pelanggan.destroy', $item->pelanggan_id)}}" 
                                              method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $dataPelanggan->links('pagination::simple-bootstrap-5') }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
