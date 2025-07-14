<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-3">Admin Reports Dashboard</h2>

    <p class="lead">Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</p>

    <div class="alert alert-info">
        <strong>Admin-only access.</strong> This page will later contain data reports such as:
        <ul>
            <li>Total number of reminders per user</li>
            <li>Top users by reminder count</li>
            <li>Total login attempts per user</li>
            <li>Chart visualization (Bonus!)</li>
        </ul>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Coming Soon</h5>
            <p class="card-text">This section will show interactive charts for admin statistics and trends.</p>
        </div>
    </div>

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
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
