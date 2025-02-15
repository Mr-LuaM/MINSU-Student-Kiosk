<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Contact;
use App\Models\Academic;
use App\Models\Skill;
use App\Models\Achievement;
use App\Models\User;
use Usernotnull\Toast\Concerns\WireToast;

class AdminController extends Controller
{
    use WireToast; // <-- add this

    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        return view('admin.dashboard');
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
        $validatedData = $request->validate([
            'student_id' => 'required|string|unique:students,student_id|max:20',
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

        Student::create($validatedData);

        return redirect()->route('admin.students.index')->with('success', 'Student Added Successfully!');
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
        $student = Student::with(['academics', 'contact'])->findOrFail($id);

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

        // Update Student Core Data
        $student->update($validatedStudentData);

        // Update Academics if exists
        if ($student->academics) {
            $student->academics->update($validatedAcademicData);
        } else {
            $student->academics()->create($validatedAcademicData);
        }

        // Update Contact if exists
        if ($student->contact) {
            $student->contact->update($validatedContactData);
        } else {
            $student->contact()->create($validatedContactData);
        }

        toast()
            ->success('Student updated successfully!')
            ->pushOnNextPage();

        return redirect()->route('admin.students.index');
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
        ]);

        return redirect()->route('admin.accounts.index')->with('success', 'Account Added Successfully!');
    }

    /**
     * Display the specified user account.
     */
    public function showAccount($id)
    {
        $user = User::findOrFail($id);
        return view('admin.accounts.show', compact('user'));
    }

    /**
     * Show the form for editing the specified account.
     */
    public function editAccount($id)
    {
        $user = User::findOrFail($id);
        return view('admin.accounts.edit', compact('user'));
    }

    /**
     * Update the specified account in the database.
     */
    public function updateAccount(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user->update($validatedData);

        return redirect()->route('admin.accounts.index')->with('success', 'Account Updated Successfully!');
    }

    /**
     * Remove the specified account from the database.
     */
    public function deleteAccount($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.accounts.index')->with('success', 'Account Deleted Successfully!');
    }
}
