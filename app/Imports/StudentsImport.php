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
use Illuminate\Support\Facades\Log;

class StudentsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                // Generate Student ID if missing (e.g., S+YEAR+INCREMENT format)
                $year = date('Y');
                $latestStudent = Student::latest('student_id')->first();
                $nextNumber = $latestStudent ? ((int)substr($latestStudent->student_id, 5)) + 1 : 10001;
                $studentId = 'S' . $year . $nextNumber;

                // Validate enrollment_status to match ENUM values
                $validEnrollmentStatuses = ['Enrolled', 'Dropped', 'Graduated'];
                $enrollmentStatus = in_array($row['enrollment_status'], $validEnrollmentStatuses) ?
                    $row['enrollment_status'] : 'Enrolled';

                // Validate GWA (ensure it's numeric, otherwise default to NULL)
                $gwa = is_numeric($row['gwa']) ? $row['gwa'] : null;

                // Create Student
                $student = Student::updateOrCreate(
                    ['student_id' => $studentId],
                    [
                        'first_name' => $row['first_name'],
                        'middle_name' => $row['middle_name'] ?? null,
                        'last_name' => $row['last_name'],
                        'suffix' => $row['suffix'] ?? null,
                        'birth_date' => $row['birth_date'],
                        'gender' => $row['gender'],
                        'nationality' => $row['nationality'],
                        'religion' => $row['religion'] ?? null,
                        'blood_type' => $row['blood_type'] ?? null,
                        'student_type' => $row['student_type'],
                    ]
                );

                // Create Academic Record
                Academic::updateOrCreate(
                    ['student_id' => $student->student_id],
                    [
                        'student_number' => $row['student_number'],
                        'enrollment_status' => $enrollmentStatus,
                        'year_level' => $row['year_level'],
                        'college' => $row['college'],
                        'program' => $row['program'],
                        'section' => $row['section'],
                        'gwa' => $gwa,
                    ]
                );

                // Create Contact Record
                Contact::updateOrCreate(
                    ['student_id' => $student->student_id],
                    [
                        'email' => $row['email'] ?? null,
                        'phone_number' => $row['phone_number'] ?? null,
                        'address' => $row['address'] ?? null,
                        'guardian_name' => $row['guardian_name'] ?? null,
                        'guardian_contact' => $row['guardian_contact'] ?? null,
                        'emergency_contact' => $row['emergency_contact'] ?? null,
                    ]
                );

                // Handle Skills (multiple values separated by ",")
                if (!empty($row['skills'])) {
                    $skillsArray = explode(',', $row['skills']);
                    foreach ($skillsArray as $skill) {
                        $parts = explode(':', trim($skill)); // Format: "SkillName:Proficiency"
                        if (count($parts) == 2) {
                            Skill::updateOrCreate(
                                ['student_id' => $student->student_id, 'skill_name' => trim($parts[0])],
                                ['proficiency_level' => trim($parts[1])]
                            );
                        }
                    }
                }

                // Handle Achievements (multiple values separated by ",")
                if (!empty($row['achievements'])) {
                    $achievementsArray = explode(',', $row['achievements']);
                    foreach ($achievementsArray as $achievement) {
                        $parts = explode(':', trim($achievement)); // Format: "AchievementName:Category:Date:AwardingBody"
                        if (count($parts) == 4) {
                            Achievement::updateOrCreate(
                                ['student_id' => $student->student_id, 'achievement_name' => trim($parts[0])],
                                [
                                    'category' => trim($parts[1]),
                                    'award_date' => trim($parts[2]) ?: now(),
                                    'awarding_body' => trim($parts[3]),
                                ]
                            );
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error importing student', ['message' => $e->getMessage(), 'row' => $row]);
            }
        }
    }
}
