<?php require_once 'app/views/templates/headerPublic.php' ?> 

<main class="container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
	<div class="col-md-6 col-lg-5">
		<div class="card shadow">
			<div class="text-center mt-3 mb-4">
				<h2 class="fw-normal">You are not logged in</h2>
			</div>
			<div class="card-body">

				<?php if (isset($_SESSION['error_message'])): ?>
					<div class="alert alert-danger">
						<?= htmlspecialchars($_SESSION['error_message']) ?>
					</div>
					<?php unset($_SESSION['error_message']); ?>
				<?php endif; ?>

				<form action="/login/verify" method="post">
					<div class="mb-3">
						<label for="username" class="form-label">Username</label>
						<input required type="text" class="form-control" id="username" name="username">
					</div>

					<div class="mb-3">
						<label for="password" class="form-label">Password</label>
						<input required type="password" class="form-control" id="password" name="password">
					</div>

					<div class="d-grid gap-2">
						<button type="submit" class="btn btn-danger">Login</button>
						<a href="/create" class="btn btn-outline-primary">Create an Account</a>
					</div>
				</form>

			</div>
		</div>
	</div>
</main>
