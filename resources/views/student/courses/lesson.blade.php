@extends('student.layout')
@section('title', $lesson->title)
@section('page_heading', $lesson->title)

@section('content')
<nav class="student-course-breadcrumb mb-3" aria-label="Breadcrumb">
    <a href="{{ route('student.courses.show', $course) }}">{{ $course->title }}</a>
    <span aria-hidden="true">/</span>
    <span>{{ $lesson->title }}</span>
</nav>

<section class="student-dash-welcome mb-4" aria-labelledby="lesson-heading">
    <div class="student-dash-welcome__inner">
        <div class="student-dash-welcome__copy">
            <p class="student-dash-welcome__eyebrow mb-2">Lesson</p>
            <h2 id="lesson-heading" class="student-dash-welcome__title">{{ $lesson->title }}</h2>
        </div>
        <div class="student-dash-welcome__actions d-none d-md-flex">
            <a href="{{ route('student.courses.show', $course) }}" class="btn btn-light btn-sm student-dash-btn-ghost">
                <i class="bi bi-arrow-left" aria-hidden="true"></i> Back to course
            </a>
        </div>
    </div>
</section>

<div class="row g-4">
    <div class="col-lg-8">
        @if($lesson->video)
            <div class="student-dash-panel mb-4">
                <div class="student-dash-panel__head">
                    <h3 class="student-dash-panel__title mb-0"><i class="bi bi-play-btn" aria-hidden="true"></i> Video lesson</h3>
                </div>
                <div class="student-dash-panel__body student-lesson-media">
                    @if($lesson->isVideoUrl() && str_contains($lesson->videoEmbedUrl(), 'youtube.com/embed'))
                        <div class="student-lesson-video">
                            <iframe src="{{ $lesson->videoEmbedUrl() }}" title="Video: {{ $lesson->title }}" allowfullscreen loading="lazy"></iframe>
                        </div>
                    @else
                        <video class="student-lesson-video-file" controls preload="metadata" src="{{ $lesson->videoEmbedUrl() }}">
                            Your browser does not support video playback.
                        </video>
                    @endif
                </div>
            </div>
        @endif

        @if($lesson->pdfUrl())
            <div class="student-dash-panel mb-4">
                <div class="student-dash-panel__head">
                    <h3 class="student-dash-panel__title mb-0"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i> Reading material</h3>
                </div>
                <div class="student-dash-panel__body">
                    <p class="mb-3">Download or open the PDF notes for this lesson.</p>
                    <a href="{{ $lesson->pdfUrl() }}" class="btn btn-lms-primary" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-download" aria-hidden="true"></i> Open PDF notes
                    </a>
                </div>
            </div>
        @endif

        @if(! $lesson->video && ! $lesson->pdf_notes)
            <div class="student-dash-panel student-dash-panel--empty">
                <i class="bi bi-journal-x student-dash-panel__empty-icon" aria-hidden="true"></i>
                <p class="student-dash-panel__empty-text mb-0">No content uploaded for this lesson yet.</p>
            </div>
        @endif
    </div>

    <div class="col-lg-4">
        @if($lesson->quizzes->isNotEmpty())
            <div class="student-dash-panel">
                <div class="student-dash-panel__head">
                    <h3 class="student-dash-panel__title mb-0"><i class="bi bi-patch-question" aria-hidden="true"></i> Related quizzes</h3>
                </div>
                <div class="student-dash-panel__body">
                    <ul class="list-unstyled mb-0">
                        @foreach($lesson->quizzes as $quiz)
                            <li class="mb-2">
                                <a href="{{ route('student.courses.quizzes.show', [$course, $quiz]) }}" class="student-course-list__item student-course-list__item--compact">
                                    <span class="student-course-list__title">{{ $quiz->title }}</span>
                                    <span class="student-course-list__arrow"><i class="bi bi-chevron-right"></i></span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
