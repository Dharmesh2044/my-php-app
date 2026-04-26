<?php
include('../db_connect.php');

$email = $_GET['email'];
$error = "";

if(isset($_POST['verify'])){

    $otp = $_POST['otp'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE email=? AND otp_code=?");
    $stmt->bind_param("ss", $email, $otp);
    $stmt->execute();
    $res = $stmt->get_result();

    if($res->num_rows == 1){

        $row = $res->fetch_assoc();

        if(strtotime($row['otp_expiry']) > time()){

            header("Location: reset_password.php?email=$email");
            exit;

        } else {
            $error = "OTP expired!";
        }

    } else {
        $error = "Invalid OTP!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Verify OTP</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center" style="height:100vh;">

<div class="card p-4" style="width:400px;">

<h4>Enter OTP</h4>

<?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

<form method="POST">
    <input type="text" name="otp" class="form-control mb-3" placeholder="Enter OTP" required>

    <button class="btn btn-success w-100" name="verify">
        Verify
    </button>
</form>

</div>

</body>
</html>