<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Contact;
use App\Models\Academic;
use App\Models\Skill;
use App\Models\Achievement;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsTemplateExport;
use App\Exports\StudentsExport;
use App\Imports\StudentsImport;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        $totalAdmins = User::count();
        $totalStudents = Student::count();

        // Fetch recent 5 admins and students
        $recentAdmins = User::latest()->limit(5)->get();
        $recentStudents = Student::latest()->limit(5)->get();

        // Fetch student enrollment trends (last 6 months)
        $studentEnrollment = Student::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get();

        $studentData = $this->fillMissingMonths($studentEnrollment);

        // Fetch admin account growth (last 6 months)
        $adminGrowth = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get();

        $adminData = $this->fillMissingMonths($adminGrowth);

        // 🚀 Convert labels properly before sending to the Blade file
        return view('admin.dashboard', [
            'totalAdmins' => $totalAdmins,
            'totalStudents' => $totalStudents,
            'recentAdmins' => $recentAdmins,
            'recentStudents' => $recentStudents,
            'studentEnrollmentDates' => array_keys($studentData), // ["Jan 2025", "Feb 2025"]
            'studentEnrollmentCounts' => array_values($studentData), // [5, 3, 2]
            'adminGrowthDates' => array_keys($adminData), // ["Jan 2025", "Feb 2025"]
            'adminGrowthCounts' => array_values($adminData) // [2, 1, 3]
        ]);
    }

    /**
     * Fill missing months with zero counts & format as "MMM YYYY"
     */
    private function fillMissingMonths($data)
    {
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('M Y'); // Format as "Jan 2025"
            $months[$month] = 0; // Default count = 0
        }

        foreach ($data as $row) {
            $formattedMonth = Carbon::createFromFormat('Y-m', $row->month)->format('M Y');
            $months[$formattedMonth] = $row->count;
        }

        return $months;
    }

    // ===========================
    // ✅ STUDENT MANAGEMENT
    // ===========================

    /**
     * Display a paginated list of students with search functionality.
     */
    public function studentsIndex(Request $request)
    {
        $query = Student::query()->with('academics');

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('student_id', 'like', "%$searchTerm%")
                ->orWhere('first_name', 'like', "%$searchTerm%")
                ->orWhere('middle_name', 'like', "%$searchTerm%")
                ->orWhere('last_name', 'like', "%$searchTerm%")
                ->orWhereHas('academics', function ($q) use ($searchTerm) {
                    $q->where('program', 'like', "%$searchTerm%")
                        ->orWhere('year_level', 'like', "%$searchTerm%")
                        ->orWhere('enrollment_status', 'like', "%$searchTerm%");
                });
        }

        $students = $query->paginate(10)->appends(['search' => $request->search]);

        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function createStudent()
    {
        return view('admin.students.create');
    }

    /**
     * Store a newly created student in the database.
     */

    public function storeStudent(Request $request)
    {
        try {
            Log::info('storeStudent() called', ['request' => $request->all()]);

            // ✅ Auto-generate student_id
            $latestStudent = Student::latest('student_id')->first(); // Get latest student by ID
            $lastNumber = $latestStudent ? (int) substr($latestStudent->student_id, 1) : 10000; // Default start: S10000
            $newStudentId = 'S' . ($lastNumber + 1); // Increment last ID

            Log::info('Generated student_id', ['student_id' => $newStudentId]);

            // ✅ Validate Student Core Data
            $validatedStudentData = $request->validate([
                'first_name' => 'required|string|max:50',
                'middle_name' => 'nullable|string|max:50',
                'last_name' => 'required|string|max:50',
                'suffix' => 'nullable|string|max:10',
                'birth_date' => 'required|date',
                'gender' => 'required|in:Male,Female,Other',
                'nationality' => 'required|string|max:50',
                'religion' => 'nullable|string|max:50',
                'blood_type' => 'nullable|string|max:5',
                'student_type' => 'required|in:Regular,Irregular,Transferee,Foreign',
            ]);
            Log::info('Student core data validated', $validatedStudentData);

            // ✅ Validate Academic Data
            $validatedAcademicData = $request->validate([
                'student_number' => 'required|string|unique:academics,student_number|max:20',
                'enrollment_status' => 'required|in:Enrolled,Dropped,Graduated',
                'year_level' => 'required|integer|min:1',
                'college' => 'nullable|string|max:100',
                'program' => 'nullable|string|max:100',
                'section' => 'nullable|string|max:20',
                'gwa' => 'nullable|numeric|between:0,5.00',
            ]);
            Log::info('Academic data validated', $validatedAcademicData);

            // ✅ Validate Contact Data
            $validatedContactData = $request->validate([
                'email' => 'nullable|email|max:100',
                'phone_number' => 'nullable|string|max:15',
                'address' => 'nullable|string',
                'guardian_name' => 'nullable|string|max:100',
                'guardian_contact' => 'nullable|string|max:15',
                'emergency_contact' => 'nullable|string|max:15',
            ]);
            Log::info('Contact data validated', $validatedContactData);

            // ✅ Add the auto-generated student_id
            $validatedStudentData['student_id'] = $newStudentId;

            // ✅ Create Student Record
            $student = Student::create($validatedStudentData);
            Log::info('Student record created', ['student_id' => $student->student_id]);

            // ✅ Create Academics Record
            $student->academics()->create($validatedAcademicData);
            Log::info('Academic record created', ['student_id' => $student->student_id]);

            // ✅ Create Contact Record
            $student->contact()->create($validatedContactData);
            Log::info('Contact record created', ['student_id' => $student->student_id]);

            // ✅ Handle Skills (if provided)
            if ($request->has('skills')) {
                Log::info('Skills found in request', $request->input('skills'));

                $validatedSkills = collect($request->input('skills'))->map(function ($skill) {
                    return [
                        'skill_name' => $skill['skill_name'] ?? null,
                        'proficiency_level' => $skill['proficiency_level'] ?? null,
                    ];
                })->filter(fn($skill) => $skill['skill_name'] !== null); // Remove empty skills

                if ($validatedSkills->isNotEmpty()) {
                    $student->skills()->createMany($validatedSkills);
                    Log::info('Skills stored', ['skills' => $validatedSkills]);
                }
            }

            // ✅ Handle Achievements (if provided)
            if ($request->has('achievements')) {
                Log::info('Achievements found in request', $request->input('achievements'));

                $validatedAchievements = collect($request->input('achievements'))->map(function ($achievement) {
                    return [
                        'achievement_name' => $achievement['achievement_name'] ?? null,
                        'category' => $achievement['category'] ?? null,
                        'award_date' => $achievement['award_date'] ?? null,
                        'awarding_body' => $achievement['awarding_body'] ?? null,
                    ];
                })->filter(fn($achievement) => $achievement['achievement_name'] !== null); // Remove empty achievements

                if ($validatedAchievements->isNotEmpty()) {
                    $student->achievements()->createMany($validatedAchievements);
                    Log::info('Achievements stored', ['achievements' => $validatedAchievements]);
                }
            }

            Log::info('Student creation successful', ['student_id' => $student->student_id]);

            return redirect()->route('admin.students.index')->with('success', 'Student Added Successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation error in storeStudent()', ['errors' => $e->errors()]);

            return redirect()->back()
                ->withInput()
                ->withErrors($e->validator) // Flash validation errors
                ->with('error', implode(', ', collect($e->validator->errors()->all())->toArray())); // Convert errors to string
        } catch (\Exception $e) {
            Log::error('Error in storeStudent()', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }



    /**
     * Display the specified student.
     */
    public function showStudent($id)
    {
        $student = Student::with(['academics', 'contact', 'skills', 'achievements'])->findOrFail($id);
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function editStudent($id)
    {
        $student = Student::with(['academics', 'contact', 'skills', 'achievements'])->findOrFail($id);
        // var_dump($student);
        return view('admin.students.edit', compact('student'));
    }


    /**
     * Update the specified student in the database.
     */
    public function updateStudent(Request $request, $id)
    {
        $student = Student::with(['academics', 'contact', 'skills', 'achievements'])->findOrFail($id);

        // Validate Student Core Data
        $validatedStudentData = $request->validate([
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'suffix' => 'nullable|string|max:10',
            'birth_date' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'nationality' => 'required|string|max:50',
            'religion' => 'nullable|string|max:50',
            'blood_type' => 'nullable|string|max:5',
            'student_type' => 'required|in:Regular,Irregular,Transferee,Foreign',
        ]);

        // Validate Academic Data
        $validatedAcademicData = $request->validate([
            'enrollment_status' => 'required|in:Enrolled,Dropped,Graduated',
            'year_level' => 'required|integer|min:1',
            'college' => 'nullable|string|max:100',
            'program' => 'nullable|string|max:100',
            'section' => 'nullable|string|max:20',
            'gwa' => 'nullable|numeric|between:0,5.00',
        ]);

        // Validate Contact Data
        $validatedContactData = $request->validate([
            'email' => 'nullable|email|max:100',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'guardian_name' => 'nullable|string|max:100',
            'guardian_contact' => 'nullable|string|max:15',
            'emergency_contact' => 'nullable|string|max:15',
        ]);

        // ✅ Update Student Core Data
        $student->update($validatedStudentData);

        // ✅ Update Academics if exists, or create a new record
        if ($student->academics) {
            $student->academics->update($validatedAcademicData);
        } else {
            $student->academics()->create($validatedAcademicData);
        }

        // ✅ Update Contact if exists, or create a new record
        if ($student->contact) {
            $student->contact->update($validatedContactData);
        } else {
            $student->contact()->create($validatedContactData);
        }

        // ✅ Update Skills
        $validatedSkills = $request->input('skills', []);
        $student->skills()->delete(); // Remove existing skills to replace with new ones

        foreach ($validatedSkills as $skill) {
            if (!empty($skill['skill_name'])) {
                $student->skills()->create([
                    'skill_name' => $skill['skill_name'],
                    'proficiency_level' => $skill['proficiency_level'],
                ]);
            }
        }

        // ✅ Update Achievements
        $validatedAchievements = $request->input('achievements', []);
        $student->achievements()->delete(); // Remove existing achievements to replace with new ones

        foreach ($validatedAchievements as $achievement) {
            if (!empty($achievement['achievement_name'])) {
                $student->achievements()->create([
                    'achievement_name' => $achievement['achievement_name'],
                    'category' => $achievement['category'],
                    'award_date' => $achievement['award_date'],
                    'awarding_body' => $achievement['awarding_body'],
                ]);
            }
        }

        return redirect()->route('admin.students.index')->with('success', 'Student Updated Successfully!');
    }


    /**
     * Remove the specified student from the database.
     */
    public function deleteStudent($id)
    {
        Student::findOrFail($id)->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student Deleted Successfully!');
    }

    // ===========================
    // ✅ ACCOUNT MANAGEMENT
    // ===========================

    /**
     * Display a paginated list of users.
     */
    public function accountsIndex(Request $request)
    {
        $users = User::paginate(10);
        return view('admin.accounts.index', compact('users'));
    }

    /**
     * Show the form for creating a new account.
     */
    public function createAccount()
    {
        return view('admin.accounts.create');
    }

    /**
     * Store a newly created account in the database.
     */
    public function storeAccount(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'email_verified_at' => now(), // ✅ Auto-verifies the email
        ]);

        //room for improvemnt.. could auto mail this out to the user
        return redirect()->route('admin.accounts.index')->with('success', 'Account Added Successfully!');
    }

    /**
     * Display the specified user account.
     */
    // public function showAccount($id)
    // {
    //     $user = User::findOrFail($id);
    //     return view('admin.accounts.show', compact('user'));
    // }

    /**
     * Show the form for editing the specified account.
     */
    // public function editAccount($id)
    // {
    //     $user = User::findOrFail($id);
    //     return view('admin.accounts.edit', compact('user'));
    // }

    /**
     * Update the specified account in the database.
     */
    // public function updateAccount(Request $request, $id)
    // {
    //     $user = User::findOrFail($id);

    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:50',
    //         'email' => 'required|email|unique:users,email,' . $id,
    //     ]);

    //     $user->update($validatedData);

    //     return redirect()->route('admin.accounts.index')->with('success', 'Account Updated Successfully!');
    // }

    /**
     * Remove the specified account from the database.
     */
    public function deleteAccount($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.accounts.index')->with('success', 'Account Deleted Successfully!');
    }

    // ✅ Download Import Template
    public function downloadTemplate()
    {
        return Excel::download(new StudentsTemplateExport, 'students_template.xlsx');
    }

    // ✅ Export All Students
    public function exportStudents()
    {
        return Excel::download(new StudentsExport, 'students.xlsx');
    }

    // ✅ Import Students from Uploaded File
    public function importStudents(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new StudentsImport, $request->file('file'));

        return back()->with('success', 'Students Imported Successfully!');
    }
}
