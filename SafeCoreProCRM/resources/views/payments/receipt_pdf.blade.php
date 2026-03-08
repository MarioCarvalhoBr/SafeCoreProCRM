<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('messages.receipt') }} - {{ $appointment->patient->name }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; padding: 30px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #10b981; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { max-height: 70px; margin-bottom: 10px; }
        .clinic-name { font-size: 24px; font-weight: bold; color: #047857; text-transform: uppercase; }
        .clinic-contact { font-size: 12px; color: #6b7280; margin-top: 5px; }

        .receipt-title { text-align: center; font-size: 28px; font-weight: bold; margin: 20px 0; color: #111827; letter-spacing: 2px; text-transform: uppercase; }
        .receipt-number { text-align: center; font-size: 14px; color: #6b7280; margin-bottom: 40px; }

        .box { border: 1px solid #e5e7eb; background-color: #f9fafb; padding: 20px; margin-bottom: 30px; border-radius: 8px; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 15px; }
        th { text-align: left; padding: 12px; background-color: #10b981; color: white; border-bottom: 2px solid #047857; }
        td { padding: 12px; border-bottom: 1px solid #e5e7eb; }

        .total-row { font-weight: bold; font-size: 18px; background-color: #ecfdf5; }

        .footer { margin-top: 60px; text-align: center; font-size: 14px; color: #6b7280; }
        .signature-line { width: 300px; border-top: 1px solid #333; margin: 40px auto 10px auto; }
    </style>
</head>
<body>

    <div class="header">
        @if($tenant->logo_path)
            @php
                $path = storage_path('app/public/' . $tenant->logo_path);
                $base64 = 'data:image/' . pathinfo($path, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($path));
            @endphp
            <img src="{{ $base64 }}" class="logo">
        @endif
        <div class="clinic-name">{{ $tenant->name ?? 'SafeCoreProCRM' }}</div>
        <div class="clinic-contact">
            {{ $tenant->email ?? '' }} | {{ $tenant->phone ?? '' }}
        </div>
    </div>

    <div class="receipt-title">{{ __('messages.receipt') }}</div>
    <div class="receipt-number">Nº {{ str_pad($appointment->payment->id, 6, '0', STR_PAD_LEFT) }} | {{ __('messages.date') }}: {{ \Carbon\Carbon::parse($appointment->payment->paid_at)->format('d/m/Y H:i') }}</div>

    <div class="box">
        <p><strong>{{ __('messages.patient') }}:</strong> {{ $appointment->patient->name }}</p>
        <p><strong>{{ __('messages.document_id') ?? 'Document' }}:</strong> {{ $appointment->patient->document_id ?? '--' }}</p>
        <p><strong>{{ __('messages.doctor') }}:</strong> Dr(a). {{ $appointment->doctor->name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>{{ __('messages.description') ?? 'Description' }}</th>
                <th style="text-align: right;">{{ __('messages.amount') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Consulta Médica - {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</td>
                <td style="text-align: right;">$ {{ number_format($appointment->payment->amount, 2, '.', ',') }}</td>
            </tr>
            <tr class="total-row">
                <td>{{ __('messages.payment_method') }}: {{ __('messages.' . $appointment->payment->payment_method) }}</td>
                <td style="text-align: right;">TOTAL: $ {{ number_format($appointment->payment->amount, 2, '.', ',') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-line"></div>
        {{ $tenant->name ?? 'Clínica' }}<br>
        <em>{{ __('messages.thank_you') ?? 'Thank you for trusting us!' }}</em>
    </div>

</body>
</html>
