@extends('layout.main')
@section('content')

    <!-- Start Banner Area -->
    <div id="banner" class="banner-area position-relative z-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="banner-content" data-cue="slideInUp">
                        <div class="title">
                            <span class="sub-title d-inline-block">An Online Tutoring Initiative</span>
                            <h2>
                                Empowered Minds, Proven Results, Exceptional 
                                <span class="position-relative">
                                    Futures.
                                </span>
                            </h2>
                        </div>
                        <div class="button-list d-flex align-items-center">
                            <a href="{{ route('contact-us') }}" class="default-btn">
                                <img src="assets/images/banner/left-bold.svg" alt="icon">
                                Enroll Now
                            </a>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-6">
                    <div class="banner-image position-relative z-1"  data-cue="slideInUp">
                        <div class="image">
                            <img src="{{asset('assets/images/banner/banner1-new.webp')}}" alt="banner-image">
                        </div>
                        <div class="user-info text-center">
                            <div class="box-success">
                                <img src="{{asset('assets/images/banner/success-image.webp')}}" alt="icon">
                            </div>
                            <h3>Study smart, aim high.</h3>
                            <h4>Turn your dreams into achievements.</h4>
                        </div>
                        <div class="button blick-100 mentor-info d-flex align-items-center justify-content-between p-3 shadow-sm rounded bg-light">
                            <a class="bliink-inner same-wraps" href="https://api.whatsapp.com/send?phone=447507719318&text=Hello%20there!" target="_blank">
                                <div class="content">
                                    <h3 class="mb-1 text-whatsapp font-weight-bold">
                                        Chat Instantly on WhatsApp
                                    </h3>
                                    <span class="text-muted">
                                        Connect with your mentor anytime, anywhere
                                    </span>
                                </div>
                                <div class="icon ml-3">
                                    <img src="assets/images/banner/whatsapp.svg" alt="user-image" class="whatz-icon" />
                                </div>
                            </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="banner-shape2">
            <img src="assets/images/banner/banner-shape2.webp" alt="shape">
        </div>
        <div class="banner-shape3">
            <img src="assets/images/banner/banner-shape2.webp" alt="shape">
        </div>
        <div class="banner-shape4">
            <img src="assets/images/banner/banner-shape3.webp" alt="shape">
        </div>
        <div class="banner-shape8">
            <img src="assets/images/banner/banner-shape8.webp" alt="shape">
        </div>
    </div>
</div>
    <!-- End Banner Area -->
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

    <!-- Start Categories Area -->
    <div class="categories-area pt-136 pb-110">
        <div class="container">
            <div class="categories-section-title" data-cue="slideInUp">
                <div class="row align-items-end">
                    <div class="col-lg-12 col-md-7 text-center">
                        <div class="section-title">
                            <span class="d-inline-block sub-title">Course Category</span>
                            <h2>
                                Explore Top 
                                <span class="position-relative">
                                    Categories
                                </span>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" data-cues="fadeIn">
                <div class="col-lg-4 col-sm-6">
                    <div class="single-categories-card text-center">
                        <div class="icon mx-auto position-relative z-1">
                            <img  src="assets/images/banner/categories-bg-shape.svg" alt="bg-shape">
                            <img class="bg-shape" src="{{asset('assets/images/banner/english.webp')}}" alt="icon">
                        </div>
                        <h3>English</h3>
                        <p>(Primary Level)</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single-categories-card second-color text-center">
                        <div class="icon mx-auto position-relative z-1">
                           <img  src="assets/images/banner/categories-bg-shape.svg" alt="bg-shape">
                            <img class="bg-shape" src="{{asset('assets/images/banner/esol.webp')}}" alt="icon">
                        </div>
                        <h3>ESOL</h3>
                        <p>(For non-native English speakers)</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single-categories-card text-center">
                        <div class="icon mx-auto position-relative z-1">
                            <img  src="assets/images/banner/categories-bg-shape.svg" alt="bg-shape">
                            <img class="bg-shape" src="{{asset('assets/images/banner/Graphic design.webp')}}" alt="icon">
                        </div>
                        <h3>Graphic Design</h3>
                        <p>(For non-native designers)</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single-categories-card second-color text-center">
                        <div class="icon mx-auto position-relative z-1">
                             <img  src="assets/images/banner/categories-bg-shape.svg" alt="bg-shape">
                            <img class="bg-shape" src="{{asset('assets/images/banner/Maths.webp')}}" alt="icon">
                        </div>
                        <h3>Mathematics</h3>
                        <p>(Up to GCSE Level)</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single-categories-card text-center">
                        <div class="icon mx-auto position-relative z-1">
                            <img  src="assets/images/banner/categories-bg-shape.svg" alt="bg-shape">
                            <img class="bg-shape" src="{{asset('assets/images/banner/socialmedia.webp')}}" alt="icon">
                        </div>
                        <h3>Social Media Studies</h3>
                        <p>(Content Creation)</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single-categories-card second-color text-center">
                        <div class="icon mx-auto position-relative z-1">
                            <img  src="assets/images/banner/categories-bg-shape.svg" alt="bg-shape">
                            <img class="bg-shape" src="{{asset('assets/images/banner/quran.webp')}}" alt="icon">
                        </div>
                        <h3>Qur’an Reading</h3>
                        <p>(With Tajweed Rules)</p>
                    </div>
                </div>
            </div>
             <div class="row" data-cues="fadeIn">
                <div class="col-lg-4 col-sm-6">
                    <div class="single-categories-card text-center">
                        <div class="icon mx-auto position-relative z-1">
                            <img  src="assets/images/banner/categories-bg-shape.svg" alt="bg-shape">
                            <img class="bg-shape" src="{{asset('assets/images/banner/Quran Memorizing.webp')}}" alt="icon">
                        </div>
                        <h3>Qur’an Memorisation</h3>
                        <p> (Hifdh Programme)</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single-categories-card second-color text-center">
                        <div class="icon mx-auto position-relative z-1">
                           <img  src="assets/images/banner/categories-bg-shape.svg" alt="bg-shape">
                            <img class="bg-shape" src="{{asset('assets/images/banner/university.webp')}}" alt="icon">
                        </div>
                        <h3>University Admissions Exams</h3>
                        <p>(UKCAT/BMAT)</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single-categories-card text-center">
                        <div class="icon mx-auto position-relative z-1">
                            <img  src="assets/images/banner/categories-bg-shape.svg" alt="bg-shape">
                            <img class="bg-shape" src="{{asset('assets/images/banner/Web design.webp')}}" alt="icon">
                        </div>
                        <h3>Website/Webpage Design</h3>
                        <p>(For non-native beginners)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Categories Area -->
    @include('components.apply-form')
      <!-- Start Courses Area -->
    <div class="courses-area pt-136 pb-110">
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
            <!-- <div class="single-courses-button text-center" data-cue="slideInUp">
                <a href="courses-details.html" class="default-btn2"> 
                    View All Courses
                     <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div> -->
        </div>
    </div>
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
    <div class="team-area pt-136 pb-110">
        <div class="container">
            <div class="row align-items-center justify-content-center" data-cues="fadeIn">
                <div class="col-lg-3">
                    <div class="single-team-content">
                        <div class="section-title">
                            <span class="d-inline-block sub-title">Team Members</span>
                            <h2>
                                Our Expert
                                <span class="position-relative">
                                    Lecturers
                                </span>
                            </h2>
                        </div>
                        <p>Our team at ViAaNur Online Academy is a group of passionate educators, innovators, and professionals committed to providing an exceptional learning experience.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-team-card position-relative">
                        <div class="image">
                            <a href="team-details.html">
                                <img class="img-fluid-team-11" src="{{ asset('assets/images/banner/WhatsApp Image 2026-02-11 at 2.50.39 PM.jpeg') }}" alt="team-image">
                            </a>
                        </div>
                        <div class="content text-center">
                            <h3>
                                Ruheena Quraishi
                            </h3>
                            <p>Founder & Lead Practitioner</p>
                            <a href="{{ route('teams') }}" class="default-btn2 style-3">View More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-team-card position-relative z-12">
                        <div class="image">
                            <a href="team-details.html">
                                <img class="img-fluid-team-12" src="{{ asset('assets/images/banner/WhatsApp Image 2026-02-11 at 2.50.14 PM.jpeg') }}" alt="team-image">
                            </a>
                        </div>
                        <div class="content text-center">
                            <h3>
                                Aftab Anwar
                            </h3>
                            <p>Managing Director & Social Media Studies Trainer</p>
                            <a href="{{ route('teams') }}" class="default-btn2 style-3">View More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-team-card position-relative z-1">
                        <div class="image">
                            <img class="img-fluid-team" src="{{ asset('assets/images/banner/WhatsApp Image 2026-02-26 at 8.29.33 PM.jpeg') }}" alt="team-image">
                        </div>
                        <div class="content text-center">
                            <h3>
                               Sabreena Quraishi
                            </h3>
                            <p>Early Years Lead & Primary Tutor</p>
                            <a href="{{ route('teams') }}" class="default-btn2 style-3">View More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Team Area -->

    <!-- Start Newsletter Area -->
    <div class="newsletter-area">
        <div class="container">
            <div class="newsletter-info position-relative z-1" data-cue="slideInUp">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="newsletter-content d-flex">
                            <h2>Enter Your email To Subscribe <br />Our Newsletter</h2>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="newsletter-form">
                            <form>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control" placeholder="Write your email">
                                    <button type="submit" class="default-btn2">
                                        Subscribe
                                        <i class="bi bi-arrow-right ml-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Newsletter Area -->


@stop
@section('js')

@endsection