<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}
require '../db/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $companyID = $_POST['CompanyID'];
    $rating = $_POST['Rating'];
    $comment = $_POST['Comment'];

    $stmt = $pdo->prepare("INSERT INTO REVIEWS (CompanyID, StudentID, Rating, Comment) VALUES (?, ?, ?, ?)");
    $stmt->execute([$companyID, $_SESSION['student_id'], $rating, $comment]);
    echo "Review submitted successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Write Review</title>
</head>
<body>
    <h1>Write a Review</h1>
    <form action="write_review.php" method="POST">
        <input type="hidden" name="CompanyID" value="<?php echo $_GET['company_id']; ?>">
        <input type="number" name="Rating" min="1" max="5" placeholder="Rating (1-5)" required>
        <textarea name="Comment" placeholder="Write your review here..." required></textarea>
        <button type="submit">Submit Review</button>
    </form>
    <p><a href="../student/dashboard.php">Back to Dashboard</a></p>
</body>
</html>
