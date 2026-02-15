<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
</head>

<body>

    <h2>Dashboard Sistem Magang</h2>

    <p>Login berhasil!</p>

    <p>
        User ID: <?= $this->session->userdata('user_id') ?><br>
        Active Role: <?= $this->session->userdata('active_role') ?><br>
        All Roles: <?= implode(', ', $this->session->userdata('roles') ?? []) ?>
    </p>

    <a href="<?= base_url('auth/logout') ?>">Logout</a>

</body>

</html>