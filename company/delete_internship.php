<?php
session_start();
if (!isset($_SESSION['company_id'])) {
    header("Location: login.php");
    exit();
}
require '../db/database.php';

$internshipID = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM INTERNSHIPS WHERE InternshipID = ?");
$stmt->execute([$internshipID]);
echo "Internship deleted successfully!";
header("Location: manage_internships.php");
?>
