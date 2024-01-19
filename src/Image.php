<?php

namespace Cleup\Package\Captcha;

class Image
{

    /**
     * @var array $fontList
     */
    private $fontList = array(
        'AntykwaBold',
        'Ding-DongDaddyO',
        'Duality',
        'Jura',
        'VeraSansBold',
        'StayPuft',
        'BrahmsGotischCyr',
        'Alkalami-Regular'
    );

    /**
     * @var array $cfg
     */
    private $cfg = array();

    /**
     * 
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->cfg = array(
            'length' => random_int(5, 7),
            'fontSize' => 24,
            'allowedCharacters' => '1234567890abcdefghijkmnpqrstuvwxyz',
            'width' => 140,
            'height' => 60,
            'maxLines' => 8,
            'minLines' => 4,
            'pointColor' => array(77, 77, 77),
            'textColor' => array(
                rand(0, 78),
                rand(0, 100),
                rand(0, 7)
            )
        );

        $this->cfg = array_merge($this->cfg, $config);
    }

    /**
     * Use config
     * 
     * @param string $key
     * @param mixed $default
     */
    protected function config(string $key, mixed $default = ''): mixed
    {
        return $this->cfg[$key] ?? $default;
    }

    /**
     * Get the full path to the font file
     * 
     */
    protected function fontPath(): string
    {
        $count = count($this->fontList) - 1;
        $rand = random_int(0, $count);
        $font = $this->fontList[$rand];

        return  __DIR__ . '/fonts/' . $font . '.ttf';
    }

    /**
     * Create a captcha image
     * 
     */
    public function create(): void
    {
        $width =  $this->config('width');
        $height = $this->config('height');
        $chars =  str_shuffle($this->config('allowedCharacters'));
        $code = substr($chars, 0, $this->config('length', 6));
        $image = imagecreatetruecolor($width, $height);

        if ($image !== false) {
            $color = imagecolorallocatealpha($image, 0, 0, 0, 127);

            if ($color !== false) {
                $fontPath = $this->fontPath();
                imagesavealpha($image, true);
                imagefill($image, 0, 0, $color);
                $FontCalculate = imagettfbbox(
                    $this->config('fontSize', 24),
                    0,
                    $fontPath,
                    $code
                );
                $angle = random_int(-10, 10);
                $textColor = $this->config('textColor');
                $color = imagecolorallocate(
                    $image,
                    $textColor[0] ?? 0,
                    $textColor[1] ?? 0,
                    $textColor[2] ?? 0
                );

                if ($color !== false) {
                    imagettftext(
                        $image,
                        $this->config('fontSize', 24),
                        $angle,
                        (int) (($width / 2) - ($FontCalculate[4] / 2)),
                        (int)  (($height / 2) - ($FontCalculate[5] / 2)),
                        $color,
                        $fontPath,
                        $code
                    );

                    $pointColor = $this->config('pointColor', array());

                    for ($i = 0; $i < 1200; $i++) {
                        imagesetpixel(
                            $image,
                            rand() % $this->config('width'),
                            rand() % $this->config('height'),
                            imagecolorallocate(
                                $image,
                                $pointColor[0] ?? 0,
                                $pointColor[1] ?? 0,
                                $pointColor[2] ?? 0
                            )
                        );
                    }

                    $lines = random_int(
                        $this->config('minLines'),
                        $this->config('maxLines')
                    );

                    for ($i = 0; $i < $lines; $i++) {
                        imageline(
                            $image,
                            (int)$width,
                            (int)(($height / 2) - rand(1, 15) - ($FontCalculate[5] / 2)),
                            random_int(2, 4),
                            (int)(($height / 2) - rand(1, 25) - ($FontCalculate[5] / 2)),
                            imagecolorallocate(
                                $image,
                                random_int(125, 255),
                                random_int(125, 255),
                                random_int(125, 255)
                            )
                        );
                    }

                    $_SESSION['captcha'] = $code;
                }

                header('Content-type: image/png');
                imagepng($image);
                imagedestroy($image);
            }
        }
    }
}
