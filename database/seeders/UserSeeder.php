<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {

        DB::table("users")->delete();

        $faker = Faker::create();

        // Seed admin user
        User::create([
            'noms' => 'Admin User',
            'matricule' => 'admin123',
            'mail' => 'admin@example.com',
            'role' => 'admin',
            'filiere' => 'Computer Science', // Replace with the actual filiere
        ]);

        // Seed regular user
        for($i=0; $i <50; $i++){
            User::create([
                'noms' => $faker->name(),
                'mail' => $faker->unique()->safeEmail(),
                'matricule' => strtoupper(Str::random(6)),
                'filiere' => Arr::random(["Mathematics","Computer Science","Biology","Industrial Security"]),// Replace with the actual filiere
            ]);    
        }
        
        // Add more users as needed
    }
}
