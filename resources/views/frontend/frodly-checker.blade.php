@extends('frontend.layouts.master')

@section('title', 'Home Page')

@push('styles')
<style>
    /* Logo gradient animation */
    .logo_brand {
        font-size:44px; font-weight:bold; font-family:'Segoe UI',sans-serif;
        background:linear-gradient(270deg,#ff0000,#ff8c00,#01cf23); background-size:600% 600%;
        -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        animation:gradientMove 4s ease infinite; text-transform:uppercase; letter-spacing:4px; text-align:center;
    }
    @keyframes gradientMove {0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}

    /* Card and stat boxes */
    .card-box, .stat-box {border-radius:5px; padding:20px; box-shadow:2px 8px 12px 5px rgba(0,0,0,0.05); text-align:center; background:#fff; transition:.3s;}
    .card-box:hover {transform:translateY(-2px); box-shadow:0 6px 16px rgba(0,0,0,0.08);}
    .stat-box {border-bottom:4px solid #1677ff;}

    /* Risk label */
    .risk-label {border-left:6px solid; border-radius:5px; padding:6px 14px; font-weight:600; margin-top:10px; display:inline-block;}

    /* Slide line */
    @keyframes slideLR {0%{left:0}50%{left:calc(100% - 35px)}100%{left:0}}

    /* Table */
    .table {padding:10px; border-radius:8px; overflow:hidden; box-shadow:2px 8px 12px 5px rgba(0,0,0,0.05); background:#fff; color:#333; border-collapse:separate; border-spacing:0;}
    .table thead th {border-bottom:2px solid #ddd; font-weight:600; background:#f8f9fa; color:#333; text-align:center; padding:12px;}
    .table tbody td {padding:12px; text-align:center; vertical-align:middle;}
    .table-striped tbody tr:nth-of-type(odd){background:#f9f9f9;}
    .table-hover tbody tr:hover{background:#f1f1f1;}

    /* Dark mode */
    body.dark-mode .table {background:#1e1e1e; color:#e0e0e0; box-shadow:2px 8px 12px 5px rgba(0,0,0,0.3);}
    body.dark-mode .table thead th {background:#2a2a2a; color:#fff; border-bottom:2px solid #444;}
    body.dark-mode .table tbody tr:nth-of-type(odd){background:#2a2a2a;}
    body.dark-mode .table tbody tr:nth-of-type(even){background:#242424;}
    body.dark-mode .table tbody tr:hover{background:#333;}
    body.dark-mode .table tbody td{color:#e0e0e0; background-color:#ffffff0d !important;}
    body.dark-mode .text-danger{color:#ff6b6b !important;}
    body.dark-mode .text-success{color:#00ff7f !important;}
    body.dark-mode input, body.dark-mode button{background:#2a2a2a; color:#e0e0e0; border-color:#444;}
    body.dark-mode .risk-label{color:#fff;}
</style>
@endpush

@section('content')
<div class="container" style="padding-top: 100px">
    <h1 class="logo_brand">Frodly</h1>
    <p class="text-center">পার্সেল রিটার্ন এর পরিমাপ করুন</p>

    <!-- Bootstrap Search Box -->
    <div class="row justify-content-center my-5">
        <div class="col-md-8">
            <form class="d-flex" id="searchForm">
                <input class="form-control me-2 rounded-start" type="text" id="phoneInput" placeholder="01XXXXXXXXXX" />
                <button class="btn btn-primary rounded-end" type="submit" id="submit-btn">রিপোর্ট দেখুন</button>
            </form>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-3 text-center">
            <div id="loading-screen" style="display:none">
                <img src="{{ asset('images/loading-200x200x.gif') }}" alt="Loading">
            </div>
            <div id="serch-image">
                <img src="{{ asset('images/find-fraud.png') }}" alt="Find Fraud" class="img-fluid" />
            </div>
        </div>
    </div>

    <div class="row" id="content-data" style="display:none">
        <div class="col-md-4">
            <div class="card-box bg-light" id="chartBox">
                <canvas id="successChart" width="150" height="150"></canvas>
                <h5 class="mt-4" id="chartTitle">Delivery Success Ratio</h5>
                <span class="risk-label" id="riskLabel">Moderate Risk</span>
            </div>
        </div>

        <div class="col-md-8">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="stat-box text-center bg-light" id="ordersBox">
                        <h3 id="totalOrders">0</h3>
                        <p>মোট অর্ডার</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-box text-center bg-light" id="successBox">
                        <h3 id="totalSuccess">0</h3>
                        <p>মোট ডেলিভারি</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-box text-center bg-light" id="cancelBox">
                        <h3 id="totalCancel">0</h3>
                        <p>মোট বাতিল</p>
                    </div>
                </div>
            </div>

            <div class="table-responsive mt-4">
                <table class="table">
                    <thead>
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

    <div style="width:100%; height:2px; background:#ddd; margin:20px 0; position:relative; overflow:hidden;">
        <span style="display:inline-block; width:35px; height:2px; background:#007bff; position:absolute; top:0; left:0; animation: slideLR 8s infinite ease-in-out;"></span>
    </div>

    <div class="row justify-content-center m-5">
        <div class="col-md-2 p-4 rounded bg-light border-warning text-center">
            <a class="navbar-brand me-auto" href="https://frodlybd.com">
                <img src="{{ asset('images/logo-light.svg') }}" alt="Frodly Logo" height="40" class="logo-light">
                <img src="{{ asset('images/logo-dark.svg') }}" alt="Frodly Logo Dark" height="40" class="logo-dark">
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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
        $('#content-data').hide();

        $.get("{{ route('get.frodly') }}", { phone }, function(res) {
            if (!res.status) return alert('ডেটা পাওয়া যায়নি');

            $('#loading-screen').hide();
            $('#content-data').show();

            let { totalSummary, Summaries } = res.data;

            animateChart(totalSummary.successRate);
            animateNumbers(totalSummary);

            // Risk label
            let riskData = totalSummary.successRate < 50 ? {
                label: 'High Risk', bg: '#fde2e1', border: '#e63946', color: '#e63946'
            } : totalSummary.successRate < 75 ? {
                label: 'Moderate Risk', bg: '#fff3cd', border: '#ffb703', color: '#ffb703'
            } : totalSummary.successRate < 90 ? {
                label: 'Great Customer', bg: '#e0f7fa', border: '#00b606', color: '#00b606'
            } : {
                label: 'Excellent Customer', bg: '#e0f7fa', border: '#00b606', color: '#00b606'
            };

            $('#riskLabel').text(riskData.label).css({
                'background-color': riskData.bg,
                'border-left': `6px solid ${riskData.border}`,
                'color': riskData.color
            });

            // Courier table
            $('#courierTableBody').html(Object.entries(Summaries).map(([courier, data]) => {
                let cancelRate = data.total > 0 ? ((data.cancel / data.total) * 100).toFixed(1) : '0.0';
                return `<tr>
                    <td><img src="${data.logo}" alt="${courier}" style="height:42px;margin-right:6px;vertical-align:middle;"></td>
                    <td>${data.total}</td>
                    <td>${data.success}</td>
                    <td>${data.cancel}</td>
                    <td class="${cancelRate > 30 ? 'text-danger' : 'text-success'}"><strong>${cancelRate}%</strong></td>
                </tr>`;
            }).join(''));
        }).fail(() => {
            alert('API কল ব্যর্থ হয়েছে');
            $('#loading-screen').hide();
            $('#serch-image').show();
        });
    });

    function animateNumbers({ total, success, cancel }) {
        animateValue('totalOrders', 0, total, 800);
        animateValue('totalSuccess', 0, success, 800);
        animateValue('totalCancel', 0, cancel, 800);
    }

    function animateValue(id, start, end, duration) {
        let obj = document.getElementById(id);
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            obj.innerHTML = Math.floor(progress * (end - start) + start);
            if (progress < 1) window.requestAnimationFrame(step);
        };
        window.requestAnimationFrame(step);
    }

    function animateChart(finalValue) {
        const ctx = document.getElementById('successChart').getContext('2d');
        if (chartInstance) chartInstance.destroy();

        let currentValue = 0;
        const animationDuration = 1500;
        const animationStep = finalValue / (animationDuration / 16);

        const getTextColor = (value) => {
            if (value < 50) return '#e63946';
            if (value < 75) return '#ffb703';
            return '#00b606';
        };

        chartInstance = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [currentValue, 100 - currentValue],
                    backgroundColor: [
                        finalValue < 50 ? '#e63946' : finalValue < 75 ? '#ffb703' : '#00b606',
                        '#f1f1f1'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '75%',
                plugins: { legend: { display: false }, tooltip: { enabled: false } },
                animation: { duration: 0 }
            },
            plugins: [{
                id: 'centerText',
                beforeDraw(chart) {
                    const { ctx, chartArea: { top, bottom, left, right } } = chart;
                    const x = (left + right) / 2;
                    const y = (top + bottom) / 2;

                    ctx.save();
                    ctx.font = "bold 34px Segoe UI";
                    ctx.fillStyle = getTextColor(currentValue);
                    ctx.textAlign = "center";
                    ctx.textBaseline = "middle";
                    ctx.fillText(Math.round(currentValue) + "%", x, y);
                    ctx.restore();
                }
            }]
        });

        const animate = () => {
            if (currentValue < finalValue) {
                currentValue += animationStep;
                if (currentValue > finalValue) currentValue = finalValue;

                chartInstance.data.datasets[0].data = [currentValue, 100 - currentValue];
                chartInstance.update();
                requestAnimationFrame(animate);
            }
        };
        animate();
    }
});
</script>
@endpush
