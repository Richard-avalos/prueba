<?php

namespace Database\Seeders;


use App\Models\Appointment;
use Illuminate\Database\Seeder;

class AppointmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            Appointment::factory()
                ->count(300)
                ->create();
        }
    }
}
