<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

require '../db/database.php';

// Fetch student details
$studentID = $_SESSION['student_id'];
$stmt = $pdo->prepare("SELECT * FROM STUDENTS WHERE StudentID = ?");
$stmt->execute([$studentID]);
$student = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Student Dashboard</title>
</head>
<body>
    <h1>Hey, <?php echo htmlspecialchars($student['FirstName']); ?>!</h1>
    
    <h2>Actions</h2>
    <p><a href="view_internships.php" class="button">View Available Internships</a></p>
    <p><a href="view_saved_internships.php" class="button">View Saved Internships</a></p>
    <p><a href="view_profile.php" class="button">View Profile</a></p>
    <p><a href="edit_profile.php" class="button">Edit Profile</a></p>
    <p><a href="view_your_reviews.php" class="button">View Your Reviews</a></p> <!-- New Button -->

    <h2>Logout</h2>
    <p><a href="logout.php" class="button">Logout</a></p>
</body>
</html>
