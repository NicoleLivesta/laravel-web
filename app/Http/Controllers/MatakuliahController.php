<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    // Method index untuk menampilkan data matakuliah
    public function index()
    {
        return view('index'); // Menampilkan view index.blade.php
    }

    // Method show untuk menampilkan matakuliah berdasarkan kode
    public function show($kode = null)
    {
        if ($kode) {
            // Menampilkan view dengan nama halaman-matakuliah
            return view('halaman-matakuliah', ['kode' => $kode]);
        } else {
            return view('halaman-matakuliah', ['kode' => null]);
        }
    }
}
