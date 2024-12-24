<?php

use App\Models\Rekening;
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
        Schema::create('rekenings', function (Blueprint $table) {
            $table->id();
            $table->string('untuk');
            $table->string('bank');
            $table->string('no_rek');
            $table->string('nama_rek');
            $table->timestamps();
        });

        $data = [
            [
                'untuk' => 'kas-besar',
                'bank' => 'BCA',
                'no_rek' => '1234567890',
                'nama_rek' => 'PT. ABC'
            ],
            [
                'untuk' => 'kas-kecil',
                'bank' => 'BCA',
                'no_rek' => '1234567890',
                'nama_rek' => 'PT. ABC'
            ],

        ];

        foreach ($data as $key => $value) {
            Rekening::create($value);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekenings');
    }
};
