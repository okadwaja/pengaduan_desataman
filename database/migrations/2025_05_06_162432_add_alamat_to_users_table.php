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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('alamat', [
                'Br. Batubayan',
                'Br. Dlodpasar',
                'Br. Gunung',
                'Br. Jempeng',
                'Br. Jempeng Kauh',
                'Br. Ketogan',
                'Br. Mambul',
                'Br. Pegongan',
                'Br. Raketan',
                'Br. Sukajati',
                'Br. Tabah',
                'Br. Tebejero',
            ])->after('no_telp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('alamat');
        });
    }
};
