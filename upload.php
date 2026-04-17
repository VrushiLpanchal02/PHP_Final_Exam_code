<?php
// Handles image upload with validation and DB storage

require "config/db.php";
require "includes/auth.php";
checkAuth();

include "includes/header.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $file = $_FILES['image'];

    // Allowed file types
    $allowed = ['jpg','jpeg','png','gif'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Validation
    if (empty($title) || empty($file['name'])) {
        $msg = "All fields required";
    }
    elseif (!in_array($ext, $allowed)) {
        $msg = "Invalid file type";
    } else {

        // Create unique file name
        $new = time() . "_" . $file['name'];
        $path = "uploads/" . $new;

        // Move file to uploads folder
        move_uploaded_file($file['tmp_name'], $path);

        // Save file path in database
        $stmt = $pdo->prepare("INSERT INTO images (user_id,title,file_path) VALUES (?,?,?)");
        $stmt->execute([$_SESSION['user_id'],$title,$path]);

        $msg = "Uploaded successfully";
    }
}
?>

<h3>Upload Image</h3>
<p class="msg"><?= $msg ?></p>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Image title">
    <input type="file" name="image">
    <button type="submit">Upload</button>
</form>

<?php include "includes/footer.php"; ?>