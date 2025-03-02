<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Academic;
use App\Models\Contact;
use App\Models\Skill;
use App\Models\Achievement;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;

class StudentsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            if ($index === 0) continue; // Skip headers

            $studentId = $row[0] ?? null;
            $studentNumber = $row[10] ?? null;

            if (!$studentId) {
                $latestStudent = Student::latest('student_id')->first();
                $latestNumber = $latestStudent ? (int)substr($latestStudent->student_id, 1) : 18000;
                $studentId = 'S' . ($latestNumber + 1);
            }

            // Ensure valid date formats
            $birthDate = $row[5] ?? now()->format('Y-m-d');
            $awardDates = explode(',', $row[27] ?? now()->format('Y-m-d'));

            $student = Student::updateOrCreate(
                ['student_id' => $studentId],
                [
                    'first_name' => $row[1] ?? 'Unknown',
                    'middle_name' => $row[2] ?? '',
                    'last_name' => $row[3] ?? 'Unknown',
                    'suffix' => $row[4] ?? '',
                    'birth_date' => Carbon::parse($birthDate)->format('Y-m-d'),
                    'gender' => $row[6] ?? 'Other',
                    'nationality' => $row[7] ?? 'Unknown',
                    'religion' => $row[8] ?? 'Unknown',
                    'blood_type' => $row[9] ?? 'Unknown',
                    'student_type' => $row[10] ?? 'Regular',
                ]
            );

            Academic::updateOrCreate(
                ['student_id' => $studentId],
                [
                    'student_number' => $studentNumber,
                    'enrollment_status' => $row[11] ?? 'Enrolled',
                    'year_level' => $row[12] ?? 1,
                    'college' => $row[13] ?? 'Unknown',
                    'program' => $row[14] ?? 'Unknown',
                    'section' => $row[15] ?? 'Unknown',
                    'gwa' => is_numeric($row[16]) ? $row[16] : null,
                ]
            );

            Contact::updateOrCreate(
                ['student_id' => $studentId],
                [
                    'email' => $row[17] ?? 'N/A',
                    'phone_number' => $row[18] ?? 'N/A',
                    'address' => $row[19] ?? 'N/A',
                    'guardian_name' => $row[20] ?? 'N/A',
                    'guardian_contact' => $row[21] ?? 'N/A',
                    'emergency_contact' => $row[22] ?? 'N/A',
                ]
            );

            if (!empty($row[23])) {
                $skills = explode(',', $row[23]);
                $proficiencyLevels = explode(',', $row[24] ?? 'Beginner');
                Skill::where('student_id', $studentId)->delete();
                foreach ($skills as $key => $skill) {
                    Skill::create([
                        'student_id' => $studentId,
                        'skill_name' => trim($skill),
                        'proficiency_level' => $proficiencyLevels[$key] ?? 'Beginner',
                    ]);
                }
            }

            if (!empty($row[25])) {
                $achievements = explode(',', $row[25]);
                $categories = explode(',', $row[26] ?? 'Academic');
                $awardingBodies = explode(',', $row[28] ?? 'Unknown');
                Achievement::where('student_id', $studentId)->delete();
                foreach ($achievements as $key => $achievement) {
                    Achievement::create([
                        'student_id' => $studentId,
                        'achievement_name' => trim($achievement),
                        'category' => $categories[$key] ?? 'Academic',
                        'award_date' => $awardDates[$key] ?? now()->format('Y-m-d'),
                        'awarding_body' => $awardingBodies[$key] ?? 'Unknown',
                    ]);
                }
            }
        }
    }
}
