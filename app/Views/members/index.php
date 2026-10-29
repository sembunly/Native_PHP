<?php require dirname(__DIR__, 3) . '/resources/layouts/header.php'; ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm"><div class="card-header"><h4 class="mb-0">Members List</h4></div><div class="card-body">
        <form method="get" action="<?= htmlspecialchars(url('members'), ENT_QUOTES, 'UTF-8') ?>" class="mb-3"><div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search name, phone, email..." value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
            <button class="btn btn-primary" type="submit">Search</button><a href="<?= htmlspecialchars(url('members'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-secondary">Clear</a>
        </div></form>
        <div class="table-responsive"><table class="table table-bordered table-striped"><thead><tr><th>First name</th><th>Last name</th><th>Gender</th><th>DOB</th><th>Phone</th><th>Email</th><th>Address</th><th>Join Date</th><th>Action</th></tr></thead><tbody>
        <?php if ($members): foreach ($members as $row): ?><tr>
            <?php foreach (['first_name', 'last_name', 'gender', 'dob', 'phone', 'email', 'address', 'join_date'] as $field): ?><td><?= htmlspecialchars((string) $row[$field], ENT_QUOTES, 'UTF-8') ?></td><?php endforeach; ?>
            <td><a class="btn btn-primary btn-sm" href="<?= htmlspecialchars(url('members/edit?id=' . (int) $row['id']), ENT_QUOTES, 'UTF-8') ?>">Edit</a>
                <form method="post" action="<?= htmlspecialchars(url('members/delete'), ENT_QUOTES, 'UTF-8') ?>" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this member?')">
                    <input type="hidden" name="_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>"><input type="hidden" name="id" value="<?= (int) $row['id'] ?>"><button class="btn btn-danger btn-sm" type="submit">Delete</button>
                </form></td>
        </tr><?php endforeach; else: ?><tr><td colspan="9" class="text-center">No members found</td></tr><?php endif; ?>
        </tbody></table></div>
    </div></div>
</div>
<?php require dirname(__DIR__, 3) . '/resources/layouts/footer.php'; ?>
