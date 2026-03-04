<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Limpa o cache do Spatie para evitar conflitos ao rodar múltiplas vezes
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Criando as Roles (Cargos Base)
        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);
        $roleDoctor = Role::firstOrCreate(['name' => 'Doctor']);
        $roleReceptionist = Role::firstOrCreate(['name' => 'Receptionist']);

        // 2. Criando o Usuário Administrador Master (Dono da Clínica)
        // Usamos firstOrCreate para não duplicar se rodarmos o comando duas vezes
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@safecoreprocrm.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('senha123'), // Senha forte
            ]
        );

        // 3. Atribuindo o cargo de Admin ao usuário
        $adminUser->assignRole($roleAdmin);
    }
}
