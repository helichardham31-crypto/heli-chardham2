@extends('frontend.layouts.app')
@section('content')

  <!-- Title -->
        <section class="hero" data-aos="fade">
            <div class="hero-bg">
            <img src="{{asset('frontend/assets/img/tours/bg.jpg')}}"  alt="">

            </div>
            <div class="bg-content container">
                <div class="hero-page-title">
                    <span class="hero-sub-title">Get to Know Us</span>
                    <h1 class="display-3 hero-title">
                        About Us
                    </h1>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">About us</li>
                    </ol>
                </nav>
            </div>
        </section>
        <!-- /Title -->
    <!-- Featured -->
    <section class="pt-5 pb-4 bg-gray-gradient">
            <div class="container">
                <ul class="stats-list row g-0">
                    <li class="col-6 col-xl-3">
                        <div class="stats-item">
                            <h3 class="h1 stats-number">+500</h3>
                            <p class="stats-desc">
                                Successful <br> I.R.C.T.C Helicopter Tours
                            </p>
                        </div>
                    </li>
                    <li class="col-6 col-xl-3">
                        <div class="stats-item">
                            <h3 class="h1 stats-number">+2.5L</h3>
                            <p class="stats-desc">
                                Pilgrims Served <br> by I.R.C.T.C Services
                            </p>
                        </div>
                    </li>
                    <li class="col-6 col-xl-3">
                        <div class="stats-item">
                            <h3 class="h1 stats-number">4.9</h3>
                            <p class="stats-desc">
                                <span class="star-rate-view star-rate-size-sm"><span class="star-value rate-50"></span></span>
                                <br>
                                <span>Rated on Google & I.R.C.T.C</span>
                            </p>
                        </div>
                    </li>
                    <li class="col-6 col-xl-3">
                        <div class="stats-item">
                            <h3 class="h1 stats-number">+99%</h3>
                            <p class="stats-desc">
                                Customer <br> Satisfaction Rate
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </section>

        <!-- /Featured -->

       

        <!-- About -->
        <section class="p-top-90 p-bottom-90 bg-gray-gradient">
            <div class="container">
                <div class="row g-0">
                    <div class="col-12 col-xl-6 order-1 order-xl-0">
                        <!-- Image -->
                        <div class="pe-xl-5">
                            <div class="image-info image-info-right image-info-vertical">
                                <div class="vertical-title">
                                    <small class="ls-2">
                                        <strong class="text-primary fw-semibold">Since 1993</strong> - <strong class="text-body fw-semibold">31 Years</strong> of Trusted Service
                                    </small>
                                </div>
                                <div class="image-center">
                                    <img src="{{asset('frontend/assets/img/tours/p1.jpeg')}}" class="rounded w-100" alt="Char Dham Helicopter Service">
                                </div>
                                <div class="info-top-right">
                                    <div class="vertical-award rounded shadow-sm">
                                        <div class="award-content">
                                            <img src="{{asset('frontend/assets/img/logo.png')}}" class="w-100" alt="I.R.C.T.C Logo">
                                        </div>
                                        <div class="award-footer">
                                            <small>I.R.C.T.C Helicopter Yatra</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Image -->
                    </div>
                    <div class="col-12 col-xl-6 order-0 order-xl-1">
                        <!-- Content -->
                        <div class="mb-5 mb-xl-0">
                            <div class="block-title">
                                <small class="sub-title">About Us</small>
                                <h2 class="h1 title">Char Dham Yatra by Helicopter – Powered by I.R.C.T.C</h2>
                            </div>
                            <p>
                                Experience divine comfort and trusted service with <strong>I.R.C.T.C's official Char Dham Yatra by Helicopter</strong>. Designed for convenience, speed, and spiritual fulfillment, this yatra connects you to the sacred shrines of Yamunotri, Gangotri, Kedarnath, and Badrinath — all via luxurious helicopter services.
                            </p>
                            <p>
                                Backed by <strong>I.R.C.T.C’s legacy of reliability</strong> and customer satisfaction, we ensure a seamless journey with curated packages, VIP darshan, and top-notch safety standards.
                            </p>
                            <ul class="strength-list row g-0 pt-2">
                                <li class="col-12 col-md-6">
                                    <div class="strength-item">
                                        <span class="strength-icon">
                                            <i class="hicon hicon-150 hicon-confirmation-instant"></i>
                                        </span>
                                        <strong class="strength-title">I.R.C.T.C-Verified Travel Packages</strong>
                                    </div>
                                </li>
                                <li class="col-12 col-md-6">
                                    <div class="strength-item">
                                        <span class="strength-icon">
                                            <i class="hicon hicon-150 hicon-menu-price-display"></i>
                                        </span>
                                        <strong class="strength-title">Transparent Pricing, No Hidden Costs</strong>
                                    </div>
                                </li>
                                <li class="col-12 col-md-6">
                                    <div class="strength-item">
                                        <span class="strength-icon">
                                            <i class="hicon hicon-150 hicon-pay-on-checkin"></i>
                                        </span>
                                        <strong class="strength-title">Helicopter Access to All Four Dhams</strong>
                                    </div>
                                </li>
                                <li class="col-12 col-md-6">
                                    <div class="strength-item">
                                        <span class="strength-icon">
                                            <i class="hicon hicon-150 hicon-agoda-price-guarante"></i>
                                        </span>
                                        <strong class="strength-title">I.R.C.T.C Trust & Safety Standards</strong>
                                    </div>
                                </li>
                            </ul>
                            <div class="pt-3">
                                <a href="{{ url('/about') }}" class="btn btn-primary btn-uppercase mnw-180">
                                    <span>Read more</span>
                                    <i class="hicon hicon-flights-one-ways"></i>
                                </a>
                            </div>
                        </div>
                        <!-- /Content -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /About -->
@endsection
