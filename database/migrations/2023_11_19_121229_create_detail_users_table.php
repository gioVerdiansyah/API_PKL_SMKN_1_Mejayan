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
        Schema::create('detail_users', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('jurusan_id')->constrained()->restrictOnDelete();
            $table->foreignId('kelas_id')->constrained()->restrictOnDelete();
            $table->integer('absen');
            $table->string('nis');
            $table->enum('jenis_kelamin', ['P', 'L']);
            $table->string('alamat');
            $table->string('no_hp');
            $table->string('no_hp_ortu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_users');
    }
};
