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
        Schema::create('hasil_diagnosis', function (Blueprint $table) {
            $table->increments('id_hasil');
            $table->integer('idpengguna')->nullable();
            $table->string('kode_hasil', 100)->nullable();
            $table->longText('data_diagnosis')->nullable();
            $table->longText('kondisi')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('penyakit', 50)->nullable();
            $table->string('nilai_hasil', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_diagnosis');
    }
};
