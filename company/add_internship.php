<?php
session_start();
if (!isset($_SESSION['company_id'])) {
    header("Location: login.php");
    exit();
}
require '../db/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $duration = $_POST['Duration'];
    $noOfSeats = $_POST['NoOfSeats'];
    $companyID = $_SESSION['company_id'];

    $stmt = $pdo->prepare("INSERT INTO INTERNSHIPS (Duration, NoOfSeats, CompanyID) VALUES (?, ?, ?)");
    $stmt->execute([$duration, $noOfSeats, $companyID]);
    echo "Internship added successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Add Internship</title>
</head>
<body>
    <h1>Add New Internship</h1>
    <form action="add_internship.php" method="POST">
        <input type="text" name="Duration" placeholder="Duration" required>
        <input type="number" name="NoOfSeats" placeholder="Number of Seats" required>
        <button type="submit">Add Internship</button>
    </form>
    <p><a href="manage_internships.php">Back to Manage Internships</a></p>
</body>
</html>
