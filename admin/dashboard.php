<?php
include('../db_connect.php');

// Counts
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM contact_messages"))['t'];
$unread = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as u FROM contact_messages WHERE status='new'"))['u'];
$read = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as r FROM contact_messages WHERE status='read'"))['r'];

// Last 7 days data
$chart_data = [];
$labels = [];

for($i=6; $i>=0; $i--){
    $date = date("Y-m-d", strtotime("-$i days"));
    $labels[] = date("d M", strtotime($date));

    $q = mysqli_query($conn, "SELECT COUNT(*) as c FROM contact_messages WHERE DATE(created_at)='$date'");
    $data = mysqli_fetch_assoc($q);
    $chart_data[] = $data['c'];
}

// Recent messages
$recent = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../admin/main.css">

<style>

/* GLOBAL */

/* CARDS */
.card {
    border: none;
    border-radius: 16px;
    background: #ffffff;
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
}

/* TABLE */
.table {
    border-collapse: separate;
    border-spacing: 0 10px;
}

.table thead th {
    border: none;
    font-size: 13px;
    color: #64748b;
}

.table tbody tr {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.03);
}

.table td {
    border: none;
    padding: 14px;
}

/* BADGE */
.badge {
    padding: 6px 10px;
    border-radius: 10px;
    font-size: 11px;
}

/* SCROLLBAR */
::-webkit-scrollbar {
    width: 6px;
}
::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

</style>
</head>

<body>

<div class="container-fluid py-4">

    <h3 class="fw-bold mb-4">Dashboard</h3>

    <!-- STATS -->
    <div class="row g-4 mb-4">
        
        <div class="col-md-4">
            <div class="card p-4 shadow-sm">
                <h6 class="text-muted">Total Messages</h6>
                <h2 class="fw-bold"><?php echo $total; ?></h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 shadow-sm">
                <h6 class="text-muted">Unread Messages</h6>
                <h2 class="fw-bold text-danger"><?php echo $unread; ?></h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 shadow-sm">
                <h6 class="text-muted">Response Rate</h6>
                <h2 class="fw-bold text-success">
                    <?php echo ($total > 0) ? round((($total-$unread)/$total)*100) : 0; ?>%
                </h2>
            </div>
        </div>

    </div>

    <!-- CHART -->
    <div class="row g-4 mb-4">

        <div class="col-md-8">
            <div class="card p-4">
                <h5 class="fw-bold mb-3">Messages (Last 7 Days)</h5>
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4">
                <h5 class="fw-bold mb-3">Status Overview</h5>
                <canvas id="pieChart"></canvas>
            </div>
        </div>

    </div>

    <!-- RECENT -->
    <div class="card p-4">
        <h5 class="fw-bold mb-3">Recent Messages</h5>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                <?php while($row = mysqli_fetch_assoc($recent)): ?>
                    <tr>
                        <td class="fw-semibold"><?php echo $row['name']; ?></td>
                        <td><?php echo substr($row['message'],0,40); ?>...</td>
                        <td>
                            <?php if($row['status']=='new'): ?>
                                <span class="badge bg-danger">New</span>
                            <?php else: ?>
                                <span class="badge bg-success">Read</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo date("d M Y", strtotime($row['created_at'])); ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// LINE CHART
new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            data: <?php echo json_encode($chart_data); ?>,
            borderWidth: 2,
            tension: 0.4,
            fill: true
        }]
    }
});

// PIE CHART
new Chart(document.getElementById('pieChart'), {
    type: 'doughnut',
    data: {
        labels: ['Read','Unread'],
        datasets: [{
            data: [<?php echo $read; ?>, <?php echo $unread; ?>]
        }]
    }
});
</script>

</body>
</html>