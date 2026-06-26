@php
    $profile = $profile ?? null;
    $genderOptions = $genderOptions ?? \App\Support\StudentInformation::GENDER_OPTIONS;
    $conditional = $conditional ?? false;
    $dateOfBirth = optional($profile)->date_of_birth;
    $dateOfBirthValue = old('date_of_birth', $dateOfBirth ? $dateOfBirth->format('Y-m-d') : '');
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label for="student_id_number" class="form-label">Passport Number <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('student_id_number') is-invalid @enderror" id="student_id_number" name="student_id_number" value="{{ old('student_id_number', optional($profile)->student_id_number) }}" placeholder="Enter passport number" minlength="6" maxlength="20" title="Enter your passport number" @if($conditional) data-student-required="true" @else required @endif>
        <small class="text-muted">6–20 characters, letters and numbers only.</small>
        @error('student_id_number')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-md-6">
        <label for="date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ $dateOfBirthValue }}" @if($conditional) data-student-required="true" @else required @endif>
        @error('date_of_birth')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-md-6">
        <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" @if($conditional) data-student-required="true" @else required @endif>
            <option value="">Select gender</option>
            @foreach($genderOptions as $value => $label)
                <option value="{{ $value }}" {{ old('gender', optional($profile)->gender) === $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        @error('gender')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-md-6">
        <label for="school_name" class="form-label">School Name <span class="text-muted">(if applicable)</span></label>
        <input type="text" class="form-control @error('school_name') is-invalid @enderror" id="school_name" name="school_name" value="{{ old('school_name', optional($profile)->school_name) }}">
        @error('school_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-12">
        <label for="home_address" class="form-label">Home Address <span class="text-danger">*</span></label>
        <textarea class="form-control @error('home_address') is-invalid @enderror" id="home_address" name="home_address" rows="3" @if($conditional) data-student-required="true" @else required @endif>{{ old('home_address', optional($profile)->home_address) }}</textarea>
        @error('home_address')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-md-6">
        <label for="guardian_name" class="form-label">Parent/Guardian Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('guardian_name') is-invalid @enderror" id="guardian_name" name="guardian_name" value="{{ old('guardian_name', optional($profile)->guardian_name) }}" @if($conditional) data-student-required="true" @else required @endif>
        @error('guardian_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-md-6">
        <label for="guardian_contact_number" class="form-label">Parent/Guardian Contact Number <span class="text-danger">*</span></label>
        <input type="tel" class="form-control @error('guardian_contact_number') is-invalid @enderror" id="guardian_contact_number" name="guardian_contact_number" value="{{ old('guardian_contact_number', optional($profile)->guardian_contact_number) }}" @if($conditional) data-student-required="true" @else required @endif>
        @error('guardian_contact_number')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-md-6">
        <label for="emergency_contact_number" class="form-label">Emergency Contact Number <span class="text-muted">(if different)</span></label>
        <input type="tel" class="form-control @error('emergency_contact_number') is-invalid @enderror" id="emergency_contact_number" name="emergency_contact_number" value="{{ old('emergency_contact_number', optional($profile)->emergency_contact_number) }}">
        @error('emergency_contact_number')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
</div>
