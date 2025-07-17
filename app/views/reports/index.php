<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-3 fw-bold text-primary">Admin Reports Dashboard</h2>
    <p class="lead">Welcome, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong></p>

    <?php if (isset($topUser)): ?>
        <div class="alert alert-success">
            <strong>Summary</strong> 
        </div>
        <?php endif; ?>

    <div class="row g-4 mb-4">
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

    <?php if (isset($topUser)): ?>
        <div class="alert alert-success">
            <strong>Top User:</strong> <?= htmlspecialchars($topUser['username']) ?> with <?= $topUser['total_reminders'] ?> reminders 
        </div>
        <?php endif; ?>

    <div class="mb-4">
        <label for="userSelect" class="form-label fw-semibold">Select User:</label>
        <select id="userSelect" class="form-select w-auto d-inline-block">
            <?php foreach ($userCounts as $row): ?>
                <option value="<?= $row['username'] ?>" <?= $row['username'] === $topUser['username'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['username']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Reminder Status for <span id="selectedUserReminderTitle"><?= htmlspecialchars($topUser['username']) ?></span></h5>
                    <canvas id="topUserReminderChart" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-info shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Login Attempts for <span id="selectedUserLoginTitle"><?= htmlspecialchars($topUser['username']) ?></span></h5>
                    <canvas id="topUserLoginChart" height="250"></canvas>
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
    const userCounts = <?= json_encode($userCounts) ?>;
    const loginStats = <?= json_encode($loginStats) ?>;
    let selectedUser = document.getElementById('userSelect').value;

    const loginBarCtx = document.getElementById('loginChart').getContext('2d');
    const reminderBarCtx = document.getElementById('reminderChart').getContext('2d');
    const reminderDonutCtx = document.getElementById('topUserReminderChart').getContext('2d');
    const loginDonutCtx = document.getElementById('topUserLoginChart').getContext('2d');

    let loginChartInstance, reminderChartInstance;
    let reminderDonutChart, loginDonutChart;

    function renderLoginBar(type) {
        if (loginChartInstance) loginChartInstance.destroy();
        loginChartInstance = new Chart(loginBarCtx, {
            type: type,
            data: {
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
            },
            options: {
                responsive: true,
                plugins: { title: { display: true, text: 'Login Attempts' } },
                scales: type === 'bar' ? { y: { beginAtZero: true } } : {}
            }
        });
    }

    function renderReminderBar(type) {
        if (reminderChartInstance) reminderChartInstance.destroy();
        reminderChartInstance = new Chart(reminderBarCtx, {
            type: type,
            data: {
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
            },
            options: {
                responsive: true,
                plugins: { title: { display: true, text: 'Reminders per User' } },
                scales: type === 'bar' ? { y: { beginAtZero: true } } : {}
            }
        });
    }

    function renderUserDonutCharts(username) {
        const user = userCounts.find(u => u.username === username) || {};
        const login = loginStats.find(l => l.username === username) || { success_count: 0, failure_count: 0 };

        const completed = parseInt(user.completed_count) || 0;
        const pending = parseInt(user.pending_count) || 0;
        const cancelled = parseInt(user.cancelled_count) || 0;
        const success = parseInt(login.success_count) || 0;
        const failure = parseInt(login.failure_count) || 0;

        document.getElementById('selectedUserReminderTitle').textContent = username;
        document.getElementById('selectedUserLoginTitle').textContent = username;

        if (reminderDonutChart) reminderDonutChart.destroy();
        if (loginDonutChart) loginDonutChart.destroy();

        reminderDonutChart = new Chart(reminderDonutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [completed, pending, cancelled],
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
                plugins: { legend: { position: 'bottom' } }
            }
        });

        loginDonutChart = new Chart(loginDonutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Successful Logins', 'Failed Logins'],
                datasets: [{
                    data: [success, failure],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 99, 132, 0.6)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

    renderLoginBar('bar');
    renderReminderBar('bar');
    renderUserDonutCharts(selectedUser);

    document.getElementById('loginChartType').addEventListener('change', function () {
        renderLoginBar(this.value);
    });

    document.getElementById('reminderChartType').addEventListener('change', function () {
        renderReminderBar(this.value);
    });

    document.getElementById('userSelect').addEventListener('change', function () {
        selectedUser = this.value;
        renderUserDonutCharts(selectedUser);
    });
});
</script>

<?php require_once 'app/views/templates/footer.php'; ?>
