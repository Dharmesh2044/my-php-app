<?php
// 1. Initial Settings & Security
date_default_timezone_set('Asia/Kolkata');
include('../db_connect.php'); 
include('auth_check.php');

// 2. Pagination Logic
$limit = 10;
$page_num = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
$offset = ($page_num - 1) * $limit;

// 3. View/Read Logic (using Prepared Statements for Security)
$view_id = isset($_GET['view_id']) ? (int)$_GET['view_id'] : 0;
$single_msg = null;

if ($view_id > 0) {
    // Message ko 'read' mark karein
    $stmt_update = $conn->prepare("UPDATE contact_messages SET status='read' WHERE id=?");
    $stmt_update->bind_param("i", $view_id);
    $stmt_update->execute();

    // Single message fetch karein
    $stmt_fetch = $conn->prepare("SELECT * FROM contact_messages WHERE id=?");
    $stmt_fetch->bind_param("i", $view_id);
    $stmt_fetch->execute();
    $single_msg = $stmt_fetch->get_result()->fetch_assoc();
}

// 4. Statistics (Sari counts ek hi query mein - Better Performance)
$stats_query = "SELECT 
    COUNT(*) as total, 
    SUM(CASE WHEN status='new' THEN 1 ELSE 0 END) as unread,
    SUM(CASE WHEN status='read' THEN 1 ELSE 0 END) as read_count
    FROM contact_messages";
$stats = $conn->query($stats_query)->fetch_assoc();

// 5. Fetch List Data
$list_query = "SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT ? OFFSET ?";
$stmt_list = $conn->prepare($list_query);
$stmt_list->bind_param("ii", $limit, $offset);
$stmt_list->execute();
$result = $stmt_list->get_result();

$total_pages = ceil($stats['total'] / $limit);
?>

<style>
    :root { --primary-color: #ffc107; --bg-light: #f9fafb; }
    .table-container { background: #fff; border-radius: 15px; padding: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
    .custom-table { border-collapse: separate; border-spacing: 0 8px; }
    .custom-table tbody tr { background: var(--bg-light); transition: 0.3s; }
    .custom-table tbody tr:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
    .unread-row { border-left: 5px solid #f59e0b !important; background: #fff7ed !important; font-weight: 500; }
    .badge-new { background: #f59e0b; color: #fff; font-size: 10px; padding: 2px 8px; border-radius: 50px; }
    .blink-dot { height: 8px; width: 8px; background: #ef4444; border-radius: 50%; display: inline-block; animation: blink 1s infinite; margin-right: 5px; }
    @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }
    .card-stat { border: none; border-radius: 12px; transition: 0.3s; }
    .card-stat:hover { transform: translateY(-5px); }
</style>

<div class="container-fluid py-4">
    
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card card-stat p-3 shadow-sm">
                <small class="text-muted text-uppercase">Total Messages</small>
                <h3 class="fw-bold"><?= $stats['total'] ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stat p-3 shadow-sm border-start border-warning border-4">
                <small class="text-muted text-uppercase">Unread</small>
                <h3 class="text-warning fw-bold"><?= $stats['unread'] ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stat p-3 shadow-sm border-start border-success border-4">
                <small class="text-muted text-uppercase">Read</small>
                <h3 class="text-success fw-bold"><?= $stats['read_count'] ?></h3>
            </div>
        </div>
    </div>

    <?php if($view_id && $single_msg): ?>
        <div class="row justify-content-center pt-5">
            <div class="col-md-8">
                <div class="card border-0 shadow-lg p-4" style="border-radius: 20px;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4>📩 Message Details</h4>
                        <span class="badge bg-light text-dark"><?= date('d M Y, h:i A', strtotime($single_msg['created_at'])) ?></span>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6"><strong>Name:</strong><p class="text-muted"><?= htmlspecialchars($single_msg['name']) ?></p></div>
                        <div class="col-md-6"><strong>Email:</strong><p class="text-muted"><?= htmlspecialchars($single_msg['email']) ?></p></div>
                        <div class="col-md-6"><strong>Phone:</strong><p class="text-muted"><?= htmlspecialchars($single_msg['phone']) ?></p></div>
                        <div class="col-12">
                            <strong>Message Content:</strong>
                            <div class="mt-2 p-3 bg-light rounded shadow-sm"><?= nl2br(htmlspecialchars($single_msg['message'])) ?></div>
                        </div>
                    </div>
                    <div class="mt-4 text-end">
                        <a href="?page=messages&p=<?= $page_num ?>" class="btn btn-outline-secondary px-4">Back to List</a>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">📩 Inbox</h4>
            <input type="text" id="searchInput" class="form-control shadow-sm w-25" placeholder="Search contact...">
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sender</th>
                            <th>Contact Info</th>
                            <th>Message Preview</th>
                            <th>Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php 
                        $sr = $offset + 1;
                        while($row = $result->fetch_assoc()): 
                            $isNew = ($row['status'] == 'new');
                        ?>
                        <tr class="<?= $isNew ? 'unread-row' : '' ?>">
                            <td><?= $sr++ ?></td>
                            <td class="name-col">
                                <?php if($isNew): ?><span class="blink-dot"></span><?php endif; ?>
                                <strong><?= htmlspecialchars($row['name']) ?></strong>
                                <?php if($isNew): ?><span class="badge-new">NEW</span><?php endif; ?>
                            </td>
                            <td class="info-col">
                                <small><?= htmlspecialchars($row['email']) ?></small><br>
                                <small class="text-muted"><?= htmlspecialchars($row['phone']) ?></small>
                            </td>
                            <td><?= htmlspecialchars(mb_strimwidth($row['message'], 0, 45, "...")) ?></td>
                            <td>
                                <small><?= date('d M Y', strtotime($row['created_at'])) ?></small><br>
                                <small class="text-muted"><?= date('h:i A', strtotime($row['created_at'])) ?></small>
                            </td>
                            <td class="text-center">
                                <a href="?page=messages&view_id=<?= $row['id'] ?>&p=<?= $page_num ?>" 
                                   class="btn btn-sm <?= $isNew ? 'btn-warning' : 'btn-light border' ?> rounded-pill px-3">
                                   <?= $isNew ? 'Read Now' : 'View' ?>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <?php if($total_pages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= ($page_num <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=messages&p=<?= $page_num - 1 ?>">Previous</a>
                    </li>
                    <?php for($i=1; $i<=$total_pages; $i++): ?>
                        <li class="page-item <?= ($i == $page_num) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=messages&p=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= ($page_num >= $total_pages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=messages&p=<?= $page_num + 1 ?>">Next</a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<script>
// Live Search Optimization
document.getElementById("searchInput")?.addEventListener("input", function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll("#tableBody tr");

    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });
});
</script>