<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

require '../db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['InternshipID'])) {
    $studentID = $_SESSION['student_id'];
    $internshipID = $_POST['InternshipID'];

    $checkStmt = $pdo->prepare("SELECT * FROM SAVED_INTERNSHIPS WHERE StudentID = ? AND InternshipID = ?");
    $checkStmt->execute([$studentID, $internshipID]);
    
    if ($checkStmt->rowCount() === 0) {
        $saveStmt = $pdo->prepare("INSERT INTO SAVED_INTERNSHIPS (StudentID, InternshipID, SavedDate) VALUES (?, ?, NOW())");
        $saveStmt->execute([$studentID, $internshipID]);
        $_SESSION['message'] = "Internship saved successfully!";
    } else {
        $_SESSION['message'] = "This internship is already saved.";
    }
} else {
    $_SESSION['message'] = "Invalid request.";
}

header("Location: dashboard.php");
exit();
?>
