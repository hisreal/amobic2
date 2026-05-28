<?php
$conn = new mysqli("localhost", "amobicho_hisrealite", "Hisrealite@1", "amobicho_homes");

if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}
?>