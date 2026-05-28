<?php
session_start();

if (!isset($_SESSION['guest_id']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit;
}
?>