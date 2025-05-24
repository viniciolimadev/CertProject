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
        Schema::create('user_profiles', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade'); // user_id deve ser único
    $table->string('photo_path')->nullable();
    $table->string('phone')->nullable();
    $table->string('city')->nullable();
    $table->string('state')->nullable();
    // Considere remover 'email' daqui se for sempre o mesmo do User model
    $table->string('email')->nullable();
    $table->json('social_links')->nullable(); // Usar json para 'social_links' é uma boa prática
    $table->timestamps();
});
    }

    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
};
