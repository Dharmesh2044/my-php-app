<?php
// Session shuru karo
session_start();

// Saare session variables ko delete karo
session_unset();

// Session ko puri tarah khatam karo
session_destroy();

// User ko login page par bhej do
header("Location: login.php");
exit();
?>