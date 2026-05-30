@php
    $subject = $course['subjects'][0] ?? ['name' => $course['title'], 'price' => $course['price'], 'icon' => 'bi-book'];
    $eyebrowDisplay = str_replace([' · ', ' - ', ' – '], ' • ', $course['eyebrow'] ?? '');
    $heroIcon = $course['icon'] ?? 'english.webp';
@endphp

<div class="cd-premium">
    <div class="cd-premium__shell">
        <section class="cd-premium-hero" aria-labelledby="cd-premium-title">
            <div class="cd-premium-hero__visual">
                <div class="cd-premium-hero__visual-bg" aria-hidden="true">
                    <span class="cd-premium-hero__glow cd-premium-hero__glow--1"></span>
                    <span class="cd-premium-hero__glow cd-premium-hero__glow--2"></span>
                    <span class="cd-premium-hero__wave cd-premium-hero__wave--1"></span>
                    <span class="cd-premium-hero__wave cd-premium-hero__wave--2"></span>
                    <span class="cd-premium-hero__wave cd-premium-hero__wave--3"></span>
                    <span class="cd-premium-hero__spark cd-premium-hero__spark--1"></span>
                    <span class="cd-premium-hero__spark cd-premium-hero__spark--2"></span>
                    <span class="cd-premium-hero__spark cd-premium-hero__spark--3"></span>
                    <span class="cd-premium-hero__spark cd-premium-hero__spark--4"></span>
                </div>
                <div class="cd-premium-hero__art">
                    @if(str_contains($course['slug'] ?? '', 'maths'))
                        @include('pages.coursesDetail.partials.hero-maths-art')
                    @else
                        <img
                            src="{{ asset('assets/images/banner/' . $heroIcon) }}"
                            alt=""
                            class="cd-premium-hero__icon-img"
                            loading="lazy"
                            decoding="async"
                        >
                    @endif
                    
                </div>


            </div>

            <div class="cd-premium-hero__content">
                <!-- <p class="cd-premium-hero__eyebrow">{{ $eyebrowDisplay }}</p> -->
                <h1 id="cd-premium-title" class="cd-premium-hero__title">{{ $course['title'] }}</h1>

                <div class="cd-premium-ticket">
                    <div class="cd-premium-ticket__row">
                        <span class="cd-premium-ticket__icon" aria-hidden="true">
                            <i class="bi {{ $subject['icon'] }}"></i>
                        </span>
                        <span class="cd-premium-ticket__name">{{ $subject['name'] }}</span>
                        <span class="cd-premium-ticket__price">{{ $subject['price'] }}</span>
                    </div>
                    <p class="cd-premium-ticket__desc">{{ $course['description'] }}</p>
                    <div class="cd-premium-ticket__actions">
                        <div class="button blick-100 enroll-apply-btn js-apply-form-open">
                            <a class="cd-premium-btn cd-premium-btn--primary bliink-inner1" href="javascript:void(0)">Enroll Now</a>
                        </div>
                        <a href="{{ route('home') }}" class="cd-premium-btn cd-premium-btn--ghost">
                            <i class="bi bi-arrow-left" aria-hidden="true"></i> Back to all courses
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="cd-premium-about" id="cd-about" aria-labelledby="cd-about-title">
            <header class="cd-premium-about__head">
                <h2 id="cd-about-title" class="cd-premium-about__title">About This Course</h2>
                <p class="cd-premium-about__meta">{{ $eyebrowDisplay }}</p>
            </header>
            <div class="cd-premium-about__divider" aria-hidden="true"></div>
            <p class="cd-premium-about__text">{{ $course['about'] ?? '' }}</p>
        </section>
    </div>
</div>

<style>
.single-courses-card .list-info .enroll-apply-btn .bliink-inner1, .enroll-apply-btn .bliink-inner1 {
    background: #322f89 !important;
    color: #fff !important;
    padding: 11px 38px;
    border-radius: 7px;
    display: inline-flex !important;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    font-weight: 500;
    font-size: 13px;
    cursor: pointer;
    animation: enrollBtnBlink 1.5s ease-in-out infinite alternate !important;
}


@media
</style>