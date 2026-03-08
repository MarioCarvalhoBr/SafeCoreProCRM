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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // Relação 1:1 com o Agendamento
            $table->foreignId('appointment_id')->constrained()->cascadeOnDelete();

            // Decimal 10,2 permite valores até 99.999.999,99
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->string('payment_method')->nullable(); // cash, credit_card, bank_transfer
            $table->string('status')->default('pending'); // pending, paid, canceled

            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
