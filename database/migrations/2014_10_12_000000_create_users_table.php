<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('photo_profile')->default('images/mobile/default_photo.png');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('jurusan_id')->constrained()->restrictOnDelete();
            $table->foreignId('kelas_id')->constrained()->restrictOnDelete();
            $table->integer('absen');
            $table->string('nis');
            $table->enum('jenis_kelamin', ['P', 'L']);
            $table->string('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('no_hp_ortu')->nullable();

            // Jam masuk per siswa
            $table->string('senin');
            $table->string('selasa');
            $table->string('rabu');
            $table->string('kamis');
            $table->string('jumat');
            $table->string('sabtu')->nullable();
            $table->string('minggu')->nullable();

            $table->timestamps();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
