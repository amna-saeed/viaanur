<style>
/* ============================================================
   FOOTER — Premium Dark
   Brand: #b2cd34 (lime) | #322f89 (deep purple)
============================================================ */
@keyframes ft-float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }

.ft-footer {
    position: relative;
    background: #ebebeb;
    overflow: hidden;
    padding: 84px 0 0;
    border-top: 1px solid rgba(178,205,52,.18);
}

/* dot grid */
.ft-footer::before {
    content:''; position:absolute; inset:0;
    background-image:radial-gradient(circle, rgba(255,255,255,.03) 1px, transparent 1px);
    background-size:28px 28px;
    z-index:0; pointer-events:none;
}

/* radial mesh */
.ft-footer::after {
    content:''; position:absolute; inset:0;
    background:
        radial-gradient(ellipse 48% 60% at 8% 85%, rgba(50,47,137,.28) 0%, transparent 55%),
        radial-gradient(ellipse 42% 42% at 92% 18%, rgba(178,205,52,.09) 0%, transparent 55%);
    z-index:0; pointer-events:none;
}

.ft-inner { position:relative; z-index:1; }

/* ── Brand column ── */
.ft-logo {
    height: 54px; width:auto; object-fit:contain;
    display:block; margin-bottom:20px;
}
.ft-brand-desc {
    font-size:14px; color:#101010;
    line-height:1.80; margin-bottom:28px; max-width:300px;font-weight: 500;
}

/* Social */
.ft-social { display:flex; align-items:center; gap:10px; }
.ft-social-link {
     width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgb(229 232 216);
    border: 1px solid rgba(255, 255, 255, .12);
    border-radius: 50%;
    color: rgb(101 184 76);
    font-size: 17px;
    text-decoration: none;
    transition: all .35s cubic-bezier(.175, .885, .32, 1.275);
}
.ft-social-link:hover {
    background:#b2cd34; border-color:#b2cd34;
    color:#12104a;
    transform:translateY(-5px) scale(1.10);
    box-shadow:0 10px 24px rgba(178,205,52,.40);
    text-decoration:none;
}

/* ── Column headings ── */
.ft-col-title {
    font-size:13px; font-weight:700; color:black;
    letter-spacing:.7px; text-transform:uppercase;
    margin-bottom:28px; padding-bottom:14px;
    position:relative;
}
.ft-col-title::after {
    content:''; position:absolute; left:0; bottom:0;
    width:34px; height:3px;
    background:linear-gradient(90deg,#b2cd34,#b2cd34);
    border-radius:2px;
}

/* ── Nav links ── */
.ft-links { list-style:none; padding:0; margin:0; }
.ft-links li { margin-bottom:11px; }
.ft-links a {
    font-size: 14px;
    color: #101010;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 9px;
    transition: all .3s ease;
    font-weight: 500;
}
.ft-links a::before {
    content:''; width:6px; height:6px;
    background:rgba(178,205,52,.35); border-radius:50%;
    flex-shrink:0;
    transition:background .3s, transform .3s;
}
.ft-links a:hover {
    color:#b2cd34; transform:translateX(6px); text-decoration:none;
}
.ft-links a:hover::before { background:#b2cd34; transform:scale(1.5); }

/* ── Contact list ── */
.ft-contact { list-style:none; padding:0; margin:0; }
.ft-contact li {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 16px;
    font-size: 14px;
    color: #101010;
    font-weight: 500;
}
.ft-contact-icon {
    width:38px; height:38px; min-width:38px;
    display:flex; align-items:center; justify-content:center;
    background:rgba(178,205,52,.10);
    border:1px solid rgba(178,205,52,.25);
    border-radius:10px;
    font-size:16px; color:#b2cd34;
    transition:all .3s ease;
}
.ft-contact li:hover .ft-contact-icon {
    background:#b2cd34; border-color:#b2cd34;
    color:#12104a; transform:scale(1.08);
}

/* ── Divider ── */
.ft-divider {
    height:1px;
    background:linear-gradient(90deg, transparent, rgba(255,255,255,.08), rgba(178,205,52,.18), rgba(255,255,255,.08), transparent);
    margin:64px 0 0; position:relative; z-index:1;
}

/* ── Bottom bar ── */
.ft-bottom {
    padding:20px 0;
    display:flex; align-items:center; justify-content:center;
    position:relative; z-index:1;
}
.ft-copyright {
    font-size:13px; color:black;
    margin:0; text-align:center;
}
.ft-copyright span { color:rgba(178,205,52,.70); font-weight:600; }

/* ── Responsive ── */
@media (max-width:991px) {
    .ft-footer { padding:64px 0 0; }
    .ft-brand-desc { max-width:100%; }
}
@media (max-width:767px) {
    .ft-footer { padding:52px 0 0; }
    .ft-col-title { margin-bottom:18px; }
    .ft-divider { margin-top:44px; }
}
</style>

<!-- Start Footer Area -->
<footer class="ft-footer" aria-label="Site footer">
    <div class="container ft-inner">
        <div class="row g-4 g-lg-5">

            <!-- ── Brand ── -->
            <div class="col-lg-4 col-md-12">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/images/banner/logo-new.webp') }}" alt="ViAaNur Tutoring" class="ft-logo">
                </a>
                <p class="ft-brand-desc">
                    At ViAaNur Tutoring, we believe that every learner carries unique potential waiting to be cultivated.
                </p>
                <div class="ft-social">
                    <a href="https://www.facebook.com/" target="_blank" rel="noopener" class="ft-social-link" aria-label="Facebook">
                        <i class="ri-facebook-fill"></i>
                    </a>
                    <a href="https://x.com/home" target="_blank" rel="noopener" class="ft-social-link" aria-label="Twitter / X">
                        <i class="ri-twitter-x-fill"></i>
                    </a>
                    <a href="https://www.linkedin.com/" target="_blank" rel="noopener" class="ft-social-link" aria-label="LinkedIn">
                        <i class="ri-linkedin-fill"></i>
                    </a>
                    <a href="https://www.youtube.com/" target="_blank" rel="noopener" class="ft-social-link" aria-label="YouTube">
                        <i class="ri-youtube-fill"></i>
                    </a>
                </div>
            </div>

            <!-- ── Legal ── -->
            <div class="col-lg-4 col-sm-6">
                <h3 class="ft-col-title">Legal</h3>
                <ul class="ft-links">
                    <li>
                        <a href="{{ route('terms-conditions') }}">Terms &amp; Conditions</a>
                    </li>
                    <li>
                        <a href="{{ route('privacy-policy') }}">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="{{ route('licensing') }}">Licensing</a>
                    </li>
                </ul>
            </div>

            <!-- ── Contact ── -->
            <div class="col-lg-4 col-sm-6">
                <h3 class="ft-col-title">Contact Us</h3>
                <ul class="ft-contact">
                    <li>
                        <span class="ft-contact-icon"><i class="bi bi-phone"></i></span>
                        +44 7507 719 318
                    </li>
                    <li>
                        <span class="ft-contact-icon"><i class="bi bi-envelope"></i></span>
                        admin@viaanur.com
                    </li>
                </ul>
            </div>

        </div>

        <!-- Divider -->
        <div class="ft-divider"></div>

        <!-- Bottom bar -->
        <div class="ft-bottom">
            <p class="ft-copyright">
                &copy; Copyright 2026 &nbsp;|&nbsp; <span>ViAaNur</span> &nbsp;|&nbsp; All Rights Reserved
            </p>
        </div>
    </div>
</footer>
<!-- End Footer Area -->
