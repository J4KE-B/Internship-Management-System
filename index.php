<?php
session_start();
require 'db/database.php'; // Include your database connection

// Check if the user is already logged in
if (isset($_SESSION['student_id'])) {
    header("Location: student/dashboard.php");
    exit();
} elseif (isset($_SESSION['company_id'])) {
    header("Location: company/dashboard.php");
    exit();
}

// Fetch the number of companies
$companyCountStmt = $pdo->query("SELECT COUNT(*) FROM COMPANY");
$companyCount = $companyCountStmt->fetchColumn();

// Fetch the number of students
$studentCountStmt = $pdo->query("SELECT COUNT(*) FROM STUDENTS");
$studentCount = $studentCountStmt->fetchColumn();

// Fetch available internships with company names
$internshipStmt = $pdo->query("
    SELECT i.InternshipID, i.Duration, i.NoOfSeats, c.CompanyName
    FROM INTERNSHIPS i
    JOIN COMPANY c ON i.CompanyID = c.CompanyID
    LIMIT 5"); // Limit to 5 internships
$internships = $internshipStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Link your CSS file -->
</head>
<body>
    <h1>Welcome to the Internship Portal</h1>
    <p>Please <a href="select_role.php">log in or register</a> to continue.</p>

    <h2>Statistics</h2>
    <p>Number of Registered Companies: <strong><?php echo htmlspecialchars($companyCount); ?></strong></p>
    <p>Number of Registered Students: <strong><?php echo htmlspecialchars($studentCount); ?></strong></p>

    <h2>Available Internships</h2>
    <?php if (count($internships) > 0): ?>
        <ul>
            <?php foreach ($internships as $internship): ?>
                <li>
                    <strong>Company:</strong> <?php echo htmlspecialchars($internship['CompanyName']); ?>, 
                    <strong>Duration:</strong> <?php echo htmlspecialchars($internship['Duration']); ?>, 
                    <strong>Seats Available:</strong> <?php echo htmlspecialchars($internship['NoOfSeats']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No internships available at the moment.</p>
    <?php endif; ?>
</body>
</html>
