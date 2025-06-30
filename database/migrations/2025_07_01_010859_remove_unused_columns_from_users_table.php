<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nik', 'no_telp', 'alamat', 'foto']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik', 20)->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->string('alamat')->nullable();
            $table->string('foto')->default('default.png');
        });
    }
};

