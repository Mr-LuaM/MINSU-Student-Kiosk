<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Academic;
use App\Models\Contact;
use App\Models\Skill;
use App\Models\Achievement;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Log;
use Throwable;

class StudentsImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function collection(Collection $rows)
    {
        Log::info("Import process started. Total rows: " . count($rows));

        foreach ($rows as $row) {
            try {
                // 🔹 Normalize column names (lowercase for consistency)
                $normalizedRow = array_change_key_case($row->toArray(), CASE_LOWER);

                // 🔹 Ensure required fields exist
                if (!isset($normalizedRow['student_number']) || !isset($normalizedRow['first_name']) || !isset($normalizedRow['enrollment_status']) || !isset($normalizedRow['birth_date'])) {
                    Log::warning("Skipping row: Missing required fields", ['row' => $row]);
                    continue;
                }

                // 🔹 Generate Student ID if missing
                if (empty($normalizedRow['student_id'])) {
                    $year = date('Y');
                    $latestStudent = Student::latest('student_id')->first();
                    $nextNumber = $latestStudent ? ((int)substr($latestStudent->student_id, 5)) + 1 : 10001;
                    $normalizedRow['student_id'] = 'S' . $year . $nextNumber;
                }

                // 🔹 Create or Update Student
                $student = Student::updateOrCreate(
                    ['student_id' => $normalizedRow['student_id']],
                    [
                        'first_name' => $normalizedRow['first_name'],
                        'middle_name' => $normalizedRow['middle_name'] ?? null,
                        'last_name' => $normalizedRow['last_name'],
                        'suffix' => $normalizedRow['suffix'] ?? null,
                        'birth_date' => $normalizedRow['birth_date'],
                        'gender' => $normalizedRow['gender'],
                        'nationality' => $normalizedRow['nationality'],
                        'religion' => $normalizedRow['religion'] ?? null,
                        'blood_type' => $normalizedRow['blood_type'] ?? null,
                        'student_type' => $normalizedRow['student_type'],
                    ]
                );

                // 🔹 Create Academic Record
                Academic::updateOrCreate(
                    ['student_id' => $student->student_id],
                    [
                        'student_number' => $normalizedRow['student_number'],
                        'enrollment_status' => $normalizedRow['enrollment_status'],
                        'year_level' => $normalizedRow['year_level'],
                        'college' => $normalizedRow['college'],
                        'program' => $normalizedRow['program'],
                        'section' => $normalizedRow['section'],
                        'gwa' => is_numeric($normalizedRow['gwa']) ? $normalizedRow['gwa'] : null,
                    ]
                );

                // 🔹 Create Contact Record
                Contact::updateOrCreate(
                    ['student_id' => $student->student_id],
                    [
                        'email' => $normalizedRow['email'] ?? null,
                        'phone_number' => $normalizedRow['phone_number'] ?? null,
                        'address' => $normalizedRow['address'] ?? null,
                        'guardian_name' => $normalizedRow['guardian_name'] ?? null,
                        'guardian_contact' => $normalizedRow['guardian_contact'] ?? null,
                        'emergency_contact' => $normalizedRow['emergency_contact'] ?? null,
                    ]
                );

                // 🔹 Handle Skills
                if (!empty($normalizedRow['skills']) && !empty($normalizedRow['proficiency_levels'])) {
                    $skillsArray = explode(',', $normalizedRow['skills']);
                    $proficiencyArray = explode(',', $normalizedRow['proficiency_levels']);

                    if (count($skillsArray) === count($proficiencyArray)) {
                        foreach ($skillsArray as $index => $skill) {
                            Skill::updateOrCreate(
                                ['student_id' => $student->student_id, 'skill_name' => trim($skill)],
                                ['proficiency_level' => trim($proficiencyArray[$index])]
                            );
                        }
                    } else {
                        Log::warning("Mismatched skills and proficiency levels for student", ['row' => $row]);
                    }
                }

                // 🔹 Handle Achievements
                if (!empty($normalizedRow['achievements']) && !empty($normalizedRow['categories']) && !empty($normalizedRow['award_dates']) && !empty($normalizedRow['awarding_bodies'])) {
                    $achievementsArray = explode(',', $normalizedRow['achievements']);
                    $categoriesArray = explode(',', $normalizedRow['categories']);
                    $awardDatesArray = explode(',', $normalizedRow['award_dates']);
                    $awardingBodiesArray = explode(',', $normalizedRow['awarding_bodies']);

                    if (
                        count($achievementsArray) === count($categoriesArray) &&
                        count($categoriesArray) === count($awardDatesArray) &&
                        count($awardDatesArray) === count($awardingBodiesArray)
                    ) {
                        foreach ($achievementsArray as $index => $achievement) {
                            Achievement::updateOrCreate(
                                ['student_id' => $student->student_id, 'achievement_name' => trim($achievement)],
                                [
                                    'category' => trim($categoriesArray[$index]),
                                    'award_date' => trim($awardDatesArray[$index]) ?: now(),
                                    'awarding_body' => trim($awardingBodiesArray[$index]),
                                ]
                            );
                        }
                    } else {
                        Log::warning("Mismatched achievements data for student", ['row' => $row]);
                    }
                }
            } catch (Throwable $e) {
                Log::error('Error importing student', ['message' => $e->getMessage(), 'row' => $row]);
            }
        }
    }

    public function chunkSize(): int
    {
        return 500; // Processes data in chunks of 500 rows
    }
}
