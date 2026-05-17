@extends('admin.layout')
@section('title', 'Students')
@section('page_heading', 'Students')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.students.index') }}" class="row g-2 mb-4">
            <div class="col-md-8">
                <input type="text" name="q" class="form-control" placeholder="Search by name or email..." value="{{ request('q') }}">
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->created_at->format('M j, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-outline-primary">View</a>
                            <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-muted text-center py-4">No students found.</td>
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
