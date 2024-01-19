<?php

use Cleup\Package\Captcha\Image;

require_once __DIR__ . '/../vendor/autoload.php';

// Instance of the class
$captcha = new Image([
    // Captcha Parameters
    'width' => 300,
    'height' => 60,
    /* You can set a range for these parameters using various methods (rand, random_int) */
    // 'length' => 5,
    // 'fontSize' => 24,
    // 'allowedCharacters' => '1234567890abcdefghijkmnpqrstuvwxyz',
    // 'width' => 140,
    // 'height' => 60,
    // 'maxLines' => 8,
    // 'minLines' => 4,
    // 'pointColor' => array(77, 77, 77),
    // 'textColor' => array(
    //     rand(0, 78),
    //     rand(0, 100),
    //     rand(0, 7)
    // )
]);

// Create a captcha image
$captcha->create();