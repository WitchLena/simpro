<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Your reCAPTCHA secret key
    $secret = '6Ld_QMgqAAAAADcuNbJq-Et1rzp9Q4Kd9ZRIJTOm';
    $response = $_POST['recaptcha_response']; // reCAPTCHA response from the form
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
        // Process the form submission (e.g., send email, save to database)
        
        // Respond back with JSON success
        echo json_encode(["success" => true]);
    } else {
        // reCAPTCHA verification failed
        echo json_encode(["success" => false, "error" => "reCAPTCHA verification failed."]);
    }
}
?>
