<?php

namespace App\Http\Controllers;

use App\Models\Academic;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentKioskController extends Controller
{
    /**
     * Display the Idle (First) Page.
     */
    public function idle()
    {
        return view('kiosk.idle');
    }

    /**
     * Display the Student Search Page.
     */
    // public function index()
    // {
    //     return view('kiosk.index');
    // }

    /**
     * Display Home Page.
     */
    public function home()
    {
        $yearLevels = Academic::select('year_level')->distinct()->pluck('year_level');
        $studentTypes = Student::select('student_type')->distinct()->pluck('student_type');
        $programs = Academic::select('program')->distinct()->pluck('program');

        return view('kiosk.home', compact('yearLevels', 'studentTypes', 'programs'));
    }


    /**
     * Display Guidelines.
     */
    // public function guidelines()
    // {
    //     return view('kiosk.guidelines');
    // }

    /**
     * Search for students
     */
    //temporrary solution for filtering, could use a more efficeinet sorting algorith later on 
    public function search(Request $request)
    {
        $query = Student::with(['contact', 'academics', 'skills', 'achievements']);

        // 🔍 Apply search across ALL fields
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');

            $query->where(function ($q) use ($searchTerm) {
                // Main Student fields
                $q->where('student_id', 'like', "%$searchTerm%")
                    ->orWhere('first_name', 'like', "%$searchTerm%")
                    ->orWhere('middle_name', 'like', "%$searchTerm%")
                    ->orWhere('last_name', 'like', "%$searchTerm%")
                    ->orWhere('suffix', 'like', "%$searchTerm%")
                    ->orWhere('birth_date', 'like', "%$searchTerm%")
                    ->orWhere('gender', 'like', "%$searchTerm%")
                    ->orWhere('nationality', 'like', "%$searchTerm%")
                    ->orWhere('religion', 'like', "%$searchTerm%")
                    ->orWhere('blood_type', 'like', "%$searchTerm%")
                    ->orWhere('student_type', 'like', "%$searchTerm%");

                // Related Models
                $q->orWhereHas('academics', function ($subQ) use ($searchTerm) {
                    $subQ->where('student_number', 'like', "%$searchTerm%")
                        ->orWhere('enrollment_status', 'like', "%$searchTerm%")
                        ->orWhere('year_level', 'like', "%$searchTerm%")
                        ->orWhere('college', 'like', "%$searchTerm%")
                        ->orWhere('program', 'like', "%$searchTerm%")
                        ->orWhere('section', 'like', "%$searchTerm%");
                });

                $q->orWhereHas('contact', function ($subQ) use ($searchTerm) {
                    $subQ->where('email', 'like', "%$searchTerm%")
                        ->orWhere('phone_number', 'like', "%$searchTerm%")
                        ->orWhere('address', 'like', "%$searchTerm%")
                        ->orWhere('guardian_name', 'like', "%$searchTerm%")
                        ->orWhere('guardian_contact', 'like', "%$searchTerm%")
                        ->orWhere('emergency_contact', 'like', "%$searchTerm%");
                });

                $q->orWhereHas('skills', function ($subQ) use ($searchTerm) {
                    $subQ->where('skill_name', 'like', "%$searchTerm%")
                        ->orWhere('proficiency_level', 'like', "%$searchTerm%");
                });

                $q->orWhereHas('achievements', function ($subQ) use ($searchTerm) {
                    $subQ->where('achievement_name', 'like', "%$searchTerm%")
                        ->orWhere('category', 'like', "%$searchTerm%")
                        ->orWhere('awarding_body', 'like', "%$searchTerm%");
                });
            });
        }

        // 🔍 Apply Filters (strict AND)
        if ($request->filled('year_level')) {
            $query->whereHas('academics', function ($q) use ($request) {
                $q->where('year_level', $request->year_level);
            });
        }

        if ($request->filled('student_type')) {
            $query->where('student_type', $request->student_type);
        }

        if ($request->filled('program')) {
            $query->whereHas('academics', function ($q) use ($request) {
                $q->where('program', $request->program);
            });
        }

        $students = $query->paginate(10)->appends($request->query());

        return view('kiosk.search-results', compact('students'));
    }
}
