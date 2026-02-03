<!DOCTYPE html>
<html>
<head>
    <title>Login Sistem Magang</title>
</head>
<body>
<h2>Login</h2>

<form method="post" action="<?= base_url('index.php/auth/auth/process') ?>">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
</form>

<?php if ($this->session->flashdata('error')): ?>
<p style="color:red"><?= $this->session->flashdata('error') ?></p>
<?php endif; ?>
</body>
</html>
