<!-- Start Why Choose Us Section -->
<style>
/* ============================================================
   WHY CHOOSE US — ViAaNur Tutoring
   Brand: #b2cd34 (lime-green) | #322f89 / #2e2885 (deep purple)
============================================================ */

/* ── Keyframes ── */
@keyframes mv-fadeUp   { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }
@keyframes mv-scaleIn  { from{opacity:0;transform:scale(.85)}        to{opacity:1;transform:scale(1)}     }
@keyframes mv-float    { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-14px)} }
@keyframes mv-spin     { to{transform:rotate(360deg)} }
@keyframes mv-shimmer  { 0%{background-position:-200% center} 100%{background-position:200% center} }
@keyframes mv-glowLine { 0%,100%{opacity:.5} 50%{opacity:1} }

/* ── Section wrapper ── */
.mv-section {
    position: relative;
    padding: 90px 0 100px;
    margin-top: 0;
    overflow: hidden;
}

/* Background image layer */
.mv-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url('assets/images/banner/Banner.webp') center top / cover no-repeat;
    z-index: 0;
}

/* Dark gradient overlay */
.mv-section::after {
    content: '';
    position: absolute;
    inset: 0;
    background:
        linear-gradient(160deg, rgba(8,6,25,.93) 0%, rgba(18,14,76,.90) 40%, rgba(22,18,80,.88) 70%, rgba(8,6,25,.93) 100%),
        radial-gradient(ellipse 60% 50% at 50% 100%, rgba(178,205,52,.10) 0%, transparent 70%);
    z-index: 0;
}

/* Decorative floating ring */
.mv-ring {
    position: absolute;
    border: 2px solid rgba(178,205,52,.18);
    border-radius: 50%;
    pointer-events: none;
    z-index: 1;
}
.mv-ring-1 { width:180px; height:180px; top:8%;  right:6%;  animation: mv-spin 22s linear infinite; }
.mv-ring-2 { width:90px;  height:90px;  bottom:12%; left:4%; animation: mv-spin 15s linear infinite reverse; }
.mv-ring-1::before, .mv-ring-2::before {
    content:'';
    position:absolute;
    width:8px; height:8px;
    background: rgba(178,205,52,.7);
    border-radius:50%;
    top:-4px; left:50%;
    transform:translateX(-50%);
    box-shadow: 0 0 8px rgba(178,205,52,.6);
}

/* Orb blur */
.mv-orb {
    position:absolute;
    border-radius:50%;
    filter:blur(70px);
    pointer-events:none;
    z-index:1;
}
.mv-orb-1 { width:340px; height:340px; background:radial-gradient(circle,rgba(178,205,52,.14) 0%,transparent 68%); top:-60px; left:-80px; animation:mv-float 10s ease-in-out infinite; }
.mv-orb-2 { width:260px; height:260px; background:radial-gradient(circle,rgba(50,47,137,.40) 0%,transparent 68%); bottom:-40px; right:-60px; animation:mv-float 12s ease-in-out infinite reverse; }

/* ── Inner content z-index ── */
.mv-inner { position:relative; z-index:2; }

/* ── Section header ── */
.mv-header { margin-bottom: 58px; }

.mv-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(178,205,52,.10);
    border: 1px solid rgba(178,205,52,.32);
    border-radius: 60px;
    padding: 7px 22px;
    margin-bottom: 20px;
    backdrop-filter: blur(10px);
    animation: mv-fadeUp .5s ease both;
}
.mv-badge-dot {
    width:7px; height:7px;
    background:#b2cd34;
    border-radius:50%;
    box-shadow:0 0 8px rgba(178,205,52,.7);
    animation: mv-glowLine 2s ease-in-out infinite;
}
.mv-badge-text {
    font-size:11px;
    font-weight:700;
    color:#b2cd34;
    letter-spacing:.9px;
    text-transform:uppercase;
}

.mv-title {
    font-size: clamp(28px, 4vw, 46px);
    font-weight: 800;
    color: #fff;
    letter-spacing: -1px;
    margin-bottom: 18px;
    animation: mv-fadeUp .6s ease both;
    animation-delay: .1s;
}
.mv-title-accent {
    background: linear-gradient(135deg, #b2cd34 0%, #d6ec50 50%, #b2cd34 100%);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: mv-shimmer 3.5s linear infinite;
}

/* Divider */
.mv-divider {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 14px;
    animation: mv-fadeUp .7s ease both;
    animation-delay: .15s;
}
.mv-divider::before,
.mv-divider::after {
    content: '';
    width: 80px;
    height: 2px;
    background: linear-gradient(90deg, transparent, rgba(178,205,52,.55));
    border-radius: 2px;
}
.mv-divider::after { background: linear-gradient(90deg, rgba(178,205,52,.55), transparent); }
.mv-divider-icon {
    width: 44px; height: 44px;
    background: linear-gradient(135deg, #b2cd34, #c8e040);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #12104a;
    box-shadow: 0 6px 20px rgba(178,205,52,.40);
}

/* ── Cards ── */
.mv-card {
    position: relative;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 22px;
    padding: 36px 30px 32px;
    height: 100%;
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    overflow: hidden;
    transition: transform .4s cubic-bezier(.175,.885,.32,1.275),
                border-color .4s ease,
                box-shadow .4s ease;
    animation: mv-scaleIn .6s ease both;
}
.mv-card:hover {
    transform: translateY(-10px);
    border-color: rgba(178,205,52,.50);
    box-shadow: 0 24px 60px rgba(0,0,0,.35),
                0 0 0 1px rgba(178,205,52,.15);
}

/* Top accent line */
.mv-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #b2cd34, transparent);
    border-radius: 22px 22px 0 0;
    opacity: 0;
    transition: opacity .4s ease;
}
.mv-card:hover::before { opacity: 1; }

/* Large faded number */
.mv-card-num {
    position: absolute;
    top: 16px; right: 22px;
    font-size: 64px;
    font-weight: 900;
    color: rgba(255,255,255,.04);
    line-height: 1;
    pointer-events: none;
    font-family: var(--headingFontFamily, 'Poppins', sans-serif);
    transition: color .4s;
}
.mv-card:hover .mv-card-num { color: rgba(178,205,52,.07); }

/* Icon box */
.mv-icon-wrap {
    width: 58px; height: 58px;
    background: linear-gradient(135deg, rgba(178,205,52,.18), rgba(178,205,52,.08));
    border: 1.5px solid rgba(178,205,52,.35);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: #b2cd34;
    margin-bottom: 22px;
    transition: background .4s, box-shadow .4s, transform .4s;
}
.mv-card:hover .mv-icon-wrap {
    background: linear-gradient(135deg, #b2cd34, #c8e040);
    color: #12104a;
    box-shadow: 0 10px 28px rgba(178,205,52,.40);
    transform: scale(1.08);
}

/* Card title */
.mv-card-title {
    font-size: 21px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 14px;
    letter-spacing: -.3px;
}

/* Card text */
.mv-card-text {
    font-size: 14.5px;
    color: rgba(255,255,255,.65);
    line-height: 1.75;
    margin-bottom: 16px;
    overflow: hidden;
    transition: max-height .45s ease;
    max-height: 72px;   /* ~3 lines collapsed */
}
.mv-card-text.mv-expanded { max-height: 600px; }

/* Read more toggle */
.mv-rm-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
    color: #b2cd34;
    letter-spacing: .3px;
    transition: gap .3s, opacity .3s;
}
.mv-rm-btn:hover { opacity: .8; gap: 10px; }
.mv-rm-btn .mv-chev {
    font-size: 11px;
    transition: transform .35s ease;
    display: inline-block;
}
.mv-rm-btn.mv-open .mv-chev { transform: rotate(180deg); }

/* Staggered animation delays for cards */
.mv-card-col:nth-child(1) .mv-card { animation-delay: .15s; }
.mv-card-col:nth-child(2) .mv-card { animation-delay: .28s; }
.mv-card-col:nth-child(3) .mv-card { animation-delay: .41s; }

/* ── Responsive ── */
@media (max-width: 991px) {
    .mv-section { padding: 70px 0 80px; }
    .mv-ring-1, .mv-ring-2 { display: none; }
}

@media (max-width: 767px) {
    .mv-section { padding: 60px 0 70px; }
    .mv-header { margin-bottom: 40px; }
    .mv-card { padding: 28px 22px 24px; }
    .mv-card-num { font-size: 48px; }
    .mv-icon-wrap { width:50px; height:50px; font-size:22px; }
    .mv-card-title { font-size: 18px; }
    .mv-card-text { font-size: 14px; }
    .mv-orb-1, .mv-orb-2 { display: none; }
}

@media (max-width: 575px) {
    .mv-card-text { max-height: 78px; }
}
</style>

<section class="mv-section">

    <!-- Decorative rings -->
    <div class="mv-ring mv-ring-1"></div>
    <div class="mv-ring mv-ring-2"></div>

    <!-- Orb glows -->
    <div class="mv-orb mv-orb-1"></div>
    <div class="mv-orb mv-orb-2"></div>

    <div class="container mv-inner">

        <!-- ── Section Header ── -->
        <div class="mv-header text-center">
            <div class="mv-badge">
                <span class="mv-badge-dot"></span>
                <span class="mv-badge-text">Why Choose Us</span>
            </div>
            <h2 class="mv-title">
                Ethics Behind <span class="mv-title-accent">Success</span>
            </h2>
            <div class="mv-divider">
                <span class="mv-divider-icon">
                    <i class="bi bi-mortarboard-fill"></i>
                </span>
            </div>
        </div>

        <!-- ── Cards ── -->
        <div class="row g-4 justify-content-center">

            <!-- Mission -->
            <div class="col-lg-4 col-md-6 mv-card-col">
                <div class="mv-card">
                    <div class="mv-card-num">01</div>
                    <div class="mv-icon-wrap">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h4 class="mv-card-title">Mission</h4>
                    <p class="mv-card-text">
                        ViAaNur Tutoring empowers every learner through personalized, high-quality instruction that nurtures academic mastery, personal growth, and the illumination of their inner light.
                    </p>
                    <button class="mv-rm-btn" type="button">
                        Read More <i class="bi bi-chevron-down mv-chev"></i>
                    </button>
                </div>
            </div>

            <!-- Vision -->
            <div class="col-lg-4 col-md-6 mv-card-col">
                <div class="mv-card">
                    <div class="mv-card-num">02</div>
                    <div class="mv-icon-wrap">
                        <i class="bi bi-eye-fill"></i>
                    </div>
                    <h4 class="mv-card-title">Vision</h4>
                    <p class="mv-card-text">
                        ViAaNur Tutoring strives to inspire and develop future leaders by creating an empowering learning journey that strengthens each student's inner light and aligns with our commitment to Empowered Minds, Proven Results, Exceptional Futures.
                    </p>
                    <button class="mv-rm-btn" type="button">
                        Read More <i class="bi bi-chevron-down mv-chev"></i>
                    </button>
                </div>
            </div>

            <!-- Award -->
            <div class="col-lg-4 col-md-6 mv-card-col">
                <div class="mv-card">
                    <div class="mv-card-num">03</div>
                    <div class="mv-icon-wrap">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <h4 class="mv-card-title">Award</h4>
                    <p class="mv-card-text">
                        ViAaNur Tutoring is proudly recognised for exemplary personalised teaching, exceptional student mastery and achievement, and its meaningful contribution to developing empowered, confident future leaders equipped to thrive in an evolving world.
                    </p>
                    <button class="mv-rm-btn" type="button">
                        Read More <i class="bi bi-chevron-down mv-chev"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- End Why Choose Us Section -->

<script>
(function () {
    document.querySelectorAll('.mv-rm-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var text = this.previousElementSibling;
            var isOpen = text.classList.contains('mv-expanded');

            text.classList.toggle('mv-expanded', !isOpen);
            this.classList.toggle('mv-open', !isOpen);
            this.childNodes[0].textContent = isOpen ? 'Read More ' : 'Read Less ';
        });
    });
})();
</script>
