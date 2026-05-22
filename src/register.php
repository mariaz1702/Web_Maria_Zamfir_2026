<?php require_once 'config.php';
$msg = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if($_POST['captcha'] != $_SESSION['captcha_code']) { $msg = "Captcha gresit!"; }
    else {
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        try { $stmt->execute([$_POST['username'], $hash]); header("Location: login.php"); }
        catch(Exception $e) { $msg = "Userul exista deja!"; }
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
            <h2>Join the Adventure</h2>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <img src="captcha.php"><input type="text" name="captcha" placeholder="Captcha" required><br>
                <button type="submit">Inregistrare</button>
            </form>
        </div>
    </body>
</html>