<?php
$host = "sql100.infinityfree.com";
$dbname = "if0_41688395_image_gallery";
$username = "if0_41688395";
$password = "YOUR_PASSWORD";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
?>