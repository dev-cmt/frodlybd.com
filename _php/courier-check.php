<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // ==== CONFIG ====
    define('STEADFAST_EMAIL', 'unisalemart890@gmail.com');
    define('STEADFAST_PASSWORD', 'Babla2k12@#$%');

    define('REDX_PHONE', '01648811536');
    define('REDX_PASSWORD', 'DnBRedx2025$');
    define('REDX_TOKEN_FILE', __DIR__ . '/redx_token.cache');

    define('PATHAO_CLIENT_ID', 'APdRlXYaGy');
    define('PATHAO_CLIENT_SECRET', 'dkWMLtqJbTvOemaWwBwhy6bmDC6zv75AzCbKcqlS');
    define('PATHAO_USERNAME', 'mehedi1219004@gmail.com');
    define('PATHAO_PASSWORD', 'babla2k12@#');
    define('PATHAO_TOKEN_FILE', __DIR__ . '/pathao_token.json');

    // Courier logos (change to your URLs)
    $logos = [
        'Pathao'    => 'images/logo.svg',
        'Steadfast' => 'images/logo.svg',
        'Redx'      => 'images/logo.svg',
        'Paperfly'  => 'images/logo.svg'
    ];

    // ==== FUNCTIONS ====
    // Steadfast
    function steadfastCheck($phone) {
        $cookieFile = __DIR__ . '/steadfast_cookie.txt';
        $ch = curl_init('https://steadfast.com.bd/login');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_COOKIEJAR => $cookieFile,
            CURLOPT_COOKIEFILE => $cookieFile,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);
        $body = substr(curl_exec($ch), curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        if (!preg_match('/name="_token" value="([^"]+)"/', $body, $m) &&
            !preg_match('/<meta name="csrf-token" content="([^"]+)"/i', $body, $m))
            return ['success' => 0, 'cancel' => 0, 'total' => 0];
        $token = $m[1];

        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://steadfast.com.bd/login',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query(['_token' => $token, 'email' => STEADFAST_EMAIL, 'password' => STEADFAST_PASSWORD]),
            CURLOPT_HEADER => false
        ]);
        curl_exec($ch);

        curl_setopt_array($ch, [
            CURLOPT_URL => "https://steadfast.com.bd/user/frauds/check/$phone",
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POST => false
        ]);
        $data = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return [
            'success' => $data['total_delivered'] ?? 0,
            'cancel'  => $data['total_cancelled'] ?? 0,
            'total'   => ($data['total_delivered'] ?? 0) + ($data['total_cancelled'] ?? 0)
        ];
    }

    // RedX
    function getRedxToken() {
        if (file_exists(REDX_TOKEN_FILE) && time() - filemtime(REDX_TOKEN_FILE) < 3000)
            return trim(file_get_contents(REDX_TOKEN_FILE));

        $ch = curl_init('https://api.redx.com.bd/v4/auth/login');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode(['phone' => '88'.REDX_PHONE, 'password' => REDX_PASSWORD])
        ]);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (empty($res['data']['accessToken'])) return null;
        file_put_contents(REDX_TOKEN_FILE, $res['data']['accessToken']);
        return $res['data']['accessToken'];
    }
    function redxCheck($phone) {
        // $token = getRedxToken();
        $token = 'a47a79745b53b36afb14c782794c7dcdc691d09dd3161969fcfd732f18848b1df4bc87521e1cb9b9e27e528c052b42cbde3f6780abc861d8fdee8b55d8e6e9e6';
        if (!$token) return ['success' => 0, 'cancel' => 0, 'total' => 0];

        $ch = curl_init("https://redx.com.bd/api/redx_se/admin/parcel/customer-success-return-rate?phoneNumber=88$phone");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ["Authorization: Bearer $token", "Accept: application/json"]
        ]);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);

        $success = $res['data']['deliveredParcels'] ?? 0;
        $total = $res['data']['totalParcels'] ?? 0;

        return [
            'success' => $success,
            'cancel'  => $total - $success,
            'total'   => $total
        ];
    }

    // Pathao
    function getPathaoToken() {
        if (file_exists(PATHAO_TOKEN_FILE)) {
            $cached = json_decode(file_get_contents(PATHAO_TOKEN_FILE), true);
            if ($cached && isset($cached['access_token']) && time() < $cached['expires_at']) {
                return $cached['access_token'];
            }
        }
        $ch = curl_init('https://api-hermes.pathao.com/aladdin/api/v1/issue-token');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode([
                'client_id'     => PATHAO_CLIENT_ID,
                'client_secret' => PATHAO_CLIENT_SECRET,
                'grant_type'    => 'password',
                'username'      => PATHAO_USERNAME,
                'password'      => PATHAO_PASSWORD
            ]),
        ]);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (empty($res['access_token'])) return null;

        $expires_in = $res['expires_in'] ?? 3600;
        file_put_contents(PATHAO_TOKEN_FILE, json_encode([
            'access_token' => $res['access_token'],
            'expires_at'   => time() + $expires_in - 60
        ]));

        return $res['access_token'];
    }
    function pathaoCheck($phone) {
        $token = getPathaoToken();
        if (!$token) return ['success' => 0, 'cancel' => 0, 'total' => 0];

        $ch = curl_init('https://merchant.pathao.com/api/v1/user/success');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $token",
                'Content-Type: application/json'
            ],
            CURLOPT_POSTFIELDS => json_encode(['phone' => $phone])
        ]);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);

        $success = $res['data']['customer']['successful_delivery'] ?? 0;
        $total = $res['data']['customer']['total_delivery'] ?? 0;

        return [
            'success' => $success,
            'cancel'  => $total - $success,
            'total'   => $total
        ];
    }

    // Paperfly
    function paperflyCheck($phone) {
        $ch = curl_init('https://api.paperfly.com.bd/v1/merchant/parcel/success');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode(['phone' => $phone])
        ]);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (empty($res['data'])) return ['success' => 0, 'cancel' => 0, 'total' => 0];

        $data = $res['data'];
        return [
            'success' => $data['successful_delivery'] ?? 0,
            'cancel'  => $data['total_delivery'] - ($data['successful_delivery'] ?? 0),
            'total'   => $data['total_delivery'] ?? 0
        ];
    }

    // ==== API HANDLER ====
    header('Content-Type: application/json');

    $phone = $_GET['phone'] ?? '';
    if (!preg_match('/^\d{11}$/', $phone)) {
        echo json_encode(['status' => false, 'message' => 'Invalid phone number']);
        exit;
    }

    $results = [
        'Pathao'    => pathaoCheck($phone),
        'Steadfast' => steadfastCheck($phone),
        'Redx'      => redxCheck($phone),
        'Paperfly'      => paperflyCheck($phone)
    ];

    // Build summary array
    $summaries = [];
    $total_all = $success_all = $cancel_all = 0;
    foreach ($results as $courier => $data) {
        $summaries[$courier] = [
            'logo'    => $logos[$courier] ?? '',
            'total'   => $data['total'],
            'success' => $data['success'],
            'cancel'  => $data['cancel']
        ];
        $total_all   += $data['total'];
        $success_all += $data['success'];
        $cancel_all  += $data['cancel'];
    }

    $response = [
        'status'  => true,
        'message' => 'Courier info retrieved successfully.',
        'data'    => [
            'Summaries'    => $summaries,
            'totalSummary' => [
                'total'     => $total_all,
                'success'     => $success_all,
                'cancel'      => $cancel_all,
                'successRate' => $total_all ? round(($success_all / $total_all) * 100) : 0,
                'cancelRate'  => $total_all ? round(($cancel_all / $total_all) * 100) : 0
            ]
        ]
    ];

    echo json_encode($response, JSON_PRETTY_PRINT);
?>