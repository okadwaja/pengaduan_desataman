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
        Schema::create('masyarakat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nik');
            $table->string('no_telp');
            $table->enum('alamat', [
                'Br. Batubayan','Br. Dlodpasar','Br. Gunung','Br. Jempeng',
                'Br. Jempeng Kauh','Br. Ketogan','Br. Mambul','Br. Pegongan',
                'Br. Raketan','Br. Sukajati','Br. Tabah','Br. Tebejero'
            ]);
            $table->string('foto')->nullable();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masyarakat');
    }
};
