@extends('frontend.layouts.master')

@section('title', 'Home Page')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-bg-pattern"></div>

        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center hero-content">
                    <!-- Premium Badge -->
                    <div class="badge-premium">
                        <i class="fas fa-crown me-2"></i> Best Fraud Checker BD 🥇
                    </div>

                    <!-- Main Title -->
                    <h1 class="hero-title">প্রতারণামূলক অর্ডার? ভাববেন না,
                        <span>আমরা আছি</span>
                    </h1>

                    <div class="border"></div>

                    <!-- Description -->
                    <p class="hero-description">
                        সহজ সেটআপ, প্রতিটি অর্ডারকে নিরাপদ রাখুন এবং ব্যবসার নিয়ন্ত্রণ বজায় রাখুন।
                    </p>

                    <!-- Feature Highlights -->
                    <div class="features-highlight">
                        <div class="feature-tag">
                            <i class="fas fa-shield-alt"></i> ফ্রড ডিটেকশন
                        </div>
                        <div class="feature-tag">
                            <i class="fas fa-phone-alt"></i> ফোন ভেরিফিকেশন
                        </div>
                        <div class="feature-tag">
                            <i class="fas fa-tasks"></i> ইনকমপ্লিট অর্ডার ট্র্যাকিং
                        </div>
                        <div class="feature-tag">
                            <i class="fas fa-redo"></i> রিপিট অর্ডার ফিল্টারিং
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="cta-buttons">
                        <a href="{{route('dashboard')}}" class="btn btn-hero-primary">
                            <i class="fas fa-play-circle"></i> বিনামূল্যে শুরু করুন
                        </a>
                        <a href="#services" class="btn btn-hero-secondary">
                            <i class="fas fa-info-circle"></i> আরও জানুন
                        </a>
                    </div>

                    <!-- Trust Badges -->
                    <div class="trust-badges">
                        <div class="trust-item">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span>৪.৮/৫ রেটিং</span>
                        </div>
                        <div class="trust-item">
                            <i class="fas fa-users"></i>
                            <span>১০০+ ব্যবসায়ী ব্যবহার করছেন</span>
                        </div>
                        <div class="trust-item">
                            <i class="fas fa-check-circle"></i>
                            <span>১০০% সুরক্ষিত</span>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="stats-container">
                        <div class="stat-item">
                            <div class="stat-number">৯৯%</div>
                            <div class="stat-label">ফ্রড প্রতিরোধ</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">৫x</div>
                            <div class="stat-label">দক্ষতা বৃদ্ধি</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">২৪/৭</div>
                            <div class="stat-label">সাপোর্ট</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Plugin Features</h2>
            <div class="border"></div>
            <p class="section-subtitle">আপনার অনলাইন স্টোরে Frodly ইন্সটল করলে যা সুবিধা পাবেন</p>

            <div class="row g-3">

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm feature-card">
                        <div class="card-body text-center p-3">
                            <i class="fas fa-shield-alt text-warning mb-2" style="font-size: 2rem;"></i>
                            <h6 class="card-title mb-2">OTP Verification</h6>
                            <p class="card-text text-muted small">OTP ছাড়া কাস্টমার অর্ডার প্লেস করতে না পারে (Standard
                                & Flexible Checkout সাপোর্টেড)।</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm feature-card">
                        <div class="card-body text-center p-3">
                            <i class="fas fa-chart-bar text-warning mb-2" style="font-size: 2rem;"></i>
                            <h6 class="card-title mb-2">Courier Report</h6>
                            <p class="card-text text-muted small">অর্ডার লিস্টেই কাস্টমারের কুরিয়ার ডেলিভারি হিস্টোরি ও
                                ফ্রড রিপোর্ট দেখা যাবে।</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm feature-card">
                        <div class="card-body text-center p-3">
                            <i class="fas fa-filter text-warning mb-2" style="font-size: 2rem;"></i>
                            <h6 class="card-title mb-2">Smart Order Filter</h6>
                            <p class="card-text text-muted small">কম ডেলিভারি রেশিও হলে অর্ডার ব্লক বা OTP ভেরিফিকেশন
                                বাধ্যতামূলক করা যায়।</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm feature-card">
                        <div class="card-body text-center p-3">
                            <i class="fas fa-globe text-warning mb-2" style="font-size: 2rem;"></i>
                            <h6 class="card-title mb-2">VPN Block</h6>
                            <p class="card-text text-muted small">VPN ইউজ করে কেউ যেন অর্ডার করতে না পারে — তা ব্লক করা
                                যাবে।</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm feature-card">
                        <div class="card-body text-center p-3">
                            <i class="fas fa-exclamation-triangle text-warning mb-2" style="font-size: 2rem;"></i>
                            <h6 class="card-title mb-2">Fraud Detection</h6>
                            <p class="card-text text-muted small">সন্দেহজনক ব্রাউজার বা IP থেকে অর্ডার হলে অটো ব্লক করা
                                যাবে।</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm feature-card">
                        <div class="card-body text-center p-3">
                            <i class="fas fa-file-alt text-warning mb-2" style="font-size: 2rem;"></i>
                            <h6 class="card-title mb-2">Incomplete Orders</h6>
                            <p class="card-text text-muted small">নাম্বার, ঠিকানা লিখেই অর্ডার না করলেও সেই লিড সংরক্ষণ
                                হবে।</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm feature-card">
                        <div class="card-body text-center p-3">
                            <i class="fas fa-redo text-warning mb-2" style="font-size: 2rem;"></i>
                            <h6 class="card-title mb-2">Repeat Order Blocker</h6>
                            <p class="card-text text-muted small">একই কাস্টমার যেন বারবার অর্ডার না করে — টাইম/লিমিট
                                অনুযায়ী ব্লক।</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm feature-card">
                        <div class="card-body text-center p-3">
                            <i class="fas fa-history text-warning mb-2" style="font-size: 2rem;"></i>
                            <h6 class="card-title mb-2">Phone History</h6>
                            <p class="card-text text-muted small">একই ফোন নাম্বার দিয়ে আগে অর্ডার করা হয়েছে কিনা — এক
                                ক্লিকে দেখা যাবে।</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm feature-card">
                        <div class="card-body text-center p-3">
                            <i class="fas fa-sms text-warning mb-2" style="font-size: 2rem;"></i>
                            <h6 class="card-title mb-2">SMS Notification</h6>
                            <p class="card-text text-muted small">প্রতিটি অর্ডার স্ট্যাটাসে কাস্টমারকে SMS পাঠানো যাবে।
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Section -->
    <section class="py-5" id="services">
        <div class="container">
            <h2 class="section-title">What Our Service Offers</h2>
            <div class="border mb-3"></div>
            <p class="section-subtitle">কিভাবে আমাদের সার্ভিস আপনাকে হেল্প করবে সেটা জানতে নিচের বিস্তারিত বিবরণ দেখুন।</p>

            <!-- Feature Buttons as Tabs -->
            <div class="d-flex justify-content-center flex-wrap mb-5" id="feature-buttons" role="tablist">
                <button class="btn btn-android m-2 active" data-bs-toggle="tab" data-bs-target="#wordpress-tab" type="button" role="tab">ওয়ার্ডপ্রেস প্লাগইন</button>
                <button class="btn btn-web m-2" data-bs-toggle="tab" data-bs-target="#web-tab" type="button" role="tab">ওয়েব অ্যাপ্লিকেশন</button>
                <button class="btn btn-api m-2" data-bs-toggle="tab" data-bs-target="#api-tab" type="button" role="tab">API এন্ট্রিগ্রেশন</button>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="feature-content">
                <!-- WordPress Tab -->
                <div class="tab-pane fade show active" id="wordpress-tab" role="tabpanel">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-6">
                            <div class="ratio ratio-16x9 mb-4 mb-lg-0">
                                <iframe src="https://www.youtube.com/embed/DgZN3lTPBiI" title="ওয়েব অ্যাপ্লিকেশন" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="">
                                </iframe>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="feature-details h-100 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-3 feature-title-row">
                                    <h3 class="mb-0">ওয়েব অ্যাপ্লিকেশন</h3>

                                    <a href="https://download.hoorin.com/app/app-release.apk" class="btn btn-warning btn-sm download-btn" target="_blank">
                                        <i class="bi bi-download me-1"></i> ডাউনলোড
                                    </a>
                                </div>
                                <p class="mb-4">মোবাইলে সহজে ব্যবহার করুন আমাদের অ্যান্ড্রয়েড অ্যাপ</p>
                                <ul class="list-unstyled feature-list mb-4">

                                    <li class="mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="feature-icon me-3">
                                                <i class="fa-solid fa-circle-check text-warning"></i>
                                            </div>
                                            <div>যেকোনো লোকেশন থেকে অ্যাক্সেস করুন</div>
                                        </div>
                                    </li>

                                    <li class="mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="feature-icon me-3">
                                                <i class="fa-solid fa-circle-check text-warning"></i>
                                            </div>
                                            <div>আপনার সাবস্ক্রিপশন স্ট্যাটাস দেখা</div>
                                        </div>
                                    </li>

                                    <li class="mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="feature-icon me-3">
                                                <i class="fa-solid fa-circle-check text-warning"></i>
                                            </div>
                                            <div>সিকিউর এবং লাইটওয়েট অ্যাপ্লিকেশন</div>
                                        </div>
                                    </li>

                                    <li class="mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="feature-icon me-3">
                                                <i class="fa-solid fa-circle-check text-warning"></i>
                                            </div>
                                            <div>ইন্টিগ্রেশন আপনার শপ ম্যানেজমেন্টের সাথে</div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Web App Tab -->
                <div class="tab-pane fade" id="web-tab" role="tabpanel">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-6">
                            <div class="ratio ratio-16x9 mb-4 mb-lg-0">
                                <iframe src="https://www.youtube.com/embed/DgZN3lTPBiI" title="ওয়েব অ্যাপ্লিকেশন" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="">
                                </iframe>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="feature-details h-100 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-3 feature-title-row">
                                    <h3 class="mb-0">ওয়েব অ্যাপ্লিকেশন</h3>
                                </div>
                                <p class="mb-4">মোবাইলে সহজে ব্যবহার করুন আমাদের অ্যান্ড্রয়েড অ্যাপ</p>
                                <ul class="list-unstyled feature-list mb-4">

                                        <li class="mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="feature-icon me-3">
                                                    <i class="fa-solid fa-circle-check text-warning"></i>
                                                </div>
                                                <div>যেকোনো লোকেশন থেকে অ্যাক্সেস করুন</div>
                                            </div>
                                        </li>

                                        <li class="mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="feature-icon me-3">
                                                    <i class="fa-solid fa-circle-check text-warning"></i>
                                                </div>
                                                <div>আপনার সাবস্ক্রিপশন স্ট্যাটাস দেখা</div>
                                            </div>
                                        </li>

                                        <li class="mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="feature-icon me-3">
                                                    <i class="fa-solid fa-circle-check text-warning"></i>
                                                </div>
                                                <div>সিকিউর এবং লাইটওয়েট অ্যাপ্লিকেশন</div>
                                            </div>
                                        </li>

                                        <li class="mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="feature-icon me-3">
                                                    <i class="fa-solid fa-circle-check text-warning"></i>
                                                </div>
                                                <div>ইন্টিগ্রেশন আপনার শপ ম্যানেজমেন্টের সাথে</div>
                                            </div>
                                        </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- API Tab -->
                <div class="tab-pane fade" id="api-tab" role="tabpanel">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-6">
                            <div class="ratio ratio-16x9 mb-4 mb-lg-0">
                                <iframe src="https://www.youtube.com/embed/DgZN3lTPBiI" title="Api Integreation" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="">
                                </iframe>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="feature-details h-100 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-3 feature-title-row">
                                    <h3 class="mb-0">Api Integreation</h3>

                                </div>
                                <p class="mb-4">মোবাইলে সহজে ব্যবহার করুন আমাদের অ্যান্ড্রয়েড অ্যাপ</p>
                                <ul class="list-unstyled feature-list mb-4">

                                        <li class="mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="feature-icon me-3">
                                                    <i class="fa-solid fa-circle-check text-warning"></i>
                                                </div>
                                                <div>যেকোনো লোকেশন থেকে অ্যাক্সেস করুন</div>
                                            </div>
                                        </li>

                                        <li class="mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="feature-icon me-3">
                                                    <i class="fa-solid fa-circle-check text-warning"></i>
                                                </div>
                                                <div>আপনার সাবস্ক্রিপশন স্ট্যাটাস দেখা</div>
                                            </div>
                                        </li>

                                        <li class="mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="feature-icon me-3">
                                                    <i class="fa-solid fa-circle-check text-warning"></i>
                                                </div>
                                                <div>সিকিউর এবং লাইটওয়েট অ্যাপ্লিকেশন</div>
                                            </div>
                                        </li>

                                        <li class="mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="feature-icon me-3">
                                                    <i class="fa-solid fa-circle-check text-warning"></i>
                                                </div>
                                                <div>ইন্টিগ্রেশন আপনার শপ ম্যানেজমেন্টের সাথে</div>
                                            </div>
                                        </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Supports Multiple Platforms</h2>
            <div class="border"></div>
            <p class="section-subtitle">আপনার প্রয়োজন অনুযায়ী বিভিন্ন প্ল্যাটফর্মে আমাদের সমাধানগুলি ব্যবহার করুন</p>

            <div class="row g-4">
                <div class="col-md-3">
                    <div class="service-card h-100 p-4 text-center">
                        <i class="fab fa-wordpress service-icon mb-3"></i>
                        <h5 class="card-title">ওয়ার্ডপ্রেস প্লাগইন</h5>
                        <p class="card-text">খুব সহজেই আমাদের অ্যাডভান্সড প্লাগইনটি আপনার ওয়ার্ডপ্রেস সাইটে ইনস্টল করুন
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="service-card h-100 p-4 text-center">
                        <i class="fab fa-google service-icon mb-3"></i>
                        <h5 class="card-title">Google Sheet Integration</h5>
                        <p class="card-text">গুগল সীট এন্ট্রিগ্রেশন সহজে ব্যবহার করুন আমাদের এক্সটেনশন</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="service-card h-100 p-4 text-center">
                        <i class="fab fa-chrome service-icon mb-3"></i>
                        <h5 class="card-title">Google Chrome Extension</h5>
                        <p class="card-text">ক্রোম ব্রাউজারে অডার গার্ড এক্সটেনশনের মাধ্যমে কাস্টমারদের সম্পর্কে তথ্য
                            জানুন</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="service-card h-100 p-4 text-center">
                        <i class="fab fa-android service-icon mb-3"></i>
                        <h5 class="card-title">অ্যান্ড্রয়েড অ্যাপ্লিকেশন</h5>
                        <p class="card-text">মোবাইলে সহজে ব্যবহার করুন আমাদের অ্যান্ড্রয়েড অ্যাপ</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Customer Experience</h2>
                <div class="border"></div>
                <p class="section-subtitle">আমাদের সেবা ব্যবহার করে গ্রাহকদের সফল অভিজ্ঞতা</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="testimonial-icon mb-3">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <p class="testimonial-text">"Frodly ব্যবহার করার পর থেকে আমাদের ফ্রড কেসগুলো কমে গেছে।
                                এখন আমরা অনেক বেশি আত্মবিশ্বাসের সাথে নতুন গ্রাহকদের সাথে কাজ করতে পারছি।"</p>
                            <div class="testimonial-author">
                                <img src="https://i.pravatar.cc/100?img=1" alt="Customer" class="rounded-circle">
                                <div class="author-info">
                                    <h5>রহিম আহমেদ</h5>
                                    <p>ই-কমার্স ব্যবসায়ী</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="testimonial-icon mb-3">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <p class="testimonial-text">"Frodly এর সেবা আমাদের ব্যবসায় অনেক পরিবর্তন এনেছে। এখন
                                আমরা সহজেই খারাপ গ্রাহকদের চিহ্নিত করতে পারি এবং সঠিক সিদ্ধান্ত নিতে পারি।"</p>
                            <div class="testimonial-author">
                                <img src="https://i.pravatar.cc/100?img=2" alt="Customer" class="rounded-circle">
                                <div class="author-info">
                                    <h5>ফাতেমা খাতুন</h5>
                                    <p>অনলাইন শপ মালিক</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="testimonial-icon mb-3">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <p class="testimonial-text">"Frodly এর সেবা ব্যবহার করে আমরা আমাদের ফ্রড কেসগুলো ৭০%
                                কমাতে পেরেছি। এটি আমাদের ব্যবসায় অনেক সুরক্ষা দিয়েছে।"</p>
                            <div class="testimonial-author">
                                <img src="https://i.pravatar.cc/100?img=3" alt="Customer" class="rounded-circle">
                                <div class="author-info">
                                    <h5>মোঃ সাজিদ</h5>
                                    <p>অনলাইন শপ মালিক</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    <section class="py-5" id="pricing">
        <div class="container">
            <h2 class="section-title">Available Plans & Packages</h2>
            <div class="border"></div>

            <div class="row row-cols-1 row-cols-md-3 g-4" id="pricing-cards">
                @foreach($pricingPlans as $plan)
                    <div class="col-md-4">
                        <div class="pricing-card h-100 position-relative">
                            {{-- Header --}}
                            <div class="pricing-header text-center p-4">
                                <h3>{{ $plan->name }}</h3>

                                <div class="billing-badge">{{ ucfirst($plan->billing_cycle) }}</div>
                                {{-- Price --}}
                                <h4 class="mb-0">
                                    <span class="original-price">
                                        {{ $plan->regular_price ? $plan->regular_price . ' টাকা' : 'ফ্রি' }}
                                    </span>

                                    <span class="discount-price">
                                        {{ $plan->price ? $plan->price . ' টাকা' : 'ফ্রি' }}
                                    </span>
                                </h4>
                            </div>

                            {{-- Features --}}
                            <div class="pricing-features p-4">
                                <ul class="list-unstyled mb-4">
                                    @foreach(json_decode($plan->features ?? '[]', true) as $feature)
                                        <li class="mb-2">
                                            <i class="me-2 {{ $feature['is_active'] == 1 ? 'fa-solid fa-circle-check' : 'fa-regular fa-circle-check op-3' }}"></i>
                                            {{ $feature['text'] ?? '' }}
                                        </li>
                                    @endforeach
                                </ul>

                                <a href="{{ route('checkout', ['plan' => $plan->id]) }}" class="btn btn-warning w-100">শুরু করুন</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5" id="faq">
        <div class="container">
            <h2 class="section-title">Common Questions</h2>
            <div class="border"></div>
            <p class="section-subtitle">আমাদের সেবা সম্পর্কে আপনার সাধারণ প্রশ্নের উত্তর</p>

            <div class="row mt-5">
                <div class="col-md-6 accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                হুরিন অর্ডার গার্ড কীভাবে কাজ করে?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="faqOne"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                হুরিন অর্ডার গার্ড গ্রাহকের ফোন নম্বর বিশ্লেষণ করে তাদের অর্ডারের ইতিহাস, কুরিয়ার
                                ব্যবহার এবং রিটার্নের তথ্য সরবরাহ করে। এই তথ্য ব্যবহার করে আপনি সম্ভাব্য প্রতারক
                                গ্রাহকদের চিহ্নিত করতে পারেন, যা রিটার্ন রেট কমাতে সাহায্য করে এবং আপনার ব্যবসার জন্য
                                সঠিক সিদ্ধান্ত নিতে সহায়তা করে।
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                আমি কি বিনামূল্যে ট্রায়াল করতে পারি?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="faqTwo"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                হ্যাঁ, আমরা সকল নতুন ব্যবহারকারীদের জন্য ৩ দিনের বিনামূল্যে ট্রায়াল অফার করি। এই সময়ে
                                আপনি আমাদের সিস্টেমের সকল ফিচার ব্যবহার করতে পারবেন এবং এটি আপনার ব্যবসার জন্য কতটা
                                উপযোগী তা যাচাই করতে পারবেন।
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                আমার ওয়েবসাইটের সাথে হুরিন কিভাবে ইন্টিগ্রেট করব?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="faqThree"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                আমরা বিভিন্ন প্ল্যাটফর্মের জন্য একাধিক ইন্টিগ্রেশন অপশন প্রদান করি। ওয়ার্ডপ্রেস/উকমার্স
                                ব্যবহারকারীদের জন্য আমাদের প্লাগইন, গুগল শীট ইন্টিগ্রেশন, ক্রোম এক্সটেনশন, অ্যান্ড্রয়েড
                                এপ, ওয়েব অ্যাপ্লিকেশন এবং API ইন্টিগ্রেশন - এই সকল অপশন রয়েছে। আমাদের ডকুমেন্টেশন বা
                                সাপোর্ট টিমের সাহায্যে আপনি সহজেই সেটআপ করতে পারবেন।
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                আমার তথ্য কি নিরাপদ থাকবে?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="faqFour"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                হ্যাঁ, আমরা আপনার ডেটা সুরক্ষাকে সর্বোচ্চ অগ্রাধিকার দেই। আমরা উন্নত এনক্রিপশন, সুরক্ষিত
                                সার্ভার এবং অ্যাক্সেস কন্ট্রোল ব্যবস্থা ব্যবহার করি। আমরা কোনো ব্যক্তিগত ডেটা তৃতীয়
                                পক্ষের সাথে শেয়ার করি না এবং সব সময় প্রাইভেসি পলিসি অনুসরণ করি।
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <img src="{{asset('images/faq.jpg')}}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </section>

    <!--Clients section-->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">Our Customers</h2>
            <div class="border"></div>
            <p class="section-subtitle">বাংলাদেশের অনেক সফল ব্যবসা আমাদের সেবা ব্যবহার করে ফ্রড কাস্টমার থেকে নিজেদের রক্ষা করছে</p>

            <div class="client-logo-carousel">
                <div class="client-logo-track">
                    <!-- Original logos -->
                    <div class="client-logo-wrapper">
                        <img src="{{asset('images/clients/client (1).png')}}" alt="GrayGrids" class="client-logo">
                    </div>
                    <div class="client-logo-wrapper">
                        <img src="{{asset('images/clients/client (2).png')}}" alt="GrayGrids" class="client-logo">
                    </div>
                    <div class="client-logo-wrapper">
                        <img src="{{asset('images/clients/client (3).png')}}" alt="GrayGrids" class="client-logo">
                    </div>
                    <div class="client-logo-wrapper">
                        <img src="{{asset('images/clients/client (4).png')}}" alt="GrayGrids" class="client-logo">
                    </div>
                    <div class="client-logo-wrapper">
                        <img src="{{asset('images/clients/client (5).png')}}" alt="GrayGrids" class="client-logo">
                    </div>
                    <div class="client-logo-wrapper">
                        <img src="{{asset('images/clients/client (6).png')}}" alt="GrayGrids" class="client-logo">
                    </div>
                    <div class="client-logo-wrapper">
                        <img src="{{asset('images/clients/client (7).png')}}" alt="GrayGrids" class="client-logo">
                    </div>
                    <!-- Dublicate logos -->
                    <div class="client-logo-wrapper">
                        <img src="{{asset('images/clients/client (1).png')}}" alt="GrayGrids" class="client-logo">
                    </div>
                    <div class="client-logo-wrapper">
                        <img src="{{asset('images/clients/client (2).png')}}" alt="GrayGrids" class="client-logo">
                    </div>
                    <div class="client-logo-wrapper">
                        <img src="{{asset('images/clients/client (3).png')}}" alt="GrayGrids" class="client-logo">
                    </div>
                    <div class="client-logo-wrapper">
                        <img src="{{asset('images/clients/client (4).png')}}" alt="GrayGrids" class="client-logo">
                    </div>
                    <div class="client-logo-wrapper">
                        <img src="{{asset('images/clients/client (5).png')}}" alt="GrayGrids" class="client-logo">
                    </div>
                    <div class="client-logo-wrapper">
                        <img src="{{asset('images/clients/client (6).png')}}" alt="GrayGrids" class="client-logo">
                    </div>
                    <div class="client-logo-wrapper">
                        <img src="{{asset('images/clients/client (7).png')}}" alt="GrayGrids" class="client-logo">
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
