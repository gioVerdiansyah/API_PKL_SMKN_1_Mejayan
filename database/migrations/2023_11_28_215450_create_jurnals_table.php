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
        Schema::create('jurnals', function (Blueprint $table) {
            $table->id('id');
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->text('kegiatan');
            $table->string('bukti');
            $table->enum('status', [0, 1, 2])->default(0)->comment("0=Netral,1=disetujui,2=ditolak");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnals');
    }
};
