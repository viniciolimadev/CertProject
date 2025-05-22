<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('certificates', function ($table) {
        $table->boolean('pinned')->default(false);
    });

    Schema::table('projects', function ($table) {
        $table->boolean('pinned')->default(false);
    });
}

public function down()
{
    Schema::table('certificates', function ($table) {
        $table->dropColumn('pinned');
    });

    Schema::table('projects', function ($table) {
        $table->dropColumn('pinned');
    });
}

};
