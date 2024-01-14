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
        Schema::create('kelompoks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_kelompok');
            $table->foreignUuid('kakomli_id')->constrained()->restrictOnDelete();
            $table->foreignUuid('dudi_id')->constrained()->restrictOnDelete();
            $table->foreignUuid('guru_id')->constrained()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompoks');
    }
};
