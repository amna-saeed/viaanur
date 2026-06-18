@extends('layout.main')

@section('content')
@include('components.apply-form')

<!-- <div id="wrapper-box">
    <div class="viaanur-banner-container position-relative z-1">
        <img src="{{ asset('assets/images/banner/courses.webp') }}" alt="Courses" class="viaanur-banner-image">
    </div>
</div> -->

<div class="courses-detail-page courses-detail-page--premium pt-4 pb-110">
    <div class="container">
        <nav class="course-detail-breadcrumb mb-4" aria-label="Breadcrumb">
            <ol class="course-detail-breadcrumb__list list-unstyled d-flex flex-wrap align-items-center gap-1 mb-0">
                <li class="course-detail-breadcrumb__item">
                    <a href="{{ route('home') }}" class="course-detail-breadcrumb__link">Home</a>
                </li>
                <li class="course-detail-breadcrumb__sep" aria-hidden="true">/</li>
                <li class="course-detail-breadcrumb__item">
                    <a href="{{ route('courses') }}" class="course-detail-breadcrumb__link">Courses</a>
                </li>
                <li class="course-detail-breadcrumb__sep" aria-hidden="true">/</li>
                <li class="course-detail-breadcrumb__item course-detail-breadcrumb__item--current" aria-current="page">
                    {{ $course['title'] }}
                </li>
            </ol>
        </nav>

        @include('pages.coursesDetail.primaryone', [
            'course' => $course,
            'lmsCourse' => $lmsCourse ?? null,
        ])
    </div>
</div>
@endsection
