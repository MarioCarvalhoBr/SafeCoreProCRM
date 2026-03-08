<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PaymentController extends Controller
{
    // Atualiza ou Cria o pagamento vinculado à consulta
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid,canceled',
            'payment_method' => 'nullable|string',
        ]);

        $isPaidNow = $request->status === 'paid';

        $appointment->payment()->updateOrCreate(
            ['appointment_id' => $appointment->id],
            [
                'amount' => $request->amount,
                'status' => $request->status,
                'payment_method' => $request->payment_method,
                // Se foi marcado como pago agora, registra a data e hora
                'paid_at' => $isPaidNow ? Carbon::now() : null,
            ]
        );

        return back()->with('success', __('messages.payment_updated'));
    }

    // Gera o Recibo em PDF
    public function receipt(Appointment $appointment)
    {
        // Garante que a consulta e o pagamento existem e estão pagos
        $appointment->load(['patient', 'doctor', 'payment']);

        if (!$appointment->payment || $appointment->payment->status !== 'paid') {
            return back()->withErrors(['error' => 'Apenas consultas pagas podem gerar recibo.']);
        }

        // Carrega as configurações da clínica que fizemos no módulo Tenant Settings
        $tenant = \App\Models\Tenant::first();

        // Envia os dados para a view do PDF (que criaremos no próximo passo)
        $pdf = Pdf::loadView('payments.receipt_pdf', compact('appointment', 'tenant'));

        // Retorna o PDF para visualização no navegador (stream) em vez de baixar direto
        return $pdf->stream('Recibo_' . $appointment->patient->name . '_' . $appointment->appointment_date . '.pdf');
    }
}
