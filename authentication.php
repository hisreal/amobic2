<?php

session_start();
require "config/dbh.php";
require "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";


use PHPMailer\PHPMailer\Exception as MailException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

header("Content-Type: application/json");

$mailchimp_api_key = "db14be6c4f866e0f7192e7974ebd4f81-us5";
$mailchimp_server_prefix = "us5"; // Example: us21
$mailchimp_audience_id = "a99269de23";
 
$smtp_host = "mail.amobichomes.com";
$smtp_port =  465;
$smtp_username = "webmaster@amobichomes.com";
$smtp_password = "Hisrealite@1";
$smtp_secure = PHPMailer::ENCRYPTION_SMTPS;
$mail_from_address = "no-reply@amobic.com";
$mail_from_name = "Amobic Homes";

function jsonResponse($status, $message, $code = 200, $redirect = null) {
    http_response_code($code);

    echo json_encode([
        "status" => $status,
        "message" => $message,
        "redirect" => $redirect
    ]);
    exit;
}

function syncMailchimpSubscriber($email, $merge_fields = [], $tags = []) {
    global $mailchimp_api_key, $mailchimp_server_prefix, $mailchimp_audience_id;

    if (
        $mailchimp_api_key === "" ||
        $mailchimp_server_prefix === "" ||
        $mailchimp_audience_id === "" ||
        $mailchimp_api_key === "YOUR_MAILCHIMP_API_KEY" ||
        $mailchimp_server_prefix === "YOUR_SERVER_PREFIX" ||
        $mailchimp_audience_id === "YOUR_AUDIENCE_ID"
    ) {
        error_log("Mailchimp sync skipped: credentials are not configured.");
        return false;
    }

    if (!function_exists("curl_init")) {
        error_log("Mailchimp sync skipped: PHP cURL extension is not enabled.");
        return false;
    }

    $subscriber_hash = md5(strtolower($email));
    $mailchimp_url = "https://" . $mailchimp_server_prefix . ".api.mailchimp.com/3.0/lists/" . $mailchimp_audience_id . "/members/" . $subscriber_hash;

    $payload = [
        "email_address" => $email,
        "status_if_new" => "subscribed",
        "status" => "subscribed",
        "merge_fields" => $merge_fields
    ];

    if (!empty($tags)) {
        $payload["tags"] = $tags;
    }

    $ch = curl_init($mailchimp_url);

    curl_setopt($ch, CURLOPT_USERPWD, "amobic:" . $mailchimp_api_key);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);

    curl_close($ch);

    if ($curl_error || $http_code < 200 || $http_code >= 300) {
        error_log("Mailchimp sync failed for {$email}. HTTP code: {$http_code}. cURL error: {$curl_error}. Response: {$response}");
        return false;
    }

    return true;
}

function renderEmailTemplate($template_path, $merge_fields = []) {
    if (!is_file($template_path)) {
        throw new Exception("Email template not found.");
    }

    $html = file_get_contents($template_path);

    foreach ($merge_fields as $key => $value) {
        $html = str_replace("*|" . $key . "|*", htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8"), $html);
    }

    $html = str_replace("*|UNSUB|*", "https://www.amobichomes.com/", $html);

    return $html;
}

function sendConfirmationEmail($to_email, $to_name, $subject, $template_path, $merge_fields = []) {
    global $smtp_host, $smtp_port, $smtp_username, $smtp_password, $smtp_secure, $mail_from_address, $mail_from_name;

    if (!filter_var($to_email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    try {
        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";
        $mail->isHTML(true);

        if ($smtp_host !== "") {
            $mail->isSMTP();
            $mail->Host = $smtp_host;
            $mail->SMTPAuth = $smtp_username !== "";
            $mail->Username = $smtp_username;
            $mail->Password = $smtp_password;
            $mail->SMTPSecure = $smtp_secure;
            $mail->Port = $smtp_port;
        } else {
            $mail->isMail();
        }

        $mail->setFrom($mail_from_address, $mail_from_name);
        $mail->addAddress($to_email, $to_name);
        $mail->addReplyTo($mail_from_address, $mail_from_name);
        $mail->Subject = $subject;
        $mail->Body = renderEmailTemplate($template_path, $merge_fields);
        $mail->AltBody = "Thank you for joining the Amobic Homes waitlist. We have received your submission and will contact you with next steps.";

        return $mail->send();
    } catch (MailException $e) {
        error_log("PHPMailer failed for {$to_email}: " . $e->getMessage());
        return false;
    } catch (Exception $e) {
        error_log("Confirmation email failed for {$to_email}: " . $e->getMessage());
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    jsonResponse("error", "Invalid request method.", 405);
}

if (
    empty($_POST["csrf_token"]) ||
    empty($_SESSION["csrf_token"]) ||
    !hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"])
) {
    jsonResponse("error", "Security verification failed. Please refresh and try again.", 403);
}

$waitlist_type = trim($_POST["waitlist_type"] ?? "");

if (!in_array($waitlist_type, ["property_owner", "lifestyle_partner"], true)) {
    jsonResponse("error", "Invalid form submission.", 422);
}

if ($waitlist_type === "lifestyle_partner") {
    $business_name = trim($_POST["business_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $location = trim($_POST["location"] ?? "");

    $allowed_categories = [
        "restaurant",
        "spa",
        "wellness",
        "experience",
        "transport"
    ];

    if ($business_name === "" || strlen($business_name) < 2 || strlen($business_name) > 180) {
        jsonResponse("error", "Please enter a valid business name.", 422);
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        jsonResponse("error", "Please enter a valid email address.", 422);
    }

    if (!in_array($category, $allowed_categories, true)) {
        jsonResponse("error", "Please select a valid category.", 422);
    }

    if ($location === "" || strlen($location) > 180) {
        jsonResponse("error", "Please enter a valid location.", 422);
    }

    mysqli_begin_transaction($conn);

    try {
        $checkSql = "SELECT id FROM amobic_partner_waitlist WHERE email = ? LIMIT 1";
        $checkStmt = mysqli_prepare($conn, $checkSql);

        if (!$checkStmt) {
            throw new Exception("Database prepare failed: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($checkStmt, "s", $email);

        if (!mysqli_stmt_execute($checkStmt)) {
            throw new Exception("Database email check failed: " . mysqli_error($conn));
        }

        mysqli_stmt_store_result($checkStmt);

        if (mysqli_stmt_num_rows($checkStmt) > 0) {
            mysqli_stmt_close($checkStmt);
            mysqli_rollback($conn);
            jsonResponse("error", "This email address is already on the partner waitlist.");
        }

        mysqli_stmt_close($checkStmt);

        $sql = "
            INSERT INTO amobic_partner_waitlist
            (waitlist_type, business_name, email, category, location)
            VALUES (?, ?, ?, ?, ?)
        ";

        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            throw new Exception("Database prepare failed: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param(
            $stmt,
            "sssss",
            $waitlist_type,
            $business_name,
            $email,
            $category,
            $location
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Database insert failed: " . mysqli_error($conn));
        }

        mysqli_stmt_close($stmt);

        mysqli_commit($conn);

        syncMailchimpSubscriber(
            $email,
            [
                "FNAME" => $business_name,
                "CATEGORY" => $category,
                "LOCATION" => $location
            ],
            ["Lifestyle Partner Waitlist", ucfirst(str_replace("_", " ", $category))]
        );

        $confirmation_sent = sendConfirmationEmail(
            $email,
            $business_name,
            "Your Amobic Homes partner waitlist confirmation",
            __DIR__ . "/emails/partner-confirmation.html",
            [
                "FNAME" => $business_name,
                "CATEGORY" => ucfirst(str_replace("_", " ", $category)),
                "LOCATION" => $location
            ]
        );

        $message = $confirmation_sent
            ? "Thank you. You have joined the partner waitlist. A confirmation email has been sent."
            : "Thank you. You have joined the partner waitlist, but the confirmation email could not be sent.";

        jsonResponse("success", $message);
    } catch (Exception $e) {
        mysqli_rollback($conn);

        jsonResponse("error", $e->getMessage(), 500);
    }
}

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$property_type = trim($_POST["property_type"] ?? "");
$area = trim($_POST["area"] ?? "");
$number_of_units = trim($_POST["number_of_units"] ?? "");

$allowed_property_types = [
    "apartment",
    "house",
    "villa",
    "guest_house",
    "portfolio"
];

if ($name === "" || strlen($name) < 2 || strlen($name) > 150) {
    jsonResponse("error", "Please enter a valid name.", 422);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse("error", "Please enter a valid email address.", 422);
}

if (!in_array($property_type, $allowed_property_types, true)) {
    jsonResponse("error", "Please select a valid property type.", 422);
}

if ($area === "" || strlen($area) > 150) {
    jsonResponse("error", "Please enter a valid area.", 422);
}

if (!filter_var($number_of_units, FILTER_VALIDATE_INT, [
    "options" => ["min_range" => 1, "max_range" => 10000]
])) {
    jsonResponse("error", "Please enter a valid number of units.", 422);
}

$number_of_units = (int) $number_of_units;

mysqli_begin_transaction($conn);

try {
    $checkSql = "SELECT id FROM amobic_property_waitlist WHERE email = ? LIMIT 1";
    $checkStmt = mysqli_prepare($conn, $checkSql);

    if (!$checkStmt) {
        throw new Exception("Database prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($checkStmt, "s", $email);

    if (!mysqli_stmt_execute($checkStmt)) {
        throw new Exception("Database email check failed: " . mysqli_error($conn));
    }

    mysqli_stmt_store_result($checkStmt);

    if (mysqli_stmt_num_rows($checkStmt) > 0) {
        mysqli_stmt_close($checkStmt);
        mysqli_rollback($conn);
        jsonResponse("error", "This email address is already on the property owner waitlist.");
    }

    mysqli_stmt_close($checkStmt);

    $sql = "
        INSERT INTO amobic_property_waitlist
        (waitlist_type, name, email, property_type, area, number_of_units)
        VALUES (?, ?, ?, ?, ?, ?)
    ";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        throw new Exception("Database prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param(
        $stmt,
        "sssssi",
        $waitlist_type,
        $name,
        $email,
        $property_type,
        $area,
        $number_of_units
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Database insert failed: " . mysqli_error($conn));
    }

    mysqli_stmt_close($stmt);

    mysqli_commit($conn);

    syncMailchimpSubscriber(
        $email,
        [
            "FNAME" => $name,
            "PTYPE" => $property_type,
            "AREA" => $area,
            "UNITS" => (string) $number_of_units
        ],
        ["Property Owner Waitlist", ucfirst(str_replace("_", " ", $property_type))]
    );

    $confirmation_sent = sendConfirmationEmail(
        $email,
        $name,
        "Your Amobic Homes properties owners waitlist confirmation",
        __DIR__ . "/emails/property-owner-confirmation.html",
        [
            "FNAME" => $name,
            "PTYPE" => ucfirst(str_replace("_", " ", $property_type)),
            "AREA" => $area,
            "UNITS" => (string) $number_of_units
        ]
    );

    $message = $confirmation_sent
        ? "Thank you. You have joined the property owner waitlist. A confirmation email has been sent."
        : "Thank you. You have joined the property owner waitlist, but the confirmation email could not be sent.";

    jsonResponse("success", $message);

    } catch (Exception $e) {
        mysqli_rollback($conn);
    
        jsonResponse("error", $e->getMessage(), 500);
    }
