<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Home - Student Dashboard</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <h1>Welcome to Your Home Page</h1>
    <p><a href="view_internships.php">View Internships</a></p>
    <p><a href="edit_profile.php">Edit Profile</a></p>
    <p><a href="view_saved_internships.php">View Saved Internships</a></p>
    <p><a href="logout.php">Logout</a></p>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
