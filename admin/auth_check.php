<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Agar session set nahi hai, toh turant login page par bhej do
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>