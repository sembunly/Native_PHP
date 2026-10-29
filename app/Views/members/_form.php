<div class="container-fluid px-4"><div class="card mt-4 shadow-sm"><div class="card-header"><h4 class="mb-0"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>
    <a href="<?= htmlspecialchars(url('members'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-primary float-end">Back</a></h4></div><div class="card-body">
    <?php if ($error !== ''): ?><div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
    <form method="post" action="<?= htmlspecialchars(url($member && isset($member['id']) ? 'members/edit?id=' . (int) $member['id'] : 'members/create'), ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>"><div class="row">
        <?php foreach (['first_name' => 'First Name', 'last_name' => 'Last Name', 'phone' => 'Phone', 'email' => 'Email'] as $field => $label): ?>
            <div class="col-md-6 mb-3"><label><?= $label ?></label><input type="<?= $field === 'email' ? 'email' : 'text' ?>" name="<?= $field ?>" class="form-control" value="<?= htmlspecialchars((string) ($member[$field] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required></div>
        <?php endforeach; ?>
        <div class="col-md-4 mb-3"><label>Gender</label><select name="gender" class="form-control" required><option value="">Select Gender</option><?php foreach (['Male', 'Female'] as $gender): ?><option value="<?= $gender ?>" <?= ($member['gender'] ?? '') === $gender ? 'selected' : '' ?>><?= $gender ?></option><?php endforeach; ?></select></div>
        <?php foreach (['dob' => 'Date of Birth', 'join_date' => 'Join Date'] as $field => $label): ?><div class="col-md-4 mb-3"><label><?= $label ?></label><input type="date" name="<?= $field ?>" class="form-control" value="<?= htmlspecialchars((string) ($member[$field] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required></div><?php endforeach; ?>
        <div class="col-md-12 mb-3"><label>Address</label><textarea name="address" class="form-control" rows="3"><?= htmlspecialchars((string) ($member['address'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea></div>
        <div class="col-md-12 mb-3"><button type="submit" class="btn btn-primary"><?= $member && isset($member['id']) ? 'Update Member' : 'Add Member' ?></button></div>
        </div></form>
</div></div></div>
