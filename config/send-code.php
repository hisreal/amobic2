<?php

session_start();
require "dbh.php";
require __DIR__ . "/../../PHPMailer/src/Exception.php";
require __DIR__ . "/../../PHPMailer/src/PHPMailer.php";
require __DIR__ . "/../../PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\Exception as MailException;
use PHPMailer\PHPMailer\PHPMailer;

header("Content-Type: application/json");

$smtp_host = "mail.amobichomes.com";
$smtp_port = 465;
$smtp_username = "webmaster@amobichomes.com";
$smtp_password = "Hisrealite@1";
$smtp_secure = PHPMailer::ENCRYPTION_SMTPS;
$mail_from_address = "webmaster@amobichomes.com";
$mail_from_name = "Amobic Homes";

function jsonResponse($status, $message, $redirect = null) {
    echo json_encode([
        "status" => $status,
        "message" => $message,
        "redirect" => $redirect
    ]);
    exit;
}

function buildVerificationEmailTemplate($code) {
    $safe_code = htmlspecialchars((string) $code, ENT_QUOTES, "UTF-8");

    return '<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Your Amobic Homes Verification Code</title>
</head>
<body style="margin:0; padding:0; background:#f3f5ef; font-family:Arial, Helvetica, sans-serif; color:#1f2a1f;">
  <div style="display:none; max-height:0; overflow:hidden; opacity:0; color:transparent;">
    Your Amobic Homes verification code is ' . $safe_code . '.
  </div>

  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f3f5ef; margin:0; padding:0;">
    <tr>
      <td align="center" style="padding:34px 16px;">
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:640px; background:#ffffff; border-radius:24px; overflow:hidden; box-shadow:0 18px 50px rgba(31,42,31,0.12);">
          <tr>
            <td style="background:#1f2a1f; padding:36px 34px 30px 34px;">
              <p style="margin:0 0 16px 0; color:#dce6c8; font-size:13px; letter-spacing:1.8px; text-transform:uppercase; font-weight:bold;">Amobic Account Security</p>
              <h1 style="margin:0; color:#ffffff; font-size:34px; line-height:1.15; font-weight:800;">Confirm your email address</h1>
              <p style="margin:18px 0 0 0; color:#eef3e5; font-size:16px; line-height:1.65;">Use the verification code below to continue creating your Amobic Homes account.</p>
            </td>
          </tr>

          <tr>
          <td align="center" style="padding:34px 24px 22px 24px;">
            <p style="margin:0 0 18px 0; color:#6b7f4a; font-size:13px; letter-spacing:1.4px; text-transform:uppercase; font-weight:bold;">
              Your 6 digit code
            </p>
        
          <p style="margin:0; color:#1f2a1f; font-size:56px; line-height:1; font-weight:800; letter-spacing:10px; font-family:Arial, Helvetica, sans-serif;">' . $safe_code . '</p>
          <p style="margin:16px 0 0 0; color:#75806f; font-size:13px; line-height:1.5;">Copy this code and paste it on the verification page.</p>
           
          </td>
        </tr>

          <tr>
            <td style="padding:10px 34px 34px 34px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f7f8f4; border:1px solid #e1e8d7; border-radius:18px;">
                <tr>
                  <td style="padding:22px; text-align:center;">
                    <p style="margin:0; color:#4c5847; font-size:15px; line-height:1.65;">This code expires in <strong style="color:#1f2a1f;">10 minutes</strong>. If you did not request this code, you can safely ignore this email.</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <tr>
            <td style="background:#f7f8f4; padding:22px 34px; text-align:center; border-top:1px solid #e4eadb;">
              <p style="margin:0; color:#75806f; font-size:12px; line-height:1.6;">Amobic Homes sent this email to verify access to your account.</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>';
}

function sendVerificationCodeEmail($email, $code) {
    global $smtp_host, $smtp_port, $smtp_username, $smtp_password, $smtp_secure, $mail_from_address, $mail_from_name;

    try {
        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";
        $mail->isSMTP();
        $mail->Host = $smtp_host;
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;
        $mail->SMTPSecure = $smtp_secure;
        $mail->Port = $smtp_port;

        $mail->setFrom($mail_from_address, $mail_from_name);
        $mail->addAddress($email);
        $mail->addReplyTo($mail_from_address, $mail_from_name);
        $mail->isHTML(true);
        $mail->Subject = "Your Amobic Homes verification code";
        $mail->Body = buildVerificationEmailTemplate($code);
        $mail->AltBody = "Your Amobic Homes verification code is " . $code . ". This code expires in 10 minutes.";

        return $mail->send();
    } catch (MailException $e) {
        error_log("PHPMailer verification failed for {$email}: " . $e->getMessage());
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    jsonResponse("error", "Invalid request method.");
}


/* SIGNUP */
if (isset($_POST["signup"])) {

    $email = trim($_POST["email"]);

    if (empty($email)) {
        jsonResponse("error", "Email address is required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        jsonResponse("error", "Invalid email address.");
    }

    $stmt = $conn->prepare("
    SELECT id, first_name, last_name, email, password, email_verified
    FROM amobic_users
    WHERE email = ?
    LIMIT 1
");

$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows >= 1) {
    jsonResponse("error", "You are already registered. please log in.");
}

    $code = rand(100000, 999999);
    $expires = date("Y-m-d H:i:s", strtotime("+10 minutes"));
    $stmt = $conn->prepare("
        INSERT INTO amobic_users (email, verification_code, code_expires_at)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE
        verification_code = VALUES(verification_code),
        code_expires_at = VALUES(code_expires_at)
    ");

    $stmt->bind_param("sss", $email, $code, $expires);

    if (!$stmt->execute()) {
        jsonResponse("error", "Unable to create verification code.");
    }

    $_SESSION["pending_email"] = $email;

    if (!sendVerificationCodeEmail($email, $code)) {
        jsonResponse("error", "Verification code was created, but the email could not be sent. Please try again.");
    }

    jsonResponse(
        "success",
        "Verification code sent to your email.",
        "verify-code.php"
    );
}


/* VERIFY CODE */
if (isset($_POST["verify"])) {

    if (!isset($_SESSION["pending_email"])) {
        jsonResponse("error", "Session expired. Please start registration again.");
    }

    $email = $_SESSION["pending_email"];
    $code = trim($_POST["verification_code"]);

    if (empty($code)) {
        jsonResponse("error", "Verification code is required.");
    }

    if (!preg_match("/^[0-9]{6}$/", $code)) {
        jsonResponse("error", "Verification code must be 6 digits.");
    }

    $stmt = $conn->prepare("
        SELECT id FROM amobic_users
        WHERE email = ?
        AND verification_code = ?
        AND code_expires_at > NOW()
        LIMIT 1
    ");

    $stmt->bind_param("ss", $email, $code);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        jsonResponse("error", "Invalid or expired verification code.");
    }

    $update = $conn->prepare("
        UPDATE amobic_users
        SET email_verified = 1,
            verification_code = NULL,
            code_expires_at = NULL
        WHERE email = ?
    ");

    $update->bind_param("s", $email);

    if (!$update->execute()) {
        jsonResponse("error", "Unable to verify email.");
    }

    jsonResponse("success", "Email verified successfully.", "complete-profile.php");
}


/* SAVE USER PROFILE */
if (isset($_POST["save-user"])) {

    if (!isset($_SESSION["pending_email"])) {
        jsonResponse("error", "Session expired. Please start registration again.");
    }

    $email = $_SESSION["pending_email"];

    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $phone = trim($_POST["phone"]);
    $sex = trim($_POST["sex"]);
    $dob = trim($_POST["dob"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (
        empty($first_name) ||
        empty($last_name) ||
        empty($phone) ||
        empty($sex) ||
        empty($dob) ||
        empty($password) ||
        empty($confirm_password)
    ) {
        jsonResponse("error", "All fields are required.");
    }

    if ($password !== $confirm_password) {
        jsonResponse("error", "Password and confirm password do not match.");
    }

    if (strlen($password) < 8) {
        jsonResponse("error", "Password must be at least 8 characters.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("
        UPDATE amobic_users
        SET first_name = ?,
            last_name = ?,
            phone = ?,
            password = ?,
            sex = ?,
            dob = ?
        WHERE email = ?
        AND email_verified = 1
    ");

    $stmt->bind_param(
        "sssssss",
        $first_name,
        $last_name,
        $phone,
        $hashed_password,
        $sex,
        $dob,
        $email
    );

    if (!$stmt->execute()) {
        jsonResponse("error", "Something went wrong. Please try again.");
    }

    unset($_SESSION["pending_email"]);

    jsonResponse("success", "Profile completed successfully.", "login.php");
}


/* LOGIN USER */
if (isset($_POST["login-user"])) {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {
        jsonResponse("error", "Email and password are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        jsonResponse("error", "Please enter a valid email address.");
    }

    $stmt = $conn->prepare("
        SELECT id, first_name, last_name, email, password, email_verified
        FROM amobic_users
        WHERE email = ?
        LIMIT 1
    ");

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        jsonResponse("error", "Invalid email or password.");
    }

    $user = $result->fetch_assoc();

    if ($user["email_verified"] != 1) {
        jsonResponse("error", "Please verify your email before logging in.");
    }

    if (!password_verify($password, $user["password"])) {
        jsonResponse("error", "Invalid email or password.");
    }

    $_SESSION["guest_id"] = $user["id"];
    $_SESSION["guest_email"] = $user["email"];
    $_SESSION["guest_name"] = $user["first_name"] . " " . $user["last_name"];
    $_SESSION["logged_in"] = true;

    jsonResponse("success", "Login successful.", "user/dashboard.php");
}

// PROPERTY OWNER WAITLIST
if(isset($_POST['PropertyOwnerForm'])) {

if (
    empty($_POST["csrf_token"]) ||
    empty($_SESSION["csrf_token"]) ||
    !hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"])
) {
    send_json("error", "Security verification failed. Please refresh and try again.", 403);
}

$waitlist_type = trim($_POST["waitlist_type"] ?? "");
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

if ($waitlist_type !== "property_owner") {
    send_json("error", "Invalid waitlist type.", 422);
}

if ($name === "" || strlen($name) < 2 || strlen($name) > 150) {
    send_json("error", "Please enter a valid name.", 422);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    send_json("error", "Please enter a valid email address.", 422);
}

if (!in_array($property_type, $allowed_property_types, true)) {
    send_json("error", "Please select a valid property type.", 422);
}

if ($area === "" || strlen($area) > 150) {
    send_json("error", "Please enter a valid area.", 422);
}

if (!filter_var($number_of_units, FILTER_VALIDATE_INT, [
    "options" => ["min_range" => 1, "max_range" => 10000]
])) {
    send_json("error", "Please enter a valid number of units.", 422);
}

$number_of_units = (int) $number_of_units;

mysqli_begin_transaction($conn);

try {
    $sql = "
        INSERT INTO property_owner_waitlist
        (waitlist_type, name, email, property_type, area, number_of_units)
        VALUES (?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            name = VALUES(name),
            property_type = VALUES(property_type),
            area = VALUES(area),
            number_of_units = VALUES(number_of_units)
    ";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        throw new Exception("Database prepare failed.");
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
        throw new Exception("Database insert failed.");
    }

    mysqli_stmt_close($stmt);

    $mailchimp_api_key = "YOUR_MAILCHIMP_API_KEY";
    $mailchimp_server = "us21";
    $mailchimp_list_id = "YOUR_AUDIENCE_LIST_ID";

    $subscriber_hash = md5(strtolower($email));

    $mailchimp_url = "https://" . $mailchimp_server . ".api.mailchimp.com/3.0/lists/" . $mailchimp_list_id . "/members/" . $subscriber_hash;

    $mailchimp_data = [
        "email_address" => $email,
        "status_if_new" => "subscribed",
        "merge_fields" => [
            "FNAME" => $name,
            "PTYPE" => $property_type,
            "AREA" => $area,
            "UNITS" => (string) $number_of_units
        ],
        "tags" => [
            "Property Owner Waitlist"
        ]
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $mailchimp_url);
    curl_setopt($ch, CURLOPT_USERPWD, "user:" . $mailchimp_api_key);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($mailchimp_data));
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);

    curl_close($ch);

    if ($curl_error || $http_code < 200 || $http_code >= 300) {
        throw new Exception("Mailchimp sync failed.");
    }

    mysqli_commit($conn);

    unset($_SESSION["csrf_token"]);

    send_json("success", "Thank you. You have joined the property owner waitlist.");

} catch (Exception $e) {
    mysqli_rollback($conn);

    send_json("error", "Something went wrong. Please try again.", 500);
}
}




