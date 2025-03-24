<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

require '../db/database.php';

$studentID = $_SESSION['student_id'];

// Fetch current student details
$stmt = $pdo->prepare("SELECT * FROM STUDENTS WHERE StudentID = ?");
$stmt->execute([$studentID]);
$student = $stmt->fetch();

// Fetch current skills
$skillsStmt = $pdo->prepare("SELECT s.SkillID, s.SkillName FROM STUDENT_SKILLS ss JOIN SKILL s ON ss.SkillID = s.SkillID WHERE ss.StudentID = ?");
$skillsStmt->execute([$studentID]);
$currentSkills = $skillsStmt->fetchAll(PDO::FETCH_ASSOC);

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    // Get updated values from the form
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Update student details
    $updateStmt = $pdo->prepare("UPDATE STUDENTS SET FirstName = ?, LastName = ?, EmailID = ?, PhoneNo = ? WHERE StudentID = ?");
    $updateStmt->execute([$firstName, $lastName, $email, $phone, $studentID]);

    // Redirect to the profile view page after updating
    header("Location: view_profile.php");
    exit();
}

// Handle skill addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_skill'])) {
    $newSkill = $_POST['new_skill'];

    // Check if the skill already exists for the student
    $existingSkillStmt = $pdo->prepare("SELECT SkillID FROM SKILL WHERE SkillName = ?");
    $existingSkillStmt->execute([$newSkill]);
    $skill = $existingSkillStmt->fetch();

    // If the skill doesn't exist, insert it
    if ($skill) {
        $skillID = $skill['SkillID'];
        $insertSkillStmt = $pdo->prepare("INSERT INTO STUDENT_SKILLS (StudentID, SkillID) VALUES (?, ?)");
        $insertSkillStmt->execute([$studentID, $skillID]);
    } else {
        // Optionally, you can handle the case where the skill does not exist
        // For example, you can insert a new skill into the SKILL table
        $insertNewSkillStmt = $pdo->prepare("INSERT INTO SKILL (SkillName) VALUES (?)");
        $insertNewSkillStmt->execute([$newSkill]);
        $skillID = $pdo->lastInsertId();
        $insertSkillStmt = $pdo->prepare("INSERT INTO STUDENT_SKILLS (StudentID, SkillID) VALUES (?, ?)");
        $insertSkillStmt->execute([$studentID, $skillID]);
    }

    // Redirect to the same page to see updated skills
    header("Location: edit_profile.php");
    exit();
}

// Handle skill removal
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_skill'])) {
    $skillIDToRemove = $_POST['skill_id'];

    // Remove skill from STUDENT_SKILLS table
    $removeSkillStmt = $pdo->prepare("DELETE FROM STUDENT_SKILLS WHERE StudentID = ? AND SkillID = ?");
    $removeSkillStmt->execute([$studentID, $skillIDToRemove]);

    // Redirect to the same page to see updated skills
    header("Location: edit_profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Edit Profile</title>
</head>
<body>
    <h1>Edit Profile</h1>
    <form action="" method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($student['FirstName']); ?>" required>
        
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($student['LastName']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['EmailID']); ?>" required>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($student['PhoneNo']); ?>" required>

        <button type="submit" name="update_profile">Update Profile</button>
    </form>

    <h2>Your Skills</h2>
    <ul>
        <?php foreach ($currentSkills as $skill): ?>
            <li>
                <?php echo htmlspecialchars($skill['SkillName']); ?>
                <form action="" method="POST" style="display:inline;">
                    <input type="hidden" name="skill_id" value="<?php echo $skill['SkillID']; ?>">
                    <button type="submit" name="remove_skill">Remove</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Add New Skill</h3>
    <form action="" method="POST">
        <input type="text" name="new_skill" placeholder="Enter new skill" required>
        <button type="submit" name="add_skill">Add Skill</button>
    </form>

    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
