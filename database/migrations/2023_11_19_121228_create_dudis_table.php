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
        Schema::create('dudis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('pemimpin');
            $table->string('no_telp')->nullable();
            $table->string('email')->nullable();
            $table->string('alamat');
            $table->string('koordinat');
            $table->integer('radius');
            $table->foreignId('kakomli_id')->constrained()->restrictOnDelete();

            $table->string('senin');
            $table->string('selasa');
            $table->string('rabu');
            $table->string('kamis');
            $table->string('jumat');
            $table->string('sabtu')->nullable();
            $table->string('minggu')->nullable();
            // jam istirahat

            $table->string('ji_senin');
            $table->string('ji_selasa');
            $table->string('ji_rabu');
            $table->string('ji_kamis');
            $table->string('ji_jumat')->nullable();
            $table->string('ji_sabtu')->nullable();
            $table->string('ji_minggu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dudis');
    }
};
