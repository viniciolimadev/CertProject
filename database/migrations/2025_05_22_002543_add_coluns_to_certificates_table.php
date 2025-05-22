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
        Schema::table('certificates', function (Blueprint $table) {
    if (!Schema::hasColumn('certificates', 'title')) {
        $table->string('title')->nullable();
    }
    if (!Schema::hasColumn('certificates', 'file_path')) {
        $table->string('file_path')->nullable();
    }
    if (!Schema::hasColumn('certificates', 'description_certificate')) {
        $table->text('description_certificate')->nullable();
    }
    if (!Schema::hasColumn('certificates', 'user_id')) {
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
    }
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn(['title', 'file_path', 'description_certificate']);
        });
    }
};
