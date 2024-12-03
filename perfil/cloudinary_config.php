<?php
require_once '../vendor/autoload.php'; // Inclua o autoload caso use o Composer

use Cloudinary\Configuration\Configuration;

// Substitua pelos valores da sua conta Cloudinary
Configuration::instance([
    'cloud' => [
        'cloud_name' => 'dkwnf1pa9',
        'api_key' => '172524471895913',
        'api_secret' => 'et97l0iK6dUlMXh8phu52plPRSg'
    ],
    'url' => [
        'secure' => true // Usar URLs HTTPS
    ]
]);
?>
