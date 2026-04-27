<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Appointment;



class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory(10)->create();
        Service::factory(5)->create();
        Appointment::factory(20)->create([
        'patient_id' => User::inRandomOrder()->first()->id,
        'medecin_id' => User::inRandomOrder()->first()->id,
        'service_id' => Service::inRandomOrder()->first()->id,
    ]);
    }
}
