<?php

// Database configuration
$host     = "localhost"; // Aksar localhost hi hota hai
$username = "root";      // XAMPP/WAMP ka default username
$password = "";          // XAMPP/WAMP mein password aksar khali hota hai
$dbname   = "sharewaretech_db"; // Aapke database ka naam

// Connection create karna
$conn = mysqli_connect($host, $username, $password, $dbname);

// Connection check karna
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// UTF-8 support (taki special characters sahi se save hon)
mysqli_set_charset($conn, "utf8");


// Ab aap is $conn variable ko pure project mein use kar sakte hain
?>