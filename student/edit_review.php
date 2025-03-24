<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

require '../db/database.php';

// Fetch the review details
if (isset($_GET['review_id'])) {
    $reviewID = $_GET['review_id'];

    $stmt = $pdo->prepare("SELECT Rating, Comment FROM REVIEW WHERE ReviewID = ?");
    $stmt->execute([$reviewID]);
    $review = $stmt->fetch();

    if (!$review) {
        echo "Review not found.";
        exit();
    }
} else {
    echo "No review specified.";
    exit();
}

// Handle form submission to update the review
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $updateStmt = $pdo->prepare("UPDATE REVIEW SET Rating = ?, Comment = ? WHERE ReviewID = ?");
    $updateStmt->execute([$rating, $comment, $reviewID]);

    header("Location: view_your_reviews.php"); // Redirect back to the reviews page
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Edit Review</title>
</head>
<body>
    <h1>Edit Your Review</h1>
    <form action="" method="post">
        <label for="rating">Rating (1-5):</label>
        <input type="number" name="rating" id="rating" value="<?php echo htmlspecialchars($review['Rating']); ?>" min="1" max="5" required>

        <label for="comment">Comment:</label>
        <textarea name="comment" id="comment" required><?php echo htmlspecialchars($review['Comment']); ?></textarea>

        <button type="submit">Update Review</button>
    </form>
    <p><a href="view_your_reviews.php">Back to Your Reviews</a></p>
</body>
</html>
