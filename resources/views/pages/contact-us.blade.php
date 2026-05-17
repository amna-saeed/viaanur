@extends('layout.main')
@section('content')

    <div id="wrapper-box">
        <div class="viaanur-banner-container position-relative z-1">
            <img src="{{ asset('assets/images/banner/contect-banner.webp') }}" alt="About Banner" class="viaanur-banner-image">
        </div>
    </div>

    <!-- Start Contact Area -->
    <div class="contact-area pt-136 pb-110">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="single-contact-content">
                        <div class="section-title">
                            <h2>
                                Get In Touch
                            </h2>
                            <p>By booking, you agree to our Terms & Conditions and Privacy Policy.</p>
                        </div>
                        <div class="contact-list d-flex align-items-center">
                            <div class="icon">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div class="content">
                                <a href="mailto:admin@viaanur.com">
                                    admin@viaanur.com
                                </a>
                            </div>
                        </div>
                        <div class="contact-list d-flex align-items-center">
                            <div class="icon">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div class="content">
                                <a href="tel:+1234568900">
                                    +44 7507 719 318
                                </a>
                            </div>
                        </div>
                        <div class="contact-list d-flex align-items-center">
                            <div class="icon">
                                 <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div class="content">
                                <span>Book your free consultation now.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="single-contact-form style-2">
                        <div id="contactFormSuccess" class="alert alert-success d-none mb-4" role="alert"></div>
                        <div id="contactFormError" class="alert alert-danger d-none mb-4" role="alert"></div>
                        <form >
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Name*" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="Email*" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea name="message" class="form-control textarea" placeholder="Your Message*" required></textarea>
                            </div>
                            <button type="submit" class="default-btn2 style-3 border-0" id="contactSubmitBtn">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contact Area -->

    <!-- Start Contact Map -->
    <!-- <div class="contact-map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24196.22093656893!2d-111.91936604612816!3d40.70640020197386!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x87528ace2b0246f5%3A0x492b0c437e9cceb8!2sSouth%20Salt%20Lake%2C%20UT%2C%20USA!5e0!3m2!1sen!2sbd!4v1724093902757!5m2!1sen!2sbd"></iframe>
    </div> -->
    <!-- End Contact Map -->
       
@stop
@section('js')
<script>
(function() {
    var form = document.getElementById('contactForm');
    var successEl = document.getElementById('contactFormSuccess');
    var errorEl = document.getElementById('contactFormError');
    var btn = document.getElementById('contactSubmitBtn');
    if (!form || !btn) return;

    function showSuccess(msg) {
        if (errorEl) { errorEl.classList.add('d-none'); errorEl.textContent = ''; }
        if (successEl) { successEl.textContent = msg || 'Your message has been sent successfully. We will get back to you soon.'; successEl.classList.remove('d-none'); }
    }
    function showError(msg) {
        if (successEl) { successEl.classList.add('d-none'); successEl.textContent = ''; }
        if (errorEl) { errorEl.textContent = msg; errorEl.classList.remove('d-none'); }
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        var origText = btn.textContent;
        btn.disabled = true;
        btn.textContent = 'Sending...';
        if (successEl) successEl.classList.add('d-none');
        if (errorEl) errorEl.classList.add('d-none');

        var formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }

        })
        .then(function(r) { return r.json().then(function(d) { return { ok: r.ok, status: r.status, data: d }; }); })
        .then(function(result) {
            if (result.ok && result.data.success) {
                showSuccess(result.data.message);
                form.reset();
                if (result.data.mail_sent === false && result.data.mail_error) {
                    showError(result.data.message + ' ' + (result.data.mail_error || ''));
                }
            } else {
                var msg = (result.data && result.data.errors) ? Object.values(result.data.errors).flat().join(' ') : (result.data && result.data.message) || 'Something went wrong. Please try again.';
                showError(msg);
            }
        })
        .catch(function() {
            showError('Something went wrong. Please try again.');
        })
        .finally(function() {
            btn.disabled = false;
            btn.textContent = origText;
        });
    });
})();
</script>
@endsection