<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Helpers\FrodlyHelper;

use App\Jobs\FrodlyJob;
use Illuminate\Support\Facades\Cache;

class FrodlyController extends Controller
{

    public function checkInfo(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^\d{11}$/'
        ]);

        $phone = $request->phone;

        // Remove old cache if exists
        Cache::forget('courier_check_' . $phone);

        // Dispatch queue job
        FrodlyJob::dispatch($phone);

        return response()->json([
            'status'  => 202,
            'message' => 'Courier check is processing',
            'key'     => 'courier_check_' . $phone
        ]);
    }

    // 2️⃣ Get result
    public function result($phone)
    {
        $data = Cache::get('courier_check_' . $phone);

        if (!$data) {
            return response()->json([
                'status' => 202,
                'message' => 'Processing...'
            ]);
        }

        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }


    public function check(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^\d{11}$/'
        ]);

        $phone = $request->input('phone');

        dd(FrodlyHelper::getSteadFast($phone));
        
        // ✅ LOG REQUEST (time + phone + ip)
        Log::channel('courier')->info('Courier API request', [
            'phone' => $phone,
            'time'  => now()->toDateTimeString(),
            'ip'    => $request->ip(),
        ]);
        
        $lockKey = 'courier_lock_' . $phone;
        
        // ⏳ WAIT until lock is free (max wait handled naturally)
        $startTime = microtime(true);
        while (Cache::has($lockKey)) {
            usleep(100000); // 0.1s sleep
            // Optional timeout: prevent infinite wait
            if ((microtime(true) - $startTime) > 10) {
                break;
            }
        }
    
        // Lock for 5 seconds
        Cache::put($lockKey, true, 5);

        // Call courier methods
        $results = [
            'Redx'       => FrodlyHelper::getRedx($phone),
            'SteadFast'  => FrodlyHelper::getSteadFast($phone),
            'Pathao'     => FrodlyHelper::getPathao($phone),
            'Paperfly'   => FrodlyHelper::getPaperfly($phone),
        ];

        // Build summary
        $summaries = array_map(function($data) {
            return [
                'total'   => $data['total'],
                'success' => $data['success'],
                'cancel'  => $data['cancel'],
            ];
        }, $results);

        $total_all   = array_sum(array_column($results, 'total'));
        $success_all = array_sum(array_column($results, 'success'));
        $cancel_all  = array_sum(array_column($results, 'cancel'));

        $totalSummary = [
            'total'       => $total_all,
            'success'     => $success_all,
            'cancel'      => $cancel_all,
            'successRate' => $total_all ? round(($success_all / $total_all) * 100) : 0,
            'cancelRate'  => $total_all ? round(($cancel_all / $total_all) * 100) : 0,
        ];

        return response()->json([
            'status'  => 200,
            'message' => 'Courier info retrieved successfully.',
            'data'    => [
                'Summaries'   => $summaries,
                'totalSummary'=> $totalSummary,
            ]
        ]);
    }


    public function checkManualy(Request $request)
    {
        // Get token from header or query
        $token = $request->header('X-API-TOKEN') ?? $request->query('token');

        // Predefined token or phone
        $validToken = '1234567890abcdef';

        if (!$token || $token !== $validToken) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or missing token'
            ], 401);
        }

        // Validate phone
        $request->validate([
            'phone' => 'required|regex:/^\d{11}$/'
        ]);

        $phone = $request->input('phone');

        // Call courier methods
        $results = [
            'Redx'       => FrodlyHelper::getRedx($phone),
            'SteadFast'  => FrodlyHelper::getSteadFast($phone),
            'Pathao'     => FrodlyHelper::getPathao($phone),
            'Paperfly'   => FrodlyHelper::getPaperfly($phone),
        ];

        // Build summary
        $summaries = [];
        $total_all = $success_all = $cancel_all = 0;

        foreach ($results as $courier => $data) {
            $summaries[$courier] = [
                'logo'    => config("courier.logos." . strtolower($courier), ''),
                'total'   => $data['total'],
                'success' => $data['success'],
                'cancel'  => $data['cancel']
            ];

            $total_all   += $data['total'];
            $success_all += $data['success'];
            $cancel_all  += $data['cancel'];
        }

        return response()->json([
            'status' => true,
            'message' => 'Courier info retrieved successfully.',
            'data' => [
                'Summaries'   => $summaries,
                'totalSummary'=> [
                    'total'       => $total_all,
                    'success'     => $success_all,
                    'cancel'      => $cancel_all,
                    'successRate' => $total_all ? round(($success_all / $total_all) * 100) : 0,
                    'cancelRate'  => $total_all ? round(($cancel_all / $total_all) * 100) : 0
                ]
            ]
        ]);

    }
}

