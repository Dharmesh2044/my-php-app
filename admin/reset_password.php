<?php
include('../db_connect.php');

$email = $_GET['email'];

if(isset($_POST['reset'])){

    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE admin SET password=?, otp_code=NULL, otp_expiry=NULL WHERE email=?");
    $stmt->bind_param("ss", $pass, $email);
    $stmt->execute();

    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center" style="height:100vh;">

<div class="card p-4" style="width:400px;">

<h4>Reset Password</h4>

<form method="POST">
    <input type="password" name="password" class="form-control mb-3" placeholder="New Password" required>

    <button class="btn btn-primary w-100" name="reset">
        Reset Password
    </button>
</form>

</div>

</body>
</html>