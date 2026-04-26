<?php
session_start();
include('../db_connect.php');

$error = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, email, password FROM admin WHERE email = ?");
    
    if(!$stmt){
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {

        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {

            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_email'] = $row['email'];

            header("Location: index.php?page=dashboard");
            exit();

        } else {
            $error = "Incorrect password entered!";
        }

    } else {
        $error = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Secure Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
body {
    background: #f1f5f9;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.login-card {
    width: 100%;
    max-width: 420px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.form-control {
    padding: 12px;
    border-radius: 10px;
    background: #f8fafc;
}

.btn-warning {
    padding: 12px;
    border-radius: 10px;
    font-weight: 600;
}

.eye-icon {
    cursor: pointer;
}
</style>
</head>

<body>

<div class="card login-card p-4">

    <div class="text-center mb-4">
        <img src="../img/logo1.png" width="60" class="mb-2">
        <h4 class="fw-bold">SHAREWARE<span class="text-warning">TECH</span></h4>
        <p class="text-muted small">Secure Admin Login</p>
    </div>

    <?php if($error): ?>
        <div class="alert alert-danger py-2 text-center small">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <!-- EMAIL -->
        <div class="mb-3">
            <label class="form-label small fw-bold">Email</label>
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="fa fa-envelope"></i></span>
                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
            </div>
        </div>

        <!-- PASSWORD -->
        <div class="mb-2">
            <label class="form-label small fw-bold">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="fa fa-lock"></i></span>
                
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>

                <span class="input-group-text bg-white eye-icon" onclick="togglePassword()">
                    <i class="fa fa-eye" id="eyeIcon"></i>
                </span>
            </div>
        </div>

        <!-- FORGOT PASSWORD -->
        <!--div class="d-flex justify-content-end mb-3">
            <a href="forgot_password.php" class="text-decoration-none small text-warning">
                Forgot Password?
            </a>
        </div-->

        <button type="submit" name="login" class="btn btn-warning w-100 mt-5">
            Login
        </button>

    </form>

</div>

<script>
function togglePassword(){
    let pass = document.getElementById("password");
    let icon = document.getElementById("eyeIcon");

    if(pass.type === "password"){
        pass.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        pass.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>

</body>
</html>