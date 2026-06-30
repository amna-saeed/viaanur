@extends('teacher.layout')
@section('title', 'My Subjects')
@section('page_heading', 'My Subjects')

@section('content')
<div class="stu-toolbar mb-4">
    <div class="stu-toolbar__left">
        <h2 class="stu-toolbar__title">Assigned Subjects</h2>
        <span class="stu-toolbar__count">{{ $subjects->total() }} {{ Str::plural('subject', $subjects->total()) }}</span>
    </div>
</div>

<div class="ad-panel">
    <div class="stu-search-bar">
        <form method="GET" action="{{ route('teacher.subjects.index') }}" class="stu-search-form">
            <div class="stu-search-input-wrap">
                <i class="bi bi-search stu-search-icon"></i>
                <input type="text" name="q" class="form-control stu-search-input" placeholder="Search subjects…" value="{{ request('q') }}">
            </div>
            <button type="submit" class="btn btn-primary stu-search-btn">Search</button>
            @if(request('q'))
                <a href="{{ route('teacher.subjects.index') }}" class="btn admin-lms-btn-outline stu-search-btn">Clear</a>
            @endif
        </form>
    </div>
    <div class="ad-panel__body">
        <div class="row g-3">
            @forelse($subjects as $subject)
                <div class="col-md-6 col-xl-4">
                    <div class="border rounded-3 p-3 h-100" style="background:#fafbff;border-color:#e4e4f0 !important;">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            <h3 class="h6 mb-0 fw-bold">{{ $subject->name }}</h3>
                            <span class="badge bg-success-subtle text-success border">{{ $subject->students_count }} students</span>
                        </div>
                        <p class="small text-muted mb-2">
                            <i class="bi bi-journal-bookmark me-1"></i>{{ $subject->course->title ?? 'No linked course' }}
                        </p>
                        @if($subject->code)
                            <p class="small text-muted mb-0"><i class="bi bi-hash me-1"></i>{{ $subject->code }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="ad-empty py-5">
                        <i class="bi bi-book d-block mb-2"></i>
                        No subjects assigned to you yet. Contact the administrator.
                    </div>
                </div>
            @endforelse
        </div>
        @if($subjects->hasPages())
            <div class="mt-4">{{ $subjects->links() }}</div>
        @endif
    </div>
</div>

<style>
.stu-toolbar{display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap}
.stu-toolbar__left{display:flex;align-items:center;gap:.75rem}
.stu-toolbar__title{font-size:1.1rem;font-weight:700;margin:0}
.stu-toolbar__count{background:#f0fdfb;color:#0f766e;font-size:.75rem;font-weight:700;padding:.25rem .65rem;border-radius:999px;border:1px solid #99f6e4}
.stu-search-bar{padding:1rem 0 1.25rem;border-bottom:1px solid #f0f0f8;margin-bottom:1rem}
.stu-search-form{display:flex;gap:.6rem;flex-wrap:wrap}
.stu-search-input-wrap{position:relative;flex:1;min-width:200px}
.stu-search-icon{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8}
.stu-search-input{padding-left:34px !important;height:40px;border-radius:9px}
.stu-search-btn{height:40px;border-radius:9px;font-weight:600}
</style>
@endsection
