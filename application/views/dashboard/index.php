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
    Role ID: <?= $this->session->userdata('role_id') ?>
</p>

<a href="<?= base_url('auth/logout') ?>">Logout</a>

</body>
</html>
