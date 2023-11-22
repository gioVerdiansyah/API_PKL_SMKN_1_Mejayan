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
            $table->enum('jurusan', ['RPL','TKR', 'TO', 'TBSM', 'APHP']);
            $table->enum('kelas', ['X','XI', 'XII']);
            $table->string('nik');
            $table->enum('jenis_kelamin', ['P', 'L']);
            $table->string('alamat');
            $table->string('no_hp');
            $table->string('no_hp_ortu');
            $table->timestamps();
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
