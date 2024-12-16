<?php

$to = 'homethali12@gmail.com';

// Sanitize and validate inputs
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$from = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

if (!filter_var($from, FILTER_VALIDATE_EMAIL)) {
    die('Invalid email address.');
}

// Prevent header injection by removing line breaks from inputs
$name = str_replace(["\r", "\n"], '', $name);
$subject = str_replace(["\r", "\n"], '', $subject);

// Construct email headers
$headers = "From: " . ($name ? "$name <$from>" : $from) . "\r\n";
$headers .= "Reply-To: $from\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Append sender's IP address to the message
$message .= "\r\n\r\nSent from IP: " . $_SERVER['REMOTE_ADDR'];

// Send the email
if (mail($to, $subject, $message, $headers)) {
    echo 'Message sent successfully!';
} else {
    echo 'Failed to send the message.';
}

?>

