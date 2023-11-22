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
            $table->time('senin');
            $table->time('selasa');
            $table->time('rabu');
            $table->time('kamis');
            $table->time('jumat');
            $table->time('saptu')->nullable();
            $table->timestamps();
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
