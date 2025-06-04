<?php

namespace Database\Seeders;

use App\Models\Complaint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Complaint::create([
            'resident_id' => 1,
            'title' => 'Keluhan Kebisingan dari Rumah Tetangga',
            'content' => 'Saya ingin menyampaikan keluhan terkait kebisingan yang berasal dari rumah tetangga yang berada dekat dengan tempat tinggal saya. Suara yang ditimbulkan cukup mengganggu, terutama pada malam hari, dan sering kali membuat saya serta keluarga sulit beristirahat dengan tenang. Situasi ini telah berlangsung cukup lama dan mulai menimbulkan ketidaknyamanan di lingkungan sekitar. Saya berharap agar pihak yang berwenang dapat memberikan perhatian dan menyelesaikan permasalahan ini demi menjaga ketentraman dan keharmonisan antarwarga.',
            'kategori' => 'Ketentraman dan Ketertiban Umum'
        ]);
    }
}
