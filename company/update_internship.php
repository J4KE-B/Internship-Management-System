<?php
session_start();
require '../db/database.php';

if (!isset($_SESSION['company_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $internshipID = $_POST['internship_id'];
    $duration = $_POST['duration'];
    $seats = $_POST['seats'];

    $stmt = $pdo->prepare("UPDATE INTERNSHIPS SET Duration = ?, NoOfSeats = ? WHERE InternshipID = ?");
    $stmt->execute([$duration, $seats, $internshipID]);

    header("Location: dashboard.php");  // Redirect back to the company dashboard
    exit();
}
?>
