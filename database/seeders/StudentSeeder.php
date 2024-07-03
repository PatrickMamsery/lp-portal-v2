<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use \Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('sw_TZ'); // Use Swahili (Tanzania) locale for Faker

        // Create 10 students
        for ($i = 0; $i < 10; $i++) {
            Student::create([
                'first_name' => $faker->firstNameMale, // Random Swahili male first name
                'middle_name' => $faker->firstNameMale, // Random Swahili male middle name
                'last_name' => $faker->lastName, // Random Swahili last name
                'phone_number' => $faker->phoneNumber, // Random phone number
                'rfid_tag' => $faker->uuid, // Random UUID for RFID tag
                'dob' => $faker->date($format = 'Y-m-d', $max = 'now'), // Random date of birth
                'gender' => 'male', // Assuming all are male for simplicity
                'school_id' => 1, // Replace with actual school ID
            ]);
        }
    }
}
