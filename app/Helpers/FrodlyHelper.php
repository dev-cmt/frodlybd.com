<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**------------------------------------------------
 * REDX
 * ------------------------------------------------
 */
function redxLogin(): ?string
{
    $config = [
        'phone'      => '01648811536',
        'password'   => 'DnBRedx2025$',
        'token_file' => public_path('frodly/redx_token.json'),
        'api_base'   => 'https://api.redx.com.bd/v4',
    ];

    // Ensure directory exists
    @mkdir(dirname($config['token_file']), 0777, true);

    // If token is fresh (less than 50 minutes old), use it
    if (file_exists($config['token_file']) && time() - filemtime($config['token_file']) < 50 * 60) {
        return trim(file_get_contents($config['token_file']));
    }

    // Otherwise, authenticate
    $ch = curl_init("{$config['api_base']}/auth/login");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS     => json_encode([
            'phone'    => '88' . $config['phone'],
            'password' => $config['password'],
        ]),
    ]);

    $response = curl_exec($ch);
    $res = json_decode($response, true);
    curl_close($ch);

    if (!isset($res['data']['accessToken'])) {
        return null;
    }

    file_put_contents($config['token_file'], $res['data']['accessToken']);
    return $res['data']['accessToken'];
}

function getRedx(string $phone): array
{
    // $token = redxLogin();
    // $token = config('frodly.steadfast.token_data');
    $token = 'd69b5422604b55c383ca962b3bd14882d9164abd19f349dada31a5bcf8239474ae76156c6b7642b3bc748fe4daa670f3c2ed26e3db1523451e7144f1324b7c1e';
    if (!$token) {
        return ['success' => 0, 'cancel' => 0, 'total' => 0];
    }

    $url = "https://redx.com.bd/api/redx_se/admin/parcel/customer-success-return-rate?phoneNumber=88$phone";
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => [
            "Authorization: Bearer $token",
            "Accept: application/json"
        ],
    ]);

    $response = curl_exec($ch);
    $res = json_decode($response, true);
    curl_close($ch);

    $success = $res['data']['deliveredParcels'] ?? 0;
    $total = $res['data']['totalParcels'] ?? 0;

    return [
        'success' => $success,
        'cancel'  => $total - $success,
        'total'   => $total
    ];
}



/**------------------------------------------------
 * STEADFAST => MUST LOGIN
 * ------------------------------------------------
 */
function steadFastLogin()
{
    $config = [
        'email'       => 'unisalemart890@gmail.com',
        'password'    => 'Babla2k12@#$%',
        'cookie_file' => public_path('frodly/steadfast_cookie.txt'),
        'base_url'    => 'https://steadfast.com.bd/login',
    ];

    @mkdir(dirname($config['cookie_file']), 0777, true);

    $ch = curl_init($config['base_url']);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER         => true,
        CURLOPT_COOKIEJAR      => $config['cookie_file'],
        CURLOPT_COOKIEFILE     => $config['cookie_file'],
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    ]);

    $response = curl_exec($ch);
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $body = substr($response, $headerSize);

    // CSRF TOKEN
    if (!preg_match('/name="_token" value="([^"]+)"/', $body, $m) && !preg_match('/<meta name="csrf-token" content="([^"]+)"/i', $body, $m)) {
        curl_close($ch);
        return false;
    }

    $token = $m[1];

    curl_setopt_array($ch, [
        CURLOPT_URL        => $config['base_url'],
        CURLOPT_POST       => true,
        CURLOPT_POSTFIELDS => http_build_query([
            '_token'   => $token,
            'email'    => $config['email'],
            'password' => $config['password']
        ]),
        CURLOPT_HEADER     => false
    ]);


    curl_exec($ch);

    return $ch;
}

function getSteadFast($phone)
{
    // Login url or other information get
    $ch = steadFastLogin();

    if (!$ch) {return ['success' => 0, 'cancel' => 0, 'total' => 0];}

    curl_setopt_array($ch, [
        CURLOPT_URL             => "https://steadfast.com.bd/user/frauds/check/$phone",
        CURLOPT_HTTPHEADER      => ['Content-Type: application/json'],
        CURLOPT_POST            => false,
        CURLOPT_RETURNTRANSFER  => true,
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    return [
        'success' => $data['total_delivered'] ?? 0,
        'cancel'  => $data['total_cancelled'] ?? 0,
        'total'   => ($data['total_delivered'] ?? 0) + ($data['total_cancelled'] ?? 0)
    ];
}

/**------------------------------------------------
 * PATHAO 
 * ------------------------------------------------
 */
function pathaoLogin(): ?string
{
    $config = [
        'email'         => 'stylisfirst@gmail.com',
        'password'      => 'STYLIS@22bd',
        'client_id'     => 'APdRlXYaGy',
        'client_secret' => 'dkWMLtqJbTvOemaWwBwhy6bmDC6zv75AzCbKcqlS',
        'token_cache'   =>  public_path('frodly/pathao_token.json'),
        'token_url'     => 'https://api-hermes.pathao.com/aladdin/api/v1/issue-token',
    ];
    // Ensure folder exists
    @mkdir(dirname($config['token_cache']), 0777, true);

    // Check if cached token is still valid
    if (file_exists($config['token_cache'])) {
        $cache = json_decode(file_get_contents($config['token_cache']), true);
        if (!empty($cache['access_token']) && $cache['expires_at'] > time()) {
            return $cache['access_token'];
        }
    }

    // Request new token
    $response = Http::withHeaders(['Content-Type' => 'application/json'])
        ->timeout(15)
        ->post($config['token_url'], [
            'client_id'     => $config['client_id'],
            'client_secret' => $config['client_secret'],
            'grant_type'    => 'password',
            'username'      => $config['email'],
            'password'      => $config['password'],
        ]);

    if (!$response->successful()) {
        Log::error("Pathao token request failed", [
            'status'   => $response->status(),
            'response' => $response->body()
        ]);
        return null;
    }

    $res = $response->json();
    if (empty($res['access_token'])) {
        return null;
    }

    // Cache token in file
    file_put_contents($config['token_cache'], json_encode([
        'access_token' => $res['access_token'],
        // 'expires_at'   => time() + ($res['expires_in'] ?? 3600) - 60 // Optional
    ]));

    return $res['access_token'];
}

function getPathao(string $phoneNumber): array
{
    $timeout  = 15;
    $maxTries = 2;
    $baseUrl  = 'https://merchant.pathao.com/api/v1';

    if (!preg_match('/^01[3-9]\d{8}$/', $phoneNumber)) {
        return ['status' => 'error', 'message' => 'Invalid phone number format'];
    }

    for ($i = 0; $i < $maxTries; $i++) {
        // $token = pathaoLogin();
        // $token = config('frodly.pathao.token_data');
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxMDQyOCIsImp0aSI6ImExNjYyMzU4ZTVhNjlhNzdmOTgwOTA3NzY1N2U4NjFlNzFlMGI1MTEzYTJmZDIwZWUyY2EyOTRiMGYwMGZkYTZlYzRjNTliMmY1MTI3ZTI5IiwiaWF0IjoxNzU1MTkyNTk1LjM3MTE4LCJuYmYiOjE3NTUxOTI1OTUuMzcxMTgzLCJleHAiOjE3NjI5Njg1OTUuMzU5NjQ3LCJzdWIiOiIzMDE2ODkiLCJzY29wZXMiOltdfQ.h_Ht1xvpNtPWiDbeL3z0Axb1Dpc9_qvkhRDXuZrEk0jbAfZW3qQ7bEVEMXb_YrsPWXDe6czeEZvos7thGPmjK-trM6-xNRYCWehsF0_xJz-rX6sQpF_12Iqu4s5R7AuTkaUmxyxJOHv3UQRHuMOc59SRmSqZtTmQ_vYWNvvBdyUEJ9pG6j2bLiHDySUbm9Kx4ucM4f9n5yZ6R3fYMyGRReHKSZLY7hHxxlLcAdUOBG68VsnYapalV7QzwD6H2OLhS_9H88U2CFGyt0ITD_F2Ans-LgNd_jN76lJuy0XYXuMy8K1248FiPy9MvPXgiEGlLzfMBQ_eRQSsTVqS604f-TEU9PI_4jdSgOtsI8qAfEn_q62N8gl2tUhrZrp2epZUcUoT3I4uLIvwhtyzm8gL814dDPmMHnYCzZHMc_bRwTp0bQHvDPi9E5lyEnARVU-SkjYuABLczQI95hq9or43dMFiy48SQ89Fu6D5Z8AyzQ_rcdA_6uqGDzdR-0wsg9wtKw1pr7XtSMLuvmkHUZSKvS48v3mIwddVnJCRWKNyVcV3F9Tz8MUHsma0hdT6ocag068Q0gFDq0J42oE7ush9-bVAfrYge7I3AncWrcJS4sCkX-QaCgJHPmylmkP82HZGzToRNYW8uJ_ZebynoBGclryjT95gKqOy3LiJFq-kZEs';
        if (!$token) {
            // Skip to next attempt
            continue;
        }
        
        $response = Http::withHeaders([
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])
            ->timeout($timeout)
            ->post("{$baseUrl}/user/success", ['phone' => $phoneNumber]);

        if ($response->successful()) {
            $res     = $response->json();
            $success = $res['data']['customer']['successful_delivery'] ?? 0;
            $total   = $res['data']['customer']['total_delivery'] ?? 0;

            return [
                'success' => $success,
                'cancel'  => $total - $success,
                'total'   => $total,
            ];
        }
    }

    return ['success' => 0, 'cancel' => 0, 'total' => 0, 'status' => 'Max retries reached'];
}

/**------------------------------------------------
 * PAPERFLY 
 * ------------------------------------------------
 */
function getPaperfly(string $phoneNumber): array
{
    return [
        'success' => 0,
        'cancel'  => 0,
        'total'   => 0,
        'status'  => 'success'
    ];
}


/**------------------------------------------------
 * RESPONSE FUNTION => NOT USING
 * ------------------------------------------------
 */
function successResponse(array $data): array
{
    return [
        'success' => $data['total_delivered'] ?? 0,
        'cancel'  => $data['total_cancelled'] ?? 0,
        'total'   => ($data['total_delivered'] ?? 0) + ($data['total_cancelled'] ?? 0),
        'status'  => 'success'
    ];
}

function errorResponse(string $message): array
{
    return [
        'success' => 0,
        'cancel'  => 0,
        'total'   => 0,
        'status'  => 'success' . $message
    ];
}