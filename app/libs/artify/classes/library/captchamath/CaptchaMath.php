<?php
session_start(); // Asegúrate de que la sesión esté iniciada

class CaptchaSVG {
    public $objId = "";
    private $imageWidth = 200;
    private $imageHeight = 100;
    private $fontSize = 30;
    private $possibleChar = "123456789";
    private $mathsOperation = "+-*";

    function generateCaptcha() {
        // Generate CAPTCHA text
        $numberone = substr($this->possibleChar, mt_rand(0, strlen($this->possibleChar) - 1), 1);
        $numbertwo = substr($this->possibleChar, mt_rand(0, strlen($this->possibleChar) - 1), 1);
        $operator = substr($this->mathsOperation, mt_rand(0, strlen($this->mathsOperation) - 1), 1);

        switch ($operator) {
            case "+": $output = $numberone + $numbertwo;
                break;
            case "-": $output = $numberone - $numbertwo;
                break;
            case "*": $output = $numberone * $numbertwo;
                break;
        }
        $captchaCode = $numberone . $operator . $numbertwo;

        // Store result in session
        $_SESSION["artifycaptcha" . $this->objId] = $output;

        // Create SVG image
        $svg = <<<SVG
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" width="{$this->imageWidth}" height="{$this->imageHeight}" style="background: #f0f0f0;">
    <text x="50%" y="50%" font-size="{$this->fontSize}" text-anchor="middle" fill="black" dy=".3em">{$captchaCode}</text>
</svg>
SVG;

        // Output SVG
        header('Content-Type: image/svg+xml');
        echo $svg;
    }
}

// Usage
if (isset($_GET["objId"])) {
    $captcha = new CaptchaSVG();
    $captcha->objId = $_GET["objId"];
    $captcha->generateCaptcha();
} else {
    echo "No objId provided";
}
