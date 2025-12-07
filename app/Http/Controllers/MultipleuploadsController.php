<?php

namespace App\Http\Controllers;

use App\Models\Multipleuploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MultipleuploadsController extends Controller
{
    public function index()
    {
        // Ambil semua file dari database untuk ditampilkan di view
        $files = Multipleuploads::orderBy('created_at', 'desc')->get();
        return view('multipleuploads', compact('files'));
    }

    public function store(Request $request)
    {
        // Validasi file
        $request->validate([
            'filename' => 'required',
            'filename.*' => 'mimes:doc,docx,PDF,pdf,jpg,jpeg,png|max:2000', // max 2MB per file
        ]);

        if ($request->hasFile('filename')) { 
            $filesData = [];

            foreach ($request->file('filename') as $file) {
                if ($file->isValid()) {
                    // Buat nama file unik
                    $filename = round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $file->getClientOriginalName());

                    // Simpan file di storage/app/public/images
                    $file->storeAs('images', $filename, 'public');

                    $filesData[] = [
                        'filename' => $filename,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                } else {
                    return back()->with('error', 'File tidak valid: ' . $file->getClientOriginalName());
                }
            }

            if (!empty($filesData)) {
                Multipleuploads::insert($filesData);
            }

            return back()->with('success', 'File berhasil diupload!');
        }

        return back()->with('error', 'Tidak ada file yang diupload.');
    }

    // Upload file untuk entitas tertentu (misal: pelanggan)
    public function storeForRef(Request $request)
    {
        dd($request->all(), $request->file('filename'));
        // Validasi file
        $request->validate([
            "filename.*" => "required|mimes:jpg,png,pdf,doc,docx|max:2048",
            "ref_table" => "required",
            "ref_id" => "required|integer",
        ]);

        // Cek ada file atau tidak
        if ($request->hasFile('filename')) {
            foreach ($request->file('filename') as $file) {

                // Simpan ke storage/app/public/uploads/
                $path = $file->store('images', 'public');

                // Simpan ke database
                Multipleuploads::create([
                    'ref_table' => $request->ref_table,
                    'ref_id' => $request->ref_id,
                    'filename' => $path
                ]);
            }
        }

        return back()->with('success', 'File berhasil diupload!');
    }

    // Hapus file
    public function destroy($id)
    {
        $file = Multipleuploads::findOrFail($id);
        Storage::disk('public')->delete($file->filename);
        $file->delete();

        return back()->with('success', 'File berhasil dihapus!');
    }
}
