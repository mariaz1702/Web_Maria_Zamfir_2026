<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['trip_id'])) {
    $tripId = $_POST['trip_id'];
    $newLoc = $_POST['new_loc'];
    $userId = $_SESSION['user_id'];
    $role = $_SESSION['role'];

    // 1. Verificăm dacă postarea aparține userului (sau dacă e admin)
    $stmt = $pdo->prepare("SELECT image_path, user_id FROM trips WHERE id = ?");
    $stmt->execute([$tripId]);
    $trip = $stmt->fetch();

    if ($trip && ($trip['user_id'] == $userId || $role == 'admin')) {
        
        // 2. Actualizăm numele locației (folosind Procedura Stocată dacă vrei, sau direct SQL)
        $stmt = $pdo->prepare("UPDATE trips SET location_name = ? WHERE id = ?");
        $stmt->execute([$newLoc, $tripId]);

        // 3. Verificăm dacă s-a încărcat o imagine nouă
        if (isset($_FILES['new_img']) && $_FILES['new_img']['error'] === UPLOAD_ERR_OK) {
            $fileName = time() . "_" . basename($_FILES["new_img"]["name"]);
            $targetPath = "uploads/" . $fileName;

            if (move_uploaded_file($_FILES["new_img"]["tmp_name"], $targetPath)) {
                // Ștergem poza veche de pe disc
                if (file_exists($trip['image_path'])) {
                    unlink($trip['image_path']);
                }

                // Actualizăm calea în DB
                $stmt = $pdo->prepare("UPDATE trips SET image_path = ? WHERE id = ?");
                $stmt->execute([$targetPath, $tripId]);
            }
        }
    }
}

header("Location: dashboard.php");
exit;