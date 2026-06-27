<?php
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
    die("Error: Kredensial database tidak ditemukan di Railway Variables.");
}

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
