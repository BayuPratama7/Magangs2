<?php
$db_url = getenv('DATABASE_URL');
if (!$db_url) {
    die("Error: DATABASE_URL not found. Pastikan Anda sudah menghubungkan Postgres di Railway Variables.");
}

$parsed = parse_url($db_url);
$host = $parsed['host'];
$user = $parsed['user'];
$pass = $parsed['pass'];
$db   = ltrim($parsed['path'], '/');
$port = isset($parsed['port']) ? $parsed['port'] : 5432;

$dsn = "pgsql:host=$host;port=$port;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    // Baca file SQL
    $sql = file_get_contents('database_inserts.sql');
    
    if ($sql === false) {
        die("Error: Gagal membaca file database_inserts.sql");
    }

    // Eksekusi SQL
    $pdo->exec($sql);
    echo "<h1>MIGRATION SUCCESS!</h1>";
    echo "<p>Seluruh tabel dan data berhasil dimasukkan ke Railway Postgres!</p>";
    echo "<p>Silakan kembali ke <a href='index.php/auth/login'>Halaman Login</a>.</p>";

} catch (PDOException $e) {
    echo "<h1>MIGRATION FAILED</h1>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
