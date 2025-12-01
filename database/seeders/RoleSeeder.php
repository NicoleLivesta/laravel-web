<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder; // Perbaikan: Ganti koma dengan titik koma
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache permission (Wajib agar tidak error)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // role dengan huruf kecil
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']); // Perbaikan: Tambah =
        $roleUser = Role::firstOrCreate(['name' => 'user']);   // Perbaikan: Tambah =

        // Buat Akun ADMIN
        $admin = User::firstOrCreate( // Perbaikan: Tambah =
            ['email' => 'admin@gmail.com'], // Cek email biar gak duplikat
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'), // Passwordnya: password
            ]
        );
        $admin->assignRole($roleAdmin); // <-- Kasih jabatan Admin

        // Buat Akun USER BIASA
        $user = User::firstOrCreate(
            ['email' => 'user@gmail.com'], // Perbaikan: Ganti . dengan , dan hapus I
            [ // Perbaikan: Masukkan data ke dalam array kedua
                'name' => 'User Biasa',
                'password' => Hash::make('password'),
            ]
        );
        $user->assignRole($roleUser); // <-- Kasih jabatan User
    }
}
