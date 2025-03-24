<?php
require '../db/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize the input data
    $emailID = trim($_POST['EmailID']);
    $password = trim($_POST['Password']); // Use plain text password

    // Prepare a statement to check if the student exists
    $stmt = $pdo->prepare("SELECT * FROM STUDENTS WHERE EmailID = ?");
    $stmt->execute([$emailID]);
    $student = $stmt->fetch();

    // Verify password if student record is found
    if ($student && $password === $student['Password']) { // Compare plain text passwords
        session_start();
        $_SESSION['student_id'] = $student['StudentID'];
        header("Location: dashboard.php");
        exit();
    } else {
        // Display an error message for invalid login
        echo "Invalid email or password!";
    }
}
?>
