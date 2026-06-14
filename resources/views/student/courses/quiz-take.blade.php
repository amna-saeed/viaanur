@extends('student.layout')
@section('title', 'Taking: ' . $quiz->title)
@section('page_heading', 'Quiz in progress')

@section('content')
<nav class="student-course-breadcrumb mb-3" aria-label="Breadcrumb">
    <a href="{{ route('student.courses.show', $course) }}">{{ $course->title }}</a>
    <span aria-hidden="true">/</span>
    <a href="{{ route('student.courses.quizzes.show', [$course, $quiz]) }}">{{ $quiz->title }}</a>
    <span aria-hidden="true">/</span>
    <span>Attempt</span>
</nav>

@if($quiz->duration_minutes)
    <div class="student-quiz-time-announcement student-quiz-time-announcement--info mb-4" id="quiz-time-announcement" role="status" aria-live="polite" data-duration="{{ $quiz->duration_minutes }}" data-started="{{ $attempt->started_at->timestamp }}">
        <div class="student-quiz-time-announcement__inner">
            <span class="student-quiz-time-announcement__icon" aria-hidden="true"><i class="bi bi-alarm"></i></span>
            <div class="student-quiz-time-announcement__copy">
                <strong class="student-quiz-time-announcement__title" id="quiz-announcement-title">Quiz timer active</strong>
                <p class="student-quiz-time-announcement__text mb-0" id="quiz-announcement-text">Loading remaining time…</p>
            </div>
            <span class="student-quiz-time-announcement__clock" id="quiz-announcement-clock">--:--</span>
            <button type="button" class="btn-close student-quiz-time-announcement__close d-none" id="quiz-announcement-close" aria-label="Dismiss"></button>
        </div>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger student-lms-alert mb-4" role="alert">
        <strong>Please fix the following:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="student-dash-panel mb-4 student-quiz-attempt-panel">
    <div class="student-dash-panel__head d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h2 class="student-dash-panel__title mb-0">{{ $quiz->title }}</h2>
            <p class="small text-muted mb-0 mt-1">Answer all {{ $quiz->questions->count() }} questions, then submit.</p>
        </div>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            @if($quiz->duration_minutes)
                <span class="student-quiz-timer badge rounded-pill student-dash-badge" id="quiz-timer" data-duration="{{ $quiz->duration_minutes }}" data-started="{{ $attempt->started_at->timestamp }}">
                    <i class="bi bi-clock" aria-hidden="true"></i> <span id="quiz-timer-text">--:--</span>
                </span>
            @endif
            <span class="text-muted small">Started {{ $attempt->started_at->format('g:i A') }}</span>
        </div>
    </div>
    <div class="student-dash-panel__body">
        @if($quiz->questions->isEmpty())
            <div class="alert alert-warning mb-0">No questions available. <a href="{{ route('student.courses.quizzes.show', [$course, $quiz]) }}">Go back</a>.</div>
        @else
            <form action="{{ route('student.courses.quizzes.submit', [$course, $quiz, $attempt]) }}" method="POST" id="quiz-form" novalidate>
                @csrf
                <input type="hidden" name="auto_submit" value="1" id="auto-submit-flag" disabled>
                @foreach($quiz->questions as $index => $question)
                    @php $oldAnswer = old('answers.'.$question->id); @endphp
                    <fieldset class="student-quiz-question mb-4 pb-4 {{ ! $loop->last ? 'border-bottom' : '' }}" id="question-{{ $question->id }}">
                        <legend class="student-quiz-question__title">
                            <span class="student-quiz-question__num">{{ $index + 1 }}</span>
                            {{ $question->question_text }}
                            <span class="badge student-dash-badge student-dash-badge--muted ms-1">{{ $question->marks }} mark{{ $question->marks > 1 ? 's' : '' }}</span>
                        </legend>
                        @error('answers.'.$question->id)
                            <div class="text-danger small mb-2">{{ $message }}</div>
                        @enderror
                        <div class="student-quiz-options">
                            @foreach($question->options() as $key => $label)
                                <label class="student-quiz-option">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}" {{ $oldAnswer === $key ? 'checked' : '' }} @if(! $quiz->duration_minutes) required @endif>
                                    <span class="student-quiz-option__key">{{ strtoupper($key) }}</span>
                                    <span class="student-quiz-option__text">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>
                @endforeach

                <div class="student-quiz-submit-bar d-flex flex-wrap gap-2 align-items-center">
                    <button type="submit" class="btn btn-lms-primary btn-lg" id="quiz-submit-btn">
                        <i class="bi bi-send" aria-hidden="true"></i> Submit quiz
                    </button>
                    <a href="{{ route('student.courses.quizzes.show', [$course, $quiz]) }}" class="btn btn-outline-secondary">Save &amp; exit</a>
                    <span class="small text-muted ms-auto">Passing score: {{ $quiz->passing_marks }} marks</span>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    var formEl = document.getElementById('quiz-form');
    var submitBtn = document.getElementById('quiz-submit-btn');
    var autoFlag = document.getElementById('auto-submit-flag');
    var announcementEl = document.getElementById('quiz-time-announcement');
    var announcementTitle = document.getElementById('quiz-announcement-title');
    var announcementText = document.getElementById('quiz-announcement-text');
    var announcementClock = document.getElementById('quiz-announcement-clock');
    var timerEl = document.getElementById('quiz-timer');
    var textEl = document.getElementById('quiz-timer-text');
    var timedQuiz = !!(announcementEl && timerEl && textEl && formEl);
    var expired = false;

    function pad(n) { return n < 10 ? '0' + n : String(n); }

    function formatRemaining(ms) {
        var mins = Math.floor(ms / 60000);
        var secs = Math.floor((ms % 60000) / 1000);
        return pad(mins) + ':' + pad(secs);
    }

    function setAnnouncementState(state, remainingMs) {
        if (!announcementEl) return;
        announcementEl.classList.remove(
            'student-quiz-time-announcement--info',
            'student-quiz-time-announcement--warn',
            'student-quiz-time-announcement--urgent'
        );
        announcementEl.classList.add('student-quiz-time-announcement--' + state);
        var clock = formatRemaining(remainingMs);
        if (announcementClock) announcementClock.textContent = clock;
        if (textEl) textEl.textContent = clock;

        if (state === 'urgent') {
            if (announcementTitle) announcementTitle.textContent = 'Hurry! Time almost up';
            if (announcementText) announcementText.textContent = 'Less than 1 minute left. Submit now or your quiz will auto-submit.';
            if (timerEl) timerEl.classList.add('student-quiz-timer--urgent');
        } else if (state === 'warn') {
            if (announcementTitle) announcementTitle.textContent = 'Time running out';
            if (announcementText) announcementText.textContent = 'Only ' + clock + ' remaining. Please finish and submit your answers.';
            if (timerEl) timerEl.classList.add('student-quiz-timer--urgent');
        } else {
            if (announcementTitle) announcementTitle.textContent = 'Quiz timer active';
            if (announcementText) announcementText.textContent = 'You have ' + clock + ' to complete this quiz.';
        }
    }

    function closeAnnouncement() {
        if (!announcementEl || announcementEl.classList.contains('student-quiz-time-announcement--closed')) return;
        announcementEl.classList.add('student-quiz-time-announcement--closed');
        window.setTimeout(function () {
            announcementEl.style.display = 'none';
        }, 350);
    }

    function autoSubmitQuiz() {
        if (expired || !formEl) return;
        expired = true;
        closeAnnouncement();
        if (autoFlag) autoFlag.disabled = false;
        formEl.querySelectorAll('input[type="radio"][required]').forEach(function (radio) {
            radio.removeAttribute('required');
        });
        formEl.dataset.autoSubmitting = '1';
        if (submitBtn) submitBtn.disabled = true;
        window.setTimeout(function () {
            formEl.submit();
        }, 380);
    }

    if (formEl && submitBtn) {
        formEl.addEventListener('submit', function (e) {
            if (formEl.dataset.autoSubmitting === '1') {
                return;
            }
            if (!formEl.checkValidity()) {
                e.preventDefault();
                formEl.reportValidity();
                return;
            }
            if (!confirm('Submit your quiz? You cannot change answers after submitting.')) {
                e.preventDefault();
            }
        });
    }

    if (!timedQuiz) return;

    var durationMs = parseInt(announcementEl.dataset.duration, 10) * 60 * 1000;
    var startedMs = parseInt(announcementEl.dataset.started, 10) * 1000;
    var endMs = startedMs + durationMs;

    function tick() {
        if (expired) return;
        var remaining = endMs - Date.now();
        if (remaining <= 0) {
            if (announcementTitle) announcementTitle.textContent = 'Time is up';
            if (announcementText) announcementText.textContent = 'Submitting your quiz automatically…';
            if (announcementClock) announcementClock.textContent = '00:00';
            autoSubmitQuiz();
            return;
        }

        if (remaining <= 60000) {
            setAnnouncementState('urgent', remaining);
        } else if (remaining <= 300000) {
            setAnnouncementState('warn', remaining);
        } else {
            setAnnouncementState('info', remaining);
        }

        window.setTimeout(tick, 1000);
    }

    tick();
})();
</script>
@endpush
