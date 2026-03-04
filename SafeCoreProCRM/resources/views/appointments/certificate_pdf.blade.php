<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('messages.medical_certificate') }} - {{ $appointment->patient->name }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; padding: 40px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #2563eb; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { max-height: 70px; margin-bottom: 10px; }
        .clinic-name { font-size: 22px; font-weight: bold; color: #1e40af; text-transform: uppercase; }
        .clinic-contact { font-size: 12px; color: #6b7280; margin-top: 5px; }

        .title { text-align: center; font-size: 24px; font-weight: bold; margin: 30px 0; text-transform: uppercase; letter-spacing: 2px; }

        /* Bloco de Dados do Paciente */
        .patient-box { border: 1px solid #cbd5e1; background-color: #f8fafc; padding: 15px; margin-bottom: 30px; border-radius: 5px; }
        .patient-box table { width: 100%; font-size: 14px; }
        .patient-box td { padding: 5px; }
        .label { font-weight: bold; width: 150px; color: #475569; }

        /* Texto do Atestado */
        .content { font-size: 18px; text-align: justify; margin: 40px 0; line-height: 2; }

        .date-location { text-align: right; margin-top: 50px; font-size: 16px; }

        .footer { margin-top: 80px; text-align: center; }
        .signature-box { width: 350px; border-top: 1px solid #000; margin: 0 auto; padding-top: 10px; font-size: 16px; }
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

    <div class="title">{{ __('messages.medical_certificate') }}</div>

    <div class="patient-box">
        <table>
            <tr>
                <td class="label">{{ __('messages.patient_name') }}:</td>
                <td><strong>{{ $appointment->patient->name }}</strong></td>
            </tr>
            <tr>
                <td class="label">{{ __('messages.document_id') ?? 'Documento' }}:</td>
                <td>{{ $appointment->patient->document_id ?? 'Não informado' }}</td>
            </tr>
            <tr>
                <td class="label">{{ __('messages.phone') }}:</td>
                <td>{{ $appointment->patient->phone ?? 'Não informado' }}</td>
            </tr>
        </table>
    </div>

    <div class="content">
        @if($appointment->certificate_days)
            {{ __('messages.certificate_text', ['days' => $appointment->certificate_days]) }}
        @else
            {{ __('messages.certificate_text', ['days' => '______']) }}
        @endif
    </div>

    <div class="date-location">
        {{ $tenant->name ?? 'Clínica' }}, {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}.
    </div>

    <div class="footer">
        <div class="signature-box">
            <strong>Dr(a). {{ $appointment->doctor->name }}</strong><br>
            {{ __('messages.signature') }}
        </div>
    </div>

</body>
</html>
