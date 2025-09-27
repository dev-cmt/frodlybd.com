<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Frodly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>

<body>

    <div class="container py-5">
        <h1 class="logo_brand">Frodly</h1>
        <p class="text-center text-muted">পার্সেল রিটার্ন এর পরিমাপ করুন</p>

        <div class="row justify-content-center my-5">
            <div class="col-md-8">
                <div class="input-group search-box">
                    <!-- Added id="phoneInput" to connect with JS localStorage -->
                    <input type="text" id="phoneInput" class="form-control" placeholder="01XXXXXXXXXX" aria-label="Search by Phone Number" />
                    <button class="btn btn-primary" id="submit-btn">রিপোর্ট দেখুন</button>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-3 text-center">
                <div id="loading-screen" style="display: none">
                    <img src="{{ asset('images/loading-200x200x.gif') }}" alt="">
                </div>

                <div id="serch-image">
                    <img src="{{ asset('images/find-fraud.png') }}" alt="Find Fraud" class="img-fluid" />
                </div>
            </div>
        </div>

        <div class="row" id="content-data" style="display: none">
            <div class="col-md-4">
                <div class="card-box">
                    <canvas id="successChart" width="150" height="150"></canvas>
                    <h5 class="mt-4">Delivery Success Ratio</h5>
                    <span class="risk-label" id="riskLabel">Moderate Risk</span>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="stat-box text-center">
                            <h3 class="fw-bold" id="totalOrders">0</h3>
                            <p class="mb-0 text-muted">মোট অর্ডার</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-box text-center">
                            <h3 class="fw-bold" id="totalSuccess">0</h3>
                            <p class="mb-0 text-muted">মোট ডেলিভারি</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-box text-center">
                            <h3 class="fw-bold" id="totalCancel">0</h3>
                            <p class="mb-0 text-muted">মোট বাতিল</p>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-striped table-hover">
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

    </div>

    <div style="width:100%; height:2px; background:#ddd; margin:20px 0; position:relative; overflow:hidden;">
        <span style="display:inline-block; width:35px; height:2px; background:#007bff; position:absolute; top:0px; left:0; animation: slideLR 8s infinite ease-in-out;"></span>
        <style>
            @keyframes slideLR {
                0% { left: 0; }
                50% { left: calc(100% - 25px); }
                100% { left: 0; }
            }
        </style>
    </div>

    <div class="row justify-content-center m-5">
        <div class="col-md-2 p-4 rounded bg-black">
            <img src="{{ asset('images/logo.svg') }}" alt="Pro Dev Ltd. Logo" />
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(function () {
            let chartInstance = null;
            const key = 'savedPhone';
    
            // Load saved phone number
            $('#phoneInput').val(localStorage.getItem(key) || '');
            $('#phoneInput').on('input', e => localStorage.setItem(key, e.target.value));
    
            $('#submit-btn').click(function (e) {
                e.preventDefault();
                let phone = $('#phoneInput').val().trim();
                if (!phone.match(/^\d{11}$/)) return alert('সঠিক ফোন নাম্বার লিখুন (১১ ডিজিট)');
    
                $('#loading-screen').show();
                $('#serch-image').hide();
                $('#content-data').hide();
    
                $.get('/check', { phone: phone }, function (res) {
                    if (!res.status) return alert('ডেটা পাওয়া যায়নি');
    
                    $('#loading-screen').hide();
                    $('#content-data').show();
    
                    let { totalSummary, Summaries } = res.data;
    
                    animateChart(totalSummary.successRate);
                    animateNumbers(totalSummary);
    
                    let riskData = totalSummary.successRate < 50 ? {
                        label: 'High Risk',
                        bg: '#fde2e1',
                        border: '#e63946',
                        color: '#e63946'
                    } : totalSummary.successRate < 75 ? {
                        label: 'Moderate Risk',
                        bg: '#fff3cd',
                        border: '#ffb703',
                        color: '#ffb703'
                    } : {
                        label: totalSummary.successRate < 90 ? 'Great Customer' : 'Excellent Customer',
                        bg: '#e0f7fa',
                        border: '#00b606ff',
                        color: '#00b606ff'
                    };
    
                    $('#riskLabel').text(riskData.label).css({
                        'background-color': riskData.bg,
                        'border-left': `6px solid ${riskData.border}`,
                        'color': riskData.color,
                        'padding': '4px 8px',
                        'display': 'inline-block'
                    });
    
                    $('#courierTableBody').html(Object.entries(Summaries).map(([courier, data]) => {
                        let cancelRate = data.total > 0 ? ((data.cancel / data.total) * 100).toFixed(1) : '0.0';
                        return `<tr>
                            <td><img src="${data.logo}" alt="${courier}" style="height:20px; margin-right:6px; vertical-align:middle;"> ${courier}</td>
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
    
                chartInstance = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [currentValue, 100 - currentValue],
                            backgroundColor: [
                                finalValue < 50 ? '#e63946' : finalValue < 75 ? '#ffb703' : '#00b606ff',
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
                            ctx.fillStyle = "#001825ff";
                            ctx.textAlign = "center";
                            ctx.textBaseline = "middle";
                            ctx.fillText(Math.round(currentValue) + "%", x, y);
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

</body>
</html>
