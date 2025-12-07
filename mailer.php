<?php
// Only process POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and trim inputs
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r", "\n"), array(" ", " "), $name);

    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);

    $company = isset($_POST["company"]) ? strip_tags(trim($_POST["company"])) : '';
    $website = isset($_POST["website"]) ? filter_var(trim($_POST["website"]), FILTER_SANITIZE_URL) : '';

    $message = trim($_POST["message"]);

    // Validate required fields
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Oops! There was a problem with your submission. Please complete the form and try again.";
        exit;
    }

    // Recipient email
    $recipient = "support@reactheme.com"; // <-- Update to your email

    // Email subject
    $subject = "Touriza Contact Form: $name";

    // Build email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    if ($company) $email_content .= "Company: $company\n";
    if ($website) $email_content .= "Website: $website\n";
    $email_content .= "Message:\n$message\n";

    // Email headers
    $email_headers = "From: $name <$email>";

    // Send email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "Thank you! Your message has been sent.";
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }
} else {
    // Not a POST request
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
