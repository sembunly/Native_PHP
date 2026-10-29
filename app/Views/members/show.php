<?php require dirname(__DIR__, 3) . '/resources/layouts/header.php'; ?>
<div class="container-fluid px-4"><div class="alert alert-warning mt-4">No Such Member Found</div><a href="<?= htmlspecialchars(url('members'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-primary">Back to Members</a></div>
<?php require dirname(__DIR__, 3) . '/resources/layouts/footer.php'; ?>
