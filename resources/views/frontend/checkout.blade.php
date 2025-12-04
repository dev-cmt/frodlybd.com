@extends('frontend.layouts.master')

@section('title', 'Checkout')

@push('styles')
    <style>
        .checkout-container {
            max-width: 1200px;
            margin: 80px auto 20px auto;
        }

        .checkout-wrapper {
            background: #ffffff;
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.06);
        }

        .right-section {
            border-left: 1px solid #e5e7eb;
            padding-left: 30px;
        }

        @media(max-width: 992px) {
            .right-section {
                border-left: none;
                padding-left: 0;
                border-bottom: 1px solid #e5e7eb;
                padding-bottom: 25px;
                margin-bottom: 25px;
            }
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
        }

        .payment-option {
            border: 2px solid #e5e7eb;
            padding: 14px 18px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: 0.25s;
            font-weight: 600;
        }

        .payment-option:hover {
            border-color: #3b82f6;
            background: #f8fafc;
        }

        .payment-option.active {
            border-color: #2563eb;
            background: #eff6ff;
        }

        .price-box {
            background: #f1ffed;
            border-left: 5px solid #5eff00;
            padding: 10px 15px;
            border-radius: 10px;
            margin-top: 15px;
        }
    </style>
@endpush


@section('content')

    <div class="checkout-container">
        <div class="checkout-wrapper row">

            <div class="col-lg-5">

                <h4 class="section-title">প্যাকেজ সারাংশ</h4>
                <div class="border"></div>

                @if ($plan)
                    <p><strong>প্যাকেজ:</strong> {{ $plan->name }}</p>
                    <p><strong>বিলিং সাইকেল:</strong> {{ ucfirst($plan->billing_cycle) }}</p>

                    <div class="price-box">
                        <h4 class="text-success fw-bold">{{ $plan->price }} টাকা</h4>
                        @if ($plan->regular_price)
                            <small class="text-dark text-decoration-line-through">{{ $plan->regular_price }} টাকা</small>
                        @endif
                    </div>
                @endif

                <hr class="my-4">

                <h5 class="fw-bold mb-3">🔍 পেমেন্ট মেথড নির্বাচন করুন</h5>

                @foreach (['sslcommerz' => 'SSLCOMMERZ – কার্ড / মোবাইল ব্যাংকিং',
                            'nagad' => 'নগদ',
                            'bkash' => 'বিকাশ',
                            'cod' => 'ক্যাশ অন ডেলিভারি',
                        ] as $key => $label)
                    <div class="payment-option" onclick="selectPayment('{{ $key }}', this)">
                        {{ $label }}
                    </div>
                @endforeach

                {{-- INLINE ERROR MSG --}}
                <div id="payment_error" class="text-danger fw-bold mt-2" style="display:none;"></div>

            </div>

            <div class="col-lg-7 right-section">

                <h4 class="section-title">ব্যক্তিগত তথ্য</h4>
                <div class="border"></div>

                <form id="checkoutForm" action="{{ route('placeorder') }}" method="POST">
                    @csrf

                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">

                    {{-- Hidden Radio Names (payment method) --}}
                    @foreach (['sslcommerz', 'nagad', 'bkash', 'cod'] as $p)
                        <input type="radio" name="payment_method" id="method_{{ $p }}" value="{{ $p }}" class="d-none">
                    @endforeach

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>সম্পূর্ণ নাম *</label>
                            <input type="text" class="form-control" name="name"
                                value="{{ auth()->user()->name ?? '' }}" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>মোবাইল নম্বর *</label>
                            <input type="text" class="form-control" name="phone"
                                value="{{ auth()->user()->phone ?? '' }}" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>ইমেইল *</label>
                            <input type="email" class="form-control" name="email"
                                value="{{ auth()->user()->email ?? '' }}" required>
                        </div>

                        @if (auth()->user() == null)
                        <div class="col-md-12 mb-3">
                            <label>পাসওয়ার্ড *</label>
                            <input type="password" class="form-control" name="password" required minlength="6">
                        </div>
                        @endif

                        <div class="col-md-12 mb-3">
                            <label>কোম্পানির নাম (ঐচ্ছিক)</label>
                            <input type="text" class="form-control" name="company">
                        </div>
                    </div>

                    <div class="form-check mt-2">
                        <input type="checkbox" id="terms" class="form-check-input" required>
                        <label class="form-check-label" for="terms">
                            আমি <a href="#">শর্তাবলী</a> ও <a href="#">গোপনীয়তা নীতি</a>-তে সম্মত।
                        </label>
                    </div>

                    <button class="btn btn-primary w-100 mt-4 py-2 fw-bold" id="submitBtn">
                        অর্ডার নিশ্চিত করুন ও পেমেন্ট করুন
                    </button>

                </form>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            // Payment UI
            function selectPayment(key, element) {
                $("#method_" + key).prop("checked", true);

                // Remove previous error
                $("#payment_error").hide().text("");

                $(".payment-option").removeClass("active");
                $(element).addClass("active");
            }


            // Form Submit Handler
            $("#checkoutForm").on("submit", function(e) {

                let selected = $("input[name='payment_method']:checked").val();

                if (!selected) {
                    e.preventDefault();

                    $("#payment_error")
                        .text("⚠ পেমেন্ট মেথড নির্বাচন করুন")
                        .fadeIn();

                    return false;
                }

                // Button Loader
                $("#submitBtn").prop("disabled", true)
                    .html('<span class="spinner-border spinner-border-sm"></span> প্রসেসিং...');
            });
        </script>
    @endpush

@endsection
