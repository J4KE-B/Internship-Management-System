<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

require '../db/database.php';

// Fetch the student ID
$studentID = $_SESSION['student_id'];

// Fetch reviews for the logged-in student, including the company name instead of the internship title
$stmt = $pdo->prepare("SELECT r.ReviewID, r.Rating, r.Comment, c.CompanyName 
                        FROM REVIEW r 
                        JOIN INTERNSHIPS i ON r.InternshipID = i.InternshipID 
                        JOIN COMPANY c ON i.CompanyID = c.CompanyID 
                        WHERE r.StudentID = ?");
$stmt->execute([$studentID]);
$reviews = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Your Reviews</title>
</head>
<body>
    <h1>Your Reviews</h1>
    <table>
        <tr>
            <th>Company Name</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>Action</th> <!-- New header for actions -->
        </tr>
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <tr>
                    <td><?php echo htmlspecialchars($review['CompanyName']); ?></td>
                    <td><?php echo htmlspecialchars($review['Rating']); ?></td>
                    <td><?php echo htmlspecialchars($review['Comment']); ?></td>
                    <td>
                        <a href="edit_review.php?review_id=<?php echo $review['ReviewID']; ?>">Edit</a>
                        <a href="delete_review.php?review_id=<?php echo $review['ReviewID']; ?>" onclick="return confirm('Are you sure you want to delete this review?');">Delete</a> <!-- Delete link -->
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">You have not reviewed any internships yet.</td>
            </tr>
        <?php endif; ?>
    </table>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
