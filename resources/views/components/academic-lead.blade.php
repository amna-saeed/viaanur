<style>
/* ============================================================
   ACADEMIC LEAD SECTION — Premium Animated
   Brand: #b2cd34 (lime) | #322f89 (deep purple)
============================================================ */

/* ── Keyframes ── */
@keyframes al-fadeUp    { from{opacity:0;transform:translateY(32px)} to{opacity:1;transform:translateY(0)} }
@keyframes al-fadeLeft  { from{opacity:0;transform:translateX(-36px)} to{opacity:1;transform:translateX(0)} }
@keyframes al-fadeRight { from{opacity:0;transform:translateX(36px)} to{opacity:1;transform:translateX(0)} }
@keyframes al-lineDraw  { from{height:0} to{height:100%} }
@keyframes al-float     { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
@keyframes al-floatAlt  { 0%,100%{transform:translateY(0) rotate(0deg)} 50%{transform:translateY(12px) rotate(2deg)} }
@keyframes al-shimmer   { 0%{background-position:-200% center} 100%{background-position:200% center} }
@keyframes al-dot       { 0%,80%,100%{transform:scale(.75);opacity:.45} 40%{transform:scale(1.2);opacity:1} }
@keyframes al-glow      { 0%,100%{box-shadow:0 0 20px rgba(178,205,52,.3)} 50%{box-shadow:0 0 40px rgba(178,205,52,.6)} }
@keyframes al-spin      { to{transform:rotate(360deg)} }
@keyframes al-pulse     { 0%,100%{opacity:.6;transform:scale(1)} 50%{opacity:1;transform:scale(1.05)} }
@keyframes al-quoteIn   { from{opacity:0;transform:scale(.8) translateY(-10px)} to{opacity:1;transform:scale(1) translateY(0)} }

/* ── Section ── */
.al-section {
    position: relative;
    padding: 90px 0 100px;
    background: linear-gradient(155deg, #f9f7ff 0%, #ffffff 40%, #f5fcec 75%, #fafafa 100%);
    overflow: hidden;
}

/* Dot grid */
.al-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(50,47,137,.055) 1px, transparent 1px);
    background-size: 30px 30px;
    z-index: 0;
    pointer-events: none;
}

/* Colour blobs */
.al-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(85px);
    pointer-events: none;
    z-index: 0;
}
.al-orb-1 { width:440px;height:440px; background:rgba(50,47,137,.08); top:-120px;right:0; animation:al-pulse 10s ease-in-out infinite; }
.al-orb-2 { width:340px;height:340px; background:rgba(178,205,52,.10); bottom:-90px;left:-60px; animation:al-pulse 13s ease-in-out infinite reverse; }

/* Decorative spinning ring (top-right) */
.al-deco-ring {
    position: absolute;
    width: 130px; height: 130px;
    border: 2px solid rgba(178,205,52,.18);
    border-radius: 50%;
    top: 8%; right: 4%;
    z-index: 0;
    pointer-events: none;
    animation: al-spin 22s linear infinite;
}
.al-deco-ring::before {
    content:''; position:absolute;
    width:8px; height:8px;
    background:rgba(178,205,52,.7);
    border-radius:50%;
    top:-4px; left:50%;
    transform:translateX(-50%);
    box-shadow:0 0 8px rgba(178,205,52,.6);
}

/* ── Layout ── */
.al-inner {
    position: relative;
    z-index: 1;
    display: grid;
    grid-template-columns: 420px 1fr;
    gap: 72px;
    align-items: center;
}

/* ── Image column ── */
.al-media { position: relative; }

.al-img-wrapper {
    position: relative;
    display: inline-block;
    width: 100%;
}

/* Animated glow ring behind image */
.al-img-glow {
    position: absolute;
    inset: -4px;
    border-radius: 26px;
    background: linear-gradient(135deg, rgba(178,205,52,.45), rgba(50,47,137,.25), rgba(178,205,52,.15));
    z-index: 0;
    filter: blur(10px);
    animation: al-glow 4s ease-in-out infinite;
}

/* Main image */
.al-img {
    position: relative;
    z-index: 1;
    width: 100%;
    max-height: 540px;
    object-fit: cover;
    object-position: center top;
    display: block;
    border-radius: 22px;
    box-shadow: 0 28px 70px rgba(50,47,137,.18), 0 8px 24px rgba(0,0,0,.08);
    animation: al-fadeLeft .8s ease both;
    animation-delay: .2s;
    transition: transform .6s ease;
}
.al-img-wrapper:hover .al-img { transform: scale(1.02); }

/* Gradient corner accent */
.al-img-corner {
    position: absolute;
    bottom: -14px; right: -14px;
    width: 90px; height: 90px;
    background: linear-gradient(135deg, #b2cd34, #322f89);
    border-radius: 6px;
    z-index: 0;
    opacity: .90;
}
.al-img-corner::after {
    content:'';
    position:absolute;
    inset:8px;
    border:1.5px solid rgba(255,255,255,.35);
    border-radius:3px;
}

/* Floating badge — experience */
.al-badge-exp {
    position: absolute;
    bottom: 36px; left: -22px;
    background: #fff;
    border-radius: 16px;
    padding: 14px 18px;
    box-shadow: 0 16px 40px rgba(50,47,137,.18);
    display: flex; align-items: center; gap: 12px;
    z-index: 3;
    animation: al-float 5.5s ease-in-out infinite;
    border: 1px solid rgba(50,47,137,.08);
    min-width: 160px;
}
.al-badge-exp-icon {
    width: 44px; height: 44px;
    background: linear-gradient(135deg, #b2cd34, #c8e040);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; color: #12104a;
    box-shadow: 0 6px 16px rgba(178,205,52,.4);
    flex-shrink: 0;
}
.al-badge-exp-num {
    display: block;
    font-size: 22px; font-weight: 800; color: #12104a; line-height: 1;
}
.al-badge-exp-lbl {
    display: block;
    font-size: 11px; font-weight: 600; color: #888; letter-spacing: .3px;
}

/* Floating badge — students */
.al-badge-students {
    position: absolute;
    top: 28px; right: -22px;
    background: linear-gradient(135deg, #322f89, #4845a8);
    border-radius: 14px;
    padding: 12px 16px;
    box-shadow: 0 14px 36px rgba(50,47,137,.30);
    display: flex; align-items: center; gap: 10px;
    z-index: 3;
    animation: al-floatAlt 6.5s ease-in-out infinite;
    min-width: 150px;
}
.al-badge-students i {
    font-size: 20px; color: #b2cd34;
}
.al-badge-students span {
    font-size: 13px; font-weight: 700; color: #fff; white-space: nowrap;
}

/* Dot grid watermark on image */
.al-img-dots {
    position: absolute;
    bottom: -24px; left: -24px;
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 8px;
    z-index: 0;
    opacity: .25;
    pointer-events: none;
}
.al-img-dots span {
    width: 5px; height: 5px;
    background: #322f89;
    border-radius: 50%;
    display: block;
}

/* ── Content column ── */
.al-content { position: relative; padding-left: 20px; }

/* Badge pill */
.al-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(50,47,137,.07);
    border: 1px solid rgba(50,47,137,.22);
    border-radius: 60px;
    padding: 7px 22px;
    margin-bottom: 22px;
    animation: al-fadeUp .5s ease both;
    animation-delay: .3s;
    opacity: 0;
}
.al-eyebrow.al-animate { opacity: 1; }
.al-eyebrow-dot {
    width: 7px; height: 7px;
    background: #322f89; border-radius: 50%;
    box-shadow: 0 0 8px rgba(50,47,137,.55);
    animation: al-dot 2.2s ease-in-out infinite;
}
.al-eyebrow-text {
    font-size: 11px; font-weight: 700;
    color: #322f89; letter-spacing: .9px; text-transform: uppercase;
}

/* Heading */
.al-heading {
    font-size: clamp(26px, 3.5vw, 42px);
    font-weight: 800;
    color: #12104a;
    line-height: 1.12;
    letter-spacing: -1px;
    margin-bottom: 28px;
    animation: al-fadeUp .6s ease both;
    animation-delay: .4s;
    opacity: 0;
}
.al-heading.al-animate { opacity: 1; }
.al-heading-accent {
    background: linear-gradient(135deg, #322f89 0%, #b2cd34 55%, #322f89 100%);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: al-shimmer 4s linear infinite;
}

/* Quote block with animated left line */
.al-quote-wrap {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
    animation: al-fadeUp .7s ease both;
    animation-delay: .5s;
    opacity: 0;
}
.al-quote-wrap.al-animate { opacity: 1; }

/* Animated vertical line */
.al-vline-track {
    width: 5px;
    border-radius: 4px;
    background: rgba(50,47,137,.10);
    flex-shrink: 0;
    position: relative;
    overflow: hidden;
}
.al-vline-fill {
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 0;
    background: linear-gradient(180deg, #b2cd34 0%, #7a9e4a 40%, #5c7a8a 70%, #322f89 100%);
    border-radius: 4px;
    transition: height 1.4s cubic-bezier(.22,.61,.36,1);
    box-shadow: 0 0 14px rgba(178,205,52,.4), 0 0 28px rgba(50,47,137,.2);
}
.al-vline-fill.al-line-animate { height: 100%; }

/* Glow alongside line */
.al-vline-glow {
    position: absolute;
    top: 0; left: -8px; right: -8px;
    height: 100%;
    background: linear-gradient(90deg, rgba(178,205,52,.12), rgba(50,47,137,.07));
    filter: blur(6px);
    border-radius: 4px;
}

/* Quote mark */
.al-quote-body { flex: 1; padding-top: 4px; }
.al-quote-mark {
    display: block;
    font-size: 60px;
    font-family: Georgia, 'Times New Roman', serif;
    font-weight: 700;
    line-height: .8;
    background: linear-gradient(135deg, rgba(178,205,52,.55), rgba(50,47,137,.35));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 8px;
    animation: al-quoteIn .6s ease both;
    animation-delay: .6s;
}

/* Message text */
.al-message {
    font-size: 15.5px;
    line-height: 1.85;
    color: #4a4a5a;
    margin: 0;
}

/* Divider */
.al-divider {
    height: 1px;
    background: linear-gradient(90deg, rgba(50,47,137,.20), rgba(178,205,52,.20), transparent);
    margin-bottom: 24px;
    border-radius: 1px;
    animation: al-fadeUp .75s ease both;
    animation-delay: .6s;
    opacity: 0;
}
.al-divider.al-animate { opacity: 1; }

/* Meta / signature */
.al-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    animation: al-fadeUp .8s ease both;
    animation-delay: .7s;
    opacity: 0;
}
.al-meta.al-animate { opacity: 1; }

.al-meta-left { display: flex; flex-direction: column; gap: 3px; }
.al-meta-name {
    font-size: 18px; font-weight: 800;
    color: #12104a; letter-spacing: -.2px;
}
.al-meta-role {
    font-size: 12px; color: #888; font-weight: 500;
}

/* Signature */
.al-signature {
    font-family: 'Segoe Script', 'Brush Script MT', cursive;
    font-size: 26px;
    font-style: italic;
    background: linear-gradient(135deg, #322f89, #5651b5);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* ── Responsive ── */
@media (max-width: 1199px) {
    .al-inner { grid-template-columns: 360px 1fr; gap: 54px; }
}
@media (max-width: 991px) {
    .al-section { padding: 70px 0 80px; }
    .al-inner {
        grid-template-columns: 1fr;
        gap: 48px;
    }
    .al-media { max-width: 420px; margin: 0 auto; }
    .al-badge-exp { left: -10px; }
    .al-badge-students { right: -10px; }
    .al-deco-ring { display: none; }
}
@media (max-width: 767px) {
    .al-section { padding: 52px 0 64px; }
    .al-content { padding-left: 0; }
    .al-badge-exp, .al-badge-students { display: none; }
    .al-img-corner { width: 64px; height: 64px; bottom: -10px; right: -10px; }
    .al-orb-1, .al-orb-2 { display: none; }
    .al-message { font-size: 14.5px; line-height: 1.75; }
    .al-quote-mark { font-size: 44px; }
    .al-meta { flex-direction: column; align-items: flex-start; }
}
@media (max-width: 480px) {
    .al-img-dots { display: none; }
    .al-vline-track { display: none; }
    .al-quote-wrap { gap: 12px; }
}
</style>

<section class="al-section">

    <!-- Background -->
    <div class="al-orb al-orb-1"></div>
    <div class="al-orb al-orb-2"></div>
    <div class="al-deco-ring"></div>

    <div class="container">
        <div class="al-inner">

            <!-- ── Image column ── -->
            <div class="al-media">
                <div class="al-img-wrapper">

                    <!-- Glow behind image -->
                    <div class="al-img-glow"></div>

                    <!-- Main photo -->
                    <img src="{{ asset('assets/images/banner/WhatsApp Image 2026-02-11 at 2.50.39 PM.jpeg') }}"
                         alt="Ruheena Quraishi — Founder & Academic Lead"
                         class="al-img">

                    <!-- Corner accent -->
                    <div class="al-img-corner"></div>

                    <!-- Floating: Experience badge (bottom-left) -->
                    <div class="al-badge-exp">
                        <div class="al-badge-exp-icon">
                            <i class="bi bi-award-fill"></i>
                        </div>
                        <div>
                            <span class="al-badge-exp-num">10+</span>
                            <span class="al-badge-exp-lbl">Years Experience</span>
                        </div>
                    </div>

                    <!-- Floating: Students badge (top-right) -->
                    <!-- Dot grid watermark -->
                    <div class="al-img-dots">
                        @for($i=0;$i<25;$i++)<span></span>@endfor
                    </div>

                </div>
            </div>

            <!-- ── Content column ── -->
            <div class="al-content">

                <!-- Eyebrow badge -->
                <div class="al-eyebrow">
                    <span class="al-eyebrow-dot"></span>
                    <span class="al-eyebrow-text">Founder &amp; Academic Lead</span>
                </div>

                <!-- Heading -->
                <h2 class="al-heading">
                    Where Excellence<br>
                    <span class="al-heading-accent">Meets Purpose</span>
                </h2>

                <!-- Quote block with animated line -->
                <div class="al-quote-wrap">
                    <div class="al-vline-track">
                        <div class="al-vline-fill"></div>
                        <div class="al-vline-glow"></div>
                    </div>
                    <div class="al-quote-body">
                        <span class="al-quote-mark">"</span>
                        <p class="al-message">
                            At ViAaNur Tutoring, we believe that exceptional education is never accidental — it is intentional, structured, and rooted in high standards.<br><br>
                            As Academic Lead, my vision is simple: to ensure that every learner receives teaching that is academically rigorous, carefully personalised, and delivered with clarity and care. Whether a child is building foundational skills, closing gaps, or striving for the highest grades, our approach is always purposeful and aspirational.<br><br>
                            With over a decade of experience across both secondary and primary education, and having led whole-school mathematics improvement, I understand the importance of curriculum coherence, expert instruction, and consistent expectations. These principles underpin everything we do at ViAaNur.<br><br>
                            We do not believe in shortcuts. We believe in strong foundations, precise teaching, and developing confident, independent learners who truly understand what they are learning.
                        </p>
                    </div>
                </div>

                <!-- Divider -->
                <div class="al-divider"></div>

                <!-- Meta + signature -->
                <div class="al-meta">
                    <div class="al-meta-left">
                        <span class="al-meta-name">R. Quraishi</span>
                        <span class="al-meta-role">Founder &amp; Academic Lead, ViAaNur Tutoring</span>
                    </div>
                    <span class="al-signature">Ruheena Quraishi</span>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
(function () {
    /* Staggered entrance + animated vertical line via IntersectionObserver */
    var section = document.querySelector('.al-section');
    if (!section) return;

    var targets = section.querySelectorAll(
        '.al-eyebrow, .al-heading, .al-quote-wrap, .al-divider, .al-meta'
    );
    var lineFill = section.querySelector('.al-vline-fill');
    var triggered = false;

    function trigger() {
        if (triggered) return;
        triggered = true;

        /* Stagger each animated element */
        targets.forEach(function (el) {
            el.classList.add('al-animate');
        });

        /* Animate the vertical line with a slight delay */
        if (lineFill) {
            setTimeout(function () {
                lineFill.classList.add('al-line-animate');
            }, 550);
        }
    }

    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting) { trigger(); io.disconnect(); }
        }, { threshold: 0.15 });
        io.observe(section);
    } else {
        trigger(); /* fallback for old browsers */
    }
})();
</script>
