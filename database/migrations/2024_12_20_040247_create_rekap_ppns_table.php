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
        Schema::create('rekap_ppns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('divisi_id')->nullable()->constrained('divisis')->onDelete('set null');
            $table->bigInteger('masukan_id')->nullable();
            $table->bigInteger('keluaran_id')->nullable();
            $table->boolean('jenis');
            $table->string('uraian')->nullable();
            $table->bigInteger('nominal');
            $table->bigInteger('saldo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_ppns');
    }
};
