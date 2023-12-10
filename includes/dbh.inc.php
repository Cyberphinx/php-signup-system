<?php
// 'dbh.inc' is just naming convention

$dsn = "mysql:host=localhost;dbname=myfirstdatabase";
$dbusername = "root";
$dbpassword = "";

try {
    // php data objects (ie. database connection)
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
