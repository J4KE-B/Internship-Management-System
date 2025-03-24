<?php
session_start();
if (!isset($_SESSION['company_id'])) {
    header("Location: login.php");
    exit();
}
require '../db/database.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $companyID = $_POST['company_id'];
    $companyName = $_POST['company_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Update the company name and email
    $stmt = $pdo->prepare("UPDATE COMPANY SET CompanyName = ?, EmailID = ? WHERE CompanyID = ?");
    if ($stmt->execute([$companyName, $email, $companyID])) {
        // Now update the phone number in COMPANY_PHONE table
        $phoneStmt = $pdo->prepare("INSERT INTO COMPANY_PHONE (CompanyID, PhoneNo) VALUES (?, ?) ON DUPLICATE KEY UPDATE PhoneNo = ?");
        $phoneStmt->execute([$companyID, $phone, $phone]);

        // Redirect back to the dashboard with a success message
        header("Location: dashboard.php?update=success");
        exit();
    } else {
        // Handle errors, e.g., redirect back with an error message
        header("Location: dashboard.php?update=error");
        exit();
    }
}
