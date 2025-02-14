<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Contact;
use App\Models\Academic;
use App\Models\Skill;
use App\Models\Achievement;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function index(Request $request)
    {
        $students = Student::all();
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        Student::create($request->all());
        return redirect()->route('admin.dashboard')->with('success', 'Record Added!');
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.show', compact('student'));
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->update($request->all());
        return redirect()->route('admin.dashboard')->with('success', 'Updated Successfully!');
    }

    public function destroy($id)
    {
        Student::destroy($id);
        return redirect()->route('admin.dashboard')->with('success', 'Deleted Successfully!');
    }
}
