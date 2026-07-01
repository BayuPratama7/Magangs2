<?php
/**
 * Fix: Tambah akses penguji untuk Dosen Tiga, Empat, Lima
 * Akses via browser: https://magangs2-production.up.railway.app/fix_penguji.php
 * HAPUS FILE INI SETELAH SELESAI DIJALANKAN
 */

$db_url = getenv('DATABASE_URL');
$host = getenv('PGHOST');
$user = getenv('PGUSER');
$pass = getenv('PGPASSWORD');
$db   = getenv('PGDATABASE');
$port = getenv('PGPORT') ? getenv('PGPORT') : 5432;

if ($db_url) {
    $parsed = parse_url($db_url);
    $host = isset($parsed['host']) ? $parsed['host'] : $host;
    $user = isset($parsed['user']) ? $parsed['user'] : $user;
    $pass = isset($parsed['pass']) ? $parsed['pass'] : $pass;
    $db   = isset($parsed['path']) ? ltrim($parsed['path'], '/') : $db;
    $port = isset($parsed['port']) ? $parsed['port'] : $port;
}

if (!$host || !$db) {
    die("Error: Kredensial database tidak ditemukan.");
}

$dsn = "pgsql:host=$host;port=$port;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // 1. Update is_penguji di tabel dosen
    $pdo->exec("UPDATE dosen SET is_penguji = true WHERE user_id IN (60, 61, 62)");
    echo "OK: dosen.is_penguji updated untuk user_id 60, 61, 62<br>";

    // 2. Tambah role penguji (role_id=6) di tabel user_roles (skip jika sudah ada)
    $stmt = $pdo->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (:uid, 6) ON CONFLICT (user_id, role_id) DO NOTHING");
    
    foreach ([60, 61, 62] as $uid) {
        $stmt->execute([':uid' => $uid]);
        echo "OK: user_roles role_id=6 untuk user_id=$uid<br>";
    }

    echo "<br><h2>SELESAI! Dosen 3, 4, 5 sekarang punya akses Penguji.</h2>";
    echo "<p>Silakan <b>logout lalu login ulang</b> sebagai dosen3/4/5 untuk melihat perubahannya.</p>";
    echo "<p style='color:red'><b>PENTING: Hapus file fix_penguji.php setelah selesai!</b></p>";

} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}
