<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama
        Role::query()->delete();

        // Role yang digunakan dalam UserSeeder
        $roles = [
            ['id' => 1, 'name' => 'Admin'],
            ['id' => 2, 'name' => 'Pengadministrasi Umum'],
            ['id' => 3, 'name' => 'KASI Pembangunan'],
            ['id' => 4, 'name' => 'Sekretaris Lurah'],
            ['id' => 5, 'name' => 'Lurah'],
            ['id' => 7, 'name' => 'KASI Kesejahteraan Sosial'],
            ['id' => 8, 'name' => 'KASI Pemerintahan Ketentraman'],
            ['id' => 9, 'name' => 'user'], // Role khusus user penduduk
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
