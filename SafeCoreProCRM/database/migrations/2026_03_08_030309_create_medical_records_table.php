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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            // Relacionamento forte: se o paciente for apagado, o prontuário também é (cascade)
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();

            $table->string('blood_type', 5)->nullable(); // Ex: A+, O-
            $table->text('allergies')->nullable();
            $table->text('family_history')->nullable();
            $table->text('past_surgeries')->nullable();
            $table->text('current_medications')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
