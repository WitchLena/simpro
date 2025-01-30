<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Your reCAPTCHA secret key
    $secret = '6LfQKcgqAAAAABdfUa30TsoXgdNhb8CnqBLfc7oa';
    $response = $_POST['g-recaptcha-response']; // reCAPTCHA response from the form
    $remoteip = $_SERVER['REMOTE_ADDR']; // User's IP address

    // Send request to Google's reCAPTCHA API for verification
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $secret,
        'response' => $response,
        'remoteip' => $remoteip
    ];

    // Use cURL to send the request
    $options = [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_RETURNTRANSFER => true
    ];
    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    curl_close($ch);

    $resultJson = json_decode($result);
    if ($resultJson->success) {
        // reCAPTCHA was verified successfully
        // Proceed with form submission (e.g., send email, save to database)
    } else {
        // reCAPTCHA verification failed
        echo "reCAPTCHA verification failed. Please try again.";
    }
}
?>
