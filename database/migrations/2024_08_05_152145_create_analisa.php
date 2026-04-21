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
        Schema::create('analisa', function (Blueprint $table) {
            $table->increments('id_analisa');
            $table->integer('idpenyakit')->nullable();
            $table->string('gejala', 50)->nullable();
            $table->double('jumlah_nilai')->nullable();
            $table->double('nilai_prioritas')->nullable();
            $table->double('nilai_eigen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analisa');
    }
};
