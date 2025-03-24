<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

require '../db/database.php';  // Include database connection

// Fetch saved internships for the logged-in student
$studentID = $_SESSION['student_id'];
$savedInternshipsStmt = $pdo->prepare("
    SELECT i.InternshipID, i.Duration, c.CompanyName
    FROM saved_internships s
    JOIN INTERNSHIPS i ON s.InternshipID = i.InternshipID
    JOIN COMPANY c ON i.CompanyID = c.CompanyID
    WHERE s.StudentID = ?
");
$savedInternshipsStmt->execute([$studentID]);
$savedInternships = $savedInternshipsStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">  <!-- Link to your CSS file -->
    <title>Your Saved Internships</title>
</head>
<body>
    
    <h1>Your Saved Internships</h1>
    
    <?php if (count($savedInternships) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Internship ID</th>
                    <th>Duration</th>
                    <th>Company Name</th>
                    <th>Action</th> <!-- Add an action column for any future features -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($savedInternships as $internship): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($internship['InternshipID']); ?></td>
                        <td><?php echo htmlspecialchars($internship['Duration']); ?></td>
                        <td><?php echo htmlspecialchars($internship['CompanyName']); ?></td>
                        <td>
                            <form action="apply_internship.php" method="post">  <!-- Redirect to apply -->
                                <input type="hidden" name="InternshipID" value="<?php echo htmlspecialchars($internship['InternshipID']); ?>">
                                <input type="submit" value="Apply">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>You have not saved any internships yet.</p>
    <?php endif; ?>

    <p><a href="dashboard.php">Go back to Dashboard</a></p>  <!-- Link back to the dashboard -->
    
</body>
</html>
