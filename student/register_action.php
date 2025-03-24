<?php
require '../db/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['FirstName'];
    $lastName = $_POST['LastName'];
    $emailID = $_POST['EmailID'];
    $phoneNo = $_POST['PhoneNo'];
    $pinCode = $_POST['PinCode'];
    $dob = $_POST['DOB'];
    $password = password_hash($_POST['Password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO STUDENTS (FirstName, LastName, EmailID, PhoneNo, PinCode, DOB, Password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$firstName, $lastName, $emailID, $phoneNo, $pinCode, $dob, $password]);

    echo "Registration successful!";
    header("Location: login.php");
}
?>
