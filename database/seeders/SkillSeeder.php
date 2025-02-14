<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Skill;
use App\Models\Student;
use Faker\Factory as Faker;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (Student::all() as $student) {
            foreach (range(1, rand(1, 3)) as $index) { // Each student has 1-3 skills
                Skill::create([
                    'student_id' => $student->student_id,
                    'skill_name' => $faker->randomElement(['Programming', 'Public Speaking', 'Sports', 'Music']),
                    'proficiency_level' => $faker->randomElement(['Beginner', 'Intermediate', 'Advanced', 'Expert']),
                ]);
            }
        }
    }
}
