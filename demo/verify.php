<?php

use Cleup\Package\Captcha\Verification;

require_once __DIR__ . '/../vendor/autoload.php';

$captcha = new Verification();
$data = json_decode(
    file_get_contents('php://input'),
    true
);
$code = $data['code'] ?? false;

if (!$code) {
    $response = [
        'success' => false,
        'message' => 'You have not entered the required data'
    ];
} else {

    if ($captcha->verify($code)) {
        $response = [
            'success' => true,
            'message' => 'The code is correct'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'The code is incorrect'
        ];
    }
}

header('Content-type: application/json');
echo json_encode($response);
