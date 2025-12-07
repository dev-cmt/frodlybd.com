@extends('frontend.layouts.master')

@section('title', 'Order Success')

@push('styles')
    <style>
        .success-container {
            max-width: 800px;
            margin: 80px auto;
            text-align: center;
            padding: 40px;
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.06);
        }

        .success-icon {
            font-size: 60px;
            color: #28a745;
            margin-bottom: 20px;
        }

        .success-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .success-text {
            font-size: 16px;
            margin-bottom: 25px;
            color: #555;
        }

        .order-details {
            text-align: left;
            margin-top: 30px;
        }

        .order-details h5 {
            font-weight: 600;
            margin-bottom: 15px;
        }

        .order-details p {
            margin-bottom: 8px;
        }

        .btn-home {
            margin-top: 30px;
        }
    </style>
@endpush

@section('content')
    <div class="success-container">
        <div class="success-icon">✅</div>
        <div class="success-title">অর্ডার সফলভাবে সম্পন্ন হয়েছে!</div>
        <div class="success-text">
            আপনার অর্ডার <strong>#{{ $sale->invoice_number }}</strong> সফলভাবে গ্রহণ করা হয়েছে।
            বিস্তারিত তথ্য নিচে দেওয়া হলো।
        </div>

        <div class="order-details">
            <h5>অর্ডার বিস্তারিত</h5>
            <p><strong>প্যাকেজ:</strong> {{ $sale->plan->name }}</p>
            <p><strong>বিলিং সাইকেল:</strong> {{ ucfirst($sale->plan->billing_cycle) }}</p>
            <p><strong>পরিমাণ:</strong> {{ $sale->amount }} টাকা</p>
            <p><strong>অর্ডার তারিখ:</strong> {{ $sale->created_at->format('d M, Y H:i') }}</p>
            <p><strong>স্ট্যাটাস:</strong> {{ ucfirst($sale->status) }}</p>
        </div>

        <div class="order-details">
            <h5>ব্যবহারকারীর তথ্য</h5>
            <p><strong>নাম:</strong> {{ $sale->user->name }}</p>
            <p><strong>ইমেইল:</strong> {{ $sale->user->email }}</p>
            <p><strong>মোবাইল:</strong> {{ $sale->user->phone }}</p>
        </div>

        <a href="{{ route('home') }}" class="btn btn-primary btn-home">🏠 হোমে ফিরে যান</a>
        <a href="{{ route('admin.your-package.index') }}" class="btn btn-primary btn-home">📄 বিস্তারিত দেখুন</a>
    </div>
@endsection
