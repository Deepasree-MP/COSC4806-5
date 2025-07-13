<?php require_once 'app/views/templates/header.php' ?>

<div class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Hey <?= htmlspecialchars($_SESSION['username'] ?? 'Guest') ?></h1>
                <p class="lead"> <?= date("F jS, Y"); ?></p>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['auth'])): ?>
    <div class="row mb-3">
        <div class="col-lg-12">
            <a href="/remainders/index" class="btn btn-danger">My Remainders</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h3>All Registered Users</h3>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td><?= htmlspecialchars($u['username']) ?></td>
                                <td><?= htmlspecialchars($u['password']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </br>
    </br>
    <div class="row">
        <div class="col-lg-12">
            <p><a href="/logout" >Click here to logout</a></p>
        </div>
    </div>
    <?php else: ?>
    <div class="row">
        <div class="col-lg-12">
            <p><a href="/login" >Click here to login</a></p>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once 'app/views/templates/footer.php' ?>
