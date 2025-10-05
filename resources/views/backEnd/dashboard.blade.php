@extends('backEnd.layouts.master')

@section('title', 'Dashboard')

@push('css')
<style>
    .logo_brand {
        font-size: 44px;
        font-weight: bold;
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(270deg, #ff0000, #ff8c00, #01cf23);
        background-size: 600% 600%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: gradientMove 4s ease infinite;
        text-transform: uppercase;
        letter-spacing: 4px;
        text-align: center;
    }
    @keyframes gradientMove {
        0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}
    }
    @keyframes slideLR {
        0%{left:0;}50%{left:calc(100% - 35px);}100%{left:0;}
    }

    /* Stats Cards */
    .custom-card { border-radius: 6px; }
    .border-top-card { border-top-width: 4px !important; }
    .card-body .avatar { display: inline-flex; align-items: center; justify-content: center; }

    /* Table */
    table th, table td { vertical-align: middle !important; }
    .table-striped tbody tr:nth-of-type(odd) { background-color: #f8f9fa; }
</style>
@endpush

@section('content')
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <h1 class="page-title fw-semibold fs-18 mb-0">
        Welcome {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->getRoleNames()->first()) }} Dashboard)
    </h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        </ol>
    </nav>
</div>

<div class="row mb-5">
    <div class="col-xl-12">
        <h1 class="logo_brand">Frodly</h1>
        <p class="text-center text-muted">পার্সেল রিটার্ন এর পরিমাপ করুন</p>

        <!-- Search Form -->
        <div class="row justify-content-center my-4">
            <div class="col-md-8">
                <form class="d-flex" id="searchForm">
                    <input type="text" class="form-control form-control-lg me-2" id="phoneInput" placeholder="01XXXXXXXXXX">
                    <button class="btn btn-primary" type="submit" id="submit-btn">Frodly Report</button>
                </form>
            </div>
        </div>

        <!-- Loading / Placeholder -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-3 text-center">
                <div id="loading-screen" style="display:none">
                    <img src="{{ asset('images/loading-200x200x.gif') }}" alt="Loading" class="img-fluid">
                </div>
                <div id="serch-image">
                    <img src="{{ asset('images/find-fraud.png') }}" alt="Find Fraud" class="img-fluid" />
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4" id="stats-cards" style="display:none">
            @php
                $cards = [
                    ['title'=>'মোট অর্ডার','id'=>'totalOrders','icon'=>'ri-briefcase-2-line','bg'=>'primary'],
                    ['title'=>'মোট ডেলিভারি','id'=>'totalSuccess','icon'=>'ri-wallet-2-line','bg'=>'success'],
                    ['title'=>'মোট বাতিল','id'=>'totalCancel','icon'=>'ri-profile-line','bg'=>'danger'],
                    ['title'=>'সফলতার হার','id'=>'successRate','icon'=>'ri-line-chart-line','bg'=>'info'],
                    ['title'=>'বাতিল হার','id'=>'cancelRate','icon'=>'ri-money-dollar-box-line','bg'=>'warning'],
                    ['title'=>'রিস্ক লেভেল','id'=>'riskLabel','icon'=>'ri-bill-line','bg'=>'secondary'],
                ];
            @endphp
            @foreach($cards as $card)
            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                <div class="card custom-card border-top-card border-top-{{ $card['bg'] }}">
                    <div class="card-body text-center">
                        <span class="avatar avatar-md bg-{{ $card['bg'] }} shadow-sm avatar-rounded mb-2">
                            <i class="{{ $card['icon'] }} fs-16"></i>
                        </span>
                        <p class="fs-14 fw-semibold mb-2">{{ $card['title'] }}</p>
                        <h5 class="mb-0 fw-semibold" id="{{ $card['id'] }}">0</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Chart & Table -->
        <div class="row" id="content-data" style="display:none">
            <div class="col-md-3 mb-3">
                <div class="card custom-card text-center">
                    <div class="card-header">
                        <div class="card-title">Delivery Success Ratio</div>
                    </div>
                    <div class="card-body">
                        <canvas id="successChart" width="150" height="150"></canvas>
                        <div class="mt-2">
                            <span id="successChartValue" class="fs-18 fw-bold">0%</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-9 mb-3">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title text-uppercase">Details</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-primary text-uppercase">
                                    <tr>
                                        <th>কুরিয়ার</th>
                                        <th>অর্ডার</th>
                                        <th>ডেলিভারি</th>
                                        <th>বাতিল</th>
                                        <th>বাতিল হার</th>
                                    </tr>
                                </thead>
                                <tbody id="courierTableBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Animated Line -->
        <div style="width:100%; height:2px; background:#ddd; margin:20px 0; position:relative; overflow:hidden;">
            <span style="display:inline-block; width:35px; height:2px; background:#007bff; position:absolute; top:0; left:0; animation: slideLR 8s infinite ease-in-out;"></span>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script>
$(function() {
    let chartInstance = null;
    const key = 'savedPhone';
    $('#phoneInput').val(localStorage.getItem(key) || '');
    $('#phoneInput').on('input', e => localStorage.setItem(key, e.target.value));

    $('#searchForm').submit(function(e) {
        e.preventDefault();
        let phone = $('#phoneInput').val().trim();
        if (!phone.match(/^\d{11}$/)) return alert('সঠিক ফোন নাম্বার লিখুন (১১ ডিজিট)');

        $('#loading-screen').show();
        $('#serch-image').hide();
        $('#content-data, #stats-cards').hide();

        $.get("{{ route('get.frodly') }}", { phone: phone }, function(res) {
            if (!res.status) return alert('ডেটা পাওয়া যায়নি');

            $('#loading-screen').hide();
            $('#stats-cards, #content-data').show();

            let { totalSummary, Summaries } = res.data;

            // Update stats cards
            $('#totalOrders').text(totalSummary.total);
            $('#totalSuccess').text(totalSummary.success);
            $('#totalCancel').text(totalSummary.cancel);
            $('#successRate').text(totalSummary.successRate + '%');
            $('#cancelRate').text(totalSummary.cancelRate + '%');

            let riskText = totalSummary.successRate < 50 ? 'High Risk' :
                           totalSummary.successRate < 75 ? 'Moderate Risk' : 'Great Customer';
            $('#riskLabel').text(riskText);

            // Table
            $('#courierTableBody').html(Object.entries(Summaries).map(([courier, data]) => {
                let cancelRate = data.total > 0 ? ((data.cancel / data.total) * 100).toFixed(1) : '0.0';
                return `<tr>
                    <td><img src="${data.logo}" alt="${courier}" style="height:32px;margin-right:6px;vertical-align:middle;"> ${courier}</td>
                    <td>${data.total}</td>
                    <td>${data.success}</td>
                    <td>${data.cancel}</td>
                    <td class="${cancelRate > 30 ? 'text-danger fw-bold' : 'text-success fw-bold'}">${cancelRate}%</td>
                </tr>`;
            }).join(''));

            animateChart(totalSummary.successRate);
        }).fail(() => {
            alert('API কল ব্যর্থ হয়েছে');
            $('#loading-screen').hide();
            $('#serch-image').show();
        });
    });

    function animateChart(finalValue) {
        const ctx = document.getElementById('successChart').getContext('2d');
        if (chartInstance) chartInstance.destroy();

        chartInstance = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [finalValue, 100 - finalValue],
                    backgroundColor: [
                        finalValue < 50 ? '#e63946' : finalValue < 75 ? '#ffb703' : '#00b606',
                        '#f1f1f1'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '75%',
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                }
            }
        });

        // Show number under chart
        $('#successChartValue').text(finalValue + '%');
    }

});
</script>
@endpush
