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
        $table->string('github')->nullable()->after('bio');
        $table->string('linkedin')->nullable()->after('github');
        $table->string('instagram')->nullable()->after('linkedin');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['github', 'linkedin', 'instagram']);
    });
}
};
