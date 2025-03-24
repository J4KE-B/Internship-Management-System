<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}
require '../db/database.php';

// Retrieve InternshipID using POST
if (isset($_POST['InternshipID'])) {
    $internshipID = $_POST['InternshipID'];

    // Fetch internship details including company phone and internship category
    $stmt = $pdo->prepare("SELECT i.Duration, i.NoOfSeats, c.CompanyName, c.EmailID, cp.PhoneNo, ic.Type, ic.Mode 
                           FROM INTERNSHIPS i 
                           JOIN COMPANY c ON i.CompanyID = c.CompanyID 
                           JOIN COMPANY_PHONE cp ON c.CompanyID = cp.CompanyID 
                           JOIN INTERNSHIP_CATEGORIES ic ON i.InternshipID = ic.InternshipID
                           WHERE i.InternshipID = ?");
    $stmt->execute([$internshipID]);
    $internship = $stmt->fetch();
    
    if (!$internship) {
        echo "Internship not found.";
        exit();
    }
} else {
    echo "No internship specified.";
    exit();
}

// Handle review submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Rating']) && isset($_POST['Comment'])) {
    $rating = $_POST['Rating'];
    $comment = $_POST['Comment'];

    $stmt = $pdo->prepare("INSERT INTO REVIEW (StudentID, InternshipID, Rating, Comment, ReviewDate) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$_SESSION['student_id'], $internshipID, $rating, $comment]);

    echo "Review submitted successfully!";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Internship</title>
</head>
<body>
    <h1>Apply for Internship at <?php echo htmlspecialchars($internship['CompanyName']); ?></h1>
    <p><strong>Duration:</strong> <?php echo htmlspecialchars($internship['Duration']); ?></p>
    <p><strong>Number of Seats:</strong> <?php echo htmlspecialchars($internship['NoOfSeats']); ?></p>
    <p><strong>Company Contact:</strong> <?php echo htmlspecialchars($internship['EmailID']); ?></p>
    <p><strong>Company Phone:</strong> <?php echo htmlspecialchars($internship['PhoneNo']); ?></p>
    <p><strong>Type:</strong> <?php echo htmlspecialchars($internship['Type']); ?></p>
    <p><strong>Mode:</strong> <?php echo htmlspecialchars($internship['Mode']); ?></p>
    <p><strong>Instructions:</strong> Please contact the company using the email provided above to proceed with your application.</p>

    <!-- Button to go to Write Review Page -->
    <br>
    <a href="write_review.php?InternshipID=<?php echo htmlspecialchars($internshipID); ?>">
        <button>Write a Review</button>
    </a>

    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
