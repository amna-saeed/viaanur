<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Services\TeacherScopeService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherSubjectController extends Controller
{
    public function index(Request $request, TeacherScopeService $scope): View
    {
        $query = $scope->subjectsQuery()->orderBy('name');

        if ($request->filled('q')) {
            $term = $request->q;
            $query->where(function ($qry) use ($term) {
                $qry->where('name', 'like', "%{$term}%")
                    ->orWhere('code', 'like', "%{$term}%");
            });
        }

        $subjects = $query->paginate(12)->withQueryString();
        $teacher = $scope->currentTeacher();

        return view('teacher.subjects.index', compact('subjects', 'teacher'));
    }
}
