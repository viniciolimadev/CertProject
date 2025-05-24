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
        Schema::create('certificates', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('title');
    $table->string('file_path'); // Usar file_path consistentemente
    $table->text('description_certificate')->nullable();
    $table->date('start_date')->nullable();
    $table->date('end_date')->nullable();
    $table->string('duration')->nullable();
    // $table->boolean('pinned')->default(false); // Se a coluna 'pinned' ainda for necessária
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
