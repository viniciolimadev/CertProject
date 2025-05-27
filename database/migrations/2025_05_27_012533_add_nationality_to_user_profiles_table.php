<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            // Adiciona a coluna após 'date_of_birth', por exemplo, ou onde preferir
            $table->string('nationality', 100)->nullable()->after('date_of_birth');
        });
    }

    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn('nationality');
        });
    }
};