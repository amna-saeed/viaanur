@extends('layout.main')
@section('content')

<style>
    /* ── Brand tokens ── */
    :root {
        --vn-purple: #322f89;
        --vn-purple-dark: #1e1a6e;
        --vn-green: #b2cd34;
        --vn-green-dark: #8fa825;
    }

    /* ── Hero banner ── */
    .contact-hero {
        position: relative;
        background: linear-gradient(135deg, #080619 0%, #1e1a6e 50%, #2a256e 100%);
        padding: 100px 0 80px;
        overflow: hidden;
        text-align: center;
    }
    .contact-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 20% 50%, rgba(178,205,52,.12) 0%, transparent 60%),
                    radial-gradient(ellipse at 80% 20%, rgba(50,47,137,.4) 0%, transparent 55%);
        pointer-events: none;
    }
    .contact-hero .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(178,205,52,.15);
        border: 1px solid rgba(178,205,52,.35);
        border-radius: 50px;
        padding: 8px 20px;
        margin-bottom: 22px;
        font-size: 13px;
        font-weight: 600;
        color: var(--vn-green);
        letter-spacing: .5px;
        text-transform: uppercase;
    }
    .contact-hero h1 {
        font-size: clamp(2rem, 5vw, 3.5rem);
        font-weight: 800;
        color: #fff;
        line-height: 1.15;
        margin-bottom: 18px;
    }
    .contact-hero h1 span {
        color: var(--vn-green);
    }
    .contact-hero p {
        color: rgba(255,255,255,.65);
        font-size: 1.05rem;
        max-width: 520px;
        margin: 0 auto;
    }
    /* floating orbs */
    .contact-hero .orb {
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        opacity: .18;
    }
    .contact-hero .orb-1 {
        width: 320px; height: 320px;
        background: radial-gradient(circle, var(--vn-green) 0%, transparent 70%);
        top: -80px; left: -80px;
    }
    .contact-hero .orb-2 {
        width: 260px; height: 260px;
        background: radial-gradient(circle, #6c63ff 0%, transparent 70%);
        bottom: -60px; right: -40px;
    }

    /* ── Main section ── */
    .contact-main {
        background: #f8f9fc;
        padding: 90px 0 100px;
    }

    /* ── Info cards ── */
    .contact-info-card {
        background: #fff;
        border-radius: 16px;
        padding: 36px 28px;
        height: 100%;
        box-shadow: 0 4px 30px rgba(50,47,137,.07);
        transition: transform .3s, box-shadow .3s;
    }
    .contact-info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(50,47,137,.13);
    }
    .contact-info-card .card-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 18px;
        background: linear-gradient(135deg, rgba(50,47,137,.1) 0%, rgba(178,205,52,.15) 100%);
        color: var(--vn-purple);
    }
    .contact-info-card h5 {
        font-size: 15px;
        font-weight: 700;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }
    .contact-info-card a,
    .contact-info-card p {
        font-size: 1.05rem;
        font-weight: 600;
        color: #1a1a2e;
        text-decoration: none;
        margin: 0;
        transition: color .2s;
    }
    .contact-info-card a:hover {
        color: var(--vn-purple);
    }
    .contact-info-card .card-sub {
        font-size: 13px;
        font-weight: 500;
        color: #999;
        margin-top: 4px;
    }

    /* ── Form card ── */
    .contact-form-card {
        background: #fff;
        border-radius: 20px;
        padding: 48px 44px;
        box-shadow: 0 8px 50px rgba(50,47,137,.1);
        position: relative;
        overflow: hidden;
    }
    .contact-form-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--vn-purple) 0%, var(--vn-green) 100%);
    }
    .contact-form-card .form-label-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(178,205,52,.12);
        border: 1px solid rgba(178,205,52,.3);
        border-radius: 50px;
        padding: 5px 14px;
        font-size: 12px;
        font-weight: 700;
        color: var(--vn-green-dark);
        letter-spacing: .6px;
        text-transform: uppercase;
        margin-bottom: 14px;
    }
    .contact-form-card h2 {
        font-size: 2rem;
        font-weight: 800;
        color: #1a1a2e;
        margin-bottom: 6px;
    }
    .contact-form-card .form-subtitle {
        color: #777;
        font-size: .95rem;
        margin-bottom: 32px;
    }

    /* Inputs */
    .vn-form-group {
        position: relative;
        margin-bottom: 22px;
    }
    .vn-form-group label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #444;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .vn-form-group .vn-input {
        width: 100%;
        height: 54px;
        padding: 0 18px 0 46px;
        border: 2px solid #eef0f6;
        border-radius: 12px;
        background: #f8f9fc;
        font-size: .95rem;
        font-weight: 500;
        color: #1a1a2e;
        transition: border-color .25s, box-shadow .25s, background .25s;
        outline: none;
    }
    .vn-form-group .vn-input:focus {
        border-color: var(--vn-purple);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(50,47,137,.08);
    }
    .vn-form-group .vn-input.textarea {
        height: 140px;
        padding-top: 16px;
        resize: none;
    }
    .vn-form-group .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #bbb;
        font-size: 16px;
        pointer-events: none;
        transition: color .25s;
    }
    .vn-form-group:has(.vn-input:focus) .input-icon {
        color: var(--vn-purple);
    }
    .vn-form-group.textarea-group .input-icon {
        top: 20px;
        transform: none;
    }

    /* Submit button */
    .vn-submit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        height: 56px;
        background: linear-gradient(135deg, var(--vn-purple) 0%, #4a45c0 100%);
        color: #fff;
        font-size: 1rem;
        font-weight: 700;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        letter-spacing: .3px;
        transition: transform .25s, box-shadow .25s, background .25s;
        margin-top: 8px;
    }
    .vn-submit-btn:hover:not(:disabled) {
        background: linear-gradient(135deg, #2622a0 0%, var(--vn-purple) 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(50,47,137,.35);
    }
    .vn-submit-btn:disabled {
        opacity: .7;
        cursor: not-allowed;
    }
    .vn-submit-btn .btn-arrow {
        transition: transform .25s;
    }
    .vn-submit-btn:hover:not(:disabled) .btn-arrow {
        transform: translateX(4px);
    }

    /* Alerts */
    #contactFormSuccess,
    #contactFormError {
        border-radius: 12px;
        padding: 14px 20px;
        font-weight: 600;
        font-size: .92rem;
    }

    /* ── Reassurance strip ── */
    .contact-trust {
        background: linear-gradient(135deg, var(--vn-purple-dark) 0%, var(--vn-purple) 100%);
        padding: 60px 0;
    }
    .trust-item {
        display: flex;
        align-items: center;
        gap: 16px;
        color: #fff;
    }
    .trust-item .trust-icon {
        width: 52px;
        height: 52px;
        flex: 0 0 auto;
        border-radius: 14px;
        background: rgba(178,205,52,.18);
        border: 1px solid rgba(178,205,52,.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: var(--vn-green);
    }
    .trust-item h6 {
        font-size: 1rem;
        font-weight: 700;
        margin: 0 0 3px;
        color: #fff;
    }
    .trust-item p {
        margin: 0;
        font-size: .85rem;
        color: rgba(255,255,255,.6);
    }
    .trust-divider {
        width: 1px;
        height: 52px;
        background: rgba(255,255,255,.12);
    }

    @media (max-width: 991px) {
        .contact-form-card { padding: 36px 24px; }
        .trust-divider { display: none; }
        .trust-item { margin-bottom: 28px; }
    }
    @media (max-width: 575px) {
        .contact-hero { padding: 70px 0 60px; }
        .contact-form-card { padding: 28px 18px; }
        .contact-form-card h2 { font-size: 1.6rem; }
    }
</style>

<!-- ── Hero ── -->
<section class="contact-hero">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="container position-relative">
        <span class="hero-badge"><i class="bi bi-chat-dots-fill"></i> Let's Talk</span>
        <h1>Get In <span>Touch</span> With Us</h1>
        <p>Have a question or want to book a free consultation? We're here to help you every step of the way.</p>
    </div>
</section>

<!-- ── Main content ── -->
<section class="contact-main">
    <div class="container">

        <!-- Info cards row -->
        <div class="row g-4 mb-5">
            <div class="col-lg-4 col-sm-6">
                <div class="contact-info-card">
                    <div class="card-icon"><i class="bi bi-envelope-fill"></i></div>
                    <h5>Email Us</h5>
                    <a href="mailto:admin@viaanur.com">admin@viaanur.com</a>
                    <p class="card-sub">We reply within 24 hours</p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="contact-info-card">
                    <div class="card-icon"><i class="bi bi-telephone-fill"></i></div>
                    <h5>Call Us</h5>
                    <a href="tel:+447507719318">+44 7507 719 318</a>
                    <p class="card-sub">Mon – Fri, 9 am – 6 pm GMT</p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="contact-info-card">
                    <div class="card-icon"><i class="bi bi-calendar2-check-fill"></i></div>
                    <h5>Free Consultation</h5>
                    <p>Book your session</p>
                    <p class="card-sub">No commitment required</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact-form-card">
                    <span class="form-label-tag"><i class="bi bi-send-fill"></i> Send a Message</span>
                    <h2>How Can We Help?</h2>
                    <p class="form-subtitle">Fill in the form below and a member of our team will be in touch shortly.</p>

                    <div id="contactFormSuccess" class="alert alert-success d-none mb-4" role="alert"></div>
                    <div id="contactFormError" class="alert alert-danger d-none mb-4" role="alert"></div>

                    <form id="contactForm" action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="row g-0">
                            <div class="col-md-6 pe-md-2">
                                <div class="vn-form-group">
                                    <label for="contact_name">Full Name</label>
                                    <i class="bi bi-person-fill input-icon"></i>
                                    <input type="text" id="contact_name" name="name" class="vn-input" placeholder="e.g. Sarah Ahmed" required>
                                </div>
                            </div>
                            <div class="col-md-6 ps-md-2">
                                <div class="vn-form-group">
                                    <label for="contact_email">Email Address</label>
                                    <i class="bi bi-envelope-fill input-icon"></i>
                                    <input type="email" id="contact_email" name="email" class="vn-input" placeholder="you@example.com" required>
                                </div>
                            </div>
                        </div>
                        <div class="vn-form-group textarea-group">
                            <label for="contact_message">Your Message</label>
                            <i class="bi bi-chat-left-text-fill input-icon"></i>
                            <textarea id="contact_message" name="message" class="vn-input textarea" placeholder="Tell us how we can help…" required></textarea>
                        </div>
                        <button type="submit" class="vn-submit-btn" id="contactSubmitBtn">
                            Send Message
                            <i class="bi bi-arrow-right btn-arrow"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ── Trust strip ── -->
<section class="contact-trust">
    <div class="container">
        <div class="row align-items-center text-center text-lg-start gy-4">
            <div class="col-lg-4">
                <div class="trust-item justify-content-center justify-content-lg-start">
                    <div class="trust-icon"><i class="bi bi-shield-fill-check"></i></div>
                    <div>
                        <h6>Safe &amp; Confidential</h6>
                        <p>Your data is never shared with third parties</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 d-none d-lg-flex justify-content-center">
                <div class="trust-divider"></div>
            </div>
            <div class="col-lg-4">
                <div class="trust-item justify-content-center justify-content-lg-start">
                    <div class="trust-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                    <div>
                        <h6>Fast Response</h6>
                        <p>Typical reply time under 24 hours</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 d-none d-lg-flex justify-content-center">
                <div class="trust-divider"></div>
            </div>
            <div class="col-lg-2">
                <div class="trust-item justify-content-center justify-content-lg-start">
                    <div class="trust-icon"><i class="bi bi-star-fill"></i></div>
                    <div>
                        <h6>5-Star Service</h6>
                        <p>Trusted by hundreds of families</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop
@section('js')
<script>
(function () {
    var form = document.getElementById('contactForm');
    var successEl = document.getElementById('contactFormSuccess');
    var errorEl   = document.getElementById('contactFormError');
    var btn       = document.getElementById('contactSubmitBtn');
    if (!form || !btn) return;

    function showSuccess(msg) {
        if (errorEl)   { errorEl.classList.add('d-none');    errorEl.textContent = ''; }
        if (successEl) { successEl.textContent = msg || 'Your message has been sent successfully. We will get back to you soon.'; successEl.classList.remove('d-none'); }
    }
    function showError(msg) {
        if (successEl) { successEl.classList.add('d-none'); successEl.textContent = ''; }
        if (errorEl)   { errorEl.textContent = msg; errorEl.classList.remove('d-none'); }
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var origHTML = btn.innerHTML;
        btn.disabled  = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending…';
        if (successEl) successEl.classList.add('d-none');
        if (errorEl)   errorEl.classList.add('d-none');

        var formData = new FormData(form);
        fetch(form.action, {
            method:  'POST',
            body:    formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(function (r) { return r.json().then(function (d) { return { ok: r.ok, data: d }; }); })
        .then(function (result) {
            if (result.ok && result.data.success) {
                showSuccess(result.data.message);
                form.reset();
            } else {
                var msg = (result.data && result.data.errors)
                    ? Object.values(result.data.errors).flat().join(' ')
                    : (result.data && result.data.message) || 'Something went wrong. Please try again.';
                showError(msg);
            }
        })
        .catch(function () { showError('Something went wrong. Please try again.'); })
        .finally(function () { btn.disabled = false; btn.innerHTML = origHTML; });
    });
})();
</script>
@endsection
