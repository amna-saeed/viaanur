@php
    use App\Support\CourseCatalog;
    $categoryItems = CourseCatalog::forSlider();
@endphp

<style>
/* ============================================================
   CATEGORIES SECTION — Light & Clean Theme
   Brand: #b2cd34 (lime) | #322f89 (deep purple)
============================================================ */

@keyframes cat-fadeUp  { from{opacity:0;transform:translateY(26px)} to{opacity:1;transform:translateY(0)} }
@keyframes cat-shimmer { 0%{background-position:-200% center} 100%{background-position:200% center} }
@keyframes cat-dot     { 0%,80%,100%{transform:scale(.75);opacity:.45} 40%{transform:scale(1.2);opacity:1} }
@keyframes cat-pulse   { 0%,100%{opacity:.5;transform:scale(1)} 50%{opacity:1;transform:scale(1.08)} }

/* ── Section ── */
#courses-move {
    position: relative;
    padding: 96px 0 110px;
    background: linear-gradient(160deg, #eeeaff 0%, #ffffff 45%, #f0fce0 100%);
    overflow: hidden;
}

/* Dot grid texture */
#courses-move::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(50,47,137,.06) 1px, transparent 1px);
    background-size: 28px 28px;
    z-index: 0;
    pointer-events: none;
}
.owl-stage{
    padding-top: 20px;
}
/* Soft colour blobs */
#courses-move .cat-blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(90px);
    pointer-events: none;
    z-index: 0;
}
#courses-move .cat-blob-1 {
    width: 420px; height: 420px;
    background: rgba(50,47,137,.08);
    top: -100px; left: -80px;
    animation: cat-pulse 9s ease-in-out infinite;
}
#courses-move .cat-blob-2 {
    width: 340px; height: 340px;
    background: rgba(178,205,52,.12);
    bottom: -80px; right: -60px;
    animation: cat-pulse 11s ease-in-out infinite reverse;
}

/* ── z-index wrapper ── */
#courses-move .cat-inner { position: relative; z-index: 1; }

/* ── Section header ── */
#courses-move .cat-header { margin-bottom: 56px; animation: cat-fadeUp .55s ease both; }

#courses-move .cat-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(50,47,137,.07);
    border: 1px solid rgba(50,47,137,.22);
    border-radius: 60px;
    padding: 7px 22px;
    margin-bottom: 18px;
    backdrop-filter: blur(8px);
}
#courses-move .cat-badge-dot {
    width: 7px; height: 7px;
    background: #322f89;
    border-radius: 50%;
    box-shadow: 0 0 8px rgba(50,47,137,.55);
    animation: cat-dot 2.2s ease-in-out infinite;
}
#courses-move .cat-badge-text {
    font-size: 11px; font-weight: 700;
    color: #322f89;
    letter-spacing: .9px;
    text-transform: uppercase;
}

#courses-move .cat-title {
    font-size: clamp(28px, 4vw, 46px);
    font-weight: 800;
    color: #12104a;
    letter-spacing: -1px;
    margin-bottom: 0;
    animation: cat-fadeUp .65s ease both;
    animation-delay: .1s;
}
#courses-move .cat-title-accent {
    background: linear-gradient(135deg, #322f89 0%, #b2cd34 55%, #322f89 100%);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: cat-shimmer 4s linear infinite;
}

#courses-move .cat-divider {
    display: flex; align-items: center;
    justify-content: center; gap: 12px;
    margin-top: 20px;
    animation: cat-fadeUp .75s ease both;
    animation-delay: .15s;
}
#courses-move .cat-divider::before,
#courses-move .cat-divider::after {
    content: '';
    width: 64px; height: 2px;
    border-radius: 2px;
}
#courses-move .cat-divider::before { background: linear-gradient(90deg, transparent, rgba(50,47,137,.40)); }
#courses-move .cat-divider::after  { background: linear-gradient(90deg, rgba(50,47,137,.40), transparent); }
#courses-move .cat-divider-icon {
    width: 40px; height: 40px;
    background: linear-gradient(135deg, #322f89, #5651b5);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; color: #fff;
    box-shadow: 0 6px 18px rgba(50,47,137,.30);
}

/* ── Owl nav arrows ── */
#courses-move .categories-slider-items .owl-nav .owl-prev,
#courses-move .categories-slider-items .owl-nav .owl-next {
    background: #ffffff !important;
    border: 1.5px solid rgba(50,47,137,.25) !important;
    color: #322f89 !important;
    border-radius: 50% !important;
    width: 44px !important; height: 44px !important;
    line-height: 42px !important; font-size: 18px !important;
    box-shadow: 0 4px 16px rgba(50,47,137,.12) !important;
    transition: all .3s ease !important;
}
#courses-move .categories-slider-items .owl-nav .owl-prev:hover,
#courses-move .categories-slider-items .owl-nav .owl-next:hover {
    background: #322f89 !important;
    border-color: #322f89 !important;
    color: #fff !important;
    box-shadow: 0 8px 28px rgba(50,47,137,.35) !important;
    transform: scale(1.08) !important;
}

/* ── Cards ── */
#courses-move .single-categories-card {
    background: #ffffff;
    border: 1px solid rgba(50,47,137,.09);
    border-radius: 20px;
    padding: 30px 18px 26px;
    margin-bottom: 0;
    min-height: 190px;
    box-shadow: 0 4px 22px rgba(50,47,137,.08);
    position: relative;
    overflow: hidden;
    transition: transform .4s cubic-bezier(.175,.885,.32,1.275),
                box-shadow .4s ease,
                border-color .4s ease;
}

/* Top accent bar — always visible, purple → lime */
#courses-move .single-categories-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, #322f89, #b2cd34);
    border-radius: 20px 20px 0 0;
    opacity: .55;
    transition: opacity .35s;
}
#courses-move .single-categories-card:hover::before { opacity: 1; }

/* second-color: flip gradient direction */
#courses-move .single-categories-card.second-color::before {
    background: linear-gradient(90deg, #b2cd34, #322f89);
}

#courses-move a.single-categories-card:hover,
#courses-move .single-categories-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 22px 55px rgba(50,47,137,.18),
                0 0 0 2px rgba(178,205,52,.30);
    border-color: rgba(178,205,52,.40);
}

/* second-color variant — lighter purple tint */
#courses-move .single-categories-card.second-color {
    background: #fdfcff;
    border-color: rgba(50,47,137,.07);
}

/* ── Icon ── */
#courses-move .single-categories-card .icon img:first-child { display: none; } /* hide SVG bg shape */

#courses-move .single-categories-card .icon {
    width: 68px !important; height: 68px !important;
    background: linear-gradient(135deg, rgba(50,47,137,.10), rgba(178,205,52,.10));
    border: 1.5px solid rgba(50,47,137,.18);
    border-radius: 18px;
    display: flex !important;
    align-items: center; justify-content: center;
    margin: 0 auto 20px !important;
    overflow: hidden;
    position: relative;
    transition: background .4s, box-shadow .4s, transform .4s, border-color .4s;
}
/* second-color icon — swap gradient */
#courses-move .second-color .icon {
    background: linear-gradient(135deg, rgba(178,205,52,.14), rgba(50,47,137,.08));
    border-color: rgba(178,205,52,.35);
}

#courses-move .single-categories-card:hover .icon {
    background: linear-gradient(135deg, #322f89, #5651b5);
    border-color: #322f89;
    box-shadow: 0 10px 26px rgba(50,47,137,.28);
    transform: scale(1.10) rotate(-5deg);
}
#courses-move .second-color:hover .icon {
    background: linear-gradient(135deg, #b2cd34, #c8e040);
    border-color: #b2cd34;
    box-shadow: 0 10px 26px rgba(178,205,52,.35);
}

/* Icon image */
#courses-move .single-categories-card .icon .bg-shape {
    position: static !important; transform: none !important;
    width: 36px !important; height: 36px !important;
    object-fit: contain; display: block !important;
    top: auto !important; left: auto !important;
    right: auto !important; margin: 0 !important;
    transition: filter .4s;
}
/* Make icon white when background fills dark on hover */
#courses-move .single-categories-card:hover .icon .bg-shape {
    filter: brightness(0) invert(1);
}

/* ── Text ── */
#courses-move .single-categories-card h3 {
    color: #12104a;
    font-size: 13.5px;
    font-weight: 700;
    margin-bottom: 5px;
    letter-spacing: -.1px;
    line-height: 1.4;
    transition: color .3s;
}
#courses-move a.single-categories-card:hover h3 { color: #322f89; }

#courses-move .single-categories-card p {
    color: #888;
    font-size: 11.5px;
    font-weight: 500;
    margin: 0;
}

/* ── Responsive ── */
@media (max-width: 991px) { #courses-move { padding: 72px 0 84px; } }
@media (max-width: 767px) {
    #courses-move { padding: 56px 0 68px; }
    #courses-move .cat-header { margin-bottom: 38px; }
    #courses-move .cat-blob-1, #courses-move .cat-blob-2 { display: none; }
    #courses-move .categories-slider-items { padding: 0 36px; }
}
@media (max-width: 480px) {
    #courses-move .categories-slider-items { padding: 0 28px; }
}
</style>

<div class="categories-area" id="courses-move">

    <div class="cat-blob cat-blob-1"></div>
    <div class="cat-blob cat-blob-2"></div>

    <div class="container cat-inner">

        <!-- ── Header ── -->
        <div class="cat-header text-center">
            <div class="cat-badge">
                <span class="cat-badge-dot"></span>
                <span class="cat-badge-text">Course Category</span>
            </div>
            <h2 class="cat-title">
                Explore Top <span class="cat-title-accent">Categories</span>
            </h2>
            <div class="cat-divider">
                <span class="cat-divider-icon">
                    <i class="bi bi-grid-fill"></i>
                </span>
            </div>
        </div>

        <!-- ── Slider — Owl Carousel structure unchanged ── -->
        <div class="categories-slider">
            <div class="categories-slider-items">
                <div class="categories-slider-info owl-carousel owl-theme">
                    @foreach($categoryItems as $item)
                        <div class="item">
                            <a href="{{ $item['url'] }}"
                               class="single-categories-card text-center d-block text-decoration-none {{ $loop->iteration % 2 === 0 ? 'second-color' : '' }}">
                                <div class="icon mx-auto position-relative z-1">
                                    <img src="{{ asset('assets/images/banner/categories-bg-shape.svg') }}" alt="">
                                    <img class="bg-shape"
                                         src="{{ asset('assets/images/banner/' . $item['icon']) }}"
                                         alt="{{ $item['title'] }}">
                                </div>
                                <h3>{{ $item['title'] }}</h3>
                                @if(!empty($item['subtitle']))
                                    <p>{{ $item['subtitle'] }}</p>
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
