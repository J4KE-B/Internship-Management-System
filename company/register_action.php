<?php
require '../db/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $companyName = $_POST['CompanyName'];
    $emailID = $_POST['EmailID'];
    $password = $_POST['Password']; // Use plain text password
    $phoneNo = $_POST['PhoneNo'];

    try {
        // Start transaction
        $pdo->beginTransaction();

        // Insert into COMPANY table
        $stmt = $pdo->prepare("INSERT INTO COMPANY (CompanyName, EmailID, Password) VALUES (?, ?, ?)");
        $stmt->execute([$companyName, $emailID, $password]); // No password hashing

        // Get the last inserted CompanyID
        $companyID = $pdo->lastInsertId();

        // Insert into COMPANY_PHONE table
        $phoneStmt = $pdo->prepare("INSERT INTO COMPANY_PHONE (CompanyID, PhoneNo) VALUES (?, ?)");
        $phoneStmt->execute([$companyID, $phoneNo]);

        // Commit transaction
        $pdo->commit();

        echo "Registration successful!";
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>
