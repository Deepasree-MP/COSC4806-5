<?php include 'app/views/templates/header.php'; ?>

<div class="container">
    <div class="page-header mb-4">
        <h2>Delete Remainder</h2>
    </div>

    <div class="alert alert-warning">
        <p>Do you want to delete this remainder?</p>
        <p><strong>Subject:</strong> <?= htmlspecialchars($remainder['subject']); ?></p>
        <p><strong>Description:</strong> <?= htmlspecialchars($remainder['description']); ?></p>
    </div>

    <?php if (!isset($updated)): ?>
    <form action="/remainders/confirm_delete/<?= $remainder['id'] ?>" method="post">
        <div class="d-flex flex-wrap gap-2 mb-4">
            <button type="submit" class="btn btn-danger">Confirm Delete</button>
            <a href="/remainders" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
    <?php endif; ?>

    <h4>Remainder Details (Before)</h4>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th><th>User ID</th><th>Subject</th><th>Description</th><th>Status</th>
                    <th>Created At</th><th>Updated At</th><th>Deleted At</th><th>Completed At</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $remainder['id'] ?></td>
                    <td><?= $remainder['user_id'] ?></td>
                    <td><?= htmlspecialchars($remainder['subject']); ?></td>
                    <td><?= htmlspecialchars($remainder['description']); ?></td>
                    <td><?= $remainder['status'] ?></td>
                    <td><?= $remainder['created_at'] ?></td>
                    <td><?= $remainder['updated_at'] ?></td>
                    <td><?= $remainder['deleted_at'] ?></td>
                    <td><?= $remainder['completed_at'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <?php if (isset($updated) && $updated): ?>
    <h4>Remainder Details (After)</h4>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th><th>User ID</th><th>Subject</th><th>Description</th><th>Status</th>
                    <th>Created At</th><th>Updated At</th><th>Deleted At</th><th>Completed At</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $newRow['id'] ?></td>
                    <td><?= $newRow['user_id'] ?></td>
                    <td><?= htmlspecialchars($newRow['subject']); ?></td>
                    <td><?= htmlspecialchars($newRow['description']); ?></td>
                    <td><?= $newRow['status'] ?></td>
                    <td><?= $newRow['created_at'] ?></td>
                    <td><?= $newRow['updated_at'] ?></td>
                    <td><?= $newRow['deleted_at'] ?></td>
                    <td><?= $newRow['completed_at'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="alert alert-success mt-3">
        Deleted! Redirecting back to index in <span id="timer">10</span> seconds...
    </div>

    <button onclick="window.location.href='/remainders'" class="btn btn-primary mt-2">
        Redirect Now
    </button>

    <script>
        let timeLeft = 10;
        const timer = document.getElementById('timer');

        const countdown = setInterval(() => {
            timeLeft--;
            timer.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                window.location.href = "/remainders";
            }
        }, 1000);
    </script>
    <?php endif; ?>
</div>

<?php include 'app/views/templates/footer.php'; ?>
