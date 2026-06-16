@php
    $profile = $profile ?? null;
    $student = $student ?? null;
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label for="attendance_percentage" class="form-label">Attendance Rate (%)</label>
        <input type="number" step="0.01" min="0" max="100" class="form-control @error('attendance_percentage') is-invalid @enderror" id="attendance_percentage" name="attendance_percentage" value="{{ old('attendance_percentage', $student->attendance_percentage) }}">
        @error('attendance_percentage')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-md-6">
        <label for="progress_score" class="form-label">Progress Score (%)</label>
        <input type="number" step="0.01" min="0" max="100" class="form-control @error('progress_score') is-invalid @enderror" id="progress_score" name="progress_score" value="{{ old('progress_score', optional($profile)->progress_score) }}">
        @error('progress_score')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-md-6">
        <label for="total_sessions_booked" class="form-label">Total Sessions Booked</label>
        <input type="number" min="0" class="form-control @error('total_sessions_booked') is-invalid @enderror" id="total_sessions_booked" name="total_sessions_booked" value="{{ old('total_sessions_booked', optional($profile)->total_sessions_booked ?? 0) }}">
        @error('total_sessions_booked')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-md-6">
        <label for="total_sessions_attended" class="form-label">Total Sessions Attended</label>
        <input type="number" min="0" class="form-control @error('total_sessions_attended') is-invalid @enderror" id="total_sessions_attended" name="total_sessions_attended" value="{{ old('total_sessions_attended', optional($profile)->total_sessions_attended ?? 0) }}">
        @error('total_sessions_attended')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-md-6">
        <label for="last_session_date" class="form-label">Last Session Date</label>
        <input type="date" class="form-control @error('last_session_date') is-invalid @enderror" id="last_session_date" name="last_session_date" value="{{ old('last_session_date', optional(optional($profile)->last_session_date)->format('Y-m-d')) }}">
        @error('last_session_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-md-6">
        <label for="next_session_date" class="form-label">Next Session Date</label>
        <input type="date" class="form-control @error('next_session_date') is-invalid @enderror" id="next_session_date" name="next_session_date" value="{{ old('next_session_date', optional(optional($profile)->next_session_date)->format('Y-m-d')) }}">
        @error('next_session_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-md-6">
        <label for="homework_completion_rate" class="form-label">Homework Completion Rate (%)</label>
        <input type="number" step="0.01" min="0" max="100" class="form-control @error('homework_completion_rate') is-invalid @enderror" id="homework_completion_rate" name="homework_completion_rate" value="{{ old('homework_completion_rate', optional($profile)->homework_completion_rate) }}">
        @error('homework_completion_rate')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-md-6">
        <label for="assessment_average" class="form-label">Assessment Average (%)</label>
        <input type="number" step="0.01" min="0" max="100" class="form-control @error('assessment_average') is-invalid @enderror" id="assessment_average" name="assessment_average" value="{{ old('assessment_average', optional($profile)->assessment_average) }}">
        @error('assessment_average')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
</div>
