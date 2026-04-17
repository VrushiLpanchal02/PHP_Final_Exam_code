<?php
// Login page: verifies credentials and starts session

require "config/db.php";
session_start();
include "includes/header.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Fetch user from DB using prepared statement
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verify password using password_verify()
    if ($user && password_verify($password, $user['password'])) {

        // Store session data for login
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header("Location: dashboard.php");
        exit;

    } else {
        $msg = "Invalid credentials";
    }
}
?>

<h3>Login</h3>
<p class="msg"><?= $msg ?></p>

<form method="POST">
    <input type="text" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    <button type="submit">Login</button>
</form>

<a href="register.php">Register</a>

<?php include "includes/footer.php"; ?>