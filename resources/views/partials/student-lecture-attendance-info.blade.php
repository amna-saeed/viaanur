@php
    $lectureAttendance = $lectureAttendance ?? collect();
@endphp

<div class="sp-lecture-attendance mt-4 pt-4 border-top">
    <span class="sp-field__label d-block mb-3">Lecture Attendance</span>

    @if($lectureAttendance->isEmpty())
        <p class="sp-not-set mb-0">No lectures assigned yet.</p>
    @else
        <div class="sp-lecture-attendance__list">
            @foreach($lectureAttendance as $lecture)
                <div class="sp-lecture-attendance__item {{ $lecture['attended'] ? 'sp-lecture-attendance__item--attended' : 'sp-lecture-attendance__item--missing' }}">
                    <div class="sp-lecture-attendance__title">
                        {{ $lecture['title'] }}
                        <span class="sp-lecture-attendance__course">{{ $lecture['course_title'] }}</span>
                    </div>
                    <p class="sp-lecture-attendance__status mb-0">{{ $lecture['status_message'] }}</p>
                    @if($lecture['attended'] && $lecture['attended_at'])
                        <span class="sp-lecture-attendance__meta">
                            Attended {{ $lecture['attended_at']->format('M d, Y g:i A') }}
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
