<?php include 'app/views/templates/header.php'; ?>

<div class="container">
    <div class="page-header mb-4">
        <h2>Modify Remainder</h2>
    </div>

    <form action="/remainders/update/<?= $remainder['id'] ?>" method="post">
        <div class="mb-3">
            <label class="form-label">Subject:</label>
            <input type="text" name="subject" value="<?= htmlspecialchars($remainder['subject']); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description:</label>
            <textarea name="description" rows="5" class="form-control" required><?= htmlspecialchars($remainder['description']); ?></textarea>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <button type="submit" class="btn btn-danger">Update</button>
            <a href="/remainders" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>

    <?php if (isset($updated) && $updated): ?>
        <div class="mt-5">
            <h4>Previous Data</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Subject</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Deleted At</th>
                            <th>Completed At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $oldRow['id'] ?></td>
                            <td><?= $oldRow['user_id'] ?></td>
                            <td><?= htmlspecialchars($oldRow['subject']); ?></td>
                            <td><?= htmlspecialchars($oldRow['description']); ?></td>
                            <td><?= $oldRow['status'] ?></td>
                            <td><?= $oldRow['created_at'] ?></td>
                            <td><?= $oldRow['updated_at'] ?></td>
                            <td><?= $oldRow['deleted_at'] ?></td>
                            <td><?= $oldRow['completed_at'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h4>Updated Data</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Subject</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Deleted At</th>
                            <th>Completed At</th>
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
                Update successful! Redirecting to index in <span id="timer">10</span> seconds...
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
        </div>
    <?php endif; ?>
</div>

<?php include 'app/views/templates/footer.php'; ?>
