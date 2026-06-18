@extends('admin.layout')
@section('title', 'Teachers')
@section('page_heading', 'Teachers Management')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">All Teachers</h5>
    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Teacher
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.teachers.index') }}" class="row g-2 mb-4">
            <div class="col-md-8">
                <input type="text" name="q" class="form-control" placeholder="Search by name, email, or department..." value="{{ request('q') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary me-2 w-auto">
                    <i class="bi bi-search"></i> Search
                </button>
                <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-secondary">Clear</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th><i class="bi bi-person me-2"></i>Name</th>
                        <th><i class="bi bi-envelope me-2"></i>Email</th>
                        <th><i class="bi bi-briefcase me-2"></i>Department</th>
                        <th><i class="bi bi-mortarboard me-2"></i>Subjects</th>
                        <th><i class="bi bi-check-circle me-2"></i>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $teacher)
                    <tr>
                        <td>
                            <strong>{{ $teacher->name }}</strong>
                        </td>
                        <td>{{ $teacher->email }}</td>
                        <td>
                            @if($teacher->department)
                                <span class="badge bg-light text-dark">{{ $teacher->department }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $teacher->subjects->count() }}</span>
                        </td>
                        <td>
                            @if($teacher->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.teachers.show', $teacher) }}" class="btn btn-sm btn-outline-primary">View</a>
                            <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No teachers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($teachers->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $teachers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
