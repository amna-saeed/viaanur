{{-- Trigger: isi button ya kisi bhi element par class "js-apply-form-open" laga do, click par form open hoga --}}

{{-- Modal overlay + form --}}
<div id="applyFormModal" class="apply-form-modal" aria-hidden="true">
    <div class="apply-form-overlay js-apply-form-close"></div>
    <div class="apply-form-modal-inner">
        <div class="apply-form-modal-box">
            <button type="button" class="apply-form-close js-apply-form-close" aria-label="Close">
                <i class="bi bi-x-lg"></i>
            </button>
            <div class="apply-form-content" id="applyFormContent">
                <div class="apply-form-card">
                    <div class="apply-form-header">
                        <h3 class="apply-form-title">Apply Now</h3>
                        <p class="apply-form-desc">Fill in your details and we’ll get back to you.</p>
                    </div>
                    <form class="apply-form" method="POST" action="{{ route('application.store') }}" id="applyForm">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="apply_name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="apply_name" class="form-control" placeholder="Your full name" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="apply_email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="apply_email" class="form-control" placeholder="your@email.com" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="apply_phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" id="apply_phone" class="form-control" placeholder="e.g. +44 7500 000000" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="apply_course" class="form-label">Course <span class="text-danger">*</span></label>
                                <select name="course" id="apply_course" class="form-control form-select" required>
                                    <option value="">Select a course</option>
                                    <option value="social-media">Introduction to Social Media Concepts</option>
                                    <option value="gcse-maths">GCSE Level Mathematics</option>
                                    <option value="islamic-studies">Islamic Studies</option>
                                    <option value="esol">Introduction to ESOL</option>
                                    <option value="english">Introduction to English</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="apply_student_id_number" class="form-label">ID Card Number <span class="text-danger">*</span></label>
                                <input type="text" name="student_id_number" id="apply_student_id_number" class="form-control" placeholder="13-digit ID card number" inputmode="numeric" pattern="\d{13}" minlength="13" maxlength="13" title="Enter a 13-digit ID card number" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="apply_date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" name="date_of_birth" id="apply_date_of_birth" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="apply_gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                <select name="gender" id="apply_gender" class="form-control form-select" required>
                                    <option value="">Select gender</option>
                                    @foreach(\App\Support\StudentInformation::GENDER_OPTIONS as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="apply_school_name" class="form-label">School Name <span class="text-muted">(if applicable)</span></label>
                                <input type="text" name="school_name" id="apply_school_name" class="form-control" placeholder="Current school">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="apply_home_address" class="form-label">Home Address <span class="text-danger">*</span></label>
                        <textarea name="home_address" id="apply_home_address" class="form-control" rows="3" placeholder="Full home address" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="apply_guardian_name" class="form-label">Parent/Guardian Name <span class="text-danger">*</span></label>
                                <input type="text" name="guardian_name" id="apply_guardian_name" class="form-control" placeholder="Parent or guardian name" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="apply_guardian_contact_number" class="form-label">Parent/Guardian Contact <span class="text-danger">*</span></label>
                                <input type="tel" name="guardian_contact_number" id="apply_guardian_contact_number" class="form-control" placeholder="Contact number" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="apply_emergency_contact_number" class="form-label">Emergency Contact Number <span class="text-muted">(if different)</span></label>
                        <input type="tel" name="emergency_contact_number" id="apply_emergency_contact_number" class="form-control" placeholder="Alternative emergency number">
                    </div>
                    <div class="form-group text-center mt-4">
                        <button type="submit" class="apply-form-btn default-btn2 style-3 border-0">
                            Submit Application
                        </button>
                    </div>
                </form>
                </div>
            </div>
            <div class="apply-form-success" id="applyFormSuccess" aria-hidden="true">
                <div class="apply-form-success-icon"><i class="bi bi-check-circle-fill"></i></div>
                <h3 class="apply-form-success-title">Request Submitted</h3>
                <p class="apply-form-success-text">Your request has been submitted successfully. We will reach out to you soon.</p>
            </div>
        </div>
    </div>
</div>

<style>
/* ENROLL NOW button - unique class, blink yahan hi fix (keyframes + !important) */
.enroll-apply-btn {
    border: 0;
    background: transparent;
    padding: 0;
    display: inline-block;
}
.single-courses-card .list-info .enroll-apply-btn .bliink-inner1,
.enroll-apply-btn .bliink-inner1 {
    background: #322f89 !important;
    color: #fff !important;
    padding: 7px 10px;
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
.enroll-apply-btn .bliink-inner1:hover {
    color: #fff !important;
}
@keyframes enrollBtnBlink {
    0% { box-shadow: 0 0 0 #322f89; }
    100% { box-shadow: 0 0 10px #322f89, 0 0 18px #322f89; }
}

/* Trigger button - jahan include kiya hai wahan dikhega */
.apply-form-trigger-btn {
    padding: 12px 28px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}
.apply-form-trigger-btn:hover {
    opacity: 0.92;
    transform: translateY(-2px);
}

/* Modal overlay - professional opacity + shadow feel */
.apply-form-modal {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}
.apply-form-modal.is-open {
    opacity: 1;
    visibility: visible;
}
/* Backdrop: dark overlay, professional opacity, optional blur */
.apply-form-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.55);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}
/* Inner wrapper for centering */
.apply-form-modal-inner {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 760px;
    max-height: 90vh;
    overflow-y: auto;
}

/* Form box - professional shadow + elevation */
.apply-form-modal-box {
    position: relative;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2), 0 12px 24px -8px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(0, 0, 0, 0.04);
    padding: 45px 26px 28px;
    animation: applyFormSlideIn 0.3s ease;
    border: 1px solid #b6b0b0;
}
@keyframes applyFormSlideIn {
    from {
        opacity: 0;
        transform: scale(0.96) translateY(-10px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

/* Close button */
.apply-form-close {
    position: absolute;
    top: 14px;
    right: 14px;
    width: 36px;
    height: 36px;
    border: 0;
    border-radius: 8px;
    background: rgb(205 38 38 / 22%);
    color: #d81717;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s, color 0.2s;
    z-index: 2;
}
.apply-form-close:hover {
    background: rgb(205 38 38 / 78%);
    color: #f7f7f7;
}
.apply-form-close i { font-size: 16px; }

/* Apply form card - unique class, style same as single-contact-form.style-2 */
.apply-form-card {
    border-radius: 8px;
    margin-bottom: 25px;
}
.apply-form-card .apply-form-header { margin-bottom: 24px; padding-right: 0; }
.apply-form-card .apply-form-title {
    margin-bottom: 16px;
    color: var(--blackColor);
    font-size: 30px;
    font-weight: 600;
    font-family: var(--fontFamily);
    text-align: center;
}
.apply-form-card .apply-form-desc {
    font-weight: 300;
    margin-bottom: 30px;
    color: var(--bodyColor);
    text-align: center;
}
.apply-form .form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #232323;
    margin-bottom: 6px;
}
.apply-form .form-group .form-control {
    border: 1px solid #e8e8e8;
    height: 48px;
    font-weight: 500;
    box-shadow: none;
    padding-left: 16px;
    color: #333;
    background-color: #fafafa;
    border-radius: 6px;
    transition: border-color 0.2s, background-color 0.2s;
    font-size: 13px;
}
.apply-form .form-group textarea.form-control {
    height: auto;
    min-height: 92px;
    padding-top: 12px;
}
.apply-form .form-group .form-control::placeholder {
    color: #b0b0b0;
}
.apply-form .form-group .form-control::-webkit-input-placeholder { color: #b0b0b0; }
.apply-form .form-group .form-control::-moz-placeholder { color: #b0b0b0; opacity: 1; }
.apply-form .form-group .form-control:focus {
    outline: 0;
    border-color: #322f89;
    background-color: #fff;
}
.apply-form .form-group select.form-control.form-select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    padding-right: 36px;
    cursor: pointer;
    color: #333;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23666' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
}
.apply-form .form-group {
    margin-bottom: 30px !important;
}
.apply-form .form-group select.form-control.form-select option:first-child {
    color: #b0b0b0;
}
.apply-form .form-group { margin-bottom: 18px; }
.apply-form-btn {
    padding: 12px 28px;
    font-size: 15px;
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}
.apply-form-btn:hover {
    opacity: 0.92;
    transform: translateY(-1px);
}

/* Success message - submit ke baad */
.apply-form-success {
    display: none;
    text-align: center;
    padding: 24px 16px 16px;
}
.apply-form-success.is-visible {
    display: block;
    animation: applyFormSuccessIn 0.35s ease;
}
.apply-form-content.is-hidden {
    display: none;
}
.apply-form-success-icon {
    font-size: 52px;
    color: #22c55e;
    margin-bottom: 25px;
    line-height: 1;
}
.apply-form-success-title {
    font-size: 22px;
    font-weight: 700;
    color: var(--blackColor, #070707);
    margin: 0 0 10px 0;
}
.apply-form-success-text {
    font-size: 15px;
    color: var(--bodyColor, #555);
    margin: 0;
    line-height: 1.5;
}
@keyframes applyFormSuccessIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
</style>

<script>
(function() {
    var modal = document.getElementById('applyFormModal');
    var formContent = document.getElementById('applyFormContent');
    var successBlock = document.getElementById('applyFormSuccess');
    var form = document.getElementById('applyForm');
    if (!modal || !form) return;
    var closeBtns = modal.querySelectorAll('.js-apply-form-close');

    function openModal(e) {
        if (e) e.preventDefault();
        var opener = e && e.target && e.target.closest && e.target.closest('.js-apply-form-open');
        var courseSel = document.getElementById('apply_course');
        if (courseSel) {
            var preset = opener && opener.getAttribute('data-apply-course');
            if (preset && courseSel.querySelector('option[value="' + preset + '"]')) {
                courseSel.value = preset;
            } else {
                courseSel.value = '';
            }
        }
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        resetFormView();
    }
    function closeModal() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }
    function resetFormView() {
        if (formContent) formContent.classList.remove('is-hidden');
        if (successBlock) {
            successBlock.classList.remove('is-visible');
            successBlock.setAttribute('aria-hidden', 'true');
        }
    }
    function showSuccess() {
        if (formContent) formContent.classList.add('is-hidden');
        if (successBlock) {
            successBlock.classList.add('is-visible');
            successBlock.setAttribute('aria-hidden', 'false');
        }
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        var btn = form.querySelector('button[type="submit"]');
        var origText = btn ? btn.textContent : '';
        if (btn) { btn.disabled = true; btn.textContent = 'Sending...'; }
        var formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }

        })
        .then(function(r) { return r.json().then(function(d) { return { ok: r.ok, data: d }; }); })
        .then(function(result) {
            if (result.ok && result.data.success) {
                showSuccess();
                form.reset();
                if (result.data.mail_sent === false && result.data.mail_error) {
                    console.warn('Mail:', result.data.mail_error);
                    alert('Application saved.\n\nEmail could not be sent:\n' + result.data.mail_error);
                } else if (result.data.confirmation_sent === false && result.data.mail_error) {
                    console.warn('Confirmation mail:', result.data.mail_error);
                }
            } else {
                alert(result.data.message || 'Something went wrong. Please try again.');
            }
        })
        .catch(function() {
            alert('Something went wrong. Please try again.');
        })
        .finally(function() {
            if (btn) { btn.disabled = false; btn.textContent = origText; }
        });
    });

    document.addEventListener('click', function(e) {
        var opener = e.target && e.target.closest && e.target.closest('.js-apply-form-open');
        if (opener) {
            openModal(e);
            return;
        }
    });
    closeBtns.forEach(function(btn) { btn.addEventListener('click', closeModal); });
    modal.querySelector('.apply-form-overlay').addEventListener('click', closeModal);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
    });
})();
</script>
