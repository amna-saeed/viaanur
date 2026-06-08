@extends('layout.main')
@section('content')

    <!-- Start Premium Hero Area -->
    <style>
        /* ============================================================
           PREMIUM HERO — ViAaNur Tutoring
           Brand: #b2cd34 (lime-green), #322f89 / #2e2885 (deep purple)
        ============================================================ */

        /* Keyframes */
        @keyframes vn-fadeUp {
            from { opacity: 0; transform: translateY(36px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes vn-fadeRight {
            from { opacity: 0; transform: translateX(-28px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes vn-float {
            0%,100% { transform: translateY(0); }
            50%      { transform: translateY(-18px); }
        }
        @keyframes vn-floatAlt {
            0%,100% { transform: translateY(0) rotate(0deg); }
            50%      { transform: translateY(16px) rotate(3deg); }
        }
        @keyframes vn-pulse {
            0%,100% { transform: scale(1);   opacity: .8; }
            50%      { transform: scale(1.12); opacity: 1; }
        }
        @keyframes vn-spin {
            to { transform: rotate(360deg); }
        }
        @keyframes vn-shimmer {
            0%   { background-position: -200% center; }
            100% { background-position:  200% center; }
        }
        @keyframes vn-glow {
            0%,100% { box-shadow: 0 0 22px rgba(178,205,52,.35); }
            50%      { box-shadow: 0 0 44px rgba(178,205,52,.65); }
        }
        @keyframes vn-dotPop {
            0%,80%,100% { transform: scale(.75); opacity:.45; }
            40%          { transform: scale(1.2);  opacity:1; }
        }
        @keyframes vn-lineDraw {
            from { width: 0; }
            to   { width: 100%; }
        }

        /* ─── Wrapper ─── */
        #vn-hero {
            position: relative;
            min-height: 100vh;
            background: linear-gradient(140deg,
                #080619 0%,
                #120e52 30%,
                #1e1a6e 55%,
                #2a256e 75%,
                #0f0c3a 100%);
            overflow: hidden;
            display: flex;
            align-items: center;
            padding: 130px 0 90px;
        }

        /* subtle texture overlay using existing bg */
        #vn-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('{{ asset("assets/images/banner/bg.webp") }}') center/cover no-repeat;
            opacity: .06;
            z-index: 0;
        }

        /* gradient mesh */
        #vn-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 60% at 18% 55%, rgba(178,205,52,.18) 0%, transparent 60%),
                radial-gradient(ellipse 50% 50% at 80% 15%, rgba(50,47,137,.35) 0%, transparent 55%),
                radial-gradient(ellipse 40% 40% at 65% 85%, rgba(178,205,52,.10) 0%, transparent 50%);
            z-index: 0;
        }

        /* ─── Floating orbs ─── */
        .vn-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            pointer-events: none;
            z-index: 0;
        }
        .vn-orb-1 {
            width: 520px; height: 520px;
            background: radial-gradient(circle, rgba(178,205,52,.22) 0%, transparent 68%);
            top: -130px; right: -100px;
            animation: vn-float 9s ease-in-out infinite;
        }
        .vn-orb-2 {
            width: 420px; height: 420px;
            background: radial-gradient(circle, rgba(46,40,133,.50) 0%, transparent 68%);
            bottom: -60px; left: -90px;
            animation: vn-floatAlt 11s ease-in-out infinite;
        }
        .vn-orb-3 {
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(178,205,52,.14) 0%, transparent 68%);
            top: 38%; left: 42%;
            animation: vn-pulse 7s ease-in-out infinite;
        }

        /* ─── Decorative shapes ─── */
        .vn-deco { position: absolute; pointer-events: none; z-index: 0; }

        .vn-ring {
            width: 110px; height: 110px;
            border: 2.5px solid rgba(178,205,52,.22);
            border-radius: 50%;
            animation: vn-spin 18s linear infinite;
            position: relative;
        }
        .vn-ring::before {
            content: '';
            position: absolute;
            width: 9px; height: 9px;
            background: rgba(178,205,52,.7);
            border-radius: 50%;
            top: -5px; left: 50%;
            transform: translateX(-50%);
            box-shadow: 0 0 10px rgba(178,205,52,.6);
        }

        .vn-circle {
            border: 2px solid rgba(178,205,52,.28);
            border-radius: 50%;
            animation: vn-float 5s ease-in-out infinite;
        }
        .vn-circle-sm { width: 40px; height: 40px; background: rgba(178,205,52,.07); animation: vn-floatAlt 4s ease-in-out infinite; }
        .vn-circle-md { width: 72px; height: 72px; }

        .vn-dots {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            opacity: .25;
        }
        .vn-dots span {
            width: 4px; height: 4px;
            background: #b2cd34;
            border-radius: 50%;
            display: block;
        }

        /* ─── Content ─── */
        #vn-hero .vn-inner { position: relative; z-index: 2; }

        /* Badge pill */
        .vn-badge {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            background: rgba(178,205,52,.10);
            border: 1px solid rgba(178,205,52,.30);
            border-radius: 60px;
            padding: 8px 22px;
            margin-bottom: 30px;
            backdrop-filter: blur(12px);
            animation: vn-fadeUp .6s ease both;
            animation-delay: .1s;
        }
        .vn-badge-dot {
            width: 8px; height: 8px;
            background: #b2cd34;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(178,205,52,.65);
            animation: vn-dotPop 2s ease-in-out infinite;
        }
        .vn-badge-label {
            font-size: 12px;
            font-weight: 700;
            color: #b2cd34;
            letter-spacing: .8px;
            text-transform: uppercase;
        }

        /* Heading */
        .vn-h1 {
            font-size: clamp(38px, 5.5vw, 68px);
            font-weight: 800;
            line-height: 1.08;
            color: #fff;
            margin-bottom: 26px;
            letter-spacing: -1.5px;
            animation: vn-fadeUp .7s ease both;
            animation-delay: .2s;
        }
        .vn-h1 .vn-accent {
            background: linear-gradient(135deg, #b2cd34 0%, #d6ec50 50%, #b2cd34 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: vn-shimmer 3.5s linear infinite;
            display: inline;
        }
        .vn-h1 .vn-ul {
            position: relative;
            display: inline-block;
        }
        .vn-h1 .vn-ul::after {
            content: '';
            position: absolute;
            left: 0; bottom: 2px;
            height: 4px;
            background: linear-gradient(90deg, #b2cd34, transparent);
            border-radius: 2px;
            animation: vn-lineDraw 1s ease both;
            animation-delay: .9s;
            width: 100%;
        }

        /* Description */
        .vn-desc {
            font-size: 17px;
            color: rgba(255,255,255,.70);
            line-height: 1.75;
            max-width: 510px;
            margin-bottom: 38px;
            animation: vn-fadeUp .8s ease both;
            animation-delay: .3s;
        }

        /* CTA group */
        .vn-cta {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
            margin-bottom: 52px;
            animation: vn-fadeUp .9s ease both;
            animation-delay: .4s;
        }

        /* Primary button */
        .vn-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #b2cd34 0%, #c9e040 100%);
            color: #12104a;
            font-weight: 700;
            font-size: 15px;
            letter-spacing: .3px;
            padding: 16px 38px;
            border-radius: 60px;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            transition: transform .4s cubic-bezier(.175,.885,.32,1.275),
                        box-shadow .4s ease;
            box-shadow: 0 8px 28px rgba(178,205,52,.38);
            animation: vn-glow 3s ease-in-out infinite;
        }
        .vn-btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,.22) 0%, transparent 55%);
            opacity: 0;
            transition: opacity .3s;
        }
        .vn-btn-primary:hover {
            transform: translateY(-4px) scale(1.04);
            box-shadow: 0 18px 44px rgba(178,205,52,.55);
            color: #0b0936;
            text-decoration: none;
        }
        .vn-btn-primary:hover::before { opacity: 1; }
        .vn-btn-primary .vn-arr {
            width: 18px; height: 18px;
            transition: transform .3s;
        }
        .vn-btn-primary:hover .vn-arr { transform: translateX(5px); }

        /* Secondary / ghost button */
        .vn-btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,.07);
            border: 1.5px solid rgba(255,255,255,.22);
            color: #fff;
            font-weight: 600;
            font-size: 15px;
            padding: 15px 32px;
            border-radius: 60px;
            text-decoration: none;
            backdrop-filter: blur(12px);
            transition: all .35s ease;
        }
        .vn-btn-ghost:hover {
            background: rgba(178,205,52,.12);
            border-color: rgba(178,205,52,.55);
            color: #b2cd34;
            transform: translateY(-3px);
            text-decoration: none;
        }

        /* Stats row */
        .vn-stats {
            display: flex;
            align-items: center;
            gap: 28px;
            flex-wrap: wrap;
            animation: vn-fadeUp 1s ease both;
            animation-delay: .55s;
        }
        .vn-stat-sep {
            width: 1px; height: 42px;
            background: rgba(255,255,255,.14);
        }
        .vn-stat-num {
            font-size: 30px;
            font-weight: 800;
            color: #b2cd34;
            line-height: 1;
            margin-bottom: 4px;
            font-family: var(--headingFontFamily, 'Poppins', sans-serif);
        }
        .vn-stat-lbl {
            font-size: 11px;
            font-weight: 600;
            color: rgba(255,255,255,.50);
            letter-spacing: .6px;
            text-transform: uppercase;
        }

        /* ─── Image column ─── */
        .vn-img-col { animation: vn-fadeRight 1s ease both; animation-delay: .3s; }

        .vn-img-frame {
            position: relative;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 36px 90px rgba(0,0,0,.50);
        }
        .vn-img-frame img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform .7s ease;
        }
        .vn-img-frame:hover img { transform: scale(1.04); }
        /* gradient overlay on image */
        .vn-img-frame::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 40%, rgba(12,9,58,.65) 100%);
            pointer-events: none;
        }

        /* glow ring behind image */
        .vn-img-glow {
            position: absolute;
            inset: -3px;
            border-radius: 30px;
            background: linear-gradient(135deg,
                rgba(178,205,52,.45) 0%,
                rgba(50,47,137,.25) 50%,
                rgba(178,205,52,.15) 100%);
            z-index: -1;
            filter: blur(10px);
            animation: vn-glow 3.5s ease-in-out infinite;
        }

        /* ─── Floating cards ─── */
        .vn-card {
            position: absolute;
            background: rgba(255,255,255,.09);
            backdrop-filter: blur(22px);
            -webkit-backdrop-filter: blur(22px);
            border: 1px solid rgba(255,255,255,.18);
            border-radius: 18px;
            box-shadow: 0 24px 48px rgba(0,0,0,.25);
            z-index: 4;
        }

        /* Success card — bottom left */
        .vn-card-success {
            bottom: -22px; left: -28px;
            padding: 16px 20px;
            min-width: 190px;
            animation: vn-float 6s ease-in-out infinite;
        }
        .vn-card-success .cs-icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, #b2cd34, #c8e040);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 10px;
            box-shadow: 0 8px 20px rgba(178,205,52,.45);
        }
        .vn-card-success .cs-icon img { width: 24px; height: 24px; object-fit: contain; }
        .vn-card-success h3 { font-size: 14px; font-weight: 700; color: #fff; margin: 0 0 3px; }
        .vn-card-success h4 { font-size: 11px; color: rgba(255,255,255,.55); font-weight: 400; margin: 0; }

        /* WhatsApp card — top right */
        .vn-card-wa {
            top: 28px; right: -28px;
            padding: 13px 16px;
            min-width: 238px;
            animation: vn-floatAlt 7s ease-in-out infinite;
            text-decoration: none;
            display: block;
            transition: background .3s, border-color .3s, transform .3s, box-shadow .3s;
        }
        .vn-card-wa:hover {
            background: rgba(37,211,102,.15);
            border-color: rgba(37,211,102,.45);
            transform: translateY(-5px);
            box-shadow: 0 28px 55px rgba(37,211,102,.22);
            text-decoration: none;
        }
        .vn-card-wa .wa-row { display: flex; align-items: center; gap: 12px; }
        .vn-card-wa .wa-icon {
            width: 44px; height: 44px; min-width: 44px;
            background: linear-gradient(135deg, #25D366, #128C7E);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 20px rgba(37,211,102,.38);
        }
        .vn-card-wa .wa-icon img { width: 24px; height: 24px; }
        .vn-card-wa h3 { font-size: 12px; font-weight: 700; color: #fff; margin: 0 0 3px; line-height: 1.3; }
        .vn-card-wa span { font-size: 10px; color: rgba(255,255,255,.55); }

        /* Experience badge — bottom right */
        .vn-card-exp {
            bottom: 52px; right: -22px;
            padding: 14px 18px;
            background: linear-gradient(135deg, #b2cd34, #c8e040);
            border: none;
            backdrop-filter: none;
            animation: vn-float 4.5s ease-in-out infinite;
            animation-delay: .5s;
            box-shadow: 0 14px 32px rgba(178,205,52,.45);
        }
        .vn-card-exp .exp-num {
            font-size: 26px; font-weight: 800;
            color: #12104a; line-height: 1;
        }
        .vn-card-exp .exp-lbl {
            font-size: 10px; font-weight: 700;
            color: rgba(18,16,74,.65);
            letter-spacing: .3px; line-height: 1.4;
        }

        /* ─── Responsive ─── */
        @media (max-width: 991px) {
            #vn-hero { padding: 100px 0 60px; min-height: auto; }
            .vn-card-success, .vn-card-wa, .vn-card-exp { display: none; }
            .vn-img-col { margin-top: 44px; }
            .vn-img-frame { max-width: 480px; margin: 0 auto; }
        }
        @media (max-width: 767px) {
            #vn-hero { padding: 80px 0 50px; }
            .vn-h1 { letter-spacing: -.5px; }
            .vn-stats { gap: 16px; }
            .vn-stat-num { font-size: 24px; }
            .vn-cta { gap: 12px; }
            .vn-btn-primary, .vn-btn-ghost { padding: 14px 24px; font-size: 14px; }
            .vn-orb-1, .vn-orb-2, .vn-orb-3 { display: none; }
        }
    </style>

    <div id="banner" class="position-relative" style="overflow:hidden;">
    <section id="vn-hero">
        <!-- Orbs -->
        <div class="vn-orb vn-orb-1"></div>
        <div class="vn-orb vn-orb-2"></div>
        <div class="vn-orb vn-orb-3"></div>

        <!-- Decorative shapes -->
        <div class="vn-deco vn-circle vn-circle-md" style="top:16%;left:7%;animation-delay:.2s;"></div>
        <div class="vn-deco vn-circle vn-circle-sm" style="top:62%;left:4%;animation-delay:1.1s;"></div>
        <div class="vn-deco vn-ring" style="bottom:22%;right:14%;animation-delay:.6s;"></div>
        <div class="vn-deco vn-circle vn-circle-sm" style="top:28%;right:36%;animation-delay:1.8s;"></div>

        <!-- Dot grid top-right -->
        <div class="vn-deco" style="top:9%;right:4%;">
            <div class="vn-dots">
                @for($i=0;$i<25;$i++)<span></span>@endfor
            </div>
        </div>
        <!-- Dot grid bottom-left -->
        <div class="vn-deco" style="bottom:12%;left:1.5%;">
            <div class="vn-dots">
                @for($i=0;$i<20;$i++)<span></span>@endfor
            </div>
        </div>

        <div class="container vn-inner">
            <div class="row align-items-center g-lg-5 g-4">

                <!-- ── Left: Text ── -->
                <div class="col-lg-6">

                    <!-- Badge -->
                    <div class="vn-badge">
                        <span class="vn-badge-dot"></span>
                        <span class="vn-badge-label">An Online Tutoring Initiative</span>
                    </div>

                    <!-- Headline -->
                    <h1 class="vn-h1">
                        Empowered Minds,<br>
                        Proven Results,<br>
                        <span class="vn-accent">Exceptional</span>&nbsp;<span class="vn-ul">Futures.</span>
                    </h1>

                    <!-- Description -->
                    <p class="vn-desc">
                        Personalised tutoring that unlocks every student's potential — from GCSE Maths to Islamic Studies, led by passionate expert educators.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="vn-cta">
                        <a href="{{ route('contact-us') }}" class="vn-btn-primary">
                            Enroll Now
                            <svg class="vn-arr" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                        <a href="https://api.whatsapp.com/send?phone=447507719318&text=Hello%20there!" target="_blank" rel="noopener" class="vn-btn-ghost">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2zm.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24zM8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.85-.87 2.07 0 1.22.89 2.39 1.01 2.56.12.17 1.75 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.82-.78.99-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.47-.01z"/>
                            </svg>
                            Chat on WhatsApp
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="vn-stats">
                        <div>
                            <div class="vn-stat-num">500+</div>
                            <div class="vn-stat-lbl">Students</div>
                        </div>
                        <div class="vn-stat-sep"></div>
                        <div>
                            <div class="vn-stat-num">10+</div>
                            <div class="vn-stat-lbl">Yrs Experience</div>
                        </div>
                        <div class="vn-stat-sep"></div>
                        <div>
                            <div class="vn-stat-num">98%</div>
                            <div class="vn-stat-lbl">Satisfaction</div>
                        </div>
                    </div>

                </div>

                <!-- ── Right: Image ── -->
                <div class="col-lg-6 vn-img-col">
                    <div style="position:relative;display:inline-block;width:100%;">

                        <!-- Glow behind image -->
                        <div class="vn-img-glow"></div>

                        <!-- Main image -->
                        <div class="vn-img-frame">
                            <img src="{{ asset('assets/images/banner/banner1-new.webp') }}" alt="Empowered student">
                        </div>

                        <!-- Floating: success card (bottom-left) -->
                        <div class="vn-card vn-card-success">
                            <div class="cs-icon">
                                <img src="{{ asset('assets/images/banner/success-image.webp') }}" alt="success">
                            </div>
                            <h3>Study smart, aim high.</h3>
                            <h4>Turn dreams into achievements.</h4>
                        </div>

                        <!-- Floating: WhatsApp card (top-right) -->
                        <a class="vn-card vn-card-wa"
                           href="https://api.whatsapp.com/send?phone=447507719318&text=Hello%20there!"
                           target="_blank" rel="noopener">
                            <div class="wa-row">
                                <div class="wa-icon">
                                    <img src="{{ asset('assets/images/banner/whatsapp.svg') }}" alt="WhatsApp">
                                </div>
                                <div>
                                    <h3>Chat Instantly on WhatsApp</h3>
                                    <span>Connect with your mentor anytime</span>
                                </div>
                            </div>
                        </a>

                        <!-- Floating: experience badge (bottom-right) -->
                        <div class="vn-card vn-card-exp">
                            <div class="exp-num">10+</div>
                            <div class="exp-lbl">Years of<br>Excellence</div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
    </div>
    <!-- End Premium Hero Area -->
       <!-- Start Video Area -->
       <div class="container">
        <div class="video-area video-gradient-wrap">
            <video class="video-bg" autoplay muted loop playsinline>
                <source src="{{ asset('assets/images/banner/newvideo.mp4') }}" type="video/mp4">
            </video>
            <div class="video-gradient-overlay"></div>
        </div>
    </div>
    
    @include('components.academic-lead ')
    @include('components.categories')
    <!-- Start Categories Area -->
   
    <!-- End Categories Area -->
    <!-- @include('components.apply-form') -->
      <!-- Start Courses Area -->
    <!-- <div class="courses-area pt-136 pb-110">
        <div class="container">
            <div class="section-title text-center" data-cue="slideInUp">
                <span class="d-inline-block sub-title">Most Featured Courses</span>
                <h2>
                    Choose Our Top 
                    <span class="position-relative">
                        Courses
                    </span>
                </h2>
            </div>
            <div class="row" data-cues="fadeIn">

                <div class="col-lg-4 col-md-6">
                    <div class="single-courses-card">
                        <div class="image position-relative">
                            <a href="courses-details.html">
                                <img src="{{asset('assets/images/banner/wi.webp')}}" alt="courses-image" class="img-cource">
                            </a>
                            <span class="price">£35/ hour</span>
                        </div>
                        <div class="content">
                            <h3>
                                <a href="courses-details.html">GCSE Level Mathematics</a>
                            </h3>
                              <div class="user-info d-flex align-items-center">
                                <div class="image me-2">
                                     <img src="{{asset('assets/images/banner/WhatsApp Image 2026-02-11 at 2.50.39 PM.jpeg')}}" alt="courses-image">
                                </div>
                                <div>
                                    <h6 class="mb-1 d-flex align-items-center">
                                        Ms.R.Quraishi
                                        <span class="ms-12 rating-stars">
                                            <i class="ph-fill ph-star"></i>
                                            <i class="ph-fill ph-star"></i>
                                            <i class="ph-fill ph-star"></i>
                                            <i class="ph-fill ph-star-half"></i>

                                        </span>
                                    </h6>
                                </div>
                            </div>
                            <div class="list-info d-flex align-items-center justify-content-between">
                                <div class="title d-flex align-items-center">
                                    <div class="icon">
                                        <img src="{{asset('assets/images/banner/user-icon2.png')}}" class="users-course" alt="icon">
                                    </div>
                                </div>
                                <div class="button blick-100 enroll-apply-btn js-apply-form-open" data-apply-course="gcse-maths">
                                    <a class="bliink-inner1" href="#" role="button">ENROLL NOW</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single-courses-card">
                        <div class="image position-relative">
                            <a href="courses-details.html">
                                <img src="{{asset('assets/images/banner/socialmedia (1).webp')}}" alt="courses-image" class="img-cource">
                            </a>
                            <span class="price">£30/ hour</span>
                        </div>
                        <div class="content">
                            <h3>
                                <a href="courses-details.html">Introduction to Social Media Concepts</a>
                            </h3>
                            <div class="user-info d-flex align-items-center">
                                <div class="image me-2">
                                    <img src="{{asset('assets/images/banner/WhatsApp Image 2026-02-11 at 2.50.14 PM.jpeg')}}" 
                                        alt="courses-image" 
                                        class="rounded-circle"
                                        width="50">
                                </div>
                                <div>
                                    <h6 class="mb-1 d-flex align-items-center">
                                        Mr.A.Anwar
                                        <span class="ms-12 rating-stars">
                                            <i class="ph-fill ph-star"></i>
                                            <i class="ph-fill ph-star"></i>
                                            <i class="ph-fill ph-star"></i>
                                            <i class="ph-fill ph-star"></i>
                                            <i class="ph-fill ph-star"></i>
                                        </span>
                                    </h6>
                                </div>
                            </div>
                            <div class="list-info d-flex align-items-center justify-content-between">
                                <div class="title d-flex align-items-center">
                                    <div class="icon">
                                        <img src="{{asset('assets/images/banner/user-icon2.png')}}" class="users-course" alt="icon">
                                    </div>
                                </div>
                                <div class="button blick-100 enroll-apply-btn js-apply-form-open" data-apply-course="social-media">
                                    <a class="bliink-inner1" href="#" role="button">ENROLL NOW</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single-courses-card">
                        <div class="image position-relative">
                            <a href="courses-details.html">
                                <img src="assets/images/banner/quran (1).webp" alt="courses-image" class="img-cource">
                            </a>
                            <span class="price">£20/ hour</span>
                        </div>
                        <div class="content">
                            <h3>
                                <a href="courses-details.html">Islamic Studies</a>
                            </h3>
                            <div class="user-info d-flex align-items-center">
                                <div class="image me-2">
                                    <img src="{{asset('assets/images/banner/WhatsApp Image 2026-02-11 at 3.36.58 PM.jpeg')}}" alt="courses-image">
                                </div>
                                <div>
                                    <h6 class="mb-1 d-flex align-items-center">
                                        Ms.A.Begum
                                        <span class="ms-12 rating-stars">
                                            <i class="ph-fill ph-star"></i>
                                            <i class="ph-fill ph-star"></i>
                                            <i class="ph-fill ph-star"></i>
                                            <i class="ph-fill ph-star"></i>
                                            <i class="ph-fill ph-star-half"></i>

                                        </span>
                                    </h6>
                                </div>
                            </div>
                            <div class="list-info d-flex align-items-center justify-content-between">
                                <div class="title d-flex align-items-center">
                                    <div class="icon">
                                        <img src="{{asset('assets/images/banner/user-icon2.png')}}" class="users-course" alt="icon">
                                    </div>
                                </div>
                                <div class="button blick-100 enroll-apply-btn js-apply-form-open" data-apply-course="islamic-studies">
                                    <a class="bliink-inner1" href="#" role="button">ENROLL NOW</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div> -->
    <!-- End Courses Area -->

   

     <div class="testimonial-area ptb-10">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="row about-image position-relative z-1">
                            <div class="col-lg-6">
                                <div class="image-1">
                                    <img src="assets/images/banner/about3.webp" alt="about-image">
                                </div>
                                <div class="image-2" data-cue="slideInUp">
                                    <img src="assets/images/banner/about1.webp" alt="about-image">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 p-0">
                                <div class="image-3" data-cue="slideInUp">
                                    <img src="assets/images/banner/about2 (1).webp" alt="about-image">
                                </div>
                                <div class="experience-info d-flex align-items-center justify-content-between" data-cue="slideInUp">
                                    <div class="content">
                                        <h3>
                                            <span class="counter">10+</span>
                                        </h3>
                                        <p>+years experience</p>
                                    </div>
                                    <a href="about.html" class="icon">
                                        <i class="ph ph-arrow-up-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="testimonial-content style-3" data-cue="slideInUp">
                            <div class="section-title">
                                <h2>
                                    Discover Our Vision for Digital 
                                    <span class="position-relative">
                                        Education
                                    </span>
                                </h2>
                            </div>
                            <div class="testimonial-slider-info owl-carousel owl-theme">
                                <div class="item">
                                    <h2 class="head-mission">Mission</h2>
                                    <p class="p-17">
                                        ViAaNur Tutoring’s mission is to empower every learner through high-quality, individualized instruction designed to meet their unique needs, pace, and learning style. We provide a structured, supportive environment that promotes academic mastery, personal development, and lasting confidence. By combining tailored strategies with a holistic understanding of each student’s inner motivation and potential, we help illuminate their inner light—guiding them toward deeper understanding, meaningful progress, and sustained success.
                                    </p>
                                   
                                </div>
                                <div class="item">
                                    <h2 class="head-mission">Vision</h2>
                                    <p class="p-17">
                                        Our vision is to inspire and cultivate future leaders by creating a learning journey where every student’s inner light can rise with clarity, confidence, and purpose. At ViAaNur Tutoring, we aim to transform education into an empowering experience—one that nurtures advanced mastery, strengthens resilience, and encourages students to envision what is possible. Guided by the spirit of Empowered Minds, Proven Results, Exceptional Futures, we strive to help each learner grow into a capable, thoughtful, and impactful individual who is prepared not only to succeed, but to lead with insight and integrity.
                                    </p>
                                    
                                </div>
                               
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    <!-- End About Area -->

   
    <!-- ownere -->
      @include('components.mission')
     <!--  -->

    <!-- Start Choose Area -->
    <!-- End Choose Area -->

    <!-- Start Team Area -->
    <style>
        /* ============================================================
           TEAM SECTION — ViAaNur Tutoring
           Light theme for contrast against the dark sections above
        ============================================================ */

        @keyframes tm-fadeUp  { from{opacity:0;transform:translateY(28px)} to{opacity:1;transform:translateY(0)} }
        @keyframes tm-scaleIn { from{opacity:0;transform:scale(.9)}         to{opacity:1;transform:scale(1)}     }
        @keyframes tm-shimmer { 0%{background-position:-200% center} 100%{background-position:200% center} }
        @keyframes tm-glow    { 0%,100%{box-shadow:0 0 18px rgba(178,205,52,.3)} 50%{box-shadow:0 0 36px rgba(178,205,52,.6)} }
        @keyframes tm-dot     { 0%,80%,100%{transform:scale(.75);opacity:.4} 40%{transform:scale(1.2);opacity:1} }

        /* ── Section ── */
        .tm-section {
            position: relative;
            padding: 96px 0 108px;
            background: linear-gradient(160deg, #f8f5ff 0%, #ffffff 50%, #f4f8e8 100%);
            overflow: hidden;
        }

        /* Subtle dot-grid background pattern */
        .tm-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle, rgba(50,47,137,.07) 1px, transparent 1px);
            background-size: 28px 28px;
            z-index: 0;
        }

        /* Soft blobs */
        .tm-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }
        .tm-blob-1 { width:360px;height:360px; background:rgba(178,205,52,.12); top:-80px; right:-60px; }
        .tm-blob-2 { width:280px;height:280px; background:rgba(50,47,137,.08);  bottom:-60px; left:-50px; }

        .tm-inner { position: relative; z-index: 1; }

        /* ── Section header ── */
        .tm-header { margin-bottom: 60px; }

        .tm-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(178,205,52,.12);
            border: 1px solid rgba(178,205,52,.40);
            border-radius: 60px;
            padding: 7px 22px;
            margin-bottom: 18px;
            animation: tm-fadeUp .5s ease both;
        }
        .tm-badge-dot {
            width: 7px; height: 7px;
            background: #b2cd34;
            border-radius: 50%;
            box-shadow: 0 0 8px rgba(178,205,52,.7);
            animation: tm-dot 2s ease-in-out infinite;
        }
        .tm-badge-text {
            font-size: 11px;
            font-weight: 700;
            color: #2e2885;
            letter-spacing: .9px;
            text-transform: uppercase;
        }

        .tm-title {
            font-size: clamp(28px, 4vw, 46px);
            font-weight: 800;
            color: #12104a;
            letter-spacing: -1px;
            margin-bottom: 16px;
            animation: tm-fadeUp .6s ease both;
            animation-delay: .1s;
        }
        .tm-title-accent {
            background: linear-gradient(135deg, #2e2885 0%, #b2cd34 60%, #2e2885 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: tm-shimmer 4s linear infinite;
        }

        .tm-subtitle {
            font-size: 16px;
            color: #666;
            max-width: 520px;
            margin: 0 auto;
            line-height: 1.7;
            animation: tm-fadeUp .7s ease both;
            animation-delay: .15s;
        }

        /* Divider line */
        .tm-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin: 22px 0 0;
            animation: tm-fadeUp .7s ease both;
            animation-delay: .2s;
        }
        .tm-divider::before, .tm-divider::after {
            content: '';
            width: 70px; height: 2px;
            background: linear-gradient(90deg, transparent, rgba(46,40,133,.30));
            border-radius: 2px;
        }
        .tm-divider::after { background: linear-gradient(90deg, rgba(46,40,133,.30), transparent); }
        .tm-divider-dot {
            width: 8px; height: 8px;
            background: #b2cd34;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(178,205,52,.6);
        }

        /* ── Cards ── */
        .tm-card {
            position: relative;
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 4px 28px rgba(50,47,137,.09);
            transition: transform .4s cubic-bezier(.175,.885,.32,1.275),
                        box-shadow .4s ease;
            animation: tm-scaleIn .6s ease both;
            height: 100%;
        }
        .tm-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 24px 60px rgba(50,47,137,.18),
                        0 0 0 2px rgba(178,205,52,.35);
        }

        /* Top accent bar */
        .tm-card-accent {
            height: 4px;
            background: linear-gradient(90deg, #2e2885, #b2cd34);
            transition: height .3s ease;
        }
        .tm-card:hover .tm-card-accent { height: 5px; }

        /* Photo wrapper */
        .tm-photo-wrap {
            position: relative;
            overflow: hidden;
            aspect-ratio: 4 / 4.2;
        }
        .tm-photo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top center;
            display: block;
            transition: transform .6s ease;
        }
        .tm-card:hover .tm-photo-wrap img { transform: scale(1.06); }

        /* Overlay on hover */
        .tm-photo-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top,
                rgba(18,16,74,.82) 0%,
                rgba(18,16,74,.25) 50%,
                transparent 100%);
            opacity: 0;
            transition: opacity .4s ease;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding-bottom: 24px;
        }
        .tm-card:hover .tm-photo-overlay { opacity: 1; }

        .tm-overlay-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #b2cd34;
            color: #12104a;
            font-size: 13px;
            font-weight: 700;
            padding: 9px 22px;
            border-radius: 50px;
            text-decoration: none;
            transform: translateY(12px);
            transition: transform .4s ease .05s, box-shadow .3s ease;
            box-shadow: 0 6px 20px rgba(178,205,52,.4);
        }
        .tm-card:hover .tm-overlay-btn {
            transform: translateY(0);
        }
        .tm-overlay-btn:hover {
            box-shadow: 0 10px 28px rgba(178,205,52,.6);
            color: #12104a;
            text-decoration: none;
        }

        /* Card body */
        .tm-card-body {
            padding: 22px 24px 26px;
            text-align: center;
        }

        /* Number badge */
        .tm-card-body .tm-num {
            display: inline-block;
            width: 28px; height: 28px;
            background: linear-gradient(135deg, rgba(178,205,52,.15), rgba(178,205,52,.08));
            border: 1.5px solid rgba(178,205,52,.4);
            border-radius: 50%;
            font-size: 11px;
            font-weight: 800;
            color: #2e2885;
            line-height: 26px;
            text-align: center;
            margin-bottom: 10px;
        }

        .tm-name {
            font-size: 19px;
            font-weight: 800;
            color: #12104a;
            margin-bottom: 6px;
            letter-spacing: -.3px;
        }

        .tm-role {
            display: inline-block;
            font-size: 12.5px;
            color: #666;
            font-weight: 500;
            line-height: 1.4;
            margin-bottom: 18px;
            padding: 4px 14px;
            background: rgba(50,47,137,.06);
            border-radius: 50px;
        }

        .tm-view-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: transparent;
            border: 1.5px solid rgba(50,47,137,.25);
            color: #2e2885;
            font-size: 13px;
            font-weight: 600;
            padding: 9px 24px;
            border-radius: 50px;
            text-decoration: none;
            transition: all .3s ease;
        }
        .tm-view-btn:hover {
            background: linear-gradient(135deg, #2e2885, #322f89);
            border-color: #2e2885;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(50,47,137,.28);
            text-decoration: none;
        }
        .tm-view-btn svg { transition: transform .3s; }
        .tm-view-btn:hover svg { transform: translateX(4px); }

        /* Staggered animation */
        .tm-col:nth-child(1) .tm-card { animation-delay: .1s; }
        .tm-col:nth-child(2) .tm-card { animation-delay: .22s; }
        .tm-col:nth-child(3) .tm-card { animation-delay: .34s; }

        /* ── Responsive ── */
        @media (max-width: 991px) {
            .tm-section { padding: 72px 0 80px; }
            .tm-blob-1, .tm-blob-2 { display: none; }
        }
        @media (max-width: 767px) {
            .tm-section { padding: 56px 0 64px; }
            .tm-header { margin-bottom: 40px; }
            .tm-photo-wrap { aspect-ratio: 4 / 3.8; }
            .tm-photo-overlay { opacity: 1; }
            .tm-overlay-btn { transform: translateY(0); }
        }
        @media (max-width: 575px) {
            .tm-card-body { padding: 18px 18px 22px; }
            .tm-name { font-size: 17px; }
        }
    </style>

    <section class="tm-section">

        <!-- Background blobs -->
        <div class="tm-blob tm-blob-1"></div>
        <div class="tm-blob tm-blob-2"></div>

        <div class="container tm-inner">

            <!-- ── Header ── -->
            <div class="tm-header text-center">
                <div class="tm-badge">
                    <span class="tm-badge-dot"></span>
                    <span class="tm-badge-text">Team Members</span>
                </div>
                <h2 class="tm-title">
                    Our Expert <span class="tm-title-accent">Lecturers</span>
                </h2>
                <p class="tm-subtitle">
                    A group of passionate educators, innovators, and professionals committed to providing an exceptional learning experience at ViAaNur Online Academy.
                </p>
                <div class="tm-divider">
                    <span class="tm-divider-dot"></span>
                </div>
            </div>

            <!-- ── Team Cards ── -->
            <div class="row g-4 justify-content-center">

                <!-- Ruheena Quraishi -->
                <div class="col-lg-4 col-md-6 tm-col">
                    <div class="tm-card">
                        <div class="tm-card-accent"></div>
                        <div class="tm-photo-wrap">
                            <img src="{{ asset('assets/images/banner/WhatsApp Image 2026-02-11 at 2.50.39 PM.jpeg') }}" alt="Ruheena Quraishi">
                            <div class="tm-photo-overlay">
                                <a href="{{ route('teams') }}" class="tm-overlay-btn">
                                    View Profile
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                        <div class="tm-card-body">
                            <div class="tm-num">01</div>
                            <h3 class="tm-name">Ruheena Quraishi</h3>
                            <span class="tm-role">Founder &amp; Lead Practitioner</span><br>
                            <a href="{{ route('teams') }}" class="tm-view-btn">
                                View More
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Aftab Anwar -->
                <div class="col-lg-4 col-md-6 tm-col">
                    <div class="tm-card">
                        <div class="tm-card-accent"></div>
                        <div class="tm-photo-wrap">
                            <img src="{{ asset('assets/images/banner/WhatsApp Image 2026-02-11 at 2.50.14 PM.jpeg') }}" alt="Aftab Anwar">
                            <div class="tm-photo-overlay">
                                <a href="{{ route('teams') }}" class="tm-overlay-btn">
                                    View Profile
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                        <div class="tm-card-body">
                            <div class="tm-num">02</div>
                            <h3 class="tm-name">Aftab Anwar</h3>
                            <span class="tm-role">Managing Director &amp; Social Media Trainer</span><br>
                            <a href="{{ route('teams') }}" class="tm-view-btn">
                                View More
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sabreena Quraishi -->
                <div class="col-lg-4 col-md-6 tm-col">
                    <div class="tm-card">
                        <div class="tm-card-accent"></div>
                        <div class="tm-photo-wrap">
                            <img src="{{ asset('assets/images/banner/WhatsApp Image 2026-02-26 at 8.29.33 PM.jpeg') }}" alt="Sabreena Quraishi">
                            <div class="tm-photo-overlay">
                                <a href="{{ route('teams') }}" class="tm-overlay-btn">
                                    View Profile
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                        <div class="tm-card-body">
                            <div class="tm-num">03</div>
                            <h3 class="tm-name">Sabreena Quraishi</h3>
                            <span class="tm-role">Early Years Lead &amp; Primary Tutor</span><br>
                            <a href="{{ route('teams') }}" class="tm-view-btn">
                                View More
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End Team Area -->

    <!-- Start Newsletter Area -->
    <style>
    /* ============================================================
       NEWSLETTER — Premium Dark
       Brand: #b2cd34 (lime) | #322f89 (deep purple)
    ============================================================ */
    @keyframes nl-fadeUp  { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
    @keyframes nl-shimmer { 0%{background-position:-200% center} 100%{background-position:200% center} }
    @keyframes nl-float   { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
    @keyframes nl-dot     { 0%,80%,100%{transform:scale(.75);opacity:.45} 40%{transform:scale(1.2);opacity:1} }
    @keyframes nl-glow    { 0%,100%{box-shadow:0 8px 28px rgba(178,205,52,.38)} 50%{box-shadow:0 14px 44px rgba(178,205,52,.62)} }

    .nl-section {
        position: relative;
        padding: 96px 0 108px;
        background: linear-gradient(140deg, #080619 0%, #120e52 30%, #1e1a6e 55%, #0f0c3a 100%);
        overflow: hidden;
    }
    .nl-section::before {
        content:''; position:absolute; inset:0;
        background:
            radial-gradient(ellipse 55% 55% at 15% 62%, rgba(178,205,52,.16) 0%, transparent 58%),
            radial-gradient(ellipse 50% 50% at 85% 18%, rgba(50,47,137,.38) 0%, transparent 55%);
        z-index:0; pointer-events:none;
    }
    .nl-section::after {
        content:''; position:absolute; inset:0;
        background-image:radial-gradient(circle, rgba(255,255,255,.04) 1px, transparent 1px);
        background-size:26px 26px;
        z-index:0; pointer-events:none;
    }
    .nl-orb { position:absolute; border-radius:50%; filter:blur(75px); pointer-events:none; z-index:0; }
    .nl-orb-1 { width:380px;height:380px; background:radial-gradient(circle,rgba(178,205,52,.18) 0%,transparent 68%); top:-100px;right:-60px; animation:nl-float 10s ease-in-out infinite; }
    .nl-orb-2 { width:300px;height:300px; background:radial-gradient(circle,rgba(50,47,137,.50) 0%,transparent 68%); bottom:-60px;left:-50px; animation:nl-float 12s ease-in-out infinite reverse; }
    .nl-inner { position:relative; z-index:1; }
    .nl-wrap { max-width:680px; margin:0 auto; text-align:center; }

    .nl-badge {
        display:inline-flex; align-items:center; gap:8px;
        background:rgba(178,205,52,.10); border:1px solid rgba(178,205,52,.30);
        border-radius:60px; padding:7px 22px; margin-bottom:24px;
        animation:nl-fadeUp .5s ease both;
    }
    .nl-badge-dot {
        width:7px;height:7px; background:#b2cd34; border-radius:50%;
        box-shadow:0 0 8px rgba(178,205,52,.65);
        animation:nl-dot 2.2s ease-in-out infinite;
    }
    .nl-badge-text { font-size:11px;font-weight:700;color:#b2cd34;letter-spacing:.8px;text-transform:uppercase; }

    .nl-title {
        font-size:clamp(28px,4.5vw,52px); font-weight:800;
        color:#fff; letter-spacing:-1.2px; margin:0 0 18px; line-height:1.1;
        animation:nl-fadeUp .6s ease both; animation-delay:.1s;
    }
    .nl-title-accent {
        background:linear-gradient(135deg,#b2cd34 0%,#d6ec50 50%,#b2cd34 100%);
        background-size:200% auto;
        -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
        animation:nl-shimmer 3.5s linear infinite;
    }
    .nl-desc {
        font-size:16px; color:rgba(255,255,255,.60); line-height:1.75;
        margin:0 0 40px;
        animation:nl-fadeUp .7s ease both; animation-delay:.2s;
    }

    .nl-form { animation:nl-fadeUp .8s ease both; animation-delay:.3s; margin-bottom:22px; }
    .nl-input-wrap {
        display:flex; align-items:center;
        background:rgba(255,255,255,.07); backdrop-filter:blur(18px);
        border:1.5px solid rgba(255,255,255,.18);
        border-radius:60px; padding:6px 6px 6px 22px;
        transition:border-color .3s, box-shadow .3s;
    }
    .nl-input-wrap:focus-within {
        border-color:rgba(178,205,52,.55);
        box-shadow:0 0 0 4px rgba(178,205,52,.10);
    }
    .nl-input-icon { color:rgba(255,255,255,.42); font-size:17px; flex-shrink:0; margin-right:12px; }
    .nl-input {
        flex:1; background:transparent; border:none; outline:none;
        font-size:15px; color:#fff; min-width:0;
        font-family:var(--fontFamily,'Poppins',sans-serif);
    }
    .nl-input::placeholder { color:rgba(255,255,255,.38); }
    .nl-btn {
        display:inline-flex; align-items:center; gap:8px;
        background:linear-gradient(135deg,#b2cd34,#c8e040);
        color:#12104a; font-size:14px; font-weight:700; letter-spacing:.2px;
        font-family:var(--fontFamily,'Poppins',sans-serif);
        padding:13px 28px; border-radius:50px; border:none; cursor:pointer;
        flex-shrink:0;
        transition:transform .35s cubic-bezier(.175,.885,.32,1.275), box-shadow .35s;
        animation:nl-glow 3s ease-in-out infinite;
    }
    .nl-btn:hover { transform:scale(1.05); box-shadow:0 12px 36px rgba(178,205,52,.55); }
    .nl-btn svg { transition:transform .3s; }
    .nl-btn:hover svg { transform:translateX(4px); }

    .nl-trust {
        display:flex; align-items:center; justify-content:center;
        gap:24px; flex-wrap:wrap;
        animation:nl-fadeUp .9s ease both; animation-delay:.4s;
    }
    .nl-trust-item {
        display:flex; align-items:center; gap:7px;
        font-size:12.5px; color:rgba(255,255,255,.48); font-weight:500;
    }
    .nl-trust-check {
        width:20px;height:20px;
        background:rgba(178,205,52,.14); border:1px solid rgba(178,205,52,.35);
        border-radius:50%; display:flex; align-items:center; justify-content:center;
        font-size:10px; color:#b2cd34; flex-shrink:0;
    }

    @media (max-width:767px) {
        .nl-section { padding:68px 0 80px; }
        .nl-input-wrap { flex-direction:column; border-radius:20px; padding:16px 18px; gap:12px; }
        .nl-input-icon { display:none; }
        .nl-input { width:100%; text-align:center; }
        .nl-btn { width:100%; justify-content:center; }
    }
    @media (max-width:575px) {
        .nl-section { padding:56px 0 64px; }
        .nl-trust { gap:14px; }
    }
    </style>

    <section class="nl-section" aria-label="Newsletter signup">
        <div class="nl-orb nl-orb-1"></div>
        <div class="nl-orb nl-orb-2"></div>
        <div class="container nl-inner">
            <div class="nl-wrap">

                <div class="nl-badge">
                    <span class="nl-badge-dot"></span>
                    <span class="nl-badge-text">Stay Updated</span>
                </div>

                <h2 class="nl-title">
                    Never Miss an <span class="nl-title-accent">Update</span>
                </h2>

                <p class="nl-desc">
                    Join 500+ students and parents. Get the latest course news, learning tips, and tutoring updates delivered straight to your inbox.
                </p>

                <form class="nl-form" onsubmit="return false;">
                    <div class="nl-input-wrap">
                        <i class="bi bi-envelope-fill nl-input-icon"></i>
                        <input type="email" class="nl-input" placeholder="Enter your email address" aria-label="Email address">
                        <button type="submit" class="nl-btn">
                            Subscribe
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </form>

                <div class="nl-trust">
                    <span class="nl-trust-item">
                        <span class="nl-trust-check"><i class="bi bi-check2"></i></span>
                        No spam, ever
                    </span>
                    <span class="nl-trust-item">
                        <span class="nl-trust-check"><i class="bi bi-check2"></i></span>
                        Unsubscribe anytime
                    </span>
                    <span class="nl-trust-item">
                        <span class="nl-trust-check"><i class="bi bi-check2"></i></span>
                        500+ readers
                    </span>
                </div>

            </div>
        </div>
    </section>
    <!-- End Newsletter Area -->


@stop
@section('js')
<script>
(function () {
    'use strict';

    /* ── Parallax on mouse move ── */
    var hero = document.getElementById('vn-hero');
    if (hero) {
        var orbs  = hero.querySelectorAll('.vn-orb');
        var decos = hero.querySelectorAll('.vn-deco');
        var imgCol = hero.querySelector('.vn-img-col');

        hero.addEventListener('mousemove', function (e) {
            var rect = hero.getBoundingClientRect();
            var cx = (e.clientX - rect.left) / rect.width  - 0.5;   /* -0.5 … 0.5 */
            var cy = (e.clientY - rect.top)  / rect.height - 0.5;

            orbs.forEach(function (el, i) {
                var depth = (i + 1) * 14;
                el.style.transform = 'translate(' + (cx * depth) + 'px,' + (cy * depth) + 'px)';
            });
            decos.forEach(function (el, i) {
                var d = (i % 3 + 1) * 8;
                el.style.transform = 'translate(' + (cx * d) + 'px,' + (cy * d) + 'px)';
            });
            if (imgCol) {
                imgCol.style.transform = 'translate(' + (cx * -10) + 'px,' + (cy * -6) + 'px)';
            }
        });

        hero.addEventListener('mouseleave', function () {
            orbs.forEach(function (el)  { el.style.transform = ''; });
            decos.forEach(function (el) { el.style.transform = ''; });
            if (imgCol) imgCol.style.transform = '';
        });
    }

    /* ── Intersection-Observer entrance animations ── */
    if ('IntersectionObserver' in window) {
        var targets = document.querySelectorAll(
            '.vn-badge, .vn-h1, .vn-desc, .vn-cta, .vn-stats, .vn-img-col'
        );
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '';
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        targets.forEach(function (el) { io.observe(el); });
    }
})();
</script>
@endsection