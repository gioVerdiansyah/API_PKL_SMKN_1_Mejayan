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
        Schema::create('detail_pkls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_user_id')->constrained()->cascadeOnDelete();
            $table->string('tempat_dudi');
            $table->string('pemimpin_dudi');
            $table->string('no_telp_dudi');
            $table->string('alamat_dudi');
            $table->string('koordinat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pkls');
    }
};
