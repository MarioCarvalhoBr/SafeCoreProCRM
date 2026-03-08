<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Limpa o cache do Spatie para evitar conflitos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Criando as Roles (Cargos Base)
        $roles = ['Admin', 'Doctor', 'Receptionist', 'Patient'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // 2. Criando o Usuário Administrador Master
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@safecoreprocrm.com'], // Mantenha o email de sua preferência
            [
                'name' => 'System Administrator',
                'password' => Hash::make('senha123'),
                'email_verified_at' => now(),
            ]
        );

        // 3. Garante que ele tenha a role Admin
        if (!$adminUser->hasRole('Admin')) {
            $adminUser->assignRole('Admin');
        }

        $this->command->info('Ambiente de permissões e Admin inicial configurados com sucesso!');
    }
}
