<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Frodly Courier Check</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <!-- Header Card -->
    <div class="card shadow-lg mb-4 border-0">
        <div class="card-header bg-primary text-white rounded-top-3">
            <div class="d-flex align-items-center">
                <i class="bi bi-truck fs-1 me-3"></i>
                <div>
                    <h1 class="h2 mb-0">Frodly Courier Check</h1>
                    <p class="mb-0 opacity-75">Batch phone number verification system</p>
                </div>
            </div>
        </div>

        <div class="card-body bg-light">
            <!-- Stats Row -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card text-center h-100 border-primary">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Total Numbers</h6>
                            <h2 id="total-count" class="text-primary mb-0">60</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center h-100 border-success">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Successful</h6>
                            <h2 id="success-count" class="text-success mb-0">0</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center h-100 border-danger">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Failed</h6>
                            <h2 id="failed-count" class="text-danger mb-0">0</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center h-100 border-warning">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Progress</h6>
                            <h2 id="progress-percent" class="text-warning mb-0">0%</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Control Panel -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-gear me-2"></i>Control Panel</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
                        <button id="start-btn" class="btn btn-primary btn-lg">
                            <i class="bi bi-play-circle me-2"></i>Start Processing
                        </button>
                        <button id="pause-btn" class="btn btn-warning btn-lg" disabled>
                            <i class="bi bi-pause-circle me-2"></i>Pause
                        </button>
                        <button id="reset-btn" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-arrow-clockwise me-2"></i>Reset
                        </button>
                        @php
                            if (request()->query('action') === 'truncate_jobs') {
                                \Illuminate\Support\Facades\DB::table('jobs')->truncate();
                                \Illuminate\Support\Facades\DB::table('failed_jobs')->truncate();
                                echo "<script>window.location.href='" . request()->url() . "';</script>";
                                exit;
                            }
                        @endphp
                        <form method="GET" action="">
                            <button type="submit" name="action" value="truncate_jobs"
                                    id="delete-jobs-btn" class="btn btn-outline-danger btn-lg"
                                    onclick="return confirm('Are you sure you want to delete all jobs?')">
                                <i class="bi bi-trash me-2"></i>Delete Jobs
                            </button>
                        </form>

                        <div class="ms-auto">
                            <div class="input-group">
                                <span class="input-group-text">Delay</span>
                                <select id="delay-select" class="form-select">
                                    <option value="0" selected>No delay</option>
                                    <option value="500">0.5 seconds</option>
                                    <option value="1000">1 second</option>
                                    <option value="2000">2 seconds</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Processing Progress</span>
                            <span id="progress-text">0/60</span>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated"
                                 role="progressbar" style="width: 0%"
                                 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Results</h5>
                    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#response-list-collapse">
                        <i class="bi bi-chevron-down"></i>
                    </button>
                </div>
                <div class="collapse show" id="response-list-collapse">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th width="150">Phone Number</th>
                                        <th width="120">Status</th>
                                        <th>Response</th>
                                        <th width="150">Time</th>
                                    </tr>
                                </thead>
                                <tbody id="response-table">
                                    <!-- Results will be inserted here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const numbers = [
        "01738606158","01726319619","01879200750","01641389658","01812337616",
        "01946377865","01711506053","01917984002","01796355555","01772366352",
        "01537657779","01909302126","01879407777","01859001413","01304040910",
        "01919858585","01919220992","01836257538","01957269480","01883270119",
        "01798168537","01311145385","01979247649","01718117901","01776296648",
        "01324523404","01852210052","01701014050","01788332338","01316469005",
        "01738606158","01726319619","01879200750","01641389658","01812337616",
        "01946377865","01711506053","01917984002","01796355555","01772366352",
        "01537657779","01909302126","01879407777","01859001413","01304040910",
        "01919858585","01919220992","01836257538","01957269480","01883270119",
        "01798168537","01311145385","01979247649","01718117901","01776296648",
        "01324523404","01852210052","01701014050","01788332338","01316469005"
    ];

    let current = 0;
    let isRunning = false;
    let successCount = 0;
    let failedCount = 0;
    let delay = 0;

    // Update stats
    function updateStats() {
        $('#total-count').text(numbers.length);
        $('#success-count').text(successCount);
        $('#failed-count').text(failedCount);
        $('#progress-percent').text(Math.round((current / numbers.length) * 100) + '%');
        $('#progress-text').text(`${current}/${numbers.length}`);
    }

    // Send single number
    function sendNumber(number) {
        return $.ajax({
            url: '/api/check-courier',
            method: 'POST',
            contentType: 'application/json',
            headers: {
                'X-Webhook-URL': 'https://app.hooklistener.com/w/my-first-endpoint-l7mu'
            },
            data: JSON.stringify({ phone: number }),
            timeout: 10000
        });
    }

    // Process next number
    async function processNext() {
        if (!isRunning || current >= numbers.length) {
            if (current >= numbers.length) {
                $('#start-btn').html('<i class="bi bi-check-circle me-2"></i>Completed');
                $('#start-btn').prop('disabled', true);
                $('#pause-btn').prop('disabled', true);
            }
            return;
        }

        const number = numbers[current];
        const index = current + 1;

        try {
            // Add to table as processing
            const time = new Date().toLocaleTimeString();
            $('#response-table').prepend(`
                <tr id="row-${index}" class="table-warning">
                    <td>${index}</td>
                    <td><code>${number}</code></td>
                    <td><span class="badge bg-warning">Processing</span></td>
                    <td><em>Sending request...</em></td>
                    <td>${time}</td>
                </tr>
            `);

            // Send request
            const response = await sendNumber(number);

            // Update row with success
            $(`#row-${index}`).removeClass('table-warning').addClass('table-success');
            $(`#row-${index} td:nth-child(3)`).html('<span class="badge bg-success">Success</span>');
            $(`#row-${index} td:nth-child(4)`).html(
                `<code class="text-success">${JSON.stringify(response.data || response)}</code>`
            );
            successCount++;

        } catch (error) {
            // Update row with failure
            $(`#row-${index}`).removeClass('table-warning').addClass('table-danger');
            $(`#row-${index} td:nth-child(3)`).html('<span class="badge bg-danger">Failed</span>');
            $(`#row-${index} td:nth-child(4)`).html(
                `<code class="text-danger">${error.statusText || 'Request failed'}</code>`
            );
            failedCount++;
        }

        // Update progress
        current++;
        const progress = Math.round((current / numbers.length) * 100);
        $('#progress-bar')
            .css('width', progress + '%')
            .attr('aria-valuenow', progress)
            .text(progress + '%');

        updateStats();

        // Process next with delay
        if (isRunning && current < numbers.length) {
            setTimeout(processNext, delay);
        } else if (current >= numbers.length) {
            $('#start-btn').html('<i class="bi bi-check-circle me-2"></i>Completed');
            $('#start-btn').prop('disabled', true);
            $('#pause-btn').prop('disabled', true);
        }
    }

    // Start processing
    $('#start-btn').click(function() {
        if (!isRunning) {
            if (current >= numbers.length) return;

            isRunning = true;
            $(this).html('<i class="bi bi-pause-circle me-2"></i>Processing...');
            $(this).prop('disabled', true);
            $('#pause-btn').prop('disabled', false);

            // Start processing batch with concurrency of 1
            processNext();
        }
    });

    // Pause/Resume processing
    $('#pause-btn').click(function() {
        if (isRunning) {
            isRunning = false;
            $(this).html('<i class="bi bi-play-circle me-2"></i>Resume');
            $('#start-btn').prop('disabled', false);
            $('#start-btn').html('<i class="bi bi-play-circle me-2"></i>Resume Processing');
        } else {
            isRunning = true;
            $(this).html('<i class="bi bi-pause-circle me-2"></i>Pause');
            $('#start-btn').prop('disabled', true);
            $('#start-btn').html('<i class="bi bi-pause-circle me-2"></i>Processing...');
            processNext();
        }
    });

    // Reset everything
    $('#reset-btn').click(function() {
        isRunning = false;
        current = 0;
        successCount = 0;
        failedCount = 0;

        $('#progress-bar')
            .css('width', '0%')
            .attr('aria-valuenow', 0)
            .text('');

        $('#response-table').empty();

        $('#start-btn')
            .prop('disabled', false)
            .html('<i class="bi bi-play-circle me-2"></i>Start Processing');

        $('#pause-btn')
            .prop('disabled', true)
            .html('<i class="bi bi-pause-circle me-2"></i>Pause');

        updateStats();
    });

    // Update delay
    $('#delay-select').change(function() {
        delay = parseInt($(this).val());
    });

    // Initialize stats
    updateStats();
});
</script>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
