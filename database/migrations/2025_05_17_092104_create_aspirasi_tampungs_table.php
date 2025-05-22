
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('aspirasi_tampungs', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->string('title');
            $table->text('content');
            $table->enum('kategori', ['Pembangunan', 'Kesejahteraan Sosial', 'Ketentraman dan Ketertiban Umum', 'Pengelolaan Teknologi Informasi'])->nullable();
            $table->enum('status', ['new', 'processing', 'completed'])->default('new');
            $table->string('photo_proof')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('aspirasi_tampungs');
    }
};

