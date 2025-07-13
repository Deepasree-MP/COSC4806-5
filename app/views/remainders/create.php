<?php include 'app/views/templates/header.php'; ?>

<div class="container">
    <div class="page-header mb-4">
        <h2>Create Remainder</h2>
    </div>

    <form action="/remainders/store" method="post">
        <div class="mb-3">
            <label class="form-label">Subject:</label>
            <input type="text" name="subject" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description:</label>
            <textarea name="description" rows="5" class="form-control" required></textarea>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <button type="submit" class="btn btn-danger">Save</button>
            <a href="/remainders" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php include 'app/views/templates/footer.php'; ?>
