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
        //
        Schema::table('pengaduan', function (Blueprint $table) {
            $table->dropColumn('nama'); // hapus kolom nama
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('pengaduan', function (Blueprint $table) {
            $table->string('nama');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
