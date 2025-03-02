<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new StudentsSheet(),
            new InstructionsSheet(),
        ];
    }
}

class StudentsSheet implements FromArray, WithHeadings, WithTitle, WithStyles
{
    public function array(): array
    {
        return [
            [
                '', // Auto-generated Student ID
                'Juan',
                'Dela',
                'Cruz',
                'Jr.',
                '2000-01-01',
                'Male',
                'Filipino',
                'Catholic',
                'O+',
                'Regular',
                'SN123456',
                'Enrolled',
                '3',
                'College of Engineering',
                'BSIT',
                'SEC-1',
                '1.75',
                'juan.delacruz@example.com',
                '09123456789',
                '123 Street, City',
                'Maria Dela Cruz',
                '09198765432',
                '0911222333',
                'Coding, Public Speaking',
                'Expert, Intermediate',
                'Math Olympiad, Robotics Competition',
                'Academic, Technology',
                '2024-05-20, 2023-09-12',
                'National Science Institute, Robotics Club'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'Student ID',
            'First Name',
            'Middle Name',
            'Last Name',
            'Suffix',
            'Birth Date',
            'Gender',
            'Nationality',
            'Religion',
            'Blood Type',
            'Student Type',

            'Student Number',
            'Enrollment Status',
            'Year Level',
            'College',
            'Program',
            'Section',
            'GWA',

            'Email',
            'Phone Number',
            'Address',
            'Guardian Name',
            'Guardian Contact',
            'Emergency Contact',

            'Skills',
            'Proficiency Levels',
            'Achievements',
            'Categories',
            'Award Dates',
            'Awarding Bodies',
        ];
    }

    public function title(): string
    {
        return 'Students Template';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'CCCCCC']]
            ],

            // Student Information (Light Blue)
            'A1:K1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'B3C6E7']]],

            // Academic Information (Light Yellow)
            'L1:R1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FEF6C7']]],

            // Contact Information (Light Green)
            'S1:X1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'DFF3E3']]],

            // Skills & Achievements (Light Orange)
            'Y1:AC1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FED8B1']]],
        ];
    }
}
class InstructionsSheet implements FromArray, WithTitle
{
    public function array(): array
    {
        return [
            ['📌 Instructions for Filling Out the Student Template'],
            [' '], // Empty row for spacing

            ['✅ General Rules:'],
            ['1. **Do not modify the column headers.** Ensure all column names remain exactly as provided.'],
            ['2. **If "Student ID" is left blank, it will be generated automatically.**'],
            ['3. **"Enrollment Status", "Blood Type", and "Gender" must match allowed values.**'],
            ['4. **Separate multiple values using a comma (",").** Example: "Skill1, Skill2".'],
            ['5. **For empty fields, leave them blank (do NOT enter "N/A").**'],

            [' '], // Empty row

            ['✅ Allowed Values:'],
            ['- **Gender**: Male, Female, Other'],
            ['- **Enrollment Status**: Enrolled, Dropped, Graduated'],
            ['- **Blood Type**: A+, A-, B+, B-, O+, O-, AB+, AB-'],
            ['- **Student Type**: Regular, Irregular, Transferee, Foreign'],

            [' '], // Empty row

            ['✅ Example Data Formatting:'],
            ['- **First Name**: Juan'],
            ['- **Middle Name**: Dela'],
            ['- **Last Name**: Cruz'],
            ['- **Suffix**: Jr. (Leave blank if none)'],
            ['- **Birth Date**: 2000-01-01 (Format: YYYY-MM-DD)'],
            ['- **Email**: juan.delacruz@example.com'],
            ['- **Phone Number**: 09123456789'],
            ['- **Guardian Contact**: 09198765432'],
            ['- **Emergency Contact**: 0911222333'],

            [' '], // Empty row

            ['✅ Skills & Proficiency (Comma-Separated)'],
            ['- **Format**: "Skill1, Skill2"'],
            ['- **Example**: "Coding, Public Speaking, Graphic Design"'],
            [' '],
            ['✅ Proficiency Levels (Must Match Skills)'],
            ['- **Format**: "Level1, Level2" (Levels must match the number of skills)'],
            ['- **Example**: "Expert, Intermediate, Beginner"'],
            ['❌ Incorrect Example (Mismatch):'],
            ['  Skills: "Coding, Public Speaking"'],
            ['  Proficiency: "Expert, Intermediate, Beginner" (❌ Extra value)'],
            ['✔ Correct Example (Matching):'],
            ['  Skills: "Coding, Public Speaking"'],
            ['  Proficiency: "Expert, Intermediate"'],

            [' '], // Empty row

            ['✅ Achievements Formatting'],
            ['- **Format**: "Achievement1, Achievement2"'],
            ['- **Example**: "Math Olympiad, Robotics Competition, Best Research Paper"'],

            [' '], // Empty row

            ['✅ Categories (Must Match Achievements)'],
            ['- **Format**: "Category1, Category2"'],
            ['- **Example**: "Academic, Technology, Science"'],

            [' '], // Empty row

            ['✅ Award Dates (Must Match Achievements)'],
            ['- **Format**: YYYY-MM-DD'],
            ['- **Example**: "2024-05-20, 2023-09-12, 2022-11-15"'],

            [' '], // Empty row

            ['✅ Awarding Bodies (Must Match Achievements)'],
            ['- **Format**: "Organization1, Organization2"'],
            ['- **Example**: "National Science Institute, Robotics Club, IEEE"'],

            [' '], // Empty row

            ['❌ Incorrect Example (Mismatch)'],
            ['  Achievements: "Math Olympiad, Robotics Competition"'],
            ['  Categories: "Academic" (❌ Missing category for second achievement)'],

            ['✔ Correct Example (Matching)'],
            ['  Achievements: "Math Olympiad, Robotics Competition"'],
            ['  Categories: "Academic, Technology"'],

            [' '], // Empty row

            ['✅ Additional Notes'],
            ['- Ensure that the **number of entries in achievements, categories, award dates, and awarding bodies match**.'],
            ['- If an achievement does not have an awarding body or date, leave it blank, but **ensure the order is maintained**.'],

            [' '], // Empty row
            ['✅ Final Checklist Before Importing'],
            ['✔ **Check that column names were NOT modified.**'],
            ['✔ **Ensure that comma-separated values match correctly.**'],
            ['✔ **Confirm that all required fields are filled in.**'],
        ];
    }

    public function title(): string
    {
        return 'Instructions';
    }
}
