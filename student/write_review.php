
<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}
require '../db/database.php';

// Retrieve InternshipID using GET
if (isset($_GET['InternshipID'])) {
    $internshipID = $_GET['InternshipID'];

    // Fetch internship details
    $stmt = $pdo->prepare("SELECT i.Duration, i.NoOfSeats, c.CompanyName, c.EmailID 
                           FROM INTERNSHIPS i 
                           JOIN COMPANY c ON i.CompanyID = c.CompanyID 
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
    // Optionally, redirect to a different page or the same page to prevent resubmission
    header("Location: dashboard.php"); // Redirect to the dashboard after submission
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write Review for <?php echo htmlspecialchars($internship['CompanyName']); ?></title>
</head>
<body>
    <h1>Write a Review for <?php echo htmlspecialchars($internship['CompanyName']); ?></h1>
    <p><strong>Duration:</strong> <?php echo htmlspecialchars($internship['Duration']); ?></p>
    <p><strong>Number of Seats:</strong> <?php echo htmlspecialchars($internship['NoOfSeats']); ?></p>
    <p><strong>Company Contact:</strong> <?php echo htmlspecialchars($internship['EmailID']); ?></p>
    <p><strong>Instructions:</strong> Please contact the company using the email provided above to proceed with your application.</p>

    <h2>Write a Review</h2>
    <form action="" method="POST">
        <input type="hidden" name="InternshipID" value="<?php echo htmlspecialchars($internshipID); ?>">
        <label for="Rating">Rating (1-5):</label>
        <input type="number" name="Rating" min="1" max="5" required>
        <br>
        <label for="Comment">Comment:</label>
        <textarea name="Comment" required></textarea>
        <br>
        <button type="submit">Submit Review</button>
    </form>

    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
