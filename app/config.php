<?php
date_default_timezone_set('Europe/Minsk');

$host = getenv('MYSQL_HOST') ?: 'db';
$dbname = getenv('MYSQL_DATABASE') ?: 'task_manager';
$username = getenv('MYSQL_USER') ?: 'user';
$password = getenv('MYSQL_PASSWORD') ?: 'password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("SET time_zone = '+03:00'");
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}
?>