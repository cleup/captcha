# Cleup Captcha

Basic captcha for project security

####Installation
With composer:

```
composer require cleup/captcha
```

####Usage

##### Create an image

Create a captcha image and place it in a controller file or on a separate page of your application:

```php
use Cleup\Package\Captcha\Image;

# Instance of the class
$captcha = new Image([
    # Captcha Parameters
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

/* The end of the file. */
```
##### Output data on html page
```php
...
<img src="/image.php" alt="Captcha"/>
// Or 
<img src="/captcha/image.php?<?= rand(10, 1000); ?>" alt="Captcha"/>
...
```

##### Code verification
Code verification works using sessions. Make sure that the session is initiated and available for recording:

```php
use Cleup\Package\Captcha\Verification;
# Instance of the class
$verification = new Verification();

// Raw data
$data = json_decode(
    file_get_contents('php://input'),
    true
);

// Getting the code
$code = $data['code'] ?? false;

if (!$code) {
    $response = [
        'success' => false,
        'message' => 'You have not entered the required data'
    ];
} else {

    if ($verification->verify($code)) {
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
```

If you have any difficulties, then study the demo version of the project in the `demo` folder