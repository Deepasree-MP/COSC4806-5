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
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title m-0">Login Attempts Chart</h5>
                        <select id="loginChartType" class="form-select form-select-sm w-auto">
                            <option value="bar">Bar</option>
                            <option value="pie">Pie</option>
                        </select>
                    </div>
                    <canvas id="loginChart" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-warning shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title m-0">Reminders per User Chart</h5>
                        <select id="reminderChartType" class="form-select form-select-sm w-auto">
                            <option value="bar">Bar</option>
                            <option value="pie">Pie</option>
                        </select>
                    </div>
                    <canvas id="reminderChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <div class="col-md-6">
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Top User: <?= htmlspecialchars($topUser['username']) ?> (Reminder Status)</h5>
                    <canvas id="topUserChart" height="250"></canvas>
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
                        <th>Completed</th>
                        <th>Cancelled</th>
                        <th>Pending</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($userCounts as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= $row['total_reminders'] ?></td>
                        <td><?= $row['completed_count'] ?></td>
                        <td><?= $row['cancelled_count'] ?></td>
                        <td><?= $row['pending_count'] ?></td>
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
document.addEventListener('DOMContentLoaded', function () {
    let loginStats = <?= json_encode($loginStats) ?>;
    let userCounts = <?= json_encode($userCounts) ?>;
    let topUser = <?= json_encode($topUser) ?>;

    let loginChartInstance;
    let reminderChartInstance;

    function renderLoginChart(type) {
        const ctx = document.getElementById('loginChart').getContext('2d');
        if (loginChartInstance) loginChartInstance.destroy();
        const data = {
            labels: loginStats.map(row => row.username),
            datasets: type === 'pie' ? [{
                label: 'Total Attempts',
                data: loginStats.map(row => parseInt(row.success_count) + parseInt(row.failure_count)),
                backgroundColor: loginStats.map((_, i) => `hsl(${i * 30}, 70%, 60%)`)
            }] : [
                {
                    label: 'Successful Logins',
                    data: loginStats.map(row => parseInt(row.success_count)),
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Failed Logins',
                    data: loginStats.map(row => parseInt(row.failure_count)),
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        };
        loginChartInstance = new Chart(ctx, {
            type: type,
            data: data,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Login Attempts'
                    }
                },
                scales: type === 'bar' ? {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                } : {}
            }
        });
    }

    function renderReminderChart(type) {
        const ctx = document.getElementById('reminderChart').getContext('2d');
        if (reminderChartInstance) reminderChartInstance.destroy();
        const data = {
            labels: userCounts.map(row => row.username),
            datasets: type === 'pie' ? [{
                label: 'Total Reminders',
                data: userCounts.map(row => parseInt(row.total_reminders)),
                backgroundColor: userCounts.map((_, i) => `hsl(${i * 40}, 70%, 60%)`)
            }] : [{
                label: 'Total Reminders',
                data: userCounts.map(row => parseInt(row.total_reminders)),
                backgroundColor: 'rgba(255, 206, 86, 0.6)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        };
        reminderChartInstance = new Chart(ctx, {
            type: type,
            data: data,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Reminders per User'
                    }
                },
                scales: type === 'bar' ? {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                } : {}
            }
        });
    }

    const ctxTopUser = document.getElementById('topUserChart').getContext('2d');
    new Chart(ctxTopUser, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'Pending', 'Cancelled'],
            datasets: [{
                data: [
                    parseInt(topUser.completed_count),
                    parseInt(topUser.pending_count),
                    parseInt(topUser.cancelled_count)
                ],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(255, 99, 132, 0.6)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: `Reminder Status for ${topUser.username}`
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    document.getElementById('loginChartType').addEventListener('change', function () {
        renderLoginChart(this.value);
    });

    document.getElementById('reminderChartType').addEventListener('change', function () {
        renderReminderChart(this.value);
    });

    renderLoginChart('bar');
    renderReminderChart('bar');
});
</script>

<?php require_once 'app/views/templates/footer.php'; ?>
