@isset($highlights)
@if($highlights['count'] > 0)
<section class="student-dash-highlights mb-4" aria-labelledby="highlights-heading">
    <div class="student-dash-highlight-panel">
        <div class="student-dash-highlight-panel__glow" aria-hidden="true"></div>
        <div class="student-dash-highlight-panel__head">
            <div>
                <span class="student-dash-highlight-panel__pulse" aria-hidden="true"></span>
                <h2 id="highlights-heading" class="student-dash-highlight-panel__title">
                    <i class="bi bi-stars" aria-hidden="true"></i> What's new
                </h2>
                <p class="student-dash-highlight-panel__sub mb-0">{{ $highlights['count'] }} new {{ $highlights['count'] === 1 ? 'update' : 'updates' }} since your last visit</p>
            </div>
            <span class="student-dash-highlight-panel__count">{{ $highlights['count'] }}</span>
        </div>
        <ul class="student-dash-highlight-list list-unstyled mb-0">
            @foreach($highlights['new_courses'] as $course)
                <li class="student-dash-highlight-item student-dash-highlight-item--course">
                    <span class="student-dash-highlight-item__badge">Approved course</span>
                    <div class="student-dash-highlight-item__body">
                        <strong class="student-dash-highlight-item__title">{{ $course->title }}</strong>
                        <span class="student-dash-highlight-item__meta">
                            {{ $course->lessons_count }} lessons · {{ $course->quizzes_count }} quizzes
                        </span>
                    </div>
                    <a href="{{ route('student.courses.show', $course) }}" class="btn btn-sm btn-light student-dash-highlight-item__btn ms-auto">
                        Open
                    </a>
                </li>
            @endforeach
            @foreach($highlights['new_quizzes'] as $quiz)
                <li class="student-dash-highlight-item student-dash-highlight-item--quiz">
                    <span class="student-dash-highlight-item__badge student-dash-highlight-item__badge--quiz">New quiz</span>
                    <div class="student-dash-highlight-item__body">
                        <strong class="student-dash-highlight-item__title">{{ $quiz->title }}</strong>
                        <span class="student-dash-highlight-item__meta">{{ optional($quiz->course)->title }}</span>
                    </div>
                    @if($quiz->course)
                        <a href="{{ route('student.courses.quizzes.show', [$quiz->course, $quiz]) }}" class="btn btn-sm btn-light student-dash-highlight-item__btn ms-auto">
                            Start
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</section>
@endif
@endisset
