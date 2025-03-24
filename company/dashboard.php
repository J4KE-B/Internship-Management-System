<?php
session_start();
if (!isset($_SESSION['company_id'])) {
    header("Location: login.php");
    exit();
}
require '../db/database.php';

$companyID = $_SESSION['company_id'];
$stmt = $pdo->prepare("SELECT c.*, cp.PhoneNo FROM COMPANY c LEFT JOIN COMPANY_PHONE cp ON c.CompanyID = cp.CompanyID WHERE c.CompanyID = ?");
$stmt->execute([$companyID]);
$company = $stmt->fetch();

// Fetch all internships for the company
$internshipStmt = $pdo->prepare("SELECT * FROM INTERNSHIPS WHERE CompanyID = ?");
$internshipStmt->execute([$companyID]);
$internships = $internshipStmt->fetchAll();

// Fetch reviews for internships of the company
$reviewStmt = $pdo->prepare("
    SELECT r.*, s.FirstName, s.LastName 
    FROM REVIEW r 
    JOIN STUDENTS s ON r.StudentID = s.StudentID 
    JOIN INTERNSHIPS i ON r.InternshipID = i.InternshipID 
    WHERE i.CompanyID = ?
");
$reviewStmt->execute([$companyID]);
$reviews = $reviewStmt->fetchAll();

// Fetch number of students applied for each internship
$applicantsCount = [];
$applicantStmt = $pdo->prepare("
    SELECT InternshipID, COUNT(*) AS NumberOfApplicants 
    FROM REVIEW 
    GROUP BY InternshipID
");
$applicantStmt->execute();
while ($row = $applicantStmt->fetch()) {
    $applicantsCount[$row['InternshipID']] = $row['NumberOfApplicants'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Company Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($company['CompanyName']); ?></h1>

    <h2>Your Internships</h2>
    <table>
        <thead>
            <tr>
                <th>Duration</th>
                <th>Number of Seats</th>
                <th>Number of Applicants</th> <!-- New Column -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($internships as $internship): ?>
                <tr>
                    <td><?php echo htmlspecialchars($internship['Duration']); ?></td>
                    <td><?php echo htmlspecialchars($internship['NoOfSeats']); ?></td>
                    <td>
                        <?php 
                        // Display the number of applicants for the internship
                        echo isset($applicantsCount[$internship['InternshipID']]) ? htmlspecialchars($applicantsCount[$internship['InternshipID']]) : 0; 
                        ?>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Reviews</h3>
    <table>
        <thead>
            <tr>
                <th>Internship</th>
                <th>Student Name</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reviews as $review): ?>
                <tr>
                    <td><?php echo htmlspecialchars($review['InternshipID']); ?></td>
                    <td><?php echo htmlspecialchars($review['FirstName'] . ' ' . $review['LastName']); ?></td>
                    <td><?php echo htmlspecialchars($review['Rating']); ?></td>
                    <td><?php echo htmlspecialchars($review['Comment']); ?></td>
                    <td><?php echo htmlspecialchars($review['ReviewDate']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Actions</h3>
    <p>
        <a href="manage_internships.php">Manage Internships</a> | 
        <a href="edit_company.php?id=<?php echo htmlspecialchars($company['CompanyID']); ?>">Edit Profile</a>
    </p>

    <p><a href="logout.php">Logout</a></p>  <!-- Logout link -->
</body>
</html>
