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

        // 2. Garantir que as Roles existam (segurança caso o RolesSeeder não tenha rodado)
        $doctorRole = Role::firstOrCreate(['name' => 'Doctor']);
        $receptionistRole = Role::firstOrCreate(['name' => 'Receptionist']);

        $doctorsIds = [];
        $patientsIds = [];

        // 3. Criar 10 Médicos (Users com Role Doctor)
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
            // CORREÇÃO DO DOCUMENTO: Garante 30 IDs únicos (00000000001 até 00000000030)
            $docId = str_pad($i + 1, 11, '0', STR_PAD_LEFT);

            $patient = Patient::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->cellphone,
                'document_id' => $docId,
                'birth_date' => $faker->date('Y-m-d', '-20 years'), // Pessoas com mais de 20 anos
                'gender' => $faker->randomElement(['M', 'F']),
                'address' => $faker->address,
            ]);
            $patientsIds[] = $patient->id;
        }

        // 6. Criar 50 Agendamentos com Distribuição Controlada
        // Criamos um array com os status desejados e embaralhamos
        $statuses = array_merge(
            array_fill(0, 10, 'canceled'),
            array_fill(0, 20, 'scheduled'),
            array_fill(0, 20, 'completed')
        );
        shuffle($statuses);

        foreach ($statuses as $status) {
            // Datas entre 15 dias atrás e 15 dias no futuro
            $date = Carbon::now()->addDays(rand(-15, 15));

            Appointment::create([
                'patient_id' => $faker->randomElement($patientsIds),
                'user_id' => $faker->randomElement($doctorsIds),
                'appointment_date' => $date->format('Y-m-d'),
                'appointment_time' => $faker->randomElement(['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '16:00', '17:00']),
                'status' => $status,
                'notes' => 'Consulta gerada via Seeder automático. ' . $faker->sentence(6),
                'certificate_days' => ($status === 'completed' && rand(0, 1)) ? rand(1, 5) : null,
            ]);
        }

        $this->command->info('Sucesso: 10 médicos, 4 recepcionistas, 30 pacientes e 50 agendamentos criados!');
    }
}
