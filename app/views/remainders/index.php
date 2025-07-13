<?php include 'app/views/templates/header.php'; ?>

<div class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Hey <?= htmlspecialchars($_SESSION['username'] ?? 'Guest') ?></h1>
                <p class="lead"><?= date("F jS, Y"); ?></p>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-lg-12">
            <a href="/remainders/create" class="btn btn-danger mb-3">Create Remainder</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h3>My Remainders</h3>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Subject</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($remainders as $rem): ?>
                        <tr>
                            <td>
                                <?php
                                if ($rem['status'] == 1) echo 'Active';
                                elseif ($rem['status'] == 0) echo 'Completed';
                                elseif ($rem['status'] == 2) echo 'Cancelled';
                                ?>
                            </td>
                            <td><?= htmlspecialchars($rem['subject']); ?></td>
                            <td><?= htmlspecialchars($rem['description']); ?></td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php if ($rem['status'] != 0): ?>
                                        <a href="/remainders/edit/<?= $rem['id'] ?>" class="btn btn-sm btn-outline-primary">Modify</a>
                                    <?php endif; ?>

                                    <?php if ($rem['status'] == 1): ?>
                                        <a href="/remainders/delete/<?= $rem['id'] ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                                        <a href="/remainders/complete/<?= $rem['id'] ?>" class="btn btn-sm btn-outline-success">Complete</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <h4 class="mt-5">Remainder Database table Data</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
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
                        <?php foreach ($remainders as $rem): ?>
                        <tr>
                            <td><?= $rem['id'] ?></td>
                            <td><?= $rem['user_id'] ?></td>
                            <td><?= htmlspecialchars($rem['subject']); ?></td>
                            <td><?= htmlspecialchars($rem['description']); ?></td>
                            <td><?= $rem['status'] ?></td>
                            <td><?= $rem['created_at'] ?></td>
                            <td><?= $rem['updated_at'] ?></td>
                            <td><?= $rem['deleted_at'] ?></td>
                            <td><?= $rem['completed_at'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <p><a href="/logout">Click here to logout</a></p>
        </div>
    </div>
</div>

<?php include 'app/views/templates/footer.php'; ?>
