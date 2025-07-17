<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-3 fw-bold text-primary">Admin Reports Dashboard</h2>
    <p class="lead">Welcome, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong></p>

    <?php if (isset($topUser)): ?>
    <div class="alert alert-success">
        <strong>Top User:</strong> <?= htmlspecialchars($topUser['username']) ?> with <?= $topUser['total_reminders'] ?> reminders 
    </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Login Attempts Chart</h5>
                    <canvas id="loginChart" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Reminders per User Chart</h5>
                    <canvas id="reminderChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h4 class="fw-bold text-dark">All Reminders</h4>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Subject</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allReminders as $reminder): ?>
                    <tr>
                        <td><?= $reminder['id'] ?></td>
                        <td><?= $reminder['user_id'] ?></td>
                        <td><?= htmlspecialchars($reminder['subject']) ?></td>
                        <td><?= htmlspecialchars($reminder['description']) ?></td>
                        <td><?= $reminder['status'] ?></td>
                        <td><?= $reminder['created_at'] ?? 'N/A' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">
        <h4 class="fw-bold text-dark">Reminder Counts by User</h4>
        <div class="table-responsive">
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
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Username</th>
                        <th>Successful Logins</th>
                        <th>Failed Logins</th>
                        <th>Total Attempts</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($loginStats as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= $row['success_count'] ?></td>
                        <td><?= $row['failure_count'] ?></td>
                        <td><?= $row['success_count'] + $row['failure_count'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const loginStats = <?= json_encode($loginStats) ?>;
    const usernames = loginStats.map(row => row.username);
    const successCounts = loginStats.map(row => parseInt(row.success_count));
    const failureCounts = loginStats.map(row => parseInt(row.failure_count));

    const loginChart = new Chart(document.getElementById('loginChart'), {
        type: 'bar',
        data: {
            labels: usernames,
            datasets: [
                {
                    label: 'Successful Logins',
                    data: successCounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Failed Logins',
                    data: failureCounts,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Login Attempts: Success vs Failure'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });

    const reminderChart = new Chart(document.getElementById('reminderChart'), {
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
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>

<?php require_once 'app/views/templates/footer.php'; ?>
