<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Contact;
use App\Models\Academic;
use App\Models\Skill;
use App\Models\Achievement;
use App\Models\User;

class AdminController extends Controller
{
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

    public function createStudent()
    {
        return view('admin.students.create');
    }

    public function storeStudent(Request $request)
    {
        Student::create($request->all());
        return redirect()->route('admin.students.index')->with('success', 'Student Added!');
    }

    public function showStudent($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.show', compact('student'));
    }

    public function editStudent($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    public function updateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->update($request->all());
        return redirect()->route('admin.students.index')->with('success', 'Student Updated Successfully!');
    }

    public function deleteStudent($id)
    {
        Student::destroy($id);
        return redirect()->route('admin.students.index')->with('success', 'Student Deleted!');
    }

    // ===========================
    // ✅ ACCOUNT MANAGEMENT
    // ===========================

    public function accountsIndex()
    {
        $users = User::paginate(10);
        return view('admin.accounts.index', compact('users'));
    }

    public function createAccount()
    {
        return view('admin.accounts.create');
    }

    public function storeAccount(Request $request)
    {
        User::create($request->all());
        return redirect()->route('admin.accounts.index')->with('success', 'Account Added!');
    }

    public function showAccount($id)
    {
        $user = User::findOrFail($id);
        return view('admin.accounts.show', compact('user'));
    }

    public function editAccount($id)
    {
        $user = User::findOrFail($id);
        return view('admin.accounts.edit', compact('user'));
    }

    public function updateAccount(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('admin.accounts.index')->with('success', 'Account Updated!');
    }

    public function deleteAccount($id)
    {
        User::destroy($id);
        return redirect()->route('admin.accounts.index')->with('success', 'Account Deleted!');
    }
}
