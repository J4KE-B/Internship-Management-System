<?php
require '../db/database.php';

// Retrieve InternshipID from the query string
$internshipID = $_GET['internship_id'] ?? null;
if ($internshipID) {
    // Fetch reviews for the specific internship
    $stmt = $pdo->prepare("SELECT r.Rating, r.Comment, s.FirstName 
                            FROM REVIEW r 
                            JOIN STUDENTS s ON r.StudentID = s.StudentID 
                            WHERE r.InternshipID = ?");
    $stmt->execute([$internshipID]);
    $reviews = $stmt->fetchAll();
} else {
    echo "No internship specified.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Reviews for Internship</title>
</head>
<body>
    <h1>Reviews for Internship</h1>
    <table>
        <tr>
            <th>Student Name</th>
            <th>Rating</th>
            <th>Comment</th>
        </tr>
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <tr>
                    <td><?php echo htmlspecialchars($review['FirstName']); ?></td>
                    <td><?php echo htmlspecialchars($review['Rating']); ?></td>
                    <td><?php echo htmlspecialchars($review['Comment']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No reviews available for this internship.</td>
            </tr>
        <?php endif; ?>
    </table>
    <p><a href="index.php">Back to Internships</a></p>
</body>
</html>
