<?php require_once 'app/views/templates/headerPublic.php' ?>

<main class="container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
    <div class="col-md-6 col-lg-5">
        <div class="border rounded p-4 shadow-sm">
            <h2 class="text-center fw-normal mb-4">Create an Account</h2>

            <?php if (!empty($message)) : ?>
                <div class="alert alert-success"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="post" action="/create">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-danger">Create</button>
                    <a href="/login" class="btn btn-outline-primary">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</main>
