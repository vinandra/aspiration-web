<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Membuat tabel roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Misalnya admin, user, dll.
            $table->timestamps();
        });

        // Membuat tabel residents (pastikan ini diletakkan di awal)
        Schema::create('residents', function (Blueprint $table) {
            $table->id(); // id harus auto increment dan unsigned
            $table->string('nik', 16)->unique();
            $table->string('name');
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');
            $table->string('birth_place', 100);
            $table->text('address');
            $table->string('religion', 50)->nullable();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            $table->string('occupation', 100)->nullable();
            $table->string('phone', 15)->nullable();
            $table->enum('status', ['active', 'moved', 'deceased'])->default('active');
            $table->timestamps();
        });

        // Membuat tabel users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nik')->unique();
            $table->timestamp('nik_verified_at')->nullable();
            $table->string('password');
            $table->enum('status', ['submitted', 'approved', 'rejected'])->default('submitted');
            $table->unsignedBigInteger('role_id');  // role_id harus ada untuk referensi ke tabel roles
            $table->unsignedBigInteger('resident_id')->nullable();  // Pastikan ini unsigned
            $table->rememberToken();
            $table->timestamps();

            // Menambahkan foreign key untuk resident_id yang merujuk ke tabel residents
            $table->foreign('resident_id')->references('id')->on('residents')->onDelete('set null');

            // Menambahkan foreign key untuk role_id yang merujuk ke tabel roles
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        // Membuat tabel password_reset_tokens
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('nik')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Membuat tabel sessions
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Menghapus foreign key dan kolom yang terkait
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['resident_id']);
            $table->dropForeign(['role_id']);
            $table->dropColumn('resident_id');
        });

        // Menghapus tabel users, roles, password_reset_tokens, dan sessions
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
}
