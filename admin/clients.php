<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('../db_connect.php'); 
include('auth_check.php');

// ================= PAGINATION LOGIC =================
$limit = 10; 
$page_num = isset($_GET['p']) ? (int)$_GET['p'] : 1;
if($page_num < 1) $page_num = 1;
$offset = ($page_num - 1) * $limit;

$total_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM clients");
$total_data = mysqli_fetch_assoc($total_query);
$total_records = $total_data['total'];
$total_pages = ceil($total_records / $limit);

// ================= DELETE LOGIC =================
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM clients WHERE id=?");
    $stmt->bind_param("i", $delete_id);
    if($stmt->execute()){
        $_SESSION['msg'] = "Client deleted successfully!";
        $_SESSION['msg_type'] = "danger";
    }
    $stmt->close();
    echo "<script>window.location.href='index.php?page=clients&p=$page_num';</script>";
    exit();
}

// ================= SAVE / UPDATE LOGIC =================
if (isset($_POST['save_client'])) {
    $id = $_POST['id'] ?? '';
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if (empty($id)) {
        $stmt = $conn->prepare("INSERT INTO clients (name, phone, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $phone, $email);
        $success_msg = "New client added successfully!";
    } else {
        $stmt = $conn->prepare("UPDATE clients SET name=?, phone=?, email=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $phone, $email, $id);
        $success_msg = "Client details updated successfully!";
    }
    if($stmt->execute()){
        $_SESSION['msg'] = $success_msg;
        $_SESSION['msg_type'] = "success";
    }
    $stmt->close();
    echo "<script>window.location.href='index.php?page=clients&p=$page_num';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Client Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="../admin/main.css">
    <style>
        .card { border: none; border-radius: 12px; }
        .bg-warning { background-color: #ffc107 !important; }
        .btn-warning { font-weight: 600; border-radius: 8px; }
        .pagination .page-link { color: #333; border: none; margin: 0 3px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .pagination .active .page-link { background-color: #ffc107; color: #000; font-weight: bold; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold text-dark"><i class="bi bi-gem text-warning"></i> Client Directory</h2>
            <p class="text-muted">Manage your diamond merchants (10 per page)</p>
        </div>
        <div class="col-auto">
            <button class="btn btn-warning shadow-sm px-4" onclick="addNew()">
                <i class="bi bi-plus-lg"></i> Add New Client
            </button>
        </div>
    </div>

    <?php if(isset($_SESSION['msg'])): ?>
        <div class="alert alert-<?= $_SESSION['msg_type'] ?> alert-dismissible fade show shadow-sm mb-4" role="alert">
            <strong><?= $_SESSION['msg'] ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" id="tableSearch" class="form-control border-start-0" placeholder="Search in this page...">
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="clientTable">
                <thead>
                    <tr>
                        <th class="ps-4">Sr. No.</th>
                        <th>Client Details</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    // ASC Order taaki naya client niche jude
                    $query = mysqli_query($conn, "SELECT * FROM clients ORDER BY id ASC LIMIT $offset, $limit");
                    $sn = $offset + 1; 
                    
                    if(mysqli_num_rows($query) > 0):
                        while($row = mysqli_fetch_assoc($query)):
                    ?>
                    <tr>
                        <td class="ps-4 text-muted fw-bold"><?= $sn++ ?></td> 
                        <td><div class="fw-bold text-dark"><?= htmlspecialchars($row['name']) ?></div></td>
                        <td><div><i class="bi bi-telephone-fill text-muted small me-2"></i><?= htmlspecialchars($row['phone']) ?></div></td>
                        <td><div class="text-muted small"><?= htmlspecialchars($row['email'] ?: 'No email') ?></div></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary border-0 me-1" 
                                    onclick="editClient('<?= $row['id'] ?>', '<?= addslashes($row['name']) ?>', '<?= $row['phone'] ?>', '<?= $row['email'] ?>')">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                            <a href="index.php?page=clients&delete_id=<?= $row['id'] ?>&p=<?= $page_num ?>" class="btn btn-sm btn-outline-danger border-0" 
                               onclick="return confirm('Are you sure you want to delete this client?')">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr><td colspan="5" class="text-center py-4 text-muted">No clients found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if($total_pages > 1): ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= ($page_num <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="index.php?page=clients&p=<?= $page_num - 1 ?>">Previous</a>
            </li>
            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($page_num == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="index.php?page=clients&p=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= ($page_num >= $total_pages) ? 'disabled' : '' ?>">
                <a class="page-link" href="index.php?page=clients&p=<?= $page_num + 1 ?>">Next</a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<div class="modal fade" id="clientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <form method="POST">
                <div class="modal-header border-0 bg-warning">
                    <h5 class="fw-bold mb-0" id="modalTitle">Add Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="client_id">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Full Name</label>
                        <input type="text" name="name" id="client_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Phone Number</label>
                        <input type="text" name="phone" id="client_phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email Address</label>
                        <input type="email" name="email" id="client_email" class="form-control">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="save_client" class="btn btn-warning px-4 shadow-sm">Save Client Info</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var clientModal = new bootstrap.Modal(document.getElementById('clientModal'));

    function addNew() {
        document.getElementById('modalTitle').innerText = "Add New Client";
        document.getElementById('client_id').value = "";
        document.getElementById('client_name').value = "";
        document.getElementById('client_phone').value = "";
        document.getElementById('client_email').value = "";
        clientModal.show();
    }

    function editClient(id, name, phone, email) {
        document.getElementById('modalTitle').innerText = "Update Client Details";
        document.getElementById('client_id').value = id;
        document.getElementById('client_name').value = name;
        document.getElementById('client_phone').value = phone;
        document.getElementById('client_email').value = email;
        clientModal.show();
    }

    // Search Script
    document.getElementById('tableSearch').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('#clientTable tbody tr');
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });
    });

    // Auto-hide alert
    window.setTimeout(function() {
        let alert = document.querySelector('.alert');
        if (alert) { new bootstrap.Alert(alert).close(); }
    }, 3000);
</script>

</body>
</html>