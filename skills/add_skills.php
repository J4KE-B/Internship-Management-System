<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}
require '../db/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $skillName = $_POST['SkillName'];
    $stmt = $pdo->prepare("INSERT INTO SKILL (SkillName) VALUES (?)");
    $stmt->execute([$skillName]);
    echo "Skill added successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Add Skill</title>
</head>
<body>
    <h1>Add Skill</h1>
    <form action="add_skills.php" method="POST">
        <input type="text" name="SkillName" placeholder="Skill Name" required>
        <button type="submit">Add Skill</button>
    </form>
    <p><a href="../student/dashboard.php">Back to Dashboard</a></p>
</body>
</html>
