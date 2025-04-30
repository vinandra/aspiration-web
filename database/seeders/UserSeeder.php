<?php

namespace Database\Seeders;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id'=>1,
            'name'=>'Admin',
            'email'=>'admin@gmail.com',
            'password'=>'123',
            'status'=>'approved',
            'role_id'=>'1',
        ]);

        User::create([
            'id'=>2,
            'name'=>'Penduduk 1',
            'email'=>'penduduk1@gmail.com',
            'password'=>'123',
            'status'=>'approved',
            'role_id'=>'2',
        ]);

        Resident::create([
            'user_id' => 2,
            'nik'=>'1234567890123456',
            'name'=>'Penduduk 1',
            'gender' => 'male',
            'birth_date' => '1990-01-01',
            'birth_place' => 'City A',
            'address' => 'Street 123, City A',
            'marital_status' => 'single'
        ]);
    }
}
