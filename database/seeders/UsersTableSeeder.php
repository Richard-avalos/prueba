<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'alexi',
            'email' => 'alexiavalos1123@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'), // password
            'cedula' => '1121564512154',
            'address' => 'mi casa JAJA',
            'phone' => '5456248985',
            'role' => 'admin',

        ]);

        User::create([
            'name' => 'Paciente 1',
            'email' => 'paciente1@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'), // password
            'cedula' => '1121564512154',
            'address' => 'mi casa JAJA',
            'phone' => '5456248985',
            'role' => 'paciente',

        ]);

        User::create([
            'name' => 'doctor1',
            'email' => 'doctor1@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'), // password
            'cedula' => '1121564512154',
            'address' => 'mi casa JAJA',
            'phone' => '5456248985',
            'role' => 'doctor',

        ]);

        
        User::factory()
            ->count(50)
            ->state(['role' => 'paciente'])
            ->create();
            
    }
}
