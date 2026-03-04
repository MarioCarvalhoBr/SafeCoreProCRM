<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class FakeDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Garante que o Cargo de Médico existe
        $doctorRole = Role::firstOrCreate(['name' => 'Doctor']);

        // Arrays de dados fictícios e números repetidos
        $fakeLastNames = ['Fictício', 'Teste', 'Simulado', 'Virtual', 'Falso'];
        $repeatedNumbers = ['111', '222', '333', '444', '555', '666', '777', '888', '999', '000'];

        $doctorsIds = [];
        $patientsIds = [];

        // 2. Criar 10 Médicos (Users)
        for ($i = 0; $i < 10; $i++) {
            $num = $repeatedNumbers[$i];
            $doctor = User::create([
                'name' => 'Dr. Médico ' . $fakeLastNames[array_rand($fakeLastNames)] . ' ' . $i,
                'email' => 'medico' . $num . '@safecore.com',
                'password' => Hash::make('Senha@' . $num),
            ]);

            $doctor->assignRole('Doctor');
            $doctorsIds[] = $doctor->id;
        }

        // 3. Criar 10 Pacientes
        for ($i = 0; $i < 10; $i++) {
            $num = $repeatedNumbers[$i];
            // Gera um documento padrão: 111.111.111-11
            $docId = "{$num}.{$num}.{$num}-" . substr($num, 0, 2);
            // Gera um telefone padrão: (11) 11111-1111
            $phone = "(" . substr($num, 0, 2) . ") {$num}{$num}-{$num}" . substr($num, 0, 1);

            $patient = Patient::create([
                'name' => 'Paciente ' . $fakeLastNames[array_rand($fakeLastNames)] . ' ' . $i,
                'email' => 'paciente' . $num . '@teste.com',
                'phone' => $phone,
                'document_id' => $docId,
                'birth_date' => Carbon::now()->subYears(rand(18, 65))->format('Y-m-d'),
            ]);

            $patientsIds[] = $patient->id;
        }

        // 4. Criar 20 Agendamentos
        $statuses = ['scheduled', 'completed', 'canceled'];

        for ($i = 1; $i <= 20; $i++) {
            // Forçamos 8 consultas para "Hoje" para o gráfico diário funcionar bem.
            // O restante espalhamos aleatoriamente pelo mês atual.
            if ($i <= 8) {
                $date = Carbon::today();
            } else {
                $date = Carbon::now()->startOfMonth()->addDays(rand(0, 27));
            }

            Appointment::create([
                'patient_id' => $patientsIds[array_rand($patientsIds)],
                'user_id' => $doctorsIds[array_rand($doctorsIds)],
                'appointment_date' => $date->format('Y-m-d'),
                // Horários das 08:00 às 17:00
                'appointment_time' => sprintf('%02d:00:00', rand(8, 17)),
                'status' => $statuses[array_rand($statuses)],
                'notes' => 'Sintomas relatados: ' . $repeatedNumbers[array_rand($repeatedNumbers)] . '. Consulta gerada via Seeder.',
                'certificate_days' => rand(0, 1) ? rand(1, 5) : null,
            ]);
        }
    }
}
