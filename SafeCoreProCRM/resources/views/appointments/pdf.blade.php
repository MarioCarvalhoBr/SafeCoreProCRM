<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('messages.prescription') }} - {{ $appointment->patient->name }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header {
            width: 100%;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .header table {
            width: 100%;
        }
        .clinic-name {
            font-size: 24px;
            font-weight: bold;
            color: #1e40af;
        }
        .clinic-contact {
            font-size: 12px;
            color: #6b7280;
        }
        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }
        .info-table th {
            text-align: left;
            padding: 8px;
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            width: 30%;
        }
        .info-table td {
            padding: 8px;
            border: 1px solid #e5e7eb;
        }
        .prescription-content {
            min-height: 300px;
            padding: 20px;
            border: 1px dashed #cbd5e1;
            background-color: #f8fafc;
            font-size: 14px;
            white-space: pre-wrap; /* Mantém as quebras de linha digitadas no textarea */
        }
        .footer {
            margin-top: 50px;
            text-align: center;
        }
        .signature-line {
            width: 300px;
            border-top: 1px solid #000;
            margin: 0 auto 10px auto;
        }
        .logo {
            max-width: 150px;
            max-height: 60px;
        }
    </style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td style="width: 50%;">
                    <div class="clinic-name">{{ $tenant->name ?? 'SafeCoreProCRM' }}</div>
                    <div class="clinic-contact">
                        {{ __('messages.clinic_contact') }}: {{ $tenant->phone ?? '-' }} <br>
                        {{ $tenant->email ?? '-' }}
                    </div>
                </td>
                <td style="width: 50%; text-align: right;">
                    @if($tenant->logo_path)
                        @php
                            $path = storage_path('app/public/' . $tenant->logo_path);
                            $type = pathinfo($path, PATHINFO_EXTENSION);
                            $data = file_get_contents($path);
                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        @endphp
                        <img src="{{ $base64 }}" class="logo" alt="Logo">
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="title">{{ __('messages.prescription') }}</div>

    <table class="info-table">
        <tr>
            <th>{{ __('messages.patient_name') }}</th>
            <td>{{ $appointment->patient->name }}</td>
        </tr>
        <tr>
            <th>{{ __('messages.doctor_name') }}</th>
            <td>Dr(a). {{ $appointment->doctor->name }}</td>
        </tr>
        <tr>
            <th>{{ __('messages.date_of_issue') }}</th>
            <td>{{ \Carbon\Carbon::now()->format('d/m/Y - H:i') }}</td>
        </tr>
    </table>

    <div class="prescription-content">
        {!! nl2br(e($appointment->notes)) !!}
    </div>

    <div class="footer">
        <div class="signature-line"></div>
        <strong>Dr(a). {{ $appointment->doctor->name }}</strong><br>
        <small>{{ __('messages.signature') }}</small>
    </div>

</body>
</html>
