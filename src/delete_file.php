<?php
require_once 'config.php';
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['trip_id'])) {
    $id = $_POST['trip_id'];
    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare("SELECT image_path, user_id FROM trips WHERE id = ?");
    $stmt->execute([$id]);
    $trip = $stmt->fetch(PDO::FETCH_ASSOC);

    if($trip && ($trip['user_id'] == $userId || $_SESSION['role'] === 'admin')) {
        if(!empty($trip['image_path']) && file_exists($trip['image_path'])) {
            unlink($trip['image_path']);
        }

        $stmt = $pdo->prepare("DELETE FROM trips WHERE id = ?");
        $stmt->execute([$id]);
    }
}

header("Location: dashboard.php");
exit;
