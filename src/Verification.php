<?php

namespace Cleup\Package\Captcha;

class Verification
{

    /**
     * Regexp
     * @var string
     */
    protected $regexp = '/^[a-zA-Z0-9 \s]+$/';

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Custom Regular expression
     * 
     * @param string $regexp
     */

    public function setRegexp($regexp = ''): void
    {
        $this->regexp = $regexp;
    }

    /**
     * Check the code
     * 
     * @param string Code
     */
    public function verify($code): bool
    {
        return (
            !empty($code) &&
            !empty($_SESSION['captcha']) &&
            preg_match($this->regexp, $code) &&
            $_SESSION['captcha'] == $code
        );
    }
}
