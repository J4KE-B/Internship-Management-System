<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

require '../db/database.php';

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
    <title>View Profile</title>
</head>
<body>
    <h1>Your Profile</h1>
    <p>Name: <?php echo htmlspecialchars($student['FirstName'] . ' ' . $student['LastName']); ?></p>
    <p>Email: <?php echo htmlspecialchars($student['EmailID']); ?></p>
    <p>Phone: <?php echo htmlspecialchars($student['PhoneNo']); ?></p>
    <p>Date of Birth: <?php echo htmlspecialchars($student['DOB']); ?></p>
    <p>Skills:</p>
    <ul>
        <?php 
        $skillsStmt = $pdo->prepare("SELECT s.SkillName FROM STUDENT_SKILLS ss JOIN SKILL s ON ss.SkillID = s.SkillID WHERE ss.StudentID = ?");
        $skillsStmt->execute([$studentID]);
        $skills = $skillsStmt->fetchAll();
        
        if (count($skills) > 0) {
            foreach ($skills as $skill) {
                echo '<li>' . htmlspecialchars($skill['SkillName']) . '</li>';
            }
        } else {
            echo '<li>No skills added yet.</li>';
        }
        ?>
    </ul>
    
    <p><a href="edit_profile.php" class="button">Edit Profile</a></p>
    <p><a href="dashboard.php" class="button">Back to Dashboard</a></p>
</body>
</html>
