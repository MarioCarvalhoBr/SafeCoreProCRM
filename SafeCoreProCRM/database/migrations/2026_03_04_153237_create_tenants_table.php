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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            // Dados Básicos
            $table->string('name')->default('SafeCoreProCRM');
            $table->text('description')->nullable();

            // Paths para as Imagens (nullable porque podem não ter imagem no início)
            $table->string('logo_path')->nullable();
            $table->string('banner_path')->nullable();

            // Contatos
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
