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
    Schema::create('skill_user', function (Blueprint $table) {
        $table->id();
        // Menghubungkan ke tabel users dan otomatis terhapus jika user dihapus
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        // Menghubungkan ke tabel skills dan otomatis terhapus jika skill dihapus
        $table->foreignId('skill_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('skill_user');
}
};
