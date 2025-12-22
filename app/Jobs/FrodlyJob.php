<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\FrodlyHelper;
use Illuminate\Support\Facades\Cache;

class FrodlyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $phone;

    public $tries = 3;
    public $timeout = 120;

    public function __construct($phone)
    {
        $this->phone = $phone;
    }

    public function handle()
    {
        // 1️⃣ Call courier APIs
        $results = [
            'Redx'      => FrodlyHelper::getRedx($this->phone),
            'SteadFast' => FrodlyHelper::getSteadFast($this->phone),
            'Pathao'    => FrodlyHelper::getPathao($this->phone),
            'Paperfly'  => FrodlyHelper::getPaperfly($this->phone),
        ];

        // 2️⃣ Build summaries
        $summaries = array_map(function ($data) {
            return [
                'total'   => $data['total'] ?? 0,
                'success' => $data['success'] ?? 0,
                'cancel'  => $data['cancel'] ?? 0,
            ];
        }, $results);

        // 3️⃣ Total calculation
        $total_all   = array_sum(array_column($summaries, 'total'));
        $success_all = array_sum(array_column($summaries, 'success'));
        $cancel_all  = array_sum(array_column($summaries, 'cancel'));

        $totalSummary = [
            'total'       => $total_all,
            'success'     => $success_all,
            'cancel'      => $cancel_all,
            'successRate' => $total_all ? round(($success_all / $total_all) * 100) : 0,
            'cancelRate'  => $total_all ? round(($cancel_all / $total_all) * 100) : 0,
        ];

        // 4️⃣ Store result in cache (10 minutes)
        Cache::put(
            'courier_check_' . $this->phone,
            [
                'Summaries'    => $summaries,
                'totalSummary'=> $totalSummary,
            ],
            now()->addMinutes(10)
        );
    }

    public function failed(\Throwable $e)
    {
        Cache::put(
            'courier_check_' . $this->phone,
            ['error' => 'Courier check failed'],
            now()->addMinutes(10)
        );
    }
}
