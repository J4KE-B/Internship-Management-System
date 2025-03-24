<?php
require '../db/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailID = $_POST['EmailID'];
    $password = $_POST['Password']; // Use plain text password

    $stmt = $pdo->prepare("SELECT * FROM COMPANY WHERE EmailID = ?");
    $stmt->execute([$emailID]);
    $company = $stmt->fetch();

    // Compare plain text passwords
    if ($company && $password === $company['Password']) {
        session_start();
        $_SESSION['company_id'] = $company['CompanyID'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid email or password!";
    }
}
?>
