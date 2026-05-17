<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminStudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', User::ROLE_STUDENT)->orderBy('name');
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qry) use ($q) {
                $qry->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
            });
        }
        $students = $query->paginate(15)->withQueryString();
        return view('admin.students.index', compact('students'));
    }

    public function show(User $student)
    {
        if ($student->role !== User::ROLE_STUDENT) {
            abort(404);
        }
        return view('admin.students.show', compact('student'));
    }

    public function edit(User $student)
    {
        if ($student->role !== User::ROLE_STUDENT) {
            abort(404);
        }
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, User $student)
    {
        if ($student->role !== User::ROLE_STUDENT) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $student->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'phone']);
        
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $student->update($data);

        return redirect()->route('admin.students.show', $student)->with('success', 'Student information updated successfully.');
    }
}
