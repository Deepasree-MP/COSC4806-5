<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-3 fw-bold text-primary">Admin Reports Dashboard</h2>
    <p class="lead">Welcome, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong></p>

    <div class="row g-4">
        
        <div class="col-md-6">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-info-circle"></i> Dashboard Info</h5>
                    <p class="card-text">
                        This admin-only page shows:
                        <ul class="mb-0">
                            <li><span class="badge bg-secondary">Login Attempts</span> per user</li>
                            <li><span class="badge bg-info">Reminders</span> created by each user</li>
                            <li>Dynamic <strong>charts</strong> powered by Chart.js</li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>

        
        <div class="col-md-6">
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-bar-chart-line"></i> Login Attempts Chart</h5>
                    <canvas id="loginChart" width="400" height="250"></canvas>
                </div>
            </div>
        </div>

        
        <div class="col-md-12">
            <div class="card border-warning shadow-sm mt-3">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-bar-chart-fill"></i> Reminders per User Chart</h5>
                    <canvas id="reminderChart" width="600" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

   
    <div class="mt-5">
        <h4 class="fw-bold text-dark">Reminder Counts by User</h4>
        <div class="table-responsive mt-2">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Username</th>
                        <th>Total Reminders</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($userCounts as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= $row['total_reminders'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">
        <h4 class="fw-bold text-dark">Login Attempts by User</h4>
        <div class="table-responsive mt-2">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Username</th>
                        <th>Login Attempts</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($loginCounts as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= $row['login_count'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
    const loginChartCtx = document.getElementById('loginChart').getContext('2d');
    const reminderChartCtx = document.getElementById('reminderChart').getContext('2d');

    new Chart(loginChartCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($loginCounts, 'username')) ?>,
            datasets: [{
                label: 'Login Attempts',
                data: <?= json_encode(array_column($loginCounts, 'login_count')) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true, precision: 0 } }
        }
    });

    new Chart(reminderChartCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($userCounts, 'username')) ?>,
            datasets: [{
                label: 'Total Reminders',
                data: <?= json_encode(array_column($userCounts, 'total_reminders')) ?>,
                backgroundColor: 'rgba(255, 206, 86, 0.6)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true, precision: 0 } }
        }
    });
</script>

<?php require_once 'app/views/templates/footer.php'; ?>
