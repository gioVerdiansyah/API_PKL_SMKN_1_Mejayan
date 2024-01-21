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
        Schema::create('izins', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->enum('tipe_izin', ['Sakit','Izin', 'Dispensasi', 'Cuti']);
            $table->text('alasan');
            $table->date('awal_izin');
            $table->date('akhir_izin');
            $table->string('bukti');
            $table->enum('status', [0,1,2])->default(0)->comment("0=Netral,1=disetujui,2=ditolak");
            $table->text('comment_guru')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izins');
    }
};
