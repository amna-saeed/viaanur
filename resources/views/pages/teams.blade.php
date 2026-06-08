@extends('layout.main')
@section('content')

<style>
/* ============================================================
   TEAMS PAGE — Professional Design
   Brand: #b2cd34 (lime) | #322f89 (deep purple)
============================================================ */

/* ── Keyframes ── */
@keyframes tp-fadeUp   { from{opacity:0;transform:translateY(28px)} to{opacity:1;transform:translateY(0)} }
@keyframes tp-fadeLeft { from{opacity:0;transform:translateX(-24px)} to{opacity:1;transform:translateX(0)} }
@keyframes tp-shimmer  { 0%{background-position:-200% center} 100%{background-position:200% center} }
@keyframes tp-dot      { 0%,80%,100%{transform:scale(.75);opacity:.4} 40%{transform:scale(1.2);opacity:1} }
@keyframes tp-pulse    { 0%,100%{opacity:.5;transform:scale(1)} 50%{opacity:1;transform:scale(1.06)} }
@keyframes tp-spin     { to{transform:rotate(360deg)} }

/* ──────────────────────────────
   BANNER
────────────────────────────── */
.tp-banner {
    position: relative;
    width: 100%;
    height: 340px;
    overflow: hidden;
}
.tp-banner-img {
    width: 100%; height: 100%;
object-fit: cover;
    object-position: center 30%;
    display: block;
}
.tp-banner-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(140deg, rgb(8 6 25) 0%, rgb(18 14 76 / 91%) 45%, rgb(22 18 80 / 61%) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}
.tp-banner-content { text-align: center; }
.tp-banner-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(178,205,52,.12);
    border: 1px solid rgba(178,205,52,.35);
    border-radius: 60px;
    padding: 6px 20px;
    margin-bottom: 18px;
    animation: tp-fadeUp .5s ease both;
}
.tp-banner-badge-dot {
    width: 7px; height: 7px;
    background: #b2cd34; border-radius: 50%;
    box-shadow: 0 0 8px rgba(178,205,52,.7);
    animation: tp-dot 2s ease-in-out infinite;
}
.tp-banner-badge-text {
    font-size: 11px; font-weight: 700;
    color: #b2cd34; letter-spacing: .9px; text-transform: uppercase;
}
.tp-banner-title {
    font-size: clamp(30px, 5vw, 52px);
    font-weight: 800;
    color: #fff;
    letter-spacing: -1.5px;
    margin: 0 0 12px;
    animation: tp-fadeUp .6s ease both;
    animation-delay: .1s;
}
.tp-banner-title-accent {
    background: linear-gradient(135deg, #b2cd34 0%, #d6ec50 50%, #b2cd34 100%);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: tp-shimmer 4s linear infinite;
}
.tp-banner-sub {
    font-size: 15px; color: rgba(255,255,255,.65);
    font-weight: 400; margin: 0;
    animation: tp-fadeUp .7s ease both;
    animation-delay: .18s;
}

/* Decorative ring on banner */
.tp-banner-ring {
    position: absolute;
    width: 110px; height: 110px;
    border: 2px solid rgba(178,205,52,.18);
    border-radius: 50%;
    pointer-events: none;
    animation: tp-spin 20s linear infinite;
}
.tp-banner-ring::before {
    content:''; position:absolute;
    width:8px; height:8px;
    background:rgba(178,205,52,.7);
    border-radius:50%;
    top:-4px; left:50%;
    transform:translateX(-50%);
    box-shadow:0 0 8px rgba(178,205,52,.6);
}
.tp-banner-ring-1 { top:12%; right:8%; }
.tp-banner-ring-2 { bottom:14%; left:6%; width:72px; height:72px; animation-direction:reverse; }

/* ──────────────────────────────
   SECTION
────────────────────────────── */
.tp-section {
    position: relative;
    padding: 88px 0 100px;
    background: linear-gradient(160deg, #f8f5ff 0%, #ffffff 45%, #f2fce8 100%);
    overflow: hidden;
}
.tp-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(50,47,137,.055) 1px, transparent 1px);
    background-size: 30px 30px;
    z-index: 0;
    pointer-events: none;
}
.tp-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(90px);
    pointer-events: none;
    z-index: 0;
}
.tp-orb-1 { width:400px;height:400px; background:rgba(50,47,137,.07); top:-100px;right:-80px; animation:tp-pulse 11s ease-in-out infinite; }
.tp-orb-2 { width:320px;height:320px; background:rgba(178,205,52,.09); bottom:-80px;left:-60px; animation:tp-pulse 13s ease-in-out infinite reverse; }
.tp-inner { position:relative; z-index:1; }

/* ── Section header ── */
.tp-header { margin-bottom: 60px; animation: tp-fadeUp .55s ease both; }
.tp-hbadge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(50,47,137,.07);
    border: 1px solid rgba(50,47,137,.22);
    border-radius: 60px; padding: 7px 22px; margin-bottom: 18px;
}
.tp-hbadge-dot {
    width:7px; height:7px; background:#322f89; border-radius:50%;
    box-shadow:0 0 8px rgba(50,47,137,.55);
    animation:tp-dot 2.2s ease-in-out infinite;
}
.tp-hbadge-text { font-size:11px; font-weight:700; color:#322f89; letter-spacing:.9px; text-transform:uppercase; }
.tp-htitle {
    font-size: clamp(26px,3.8vw,44px);
    font-weight: 800; color: #12104a; letter-spacing: -1px; margin-bottom: 12px;
    animation: tp-fadeUp .65s ease both; animation-delay:.1s;
}
.tp-htitle-accent {
    background: linear-gradient(135deg, #322f89 0%, #b2cd34 55%, #322f89 100%);
    background-size: 200% auto;
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    animation: tp-shimmer 4s linear infinite;
}
.tp-hsub { font-size:15.5px; color:#666; max-width:560px; margin:0 auto; line-height:1.7; animation:tp-fadeUp .7s ease both; animation-delay:.15s; }
.tp-hdivider {
    display:flex; align-items:center; justify-content:center; gap:12px; margin-top:20px;
    animation:tp-fadeUp .75s ease both; animation-delay:.2s;
}
.tp-hdivider::before { content:''; width:64px; height:2px; background:linear-gradient(90deg,transparent,rgba(50,47,137,.35)); border-radius:2px; }
.tp-hdivider::after  { content:''; width:64px; height:2px; background:linear-gradient(90deg,rgba(50,47,137,.35),transparent); border-radius:2px; }
.tp-hdivider-icon {
    width:38px; height:38px;
    background:linear-gradient(135deg,#322f89,#5651b5);
    border-radius:50%; display:flex; align-items:center; justify-content:center;
    font-size:15px; color:#fff;
    box-shadow:0 6px 18px rgba(50,47,137,.30);
}

/* ── Team Cards ── */
.tp-cards { display:flex; flex-direction:column; gap:32px; }

.tp-card {
    background: #fff;
    border: 1px solid rgba(50,47,137,.08);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 4px 28px rgba(50,47,137,.08);
    display: grid;
    grid-template-columns: 280px 1fr;
    transition: transform .4s cubic-bezier(.175,.885,.32,1.275),
                box-shadow .4s ease,
                border-color .4s ease;
    animation: tp-fadeUp .6s ease both;
}
.tp-card:nth-child(1) { animation-delay:.1s; }
.tp-card:nth-child(2) { animation-delay:.2s; }
.tp-card:nth-child(3) { animation-delay:.3s; }
.tp-card:nth-child(4) { animation-delay:.4s; }
.tp-card:nth-child(5) { animation-delay:.5s; }
.tp-card:nth-child(6) { animation-delay:.6s; }

.tp-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 55px rgba(50,47,137,.16), 0 0 0 2px rgba(178,205,52,.25);
    border-color: rgba(178,205,52,.35);
}

/* Left accent bar */
.tp-card::before {
    content:'';
    position:absolute;
    top:0; left:0; bottom:0;
    width:4px;
    background: linear-gradient(180deg, #b2cd34, #322f89);
    opacity:.55;
    transition: opacity .3s;
    border-radius:0 0 0 24px;
}
.tp-card { position:relative; } /* ensure ::before positions correctly */
.tp-card:hover::before { opacity:1; }

/* ── Photo side ── */
.tp-card-media {
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #f0ecff, #e8f5e0);
}
.tp-card-photo {
    width: 100%; height: 100%;
    object-fit: cover;
    object-position: top center;
    display: block;
    transition: transform .6s ease;
    min-height: 320px;
}
.tp-card:hover .tp-card-photo { transform: scale(1.04); }

/* Number badge */
.tp-card-num {
    position: absolute;
    top: 16px; left: 16px;
    width: 36px; height: 36px;
    background: linear-gradient(135deg, #b2cd34, #c8e040);
    border-radius: 10px;
    font-size: 13px; font-weight: 800; color: #12104a;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 14px rgba(178,205,52,.45);
    z-index: 2;
}

/* Photo overlay gradient at bottom */
.tp-card-media::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 80px;
    background: linear-gradient(to top, rgba(50,47,137,.35), transparent);
    pointer-events: none;
}

/* ── Content side ── */
.tp-card-body {
    padding: 32px 36px 28px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

/* Role badge */
.tp-card-role {
    display: inline-block;
    background: rgba(50,47,137,.07);
    border: 1px solid rgba(50,47,137,.20);
    border-radius: 50px;
    padding: 5px 16px;
    font-size: 11.5px; font-weight: 700;
    color: #322f89; letter-spacing: .4px;
    margin-bottom: 14px;
    width: fit-content;
}

/* Name */
.tp-card-name {
    font-size: 22px; font-weight: 800;
    color: #12104a; letter-spacing: -.4px;
    margin-bottom: 16px; line-height: 1.2;
}

/* Bio text */
.tp-card-bio {
    font-size: 14.5px;
    color: #555;
    line-height: 1.78;
    margin-bottom: 20px;
    max-height: 88px;
    overflow: hidden;
    transition: max-height .5s cubic-bezier(.4,0,.2,1);
}
.tp-card-bio.tp-expanded { max-height: 2000px; }

/* Divider above button */
.tp-card-sep {
    height: 1px;
    background: linear-gradient(90deg, rgba(50,47,137,.15), rgba(178,205,52,.15), transparent);
    margin-bottom: 18px;
    border-radius: 1px;
}

/* Read More button */
.tp-rm-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: transparent;
    border: 1.5px solid rgba(50,47,137,.25);
    color: #322f89;
    font-size: 13px; font-weight: 600;
    padding: 9px 22px;
    border-radius: 50px;
    cursor: pointer;
    transition: all .3s ease;
    width: fit-content;
    font-family: var(--fontFamily, 'Poppins', sans-serif);
}
.tp-rm-btn:hover {
    background: #322f89;
    border-color: #322f89;
    color: #fff;
    box-shadow: 0 8px 22px rgba(50,47,137,.28);
    transform: translateY(-2px);
}
.tp-rm-btn .tp-chev {
    font-size: 11px;
    transition: transform .35s ease;
    display: inline-block;
}
.tp-rm-btn.tp-open .tp-chev { transform: rotate(180deg); }
.tp-rm-btn.tp-open {
    background: rgba(50,47,137,.08);
    border-color: rgba(50,47,137,.30);
}

/* ── Responsive ── */
@media (max-width: 991px) {
    .tp-banner { height: 280px; }
    .tp-section { padding: 68px 0 80px; }
    .tp-card { grid-template-columns: 220px 1fr; }
    .tp-card-photo { min-height: 260px; }
    .tp-card-body { padding: 24px 26px 22px; }
}
@media (max-width: 767px) {
    .tp-banner { height: 230px; }
    .tp-banner-ring-1, .tp-banner-ring-2 { display: none; }
    .tp-section { padding: 52px 0 64px; }
    .tp-header { margin-bottom: 44px; }
    .tp-orb-1, .tp-orb-2 { display: none; }
    .tp-card { grid-template-columns: 1fr; }
    .tp-card-media { height: 260px; }
    .tp-card-photo { min-height: 260px; }
    .tp-card::before { width:100%; height:4px; bottom:auto; border-radius:24px 24px 0 0; }
    .tp-card-body { padding: 22px 22px 20px; }
    .tp-card-name { font-size: 19px; }
    .tp-cards { gap: 22px; }
}
@media (max-width: 480px) {
    .tp-card-body { padding: 18px 18px 18px; }
    .tp-card-bio { font-size: 13.5px; }
}
</style>

<!-- ── Premium Banner ── -->
<div class="tp-banner">
    <!-- <img src="{{ asset('assets/images/banner/ourteam.webp') }}" alt="Our Team" class="tp-banner-img"> -->
    <div class="tp-banner-overlay">
        <div class="container tp-banner-content">
            <div class="tp-banner-badge">
                <span class="tp-banner-badge-dot"></span>
                <span class="tp-banner-badge-text">Meet Our Educators</span>
            </div>
            <h1 class="tp-banner-title">
                Our Expert <span class="tp-banner-title-accent">Team</span>
            </h1>
            <p class="tp-banner-sub">Passionate educators dedicated to every learner's success</p>
        </div>
    </div>
    <div class="tp-banner-ring tp-banner-ring-1"></div>
    <div class="tp-banner-ring tp-banner-ring-2"></div>
</div>

<!-- ── Team Section ── -->
<section class="tp-section">
    <div class="tp-orb tp-orb-1"></div>
    <div class="tp-orb tp-orb-2"></div>

    <div class="container tp-inner">

        <!-- Section header -->
        <div class="tp-header text-center">
            <div class="tp-hbadge">
                <span class="tp-hbadge-dot"></span>
                <span class="tp-hbadge-text">Our Team</span>
            </div>
            <h2 class="tp-htitle">
                The Experts Behind <span class="tp-htitle-accent">Every Success</span>
            </h2>
            <p class="tp-hsub">A dedicated team of qualified educators, each bringing deep expertise and genuine passion to every learner's journey.</p>
            <div class="tp-hdivider">
                <span class="tp-hdivider-icon"><i class="bi bi-people-fill"></i></span>
            </div>
        </div>

        <!-- Team cards -->
        <div class="tp-cards">

            <!-- 1. Ruheena Quraishi -->
            <div class="tp-card">
                <div class="tp-card-media">
                    <div class="tp-card-num">01</div>
                    <img class="tp-card-photo" src="{{ asset('assets/images/banner/WhatsApp Image 2026-02-11 at 2.50.39 PM.jpeg') }}" alt="Ms. Ruheena Quraishi">
                </div>
                <div class="tp-card-body">
                    <span class="tp-card-role">Founder &amp; Lead Practitioner</span>
                    <h3 class="tp-card-name">Ms. Ruheena Quraishi</h3>
                    <p class="tp-card-bio">
                        Ruheena is the Founder and Academic Lead of ViAaNur Tutoring, bringing over 10 years of teaching experience and Qualified Teacher Status (QTS) to the organisation. With a specialist background in Secondary Mathematics, she possesses deep subject expertise and a comprehensive understanding of curriculum progression, assessment frameworks, and examination standards.<br><br>
                        Her career later transitioned into Primary education, where she spent eight years teaching across all year groups and serving as Maths Lead for approximately five years. In this leadership capacity, she drove whole-school improvement, embedded mastery-based pedagogy, and secured measurable gains in pupil attainment and confidence.<br><br>
                        Ruheena has consistently transformed the outcomes of private tuition students, supporting learners to significantly improve their grades, close longstanding gaps, and surpass expectations through structured, diagnostic, and highly personalised teaching.<br><br>
                        She has completed the National Professional Qualification in Leading Teacher Development (NPQLTD), strengthening her expertise in instructional coaching, curriculum design, and evidence-informed practice. As Academic Lead, she is responsible for designing ViAaNur's curriculum frameworks, quality-assuring teaching standards, and training and mentoring all tutors, ensuring that every learner receives provision of the highest calibre.<br><br>
                        As an all-through practitioner, she works confidently with pupils from early primary through to GCSE level, supporting struggling learners, secure mathematicians, and high-achieving students seeking depth and distinction. Her approach combines academic rigour, clarity of instruction, and high expectations with warmth and encouragement.<br><br>
                        Beyond her professional role, Ms Ruheena is a new mum, bringing empathy, patience, and perspective to her work in nurturing confident, capable, and resilient learners.
                    </p>
                    <div class="tp-card-sep"></div>
                    <button class="tp-rm-btn" type="button">
                        Read More <i class="bi bi-chevron-down tp-chev"></i>
                    </button>
                </div>
            </div>

            <!-- 2. Aftab Anwar -->
            <div class="tp-card">
                <div class="tp-card-media">
                    <div class="tp-card-num">02</div>
                    <img class="tp-card-photo" src="{{ asset('assets/images/banner/WhatsApp Image 2026-02-11 at 2.50.14 PM.jpeg') }}" alt="Mr. Aftab Anwar">
                </div>
                <div class="tp-card-body">
                    <span class="tp-card-role">Managing Director &amp; Social Media Studies Trainer</span>
                    <h3 class="tp-card-name">Mr. Aftab Anwar</h3>
                    <p class="tp-card-bio">
                        Aftab serves as the Managing Director of ViAaNur Tutoring, where he provides strategic leadership and oversees the day-to-day operations of the organisation. In his role as Managing Director, he is responsible for ensuring the smooth running of services, maintaining high professional standards, and driving the long-term vision and growth of ViAaNur Tutoring.<br><br>
                        Born in Saudi Arabia and raised between Pakistan and Saudi Arabia, Aftab brings a strong international perspective to his work. He is a well-established social media personality across these regions, with a multi-million following across multiple platforms. His success in the digital space is underpinned by a deep understanding of content creation, audience engagement, and brand development.<br><br>
                        Passionate about empowering others, Aftab is committed to passing on his expertise to the next generation of content creators. He has trained and mentored numerous individuals, many of whom have gone on to become highly recognised personalities within the social media industry.<br><br>
                        Through his leadership and training, Aftab supports ViAaNur Tutoring's mission to deliver an elite education experience, combining professional excellence with real-world, future-focused skills.
                    </p>
                    <div class="tp-card-sep"></div>
                    <button class="tp-rm-btn" type="button">
                        Read More <i class="bi bi-chevron-down tp-chev"></i>
                    </button>
                </div>
            </div>

            <!-- 3. Sabreena Quraishi -->
            <div class="tp-card">
                <div class="tp-card-media">
                    <div class="tp-card-num">03</div>
                    <img class="tp-card-photo" src="{{ asset('assets/images/banner/WhatsApp Image 2026-02-26 at 8.29.33 PM.jpeg') }}" alt="Ms. Sabreena Quraishi">
                </div>
                <div class="tp-card-body">
                    <span class="tp-card-role">Early Years Lead &amp; Primary Tutor</span>
                    <h3 class="tp-card-name">Ms. Sabreena Quraishi</h3>
                    <p class="tp-card-bio">
                        Sabreena is a qualified Pharmacist who remains deeply committed to continuous professional development, ensuring her knowledge and practice are consistently aligned with the latest guidance and the highest professional standards. Her background reflects precision, structure, and a strong sense of responsibility — qualities that strongly shape her thoughtful and effective approach to tutoring.<br><br>
                        As part of the ViAaNur Tutoring team, Sabreena brings a nurturing yet purposeful approach, particularly well suited to early years and primary learners. She prioritises strong foundations, clear progression, and personalised support, ensuring every learner feels supported, appropriately challenged, and genuinely valued.<br><br>
                        Her combined experience as a healthcare professional and educator enables her to deliver an elite education experience that balances academic excellence with care, high expectations, and professional insight.
                    </p>
                    <div class="tp-card-sep"></div>
                    <button class="tp-rm-btn" type="button">
                        Read More <i class="bi bi-chevron-down tp-chev"></i>
                    </button>
                </div>
            </div>

            <!-- 4. Amina Begum -->
            <div class="tp-card">
                <div class="tp-card-media">
                    <div class="tp-card-num">04</div>
                    <img class="tp-card-photo" src="{{ asset('assets/images/banner/WhatsApp Image 2026-02-11 at 3.36.58 PM.jpeg') }}" alt="Ms. Amina Begum">
                </div>
                <div class="tp-card-body">
                    <span class="tp-card-role">Islamic Studies Lead Tutor &amp; Teaching Assistant</span>
                    <h3 class="tp-card-name">Ms. Amina Begum</h3>
                    <p class="tp-card-bio">
                        Amina is a highly experienced Teaching Assistant with over 10 years of expertise in Key Stage 2 within primary education. She holds a recognised Teaching Assistant qualification and has extensive experience working across Key Stage 1 and Reception, supporting pupils in all areas of learning, including those with Special Educational Needs (SEN).<br><br>
                        She has spent four years working in Year 6, gaining substantial experience in preparing pupils for SATs. This includes delivering targeted and personalised interventions to support a wide range of learners, from lower-attaining pupils to higher-ability learners. She is confident in implementing intervention programmes, monitoring pupil progress, and providing effective feedback to class teachers.<br><br>
                        Amina has developed a strong skill set essential to effective classroom support, including behaviour management, differentiation, one-to-one and small-group support, effective communication, safeguarding awareness, and classroom organisation.<br><br>
                        She is highly adaptable and experienced in working with children of all abilities, supporting both academic progress and emotional and social development. She provides pastoral support and equips pupils with practical strategies to build confidence, resilience, and independence in their learning.<br><br>
                        In addition to her role in mainstream education, Amina is a qualified Islamic Studies teacher, holding formal qualifications in Islamic studies and jurisprudence. She brings a nurturing and holistic approach to her teaching, offering guidance, life skills, and age-appropriate instruction. She is currently undertaking a counselling course, reflecting her strong interest in emotional wellbeing.
                    </p>
                    <div class="tp-card-sep"></div>
                    <button class="tp-rm-btn" type="button">
                        Read More <i class="bi bi-chevron-down tp-chev"></i>
                    </button>
                </div>
            </div>

            <!-- 5. Nargis Jamadar -->
            <div class="tp-card">
                <div class="tp-card-media">
                    <div class="tp-card-num">05</div>
                    <img class="tp-card-photo" src="{{ asset('assets/images/banner/WhatsApp Image 2026-02-11 at 2.51.11 PM.jpeg') }}" alt="Ms. Nargis Jamadar">
                </div>
                <div class="tp-card-body">
                    <span class="tp-card-role">Specialist ESOL &amp; Primary Tutor</span>
                    <h3 class="tp-card-name">Ms. Nargis Jamadar</h3>
                    <p class="tp-card-bio">
                        Nargis is a supportive and experienced Primary School Tutor with extensive experience working in classroom settings, delivering high-quality English teaching and targeted interventions. She supports pupils through one-to-one and small-group sessions, helping to build confidence and close learning gaps in phonics, reading, comprehension and writing.<br><br>
                        In addition to her work with children, Nargis is a specialist ESOL tutor for adult learners, with many years of experience supporting adults to develop their English language skills for everyday communication, work, and integration. She works closely with learners to tailor support to individual goals and starting points, ensuring progress is both meaningful and sustainable.<br><br>
                        Nargis is known for her patient, encouraging, and nurturing approach, creating a positive and inclusive learning environment where learners of all ages feel confident, supported, and motivated. Her teaching is carefully structured and responsive, enabling both children and adults to make sustained progress while developing independence and self-belief.<br><br>
                        As part of the ViAaNur Tutoring team, Nargis delivers an elite education experience that balances academic rigour, personalised support, and high expectations with warmth and care.
                    </p>
                    <div class="tp-card-sep"></div>
                    <button class="tp-rm-btn" type="button">
                        Read More <i class="bi bi-chevron-down tp-chev"></i>
                    </button>
                </div>
            </div>

            <!-- 6. Hani Hassan -->
            <div class="tp-card">
                <div class="tp-card-media">
                    <div class="tp-card-num">06</div>
                    <img class="tp-card-photo" src="{{ asset('assets/images/banner/WhatsApp Image 2026-02-11 at 3.38.52 PM.jpeg') }}" alt="Ms. Hani Hassan">
                </div>
                <div class="tp-card-body">
                    <span class="tp-card-role">Teaching Assistant</span>
                    <h3 class="tp-card-name">Ms. Hani Hassan</h3>
                    <p class="tp-card-bio">
                        Hani Hassan is a dedicated Teaching Assistant with several years of experience supporting pupils within primary school settings. She has developed extensive experience working with children with Special Educational Needs (SEN), with particular expertise in supporting pupils on the Autism Spectrum.<br><br>
                        Hani is highly skilled in providing individualised support, adapting learning activities, and responding sensitively to pupils' emotional and behavioural needs. She understands the importance of structure, consistency, and clear communication, and works closely with class teachers and support staff to ensure each child can access learning in a way that suits them best.<br><br>
                        Known for her calm, patient, and always-smiling demeanour, Hani quickly builds strong, trusting relationships with her learners. Her approachable nature allows children to feel safe, understood, and confident, which is especially vital for pupils who may find learning environments challenging.<br><br>
                        As part of the ViAaNur Tutoring team, Hani brings a nurturing and compassionate approach, supporting not only academic progress but also pupils' emotional wellbeing, independence, and self-confidence, ensuring every learner feels valued and supported.
                    </p>
                    <div class="tp-card-sep"></div>
                    <button class="tp-rm-btn" type="button">
                        Read More <i class="bi bi-chevron-down tp-chev"></i>
                    </button>
                </div>
            </div>

        </div><!-- /.tp-cards -->
    </div><!-- /.container -->
</section>

@include('components.testimonial')

@stop
@section('js')
<script>
(function () {
    document.querySelectorAll('.tp-rm-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var bio   = this.previousElementSibling.previousElementSibling; /* .tp-card-bio */
            var open  = bio.classList.contains('tp-expanded');
            bio.classList.toggle('tp-expanded', !open);
            this.classList.toggle('tp-open', !open);
            this.childNodes[0].textContent = open ? 'Read More ' : 'Read Less ';
        });
    });
})();
</script>
@endsection
