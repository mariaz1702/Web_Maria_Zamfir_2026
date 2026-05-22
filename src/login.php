<?php require_once 'config.php';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();
    if($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id']; $_SESSION['username'] = $user['username']; $_SESSION['role'] = $user['role'];
        if(isset($_POST['remember'])) setcookie('remember_user', $user['username'], time() + 86400*30, "/");
        header("Location: dashboard.php");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/style_login.css">
    </head>
    <body class="login-bg">
        <div class="login-box">
            <h2>Login Explorer</h2>
            <form method="POST">
                <input type="text" name="username" placeholder="Username"><br>
                <input type="password" name="password" placeholder="Password"><br>
                <input type="checkbox" name="remember"> Remember Me<br>
                <button type="submit">Login</button>
            </form>
            <a href="register.php">Cont nou</a>
        </div>
    </body>
</html>