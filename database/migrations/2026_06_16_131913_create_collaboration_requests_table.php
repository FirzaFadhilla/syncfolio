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
    Schema::create('collaboration_requests', function (Blueprint $table) {
        $table->id();
        // Mengarah ke tabel users untuk pengirim dan penerima
        $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
        // Status undangan
        $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
        $table->timestamps();

        // Mencegah pengiriman request ganda untuk orang yang sama
        $table->unique(['sender_id', 'receiver_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('collaboration_requests');
}
};
