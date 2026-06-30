@extends('student.layout')
@section('title', $lesson->title)
@section('page_heading', 'Lesson details')

@section('content')
@php
    $hasVideo = (bool) $lesson->video;
    $hasPdf = (bool) $lesson->pdfUrl();
@endphp

<nav class="student-course-breadcrumb mb-3" aria-label="Breadcrumb">
    <a href="{{ student_course_route('student.courses.show', $course) }}">{{ $course->title }}</a>
    <span aria-hidden="true">/</span>
    <span aria-current="page">{{ $lesson->title }}</span>
</nav>

<a href="{{ student_course_route('student.courses.show', $course) }}" class="student-course-back d-lg-none mb-3">
    <i class="bi bi-arrow-left" aria-hidden="true"></i> Back to course
</a>

<section class="student-course-hero-card" aria-labelledby="lesson-heading">
    <div class="student-course-hero-card__content">
        <p class="student-course-hero-card__eyebrow">Lesson {{ $lesson->order }}</p>
        <h2 id="lesson-heading" class="student-course-hero-card__title">{{ $lesson->title }}</h2>
        <p class="student-course-hero-card__desc mb-0">
            Part of <strong>{{ $course->title }}</strong>
        </p>

        @if($hasVideo || $hasPdf)
            <ul class="student-course-hero-card__stats list-unstyled mb-0">
                @if($hasVideo)
                    <li>
                        <i class="bi bi-camera-video" aria-hidden="true"></i>
                        <span>Video lesson</span>
                    </li>
                @endif
                @if($hasPdf)
                    <li>
                        <i class="bi bi-file-earmark-pdf" aria-hidden="true"></i>
                        <span>PDF notes</span>
                    </li>
                @endif
            </ul>
        @endif

        <a href="{{ student_course_route('student.courses.show', $course) }}" class="btn btn-light btn-sm student-course-hero-card__back d-none d-lg-inline-flex">
            <i class="bi bi-arrow-left" aria-hidden="true"></i> Back to course
        </a>
    </div>
</section>

<div class="student-lesson-layout row g-4 g-xl-5">
    <div class="col-lg-8">
        @if($hasVideo)
            <section class="student-lesson-panel student-lesson-panel--video" aria-labelledby="video-heading">
                <header class="student-lesson-panel__head">
                    <span class="student-lesson-panel__icon student-lesson-panel__icon--video" aria-hidden="true">
                        <i class="bi bi-play-fill"></i>
                    </span>
                    <div>
                        <h3 id="video-heading" class="student-lesson-panel__title">Video lesson</h3>
                        <p class="student-lesson-panel__sub mb-0">Watch the lesson below. You can pause and replay anytime.</p>
                    </div>
                </header>
                <div class="student-lesson-panel__body student-lesson-panel__body--media">
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
            </section>
        @endif

        @if($hasPdf)
            <section class="student-lesson-panel student-lesson-panel--pdf {{ $hasVideo ? 'mt-4' : '' }}" aria-labelledby="pdf-heading">
                <div class="student-lesson-pdf">
                    <span class="student-lesson-panel__icon student-lesson-panel__icon--pdf" aria-hidden="true">
                        <i class="bi bi-file-earmark-pdf"></i>
                    </span>
                    <div class="student-lesson-pdf__copy">
                        <h3 id="pdf-heading" class="student-lesson-panel__title mb-1">Reading material</h3>
                        <p class="student-lesson-panel__sub mb-0">Download or open the PDF notes for this lesson.</p>
                    </div>
                    <a href="{{ $lesson->pdfUrl() }}" class="btn btn-lms-primary student-lesson-pdf__btn" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                        <span>Open PDF</span>
                    </a>
                </div>
            </section>
        @endif

        @if(! $hasVideo && ! $hasPdf)
            <div class="student-dash-panel student-dash-panel--empty">
                <i class="bi bi-journal-x student-dash-panel__empty-icon" aria-hidden="true"></i>
                <p class="student-dash-panel__empty-title">No content yet</p>
                <p class="student-dash-panel__empty-text mb-0">Your instructor has not uploaded material for this lesson.</p>
            </div>
        @endif
    </div>

    <div class="col-lg-4">
        <aside class="student-lesson-sidebar" aria-labelledby="quizzes-heading">
            @if($lesson->quizzes->isNotEmpty())
                <header class="student-dash-section-head student-lesson-sidebar__head">
                    <div>
                        <h2 id="quizzes-heading" class="student-dash-section-head__title">Related quizzes</h2>
                        <p class="student-dash-section-head__sub">Practice what you learned</p>
                    </div>
                    <span class="badge rounded-pill student-dash-badge student-dash-badge--muted">{{ $lesson->quizzes->count() }}</span>
                </header>

                <div class="student-course-list">
                    @foreach($lesson->quizzes as $quiz)
                        <a href="{{ student_course_route('student.courses.quizzes.show', $course, ['quiz' => $quiz]) }}" class="student-course-list__item">
                            <span class="student-course-list__icon student-course-list__icon--quiz" aria-hidden="true">
                                <i class="bi bi-patch-question"></i>
                            </span>
                            <span class="student-course-list__body">
                                <span class="student-course-list__title">{{ $quiz->title }}</span>
                                <span class="student-course-list__meta">
                                    <span><i class="bi bi-arrow-right-circle" aria-hidden="true"></i> Take quiz</span>
                                </span>
                            </span>
                            <i class="bi bi-chevron-right student-course-list__arrow" aria-hidden="true"></i>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="student-lesson-sidebar__empty">
                    <i class="bi bi-patch-question" aria-hidden="true"></i>
                    <p class="mb-0">No quizzes linked to this lesson yet.</p>
                </div>
            @endif
        </aside>
    </div>
</div>
@endsection
