<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="<?= htmlspecialchars(url('dashboard'), ENT_QUOTES, 'UTF-8') ?>">CRM SYSTEM</a>
    <ul class="navbar-nav ms-auto me-3"><li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="fas fa-user fa-fw"></i></a>
        <ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item" href="<?= htmlspecialchars(url('logout'), ENT_QUOTES, 'UTF-8') ?>">Logout</a></li></ul>
    </li></ul>
</nav>
