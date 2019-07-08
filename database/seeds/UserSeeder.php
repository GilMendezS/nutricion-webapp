<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'lastname' => 'nutriapp',
            'phone' => '332456121',
            'age' => 24,
            'email' => 'admin@mail.com',
            'password' => bcrypt('gilberto'),
            
        ]);
        User::create([
            'name' => 'Patient 1',
            'lastname' => 'test 1',
            'phone' => '1234567890',
            'age' => 19,
            'email' => 'patient1@mail.com',
            'password' => bcrypt('patient1'),
            'creator_id' => 1
        ]);
        User::create([
            'name' => 'Patient 2',
            'lastname' => 'test 2',
            'phone' => '1237896541',
            'age' => 19,
            'email' => 'patient2@mail.com',
            'password' => bcrypt('patient2'),
            'creator_id' => 1
        ]);
    }
}
