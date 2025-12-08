<?php
require_once __DIR__ . '/env.php';

$googleClientId = getenv("GOOGLE_CLIENT_ID") ?: "YOUR_GOOGLE_CLIENT_ID_HERE";
if ($googleClientId === "YOUR_GOOGLE_CLIENT_ID_HERE") {
    error_log("Google Sign-In: set GOOGLE_CLIENT_ID in tokens.env");
}

define('GOOGLE_CLIENT_ID', $googleClientId);
