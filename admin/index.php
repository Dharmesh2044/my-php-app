<?php 
include('../db_connect.php'); 
include('auth_check.php');

// Message Counts
$total_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM contact_messages"))['total'];
$unread_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as unread FROM contact_messages WHERE status='new'"))['unread'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../img/logo1.png">
    <title>SharewareTech | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../admin/main.css">
</head>
<body>

    <div class="sidebar">
        <div class="brand-logo">
            <img src="../img/logo1.png" width="50" class="mb-2">
            <h5 class="fw-bold mb-0"><span class="text-warning">S</span>HAREWARETECH</h5>
        </div>
        
        <div class="nav flex-column">
            <a href="index.php?page=dashboard" class="nav-link <?php echo (!isset($_GET['page']) || $_GET['page'] == 'dashboard') ? 'active' : ''; ?>">
                <i class="fa-solid fa-grip"></i> Dashboard
            </a>
            
            <a href="index.php?page=messages" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'messages') ? 'active' : ''; ?>">
                <i class="fa-solid fa-comment-dots"></i> Messages
                <?php if($unread_count > 0): ?>
                    <span class="count-badge"><?php echo $unread_count; ?></span>
                <?php endif; ?>
            </a>

            <!-- client -->
            <!--a href="index.php?page=clients" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'clients') ? 'active' : ''; ?>">
                <i class="fa-solid fa-user-tie"></i> Clients
            </a-->
        </div>

        <div class="bottom-nav">
            <a href="logout.php" class="nav-link text-danger"><i class="fa-solid fa-power-off"></i> Logout</a>
        </div>
    </div>

    <div class="main-content">
        <header class="glass-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold mb-0">
                    <?php 
                        $p = isset($_GET['page']) ? ucfirst($_GET['page']) : 'Dashboard';
                        echo $p;
                    ?>
                </h5>
                <small class="text-muted">Welcome back, Admin 👋</small>
            </div>

            <div class="d-flex align-items-center">
                <span class="badge bg-success me-3" style="font-size: 10px;">Online</span>
            </div>
        </header>

        <main class="page-transition">
            <?php 
                $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
                if (file_exists($page . ".php")) {
                    include($page . ".php");
                } else {
                    echo "
                    <div class='text-center py-5'>
                        <div class='card border-0 shadow-sm p-5 rounded-5 mx-auto' style='max-width: 500px; background: white;'>
                            <i class='fa-solid fa-screwdriver-wrench fa-4x text-warning mb-4'></i>
                            <h2 class='fw-bold'>Module Arriving</h2>
                            <p class='text-muted'>We are working on this feature.</p>
                            <a href='index.php' class='btn btn-dark rounded-pill px-4'>Go Back</a>
                        </div>
                    </div>";
                }
            ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>