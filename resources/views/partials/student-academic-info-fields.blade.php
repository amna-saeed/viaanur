@php
    $profile = $profile ?? null;
@endphp

<div class="row g-3">
    <div class="col-12">
        <label for="subjects_enrolled" class="form-label">Subject(s) Enrolled</label>
        <textarea class="form-control @error('subjects_enrolled') is-invalid @enderror" id="subjects_enrolled" name="subjects_enrolled" rows="2" placeholder="e.g. Mathematics, English, Science">{{ old('subjects_enrolled', optional($profile)->subjects_enrolled) }}</textarea>
        @error('subjects_enrolled')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-md-6">
        <label for="academic_level" class="form-label">Academic Level</label>
        <input type="text" class="form-control @error('academic_level') is-invalid @enderror" id="academic_level" name="academic_level" value="{{ old('academic_level', optional($profile)->academic_level) }}">
        @error('academic_level')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-md-6">
        <label for="current_working_grade" class="form-label">Current Working Grade</label>
        <input type="text" class="form-control @error('current_working_grade') is-invalid @enderror" id="current_working_grade" name="current_working_grade" value="{{ old('current_working_grade', optional($profile)->current_working_grade) }}">
        @error('current_working_grade')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-md-6">
        <label for="target_grade" class="form-label">Target Grade</label>
        <input type="text" class="form-control @error('target_grade') is-invalid @enderror" id="target_grade" name="target_grade" value="{{ old('target_grade', optional($profile)->target_grade) }}">
        @error('target_grade')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-12">
        <label for="learning_goals" class="form-label">Learning Goals</label>
        <textarea class="form-control @error('learning_goals') is-invalid @enderror" id="learning_goals" name="learning_goals" rows="3">{{ old('learning_goals', optional($profile)->learning_goals) }}</textarea>
        @error('learning_goals')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-12">
        <label for="areas_for_improvement" class="form-label">Areas for Improvement</label>
        <textarea class="form-control @error('areas_for_improvement') is-invalid @enderror" id="areas_for_improvement" name="areas_for_improvement" rows="3">{{ old('areas_for_improvement', optional($profile)->areas_for_improvement) }}</textarea>
        @error('areas_for_improvement')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-12">
        <label for="send_learning_needs" class="form-label">SEND / Learning Needs</label>
        <textarea class="form-control @error('send_learning_needs') is-invalid @enderror" id="send_learning_needs" name="send_learning_needs" rows="3">{{ old('send_learning_needs', optional($profile)->send_learning_needs) }}</textarea>
        @error('send_learning_needs')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-12">
        <label for="eal_notes" class="form-label">English as an Additional Language (if applicable)</label>
        <textarea class="form-control @error('eal_notes') is-invalid @enderror" id="eal_notes" name="eal_notes" rows="3">{{ old('eal_notes', optional($profile)->eal_notes) }}</textarea>
        @error('eal_notes')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
</div>
