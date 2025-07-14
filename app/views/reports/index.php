<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-3">Admin Reports Dashboard</h2>

    <p class="lead">Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</p>

    <div class="alert alert-info">
        <strong>Admin-only access.</strong> This page includes reports like:
        <ul>
            <li>Total number of reminders per user</li>
            <li>Total login attempts per user</li>
            <li>Login attempts chart (below)</li>
        </ul>
    </div>

    <!-- 📊 Chart Canvas -->
    <div class="mt-5">
        <h4>Login Attempts Chart</h4>
        <canvas id="loginChart" width="600" height="300"></canvas>
    </div>

    <!-- 🧾 Table: Reminders -->
    <div class="mt-5">
        <h4>Total Reminders by User</h4>
        <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Username</th>
                        <th>Total Reminders</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($userCounts)): ?>
                        <?php foreach ($userCounts as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= $row['total_reminders'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">No reminder data found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 🧾 Table: Login Attempts -->
    <div class="mt-5">
        <h4>Total Login Attempts by User</h4>
        <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Username</th>
                        <th>Login Attempts</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($loginCounts)): ?>
                        <?php foreach ($loginCounts as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= $row['login_count'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">No login data found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Chart Script -->
<script>
    const ctx = document.getElementById('loginChart').getContext('2d');
    const loginChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($loginCounts, 'username')) ?>,
            datasets: [{
                label: 'Login Attempts',
                data: <?= json_encode(array_column($loginCounts, 'login_count')) ?>,
                backgroundColor: 'rgba(220, 53, 69, 0.7)',
                borderColor: 'rgba(220, 53, 69, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision:0
                    }
                }
            }
        }
    });
</script>

<?php require_once 'app/views/templates/footer.php'; ?>
