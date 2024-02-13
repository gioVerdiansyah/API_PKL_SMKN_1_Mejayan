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
            $table->string('photo_profile')->default(config('app.url') . '/images/mobile/default_photo.png');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignUuid('jurusan_id')->constrained()->restrictOnDelete();
            $table->foreignUuid('kelas_id')->constrained()->restrictOnDelete();
            $table->integer('absen');
            $table->string('nis');
            $table->enum('jenis_kelamin', ['P', 'L']);
            $table->string('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('no_hp_ortu')->nullable();

            // Jam masuk per siswa
            $table->string('senin')->default('08:00 - 16:00');
            $table->string('selasa')->default('08:00 - 16:00');
            $table->string('rabu')->default('08:00 - 16:00');
            $table->string('kamis')->default('08:00 - 16:00');
            $table->string('jumat')->default('08:00 - 16:00');
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
