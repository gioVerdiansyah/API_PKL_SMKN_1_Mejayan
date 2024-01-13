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
            $table->string('photo_guru')->default('images/mobile/default_photo.png');
            $table->foreignId('kakomli_id')->constrained()->restrictOnDelete();
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
