<?php
include('../db_connect.php');

$message = "";

if(isset($_POST['send_otp'])){

    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT id FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if($res->num_rows == 1){

        $otp = rand(100000, 999999);
        $expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        $update = $conn->prepare("UPDATE admin SET otp_code=?, otp_expiry=? WHERE email=?");
        $update->bind_param("sss", $otp, $expiry, $email);
        $update->execute();

        // 📧 SEND EMAIL (basic PHP mail)
        $subject = "Your OTP Code";
        $body = "Your OTP is: $otp \nValid for 10 minutes.";

        mail($email, $subject, $body);

        header("Location: verify_otp.php?email=$email");
        exit;

    } else {
        $message = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center" style="height:100vh;">

<div class="card p-4" style="width:400px;">

<h4 class="mb-3">Forgot Password</h4>

<?php if($message) echo "<div class='alert alert-danger'>$message</div>"; ?>

<form method="POST">
    <input type="email" name="email" class="form-control mb-3" placeholder="Enter Email" required>

    <button class="btn btn-warning w-100" name="send_otp">
        Send OTP
    </button>
</form>

</div>

</body>
</html>