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
        Schema::create('gurus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("nama");
            $table->string('gelar')->nullable();
            $table->string("email");
            $table->string('password');
            $table->string('photo_guru')->nullable();
            $table->enum('status', [0, 1, 2])->default(0);
            $table->foreignId('jurusan_id')->constrained()->restrictOnDelete();
            $table->text('deskripsi')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
