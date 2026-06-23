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
     Schema::create('reports', function (Blueprint $table) {
         $table->id();
         $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade'); // Pelapor
         $table->foreignId('reported_user_id')->constrained('users')->onDelete('cascade'); // Tersangka
         $table->string('reason'); // Alasan (Spam, Kasar, dll)
         $table->text('description')->nullable(); // Detail kronologi
         $table->enum('status', ['pending', 'resolved'])->default('pending'); // Status tindak lanjut admin
         $table->timestamps();
     });
 }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
