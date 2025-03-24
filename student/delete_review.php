<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

require '../db/database.php';

// Check if review ID is provided
if (isset($_GET['review_id'])) {
    $reviewID = $_GET['review_id'];

    // Prepare and execute the delete statement
    $stmt = $pdo->prepare("DELETE FROM REVIEW WHERE ReviewID = ?");
    $stmt->execute([$reviewID]);

    // Redirect back to the reviews page with a success message
    header("Location: view_your_reviews.php?message=Review deleted successfully.");
    exit();
} else {
    echo "No review specified.";
    exit();
}
?>
