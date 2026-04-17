<?php
// Dashboard: displays uploaded image gallery

require "config/db.php";
require "includes/auth.php";
checkAuth();

include "includes/header.php";
?>

<!-- User info and navigation -->
<div class="topbar">
Welcome, <?= $_SESSION['username'] ?> |
<a href="upload.php">Upload</a> |
<a href="logout.php">Logout</a>
</div>

<h3>Gallery</h3>

<div class="gallery">
<?php
// Fetch all images from database
$stmt = $pdo->query("SELECT * FROM images ORDER BY uploaded_at DESC");

while ($row = $stmt->fetch()) {
    echo "
    <div class='card'>
        <img src='{$row['file_path']}'>
        <h4>{$row['title']}</h4>
        <a class='delete' href='delete.php?id={$row['id']}'>Delete</a>
    </div>";
}
?>
</div>

<?php include "includes/footer.php"; ?>