@extends('admin.layout')
@section('title', 'Edit Teacher - ' . $teacher->name)
@section('page_heading', 'Edit Teacher')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom p-4">
        <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit: {{ $teacher->name }}</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.teachers.update', $teacher) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <label for="name" class="form-label">Full Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ old('name', $teacher->name) }}">
                    @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email Address *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email', $teacher->email) }}">
                    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $teacher->phone) }}">
                    @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6">
                    <label for="qualification" class="form-label">Qualification</label>
                    <input type="text" class="form-control @error('qualification') is-invalid @enderror" id="qualification" name="qualification" placeholder="e.g., M.Sc, Ph.D" value="{{ old('qualification', $teacher->qualification) }}">
                    @error('qualification')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="department" class="form-label">Department</label>
                    <input type="text" class="form-control @error('department') is-invalid @enderror" id="department" name="department" placeholder="e.g., Computer Science" value="{{ old('department', $teacher->department) }}">
                    @error('department')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6">
                    <label for="status" class="form-label">Status *</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="active" {{ old('status', $teacher->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $teacher->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4" placeholder="Tell us about this teacher...">{{ old('bio', $teacher->bio) }}</textarea>
                    @error('bio')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-circle me-2"></i>Update Teacher
                </button>
                <a href="{{ route('admin.teachers.show', $teacher) }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
