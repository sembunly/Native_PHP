<?php require dirname(__DIR__, 3) . '/resources/layouts/header.php'; ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <p>Welcome, <?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?>.</p>
    <ol class="breadcrumb mb-4"><li class="breadcrumb-item active">Dashboard</li></ol>
    <div class="card mb-4"><div class="card-body">Welcome to your CRM dashboard.</div></div>
</div>
<?php require dirname(__DIR__, 3) . '/resources/layouts/footer.php'; ?>
