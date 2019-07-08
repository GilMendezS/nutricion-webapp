<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'code' => 'nut',
            'name' => 'Nutriologo'
        ]);
        Role::create([
            'code' => 'pac',
            'name' => 'Paciente'
        ]);
        Role::create([
            'code' => 'admin',
            'name' => 'Administrador'
        ]);
    }
}
