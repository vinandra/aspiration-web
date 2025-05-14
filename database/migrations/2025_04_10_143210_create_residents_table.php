<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Membuat tabel residents
        Schema::create('residents', function (Blueprint $table) {
            $table->id(); // id sebagai primary key dan tipe BIGINT UNSIGNED secara default
            $table->string('nik', 16)->unique(); // NIK harus unik dan panjang 16 karakter
            $table->string('name'); // Nama penduduk
            $table->enum('gender', ['male', 'female']); // Jenis kelamin
            $table->date('birth_date'); // Tanggal lahir
            $table->string('birth_place', 100); // Tempat lahir
            $table->text('address'); // Alamat lengkap
            $table->string('religion', 50)->nullable(); // Agama, nullable jika tidak ada
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']); // Status pernikahan
            $table->string('occupation', 100)->nullable(); // Pekerjaan, nullable jika tidak ada
            $table->string('phone', 15)->nullable(); // Nomor telepon, nullable
            $table->enum('status', ['active', 'moved', 'deceased'])->default('active'); // Status penduduk
            $table->timestamps(); // Timestamp untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Menghapus tabel residents
        Schema::dropIfExists('residents');
    }
}
