<?php

use App\Models\GroupWa;
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
        Schema::create('group_was', function (Blueprint $table) {
            $table->id();
            $table->string('untuk');
            $table->string('nama_group');
            $table->string('group_id')->nullable();
            $table->timestamps();
        });


        $data = [
            ['untuk' => 'kas-besar', 'nama_group' => 'Testing Group'],
            ['untuk' => 'kas-kecil', 'nama_group' => 'Testing Group'],
            ['untuk' => 'team', 'nama_group' => 'Testing Group'],
        ];

        foreach ($data as $item) {
            GroupWa::create($item);
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_was');
    }
};
