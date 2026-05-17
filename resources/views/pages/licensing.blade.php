@extends('layout.main')
@section('content')

    <!-- Start Contact Area -->
    <section class="privacy-legal-page">
        <div class="container">
            <div class="privacy-legal-header">
                <span class="privacy-legal-badge">LEGAL</span>
                <h1 class="privacy-legal-title">
                    <span class="privacy-word"> Licensing & </span> <span class="policy-word">Intellectual Property Policy</span>
                </h1>
            </div>

            <div class="privacy-two-col">
                <aside class="privacy-sidebar" aria-label="On this page">
                    <nav class="privacy-nav">
                        <a href="#privacy-section-1" class="privacy-nav-link active">1.Ownership of Materials</a>
                        <a href="#privacy-section-2" class="privacy-nav-link">2. Permitted Use</a>
                        <a href="#privacy-section-3" class="privacy-nav-link">3.  Cancellations & Refunds</a>
                        <a href="#privacy-section-4" class="privacy-nav-link">4. Recorded Sessions</a>
                        <a href="#privacy-section-5" class="privacy-nav-link">5. Breach of Terms</a>
                        <a href="#privacy-section-6" class="privacy-nav-link">6. Branding</a>
                        <a href="#privacy-section-11" class="privacy-nav-link">11. Contact Us</a>
                    </nav>
                </aside>


                <div class="privacy-main">
                    <div class="accordion privacy-accordion">
                        <div class="accordion-item" id="privacy-section-1">
                            <button type="button" class="accordion-trigger" aria-expanded="false" aria-controls="privacy-content-1" id="privacy-trigger-1">
                                <span class="privacy-accordion-head">
                                    <span class="privacy-accordion-icon" aria-hidden="true"><span class="privacy-accordion-num">
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            width="20" 
                                            height="20" 
                                            viewBox="0 0 24 24" 
                                            fill="none" 
                                            stroke="#322f89" 
                                            stroke-width="2" 
                                            stroke-linecap="round" 
                                            stroke-linejoin="round"
                                            style="color:#322f89 !important;">
                                            
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        </svg>
                                    </span></span>
                                    <span class="privacy-accordion-title">1. Ownership of Materials</span>
                                </span>
                                <svg class="accordion-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                            </button>
                            
                            <div class="accordion-content" id="privacy-content-1" role="region" aria-labelledby="privacy-trigger-1">
                                <div class="accordion-content-inner">
                                    <p class="privacy-text">All materials provided by ViAaNur Tutoring, including:</p>
                                    <ul class="privacy-list">
                                        <li>Lesson resources</li>
                                        <li>Worksheets</li>
                                        <li>Presentations</li>
                                        <li>Recorded content</li>
                                    </ul>
                                    <p class="privacy-text">remain the intellectual property of ViAaNur Tutoring.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" id="privacy-section-2">
                            <button type="button" class="accordion-trigger" aria-expanded="false" aria-controls="privacy-content-2" id="privacy-trigger-2">
                                <span class="privacy-accordion-head">
                                    <span class="privacy-accordion-icon" aria-hidden="true"><span class="privacy-accordion-num">
                                       <svg xmlns="http://www.w3.org/2000/svg" 
                                            width="20" 
                                            height="20" 
                                            viewBox="0 0 24 24" 
                                            fill="none" 
                                            stroke="#322f89" 
                                            stroke-width="2" 
                                            stroke-linecap="round" 
                                            stroke-linejoin="round"
                                            style="color:#322f89 !important;">

                                            <path d="M9 12l2 2 4-4"></path>
                                            <circle cx="12" cy="12" r="9"></circle>
                                        </svg>
                                    </span></span>
                                    <span class="privacy-accordion-title">2. Permitted Use</span>
                                </span>
                                <svg class="accordion-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                            </button>
                            <div class="accordion-content" id="privacy-content-2" role="region" aria-labelledby="privacy-trigger-2">
                                <div class="accordion-content-inner">
                                     <p class="privacy-text">Clients are granted a limited, non-transferable licence to:</p>
                                    <ul class="privacy-list">
                                        <li>Use materials for personal educational purposes only</li>
                                        <li>Access resources provided during tutoring sessions</li>
                                    </ul>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" id="privacy-section-3">
                            <button type="button" class="accordion-trigger" aria-expanded="false" aria-controls="privacy-content-3" id="privacy-trigger-3">
                                <span class="privacy-accordion-head">
                                    <span class="privacy-accordion-icon" aria-hidden="true"><span class="privacy-accordion-num">
                                     <svg xmlns="http://www.w3.org/2000/svg" 
                                        width="20" 
                                        height="20" 
                                        viewBox="0 0 24 24" 
                                        fill="none" 
                                        stroke="#322f89" 
                                        stroke-width="2" 
                                        stroke-linecap="round" 
                                        stroke-linejoin="round"
                                        style="color:#322f89 !important;">

                                        <circle cx="12" cy="12" r="9"></circle>
                                        <line x1="9" y1="9" x2="15" y2="15"></line>
                                        <line x1="15" y1="9" x2="9" y2="15"></line>
                                    </svg>
                                    </span></span>
                                    <span class="privacy-accordion-title">3. Restrictions</span>
                                </span>
                                <svg class="accordion-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                            </button>
                            <div class="accordion-content" id="privacy-content-3" role="region" aria-labelledby="privacy-trigger-3">
                                <div class="accordion-content-inner">
                                    <p class="privacy-text">You may NOT:</p>
                                    <ul class="privacy-list">
                                        
                                        <li>Copy, reproduce, or distribute materials</li>
                                        <li>Share resources with third parties</li>
                                        <li>Upload materials online or to tutoring platforms</li>
                                        <li>Use materials for commercial purposes</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" id="privacy-section-4">
                            <button type="button" class="accordion-trigger" aria-expanded="false" aria-controls="privacy-content-4" id="privacy-trigger-4">
                                <span class="privacy-accordion-head">
                                    <span class="privacy-accordion-icon" aria-hidden="true"><span class="privacy-accordion-num">
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            width="20" 
                                            height="20" 
                                            viewBox="0 0 24 24" 
                                            fill="none" 
                                            stroke="#322f89" 
                                            stroke-width="2" 
                                            stroke-linecap="round" 
                                            stroke-linejoin="round"
                                            style="color:#322f89 !important;">

                                            <rect x="2" y="6" width="15" height="12" rx="2"></rect>
                                            <polygon points="17 10 22 7 22 17 17 14"></polygon>
                                        </svg>
                                </span></span>
                                    <span class="privacy-accordion-title">4. Recorded Sessions</span>
                                </span>
                                <svg class="accordion-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                            </button>
                            <div class="accordion-content" id="privacy-content-4" role="region" aria-labelledby="privacy-trigger-4">
                                <div class="accordion-content-inner">
                                    <p class="privacy-text">Where sessions are recorded (if applicable):</p>
                                    <ul class="privacy-list">
                                        <li>Recordings are for personal revision use only</li>
                                        <li>Distribution or sharing is strictly prohibited</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" id="privacy-section-5">
                            <button type="button" class="accordion-trigger" aria-expanded="false" aria-controls="privacy-content-5" id="privacy-trigger-5">
                                <span class="privacy-accordion-head">
                                    <span class="privacy-accordion-icon" aria-hidden="true"><span class="privacy-accordion-num">
                                       <svg xmlns="http://www.w3.org/2000/svg" 
                                            width="20" 
                                            height="20" 
                                            viewBox="0 0 24 24" 
                                            fill="none" 
                                            stroke="#322f89" 
                                            stroke-width="2" 
                                            stroke-linecap="round" 
                                            stroke-linejoin="round"
                                            style="color:#322f89 !important;">

                                            <circle cx="12" cy="12" r="9"></circle>
                                            <line x1="12" y1="8" x2="12" y2="12"></line>
                                            <circle cx="12" cy="16" r="1"></circle>
                                        </svg>
                                    </span></span>
                                    <span class="privacy-accordion-title">5. Breach of Terms</span>
                                </span>
                                <svg class="accordion-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                            </button>
                            <div class="accordion-content" id="privacy-content-5" role="region" aria-labelledby="privacy-trigger-5">
                                <div class="accordion-content-inner">
                                    <p class="privacy-text">Unauthorised use of materials may result in:</p>
                                     <ul class="privacy-list">
                                        <li>Immediate termination of services</li>
                                        <li>Legal action where necessary</li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" id="privacy-section-6">
                            <button type="button" class="accordion-trigger" aria-expanded="false" aria-controls="privacy-content-6" id="privacy-trigger-6">
                                <span class="privacy-accordion-head">
                                    <span class="privacy-accordion-icon" aria-hidden="true"><span class="privacy-accordion-num">
                                   <svg xmlns="http://www.w3.org/2000/svg" 
                                        width="20" 
                                        height="20" 
                                        viewBox="0 0 24 24" 
                                        fill="none" 
                                        stroke="#322f89" 
                                        stroke-width="2" 
                                        stroke-linecap="round" 
                                        stroke-linejoin="round"
                                        style="color:#322f89 !important;">

                                        <path d="M20 7L10 17l-5-5"></path>
                                        <circle cx="17" cy="7" r="3"></circle>
                                    </svg>
                                </span></span>
                                    <span class="privacy-accordion-title">6. Branding</span>
                                </span>
                                <svg class="accordion-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                            </button>
                            <div class="accordion-content" id="privacy-content-6" role="region" aria-labelledby="privacy-trigger-6">
                                <div class="accordion-content-inner">
                                     <p class="privacy-text">The ViAaNur Tutoring name, logo, and branding may not be used without permission.</p>
                                </div>
                            </div>
                        </div>
                       
                    </div>

                    <div class="privacy-cta-box">
                        <div class="privacy-cta-icon" aria-hidden="true">
                        <span class="privacy-accordion-head">
                                    <span class="privacy-accordion-icon" aria-hidden="true"><span class="privacy-accordion-num">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail w-4 h-4 text-primary"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg>
                                    </span></span>
                                </span>
                        </div>
                        <div class="privacy-cta-text">
                            <h3 class="privacy-cta-heading">Have Questions?</h3>
                           <a href="mailto:admin@viaanur.com" class="privacy-cta-btn">admin@viaanur.com</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  
   
@stop

@section('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
  const triggers = document.querySelectorAll(".accordion-trigger");

  triggers.forEach(trigger => {
    trigger.addEventListener("click", function () {
      const expanded = this.getAttribute("aria-expanded") === "true";

      // 👉 Close all accordions (optional – remove if multiple open allow krna ho)
      triggers.forEach(btn => {
        btn.setAttribute("aria-expanded", "false");
        const content = document.getElementById(btn.getAttribute("aria-controls"));
        content.style.maxHeight = null;
      });

      // 👉 Toggle current
      if (!expanded) {
        this.setAttribute("aria-expanded", "true");
        const content = document.getElementById(this.getAttribute("aria-controls"));
        content.style.maxHeight = content.scrollHeight + "px";
      }
    });
  });

  // ✅ Nav link click → scroll + open accordion
  const navLinks = document.querySelectorAll(".privacy-nav-link");

  navLinks.forEach(link => {
    link.addEventListener("click", function (e) {
      e.preventDefault();

      const targetId = this.getAttribute("href").replace("#", "");
      const targetItem = document.getElementById(targetId);

      if (!targetItem) return;

      const trigger = targetItem.querySelector(".accordion-trigger");

      // 👉 Open the clicked section
      triggers.forEach(btn => {
        btn.setAttribute("aria-expanded", "false");
        const content = document.getElementById(btn.getAttribute("aria-controls"));
        content.style.maxHeight = null;
      });

      trigger.setAttribute("aria-expanded", "true");
      const content = document.getElementById(trigger.getAttribute("aria-controls"));
      content.style.maxHeight = content.scrollHeight + "px";

      // 👉 Scroll to section
      targetItem.scrollIntoView({
        behavior: "smooth",
        block: "start"
      });

      // 👉 Active class update
      navLinks.forEach(l => l.classList.remove("active"));
      this.classList.add("active");
    });
  });
});
    
</script>
  <script>
        (function() {
            var navLinks = document.querySelectorAll('.privacy-nav-link');
            var sections = document.querySelectorAll('.privacy-accordion .accordion-item');
            function updateActive() {
                var scrollY = window.scrollY;
                var headerOffset = 120;
                var activeId = null;
                sections.forEach(function(section) {
                    var id = section.id;
                    var el = document.getElementById(id);
                    if (!el) return;
                    var top = el.getBoundingClientRect().top + scrollY - headerOffset;
                    if (scrollY >= top - 80) activeId = id;
                });
                navLinks.forEach(function(link) {
                    var href = link.getAttribute('href');
                    if (href === '#' + activeId) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                });
            }
            window.addEventListener('scroll', function() { requestAnimationFrame(updateActive); });
            window.addEventListener('load', updateActive);
        })();
    </script>
@endsection