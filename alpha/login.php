<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        // Use a prepared statement to look up the user by username only
        $stmt = mysqli_prepare($db, "SELECT id, username, password_hash FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        // Verify password hash securely
        if ($user && password_verify($password, $user['password_hash'])) {
            // Secure session initialization and ID regeneration
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            // Redirect to cookbook/admin area
            header('Location: alpha.php');
            exit;
        } else {
            $message = "❌ Invalid username or password.";
        }
    } else {
        $message = "⚠️ Please fill in all required fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookbook Login</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <h1>🔐 admin log-in</h1>

    <?php if (!empty($message)): ?>
        <div class="message-banner"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="recipe-card" style="width: auto; max-width: 450px; margin: 40px auto;">
        <h3>sign in</h3>
        <form method="POST" action="login.php" class="add-form">
            <div class="form-group">
                <label>username</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn">🚀 log in</button>
        </form>
    </div>
</body>
</html>