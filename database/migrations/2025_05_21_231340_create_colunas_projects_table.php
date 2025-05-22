<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('projects', function (Blueprint $table) {
        $table->string('name')->after('id');
        $table->text('description')->nullable()->after('name');
        $table->string('url_project')->nullable()->after('description');
        $table->boolean('public')->default(false)->after('url_project');
    });
}

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['name', 'description', 'url_project', 'public']);
        });
    }
};
