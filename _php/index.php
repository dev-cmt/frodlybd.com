<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Frodly</title>
    <link rel="icon" type="image/x-icon" href="/images/logo.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css"/>
</head>

<body>

    <div class="container py-5">
        <h1 class="logo_brand">Frodly</h1>
        <p class="text-center text-muted">পার্সেল রিটার্ন এর পরিমাপ করুন</p>

        <div class="row justify-content-center my-5">
            <div class="col-md-8">
                <div class="input-group search-box">
                    <input type="text" class="form-control" placeholder="01XXXXXXXXXX" aria-label="Search by Phone Number" />
                    <button class="btn btn-primary" id="submit-btn">রিপোর্ট দেখুন</button>
                </div>
            </div>
        </div>

        <div id="defult-show">
            <div class="row justify-content-center">
                <div class="col-md-3 text-center">
                    <img src="images/find-fraud.png" alt="Find Fraud" class="img-fluid" />
                </div>
            </div>
        </div>

        <div class="row d-none" id="fraud-data">
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
            <img src="images/logo.svg" alt="Pro Dev Ltd. Logo" />
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function () {
            let chartInstance = null;

            $('#submit-btn').click(function (e) {
                e.preventDefault();
                let phone = $('.search-box input').val().trim();
                if (!phone.match(/^\d{11}$/)) return alert('সঠিক ফোন নাম্বার লিখুন (১১ ডিজিট)');

                $('#defult-show').html('<div style="display:flex; justify-content:center; align-items:center; height:200px;"><img src="images/loading-200x200x.gif" alt="Loading..." /></div>').addClass('show');

                $.get('courier-check.php', { phone: phone }, function (res) {
                    if (!res.status) return alert('ডেটা পাওয়া যায়নি');

                    let { totalSummary, Summaries } = res.data;
                    $('#fraud-data').removeClass('d-none');
                    // First fade in the container
                    $('#defult-show').addClass('d-none');
                    
                    // Then animate the chart and numbers
                    animateChart(totalSummary.successRate);
                    animateNumbers(totalSummary);

                    // Updated risk colors here
                    let riskData = totalSummary.successRate < 50 ? { label: 'High Risk', bg: '#fde2e1', border: '#e63946', color: '#e63946' } :
                        totalSummary.successRate < 75 ?
                            { label: 'Moderate Risk', bg: '#fff3cd', border: '#ffb703', color: '#ffb703' } :
                            { label: totalSummary.successRate < 90 ? 'Great Customer' : 'Excellent Customer', bg: '#e0f7fa', border: '#00b606ff', color: '#00b606ff' };

                    $('#riskLabel').text(riskData.label).css({
                        'background-color': riskData.bg,
                        'border-left-color': riskData.border,
                        'color': riskData.color
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

                    $('#defult-show').removeClass('show');
                }).fail(() => {
                    alert('API কল ব্যর্থ হয়েছে');
                    $('#defult-show').html(`<div class="row justify-content-center">
                        <div class="col-md-3 text-center"><img src="images/find-fraud.png" alt="Find Fraud" class="img-fluid" /></div>
                    </div>`).addClass('show');
                });
            });

            // Animate numbers counting up
            function animateNumbers({total, success, cancel}) {
                $('.stat-box h3').each(function() {
                    $(this).addClass('counting');
                });
                
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
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    }
                };
                window.requestAnimationFrame(step);
            }

            // Update chart with animation
            function animateChart(finalValue) {
                const ctx = document.getElementById('successChart').getContext('2d');
                if (chartInstance) chartInstance.destroy();

                let currentValue = 0;
                const animationDuration = 1500; // 1.5 seconds
                const animationStep = finalValue / (animationDuration / 16); // 60fps
                
                chartInstance = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [currentValue, 100 - currentValue],
                            backgroundColor: [
                                finalValue < 50 ? '#e63946' : finalValue < 75 ? '#ffb703' : '#00b606ff', '#f1f1f1'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        cutout: '75%',
                        plugins: { legend: { display: false }, tooltip: { enabled: false } },
                        animation: {
                            duration: 0 // We'll handle animation manually
                        }
                    },
                    plugins: [{
                        id: 'centerText',
                        beforeDraw(chart) {
                            const { ctx, width } = chart;
                            ctx.save();
                            ctx.font = "bold 38px Segoe UI";
                            ctx.fillStyle = "#001825ff";
                            ctx.textAlign = "center";
                            ctx.textBaseline = "middle";
                            ctx.fillText(Math.round(currentValue) + "%", width / 2, chart.chartArea.height / 2 + chart.chartArea.top);
                        }
                    }]
                });
                
                // Animate the chart
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

        $(function() {
            // Load saved phone number from localStorage
            const key = 'savedPhone';
            $('#phoneInput').val(localStorage.getItem(key) || '');
            $('#phoneInput').on('input', e => localStorage.setItem(key, e.target.value));
        });
    </script>
</body>
</html>