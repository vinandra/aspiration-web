<?php

namespace Database\Seeders;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Risky Hardiwiranto, A.Md.Kom - Pengelolaan Teknologi',
            'nik' => '1111111111111111',
            'password' => bcrypt('123'),
            'status' => 'approved',
            'role_id' => 1,
        ]);

        // Pengadministrasi Umum
        User::create([
            'name' => 'Purwanti - Pengadministrasi Umum',
            'nik' => '1111222233334444',
            'password' => bcrypt('123'),
            'status' => 'approved',
            'role_id' => 2,
        ]);

        // Kasi Pembangunan
        User::create([
            'name' => '- KASI Pembangunan',
            'nik' => '3333333333333333',
            'password' => bcrypt('123'),
            'status' => 'approved',
            'role_id' => 3,
        ]);

        // Sekretaris Lurah
        User::create([
            'name' => 'Rochmat Hidayat, S.E - Sekretaris Lurah',
            'nik' => '4444444444444444',
            'password' => bcrypt('123'),
            'status' => 'approved',
            'role_id' => 4,
        ]);

        // Lurah
        User::create([
            'name' => 'R. Wisnu Efendi, S.E, M.M - Lurah',
            'nik' => '5555555555555555',
            'password' => bcrypt('123'),
            'status' => 'approved',
            'role_id' => 5,
        ]);

        // Kasi Kesejahteraan Sosial
        User::create([
            'name' => 'Wiwin Kristiyanti, S.H - KASI Kesejahteraan Sosial',
            'nik' => '3333333333333334',
            'password' => bcrypt('123'),
            'status' => 'approved',
            'role_id' => 7,
        ]);

        // Kasi Pemerintahan, Ketentraman dan Ketertiban Umum
        User::create([
            'name' => 'Susetyo Arief H, S.A.P - KASI Pemerintahan, Ketentraman dan Ketertiban Umum',
            'nik' => '3333333333333335',
            'password' => bcrypt('123'),
            'status' => 'approved',
            'role_id' => 8,
        ]);

        // Penduduk
        $userPenduduk = User::create([
            'name' => 'Penduduk 1',
            'nik' => '2222222222222222',
            'password' => bcrypt('123'),
            'status' => 'approved',
            'role_id' => 9,
        ]);

        // Tambahkan ke tabel residents dengan `user_id` yang valid
        $resident = Resident::create([
            'user_id' => $userPenduduk->id, // Merujuk ke ID pengguna yang baru dibuat
            'nik' => '1234567890123456',
            'name' => 'Penduduk 1',
            'gender' => 'male',
            'birth_date' => '1990-01-01',
            'birth_place' => 'City A',
            'address' => 'Street 123, City A',
            'marital_status' => 'single',
            'status' => 'active',
        ]);
    }
}
