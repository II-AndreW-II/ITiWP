<?php
require 'config.php';

if (isset($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $new_status = $_GET['status'] === 'активен' ? 'активен' : 'не активен';

    $stmt = $pdo->prepare("UPDATE contacts SET status = ? WHERE id = ?");
    $stmt->execute([$new_status, $id]);
}

header('Location: index.php');
exit;
?>