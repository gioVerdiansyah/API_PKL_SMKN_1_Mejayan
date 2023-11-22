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
        Schema::create('jam_pkls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_pkl_id')->constrained()->cascadeOnDelete();
            $table->string('senin');
            $table->string('selasa');
            $table->string('rabu');
            $table->string('kamis');
            $table->string('jumat');
            $table->string('saptu')->nullable();
            $table->string('minggu')->nullable();
            // jam istirahat

            $table->string('ji_senin');
            $table->string('ji_selasa');
            $table->string('ji_rabu');
            $table->string('ji_kamis');
            $table->string('ji_jumat')->nullable();
            $table->string('ji_saptu')->nullable();
            $table->string('ji_minggu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jam_pkls');
    }
};
