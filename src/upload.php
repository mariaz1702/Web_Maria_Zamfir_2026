<?php
require_once 'config.php';
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['img'])) {
    $loc = $_POST['loc'];
    $userId = $_SESSION['user_id'];
    
    if(!is_dir('uploads')) mkdir('uploads', 0777, true);

    $target = "uploads/" . time() . "_" . basename($_FILES["img"]["name"]);
    if(move_uploaded_file($_FILES["img"]["tmp_name"], $target)) {
        $stmt = $pdo->prepare("INSERT INTO trips (user_id, location_name, image_path) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $loc, $target]);
    }
}
header("Location: dashboard.php");