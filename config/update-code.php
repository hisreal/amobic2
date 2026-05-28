<?php

session_start();
require "dbh.php";

header("Content-Type: application/json");

function jsonResponse($status, $message, $redirect = null) {
    echo json_encode([
        "status" => $status,
        "message" => $message,
        "redirect" => $redirect
    ]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    jsonResponse("error", "Invalid request method.");
}

/* =========================================
   UPDATE PROFILE
========================================= */

if (isset($_POST['update-profile'])) {

    if (!isset($_SESSION['guest_id'])) {
        jsonResponse("error", "Session expired. Please login again.");
    }

    $user_id = $_SESSION['guest_id'];

    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $sex = trim($_POST['sex'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $preferred_currency = trim($_POST['preferred_currency'] ?? '');
    $preferred_language = trim($_POST['preferred_language'] ?? '');

    $allowed_currencies = ['USD', 'GBP', 'EUR', 'NGN', 'ZAR'];
    $allowed_languages = ['en', 'fr', 'es', 'pt'];

    if (
        empty($first_name) ||
        empty($last_name) ||
        empty($phone) ||
        empty($sex) ||
        empty($dob) ||
        empty($bio)
    ) {
        jsonResponse("error", "All fields are required.");
    }

    if (!in_array($preferred_currency, $allowed_currencies, true)) {
        jsonResponse("error", "Invalid currency selected.");
    }

    if (!in_array($preferred_language, $allowed_languages, true)) {
        jsonResponse("error", "Invalid language selected.");
    }

    $stmt = $conn->prepare("
        UPDATE amobic_users
        SET first_name = ?,
            last_name = ?,
            phone = ?,
            sex = ?,
            dob = ?,
            preferred_currency = ?,
            preferred_language = ?,
            bio = ?
        WHERE id = ?
    ");

    if (!$stmt) {
        jsonResponse("error", "Database preparation failed. $conn->error");
    }

    $stmt->bind_param(
        "ssssssssi",
        $first_name,
        $last_name,
        $phone,
        $sex,
        $dob,
        $preferred_currency,
        $preferred_language,
        $bio,
        $user_id
    );

    if ($stmt->execute()) {

        $_SESSION['preferred_currency'] = $preferred_currency;
        $_SESSION['preferred_language'] = $preferred_language;

        jsonResponse("success", "Profile updated successfully.", "profile.php");

    } else {
        jsonResponse("error", "Profile update failed. $conn->error");
    }

} else {
    jsonResponse("error", "Invalid request.");
}