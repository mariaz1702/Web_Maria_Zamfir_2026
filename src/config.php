<?php
session_start();
require_once 'Database.php';

$dbInstance = new Database(); //instantiere 
$pdo = $dbInstance->getConnection(); //se apeleaza pt a obtine conexiune activa

// Verificare Remember Me
if(!isset($_SESSION['user_id']) && isset($_COOKIE['remember_user'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_COOKIE['remember_user']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
    }
}
?>