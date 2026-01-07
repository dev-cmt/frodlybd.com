<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Helpers\FrodlyHelper;
use Carbon\Carbon;

class FrodlyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120;
    public $tries   = 1;

    protected string $phone;
    protected string $webhook;

    public function __construct(string $phone, string $webhook)
    {
        $this->phone   = $phone;
        $this->webhook = $webhook;
    }

    public function handle()
    {
        $cacheKey = 'frodly:last_run_at';
        // Check last run time
        $lastRun = Cache::get($cacheKey);
        if ($lastRun) {
            $elapsed = now()->diffInSeconds(Carbon::parse($lastRun));
            if ($elapsed < 10) {
                $wait = 10 - $elapsed;
                sleep($wait); // Wait remaining time
            }
        }
        // Update last run timestamp
        Cache::put($cacheKey, now()->toDateTimeString(), 3600); // cache 1 hour

        // -------- JOB LOGIC --------
        $results = [
            'Redx'      => FrodlyHelper::getRedx($this->phone),
            'SteadFast' => FrodlyHelper::getSteadFast($this->phone),
            'Pathao'    => FrodlyHelper::getPathao($this->phone),
            'Paperfly'  => FrodlyHelper::getPaperfly($this->phone),
        ];

        $summaries = array_map(fn ($d) => [
            'total'   => $d['total']   ?? 0,
            'success' => $d['success'] ?? 0,
            'cancel'  => $d['cancel']  ?? 0,
        ], $results);

        $total   = array_sum(array_column($results, 'total'));
        $success = array_sum(array_column($results, 'success'));
        $cancel  = array_sum(array_column($results, 'cancel'));

        $payload = [
            'status' => 200,
            'phone'  => $this->phone,
            'data'   => [
                'couriers' => $summaries,
                'summary'  => [
                    'total'       => $total,
                    'success'     => $success,
                    'cancel'      => $cancel,
                    'successRate' => $total ? round(($success / $total) * 100) : 0,
                    'cancelRate'  => $total ? round(($cancel / $total) * 100) : 0,
                ],
            ],
        ];

        // Send webhook if provided
        if ($this->webhook) {
            try {
                Http::timeout(25)->post($this->webhook, $payload);
            } catch (\Exception $e) {
                Log::error('FrodlyJob webhook failed', [
                    'phone' => $this->phone,
                    'error' => $e->getMessage()
                ]);
            }
        }

        Log::info('FrodlyJob completed: ', ['phone' => $this->phone]);
    }
}
