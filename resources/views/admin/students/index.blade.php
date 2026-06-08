@extends('admin.layout')
@section('title', 'Students')
@section('page_heading', 'Students')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">All Students</h5>
    <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Student
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.students.index') }}" class="row g-2 mb-4">
            <div class="col-md-8">
                <input type="text" name="q" class="form-control" placeholder="Search by name, email, or student ID..." value="{{ request('q') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary me-2">Search</button>
                <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">Clear</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Guardian</th>
                        <th>Joined</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr>
                        <td>
                            @if($student->studentProfile)
                                <span class="badge bg-light text-dark">{{ $student->studentProfile->student_id_number }}</span>
                            @else
                                <span class="text-muted">Not completed</span>
                            @endif
                        </td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>
                            @if($student->studentProfile)
                                {{ $student->studentProfile->guardian_name }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $student->created_at->format('M j, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-outline-primary">View</a>
                            <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-muted text-center py-4">No students found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
