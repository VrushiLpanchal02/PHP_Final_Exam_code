<?php
// Registration page: validates input and stores user securely

require "config/db.php";
include "includes/header.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate empty fields
    if (empty($username) || empty($email) || empty($password)) {
        $msg = "All fields are required.";
    }
    // Validate email format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Invalid email format.";
    } else {

        // Hash password before storing (security requirement)
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Insert user using prepared statement (prevent SQL injection)
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hash]);

        $msg = "Registration successful. Please login.";
    }
}
?>

<h3>Register</h3>
<p class="msg"><?= $msg ?></p>

<form method="POST">
    <input type="text" name="username" placeholder="Username">
    <input type="text" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    <button type="submit">Register</button>
</form>

<a href="login.php">Login</a>

<?php include "includes/footer.php"; ?>