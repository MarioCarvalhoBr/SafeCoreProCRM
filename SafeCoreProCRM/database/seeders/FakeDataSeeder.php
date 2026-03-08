<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Faker\Factory;

class FakeDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Inicializa o Faker no padrão brasileiro
        $faker = Factory::create('pt_BR');

        // 2. Garantir que as Roles existam
        $doctorRole = Role::firstOrCreate(['name' => 'Doctor']);
        $receptionistRole = Role::firstOrCreate(['name' => 'Receptionist']);

        $doctorsIds = [];
        $patientsIds = [];

        // 3. Criar 10 Médicos
        for ($i = 0; $i < 10; $i++) {
            $doctor = User::create([
                'name' => 'Dr. ' . $faker->firstName . ' ' . $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('senha123'),
                'email_verified_at' => now(),
            ]);
            $doctor->assignRole($doctorRole);
            $doctorsIds[] = $doctor->id;
        }

        // 4. Criar 4 Recepcionistas
        for ($i = 0; $i < 4; $i++) {
            $receptionist = User::create([
                'name' => $faker->name,
                'email' => "recepcao{$i}@safecore.com",
                'password' => Hash::make('senha123'),
                'email_verified_at' => now(),
            ]);
            $receptionist->assignRole($receptionistRole);
        }

        // 5. Criar 30 Pacientes com Gênero e Endereço
        for ($i = 0; $i < 30; $i++) {
            $docId = str_pad($i + 1, 11, '0', STR_PAD_LEFT);

            $patient = Patient::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->cellphone,
                'document_id' => $docId,
                'birth_date' => $faker->date('Y-m-d', '-20 years'),
                'gender' => $faker->randomElement(['M', 'F']),
                'address' => $faker->address,
            ]);
            $patientsIds[] = $patient->id;
        }

        // 6. Criar 50 Agendamentos distribuídos entre 25/02 e 25/04
        $statuses = array_merge(
            array_fill(0, 10, 'canceled'),
            array_fill(0, 20, 'scheduled'),
            array_fill(0, 20, 'completed')
        );
        shuffle($statuses);

        // Definimos os limites para o sorteio das datas
        $startDate = Carbon::create(2026, 2, 25);
        $endDate = Carbon::create(2026, 4, 25);
        $daysDifference = $startDate->diffInDays($endDate);

        foreach ($statuses as $status) {
            // Sorteia um dia dentro do intervalo definido
            $randomDate = (clone $startDate)->addDays(rand(0, $daysDifference));

            Appointment::create([
                'patient_id' => $faker->randomElement($patientsIds),
                'user_id' => $faker->randomElement($doctorsIds), // Ajustado para bater com seu Model/Controller
                'appointment_date' => $randomDate->format('Y-m-d'),
                'appointment_time' => $faker->randomElement(['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '16:00', '17:00']),
                'status' => $status,
                'notes' => 'Consulta gerada via Seeder automático. ' . $faker->sentence(6),
                'certificate_days' => ($status === 'completed' && rand(0, 1)) ? rand(1, 5) : null,
            ]);
        }

        $this->command->info('Sucesso: Dados reais e agendamentos distribuídos entre 25/02 e 25/04 criados!');
    }
}
