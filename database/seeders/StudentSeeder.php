<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            Student::create([
                'student_id' => 'S' . $faker->unique()->numberBetween(10000, 99999),
                'first_name' => $faker->firstName,
                'middle_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'suffix' => $faker->randomElement(['Jr.', 'III', null]),
                'birth_date' => $faker->date(),
                'gender' => $faker->randomElement(['Male', 'Female', 'Other']),
                'nationality' => $faker->country,
                'religion' => $faker->randomElement(['Catholic', 'Muslim', 'Protestant', 'None']),
                'blood_type' => $faker->randomElement(['A', 'B', 'AB', 'O']),
                'student_type' => $faker->randomElement(['Regular', 'Irregular', 'Transferee', 'Foreign']),
            ]);
        }
    }
}
