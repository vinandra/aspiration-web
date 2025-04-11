<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16);
            $table->string('name', 100);
            $table->enum('gender', ['male', 'femalie']);
            $table->date('birth_date');
            $table->string('birth_place', 100);
            $table->text('address');
            $table->string('religion', 50)->nullable();
            $table->enum('marital_status', ['single', 'married', 'divorced','widowed']);
            $table->string('occupation', 100)->nullable();
            $table->string('phone', 15)->nullable();
            $table->enum('status', ['active', 'moved', 'deceased'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
