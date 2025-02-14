<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\Student;
use Faker\Factory as Faker;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (Student::all() as $student) {
            Contact::create([
                'student_id' => $student->student_id,
                'email' => $faker->unique()->safeEmail,
                'phone_number' => $faker->numerify('###########'), // Generates a 10-11 digit number
                'address' => $faker->address,
                'guardian_name' => $faker->name,
                'guardian_contact' => $faker->numerify('###########'),
                'emergency_contact' => $faker->numerify('###########'),
            ]);
        }
    }
}
