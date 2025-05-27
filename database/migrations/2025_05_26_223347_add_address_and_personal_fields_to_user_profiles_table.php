<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Verifica se a tabela 'user_profiles' existe antes de tentar modificá-la
        if (Schema::hasTable('user_profiles')) {
            Schema::table('user_profiles', function (Blueprint $table) {
                // Adiciona as novas colunas.
                // Usamos 'after' para organizar, mas é opcional.
                // Escolha uma coluna existente, como 'state' ou 'photo_path', para adicionar depois.
                $table->string('cep', 9)->nullable()->after('state'); // CEP com 9 caracteres (ex: 12345-678), opcional
                $table->string('street_name')->nullable()->after('cep'); // Nome da Rua, opcional
                $table->string('street_number', 50)->nullable()->after('street_name'); // Número (pode ser "S/N"), opcional
                $table->string('address_complement')->nullable()->after('street_number'); // Complemento, opcional
                $table->string('marital_status', 50)->nullable()->after('address_complement'); // Estado Civil, opcional
                $table->text('about_me')->nullable()->after('marital_status'); // Sobre Mim (texto longo), opcional
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Verifica se a tabela 'user_profiles' existe antes de tentar modificá-la
        if (Schema::hasTable('user_profiles')) {
            Schema::table('user_profiles', function (Blueprint $table) {
                // Remove as colunas se a migration for revertida
                $table->dropColumn([
                    'cep',
                    'street_name',
                    'street_number',
                    'address_complement',
                    'marital_status',
                    'about_me'
                ]);
            });
        }
    }
};