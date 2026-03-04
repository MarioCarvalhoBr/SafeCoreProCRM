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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            // Chave Estrangeira para o Paciente
            // cascadeOnDelete: Se o paciente for apagado, os agendamentos dele também são apagados automaticamente.
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();

            // Chave Estrangeira para o Médico (Tabela users)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->date('appointment_date');
            $table->time('appointment_time');

            // Estado do Agendamento (Padrão: Agendado)
            $table->string('status')->default('scheduled');

            // Notas da receção ou do médico
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
