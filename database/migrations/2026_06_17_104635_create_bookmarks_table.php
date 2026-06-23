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
    Schema::create('bookmarks', function (Blueprint $table) {
        $table->id();
        // User yang melakukan klik simpan
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        // User talenta yang disimpan
        $table->foreignId('talent_id')->constrained('users')->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};
