<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Achievement;
use App\Models\Student;
use Faker\Factory as Faker;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (Student::all() as $student) {
            foreach (range(1, rand(1, 2)) as $index) { // Each student has 1-2 achievements
                Achievement::create([
                    'student_id' => $student->student_id,
                    'achievement_name' => $faker->sentence,
                    'category' => $faker->randomElement(['Academic', 'Sports', 'Arts', 'Technology', 'Community']),
                    'award_date' => $faker->date(),
                    'awarding_body' => $faker->company,
                ]);
            }
        }
    }
}
