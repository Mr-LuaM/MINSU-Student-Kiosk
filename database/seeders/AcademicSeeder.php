<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Academic;
use App\Models\Student;
use Faker\Factory as Faker;

class AcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (Student::all() as $student) {
            Academic::create([
                'student_id' => $student->student_id,
                'student_number' => 'SN' . $faker->unique()->numberBetween(100000, 999999),
                'enrollment_status' => $faker->randomElement(['Enrolled', 'Dropped', 'Graduated']),
                'year_level' => $faker->numberBetween(1, 4),
                'college' => $faker->randomElement(['Engineering', 'Business', 'Arts', 'Science']),
                'program' => $faker->randomElement(['BSIT', 'BSCS', 'BSEE', 'BSA']),
                'section' => 'SEC-' . $faker->randomLetter . $faker->numberBetween(1, 5),
                'gwa' => $faker->randomFloat(2, 1.0, 5.0),
            ]);
        }
    }
}
