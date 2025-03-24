<?php
session_start();
if (!isset($_SESSION['company_id'])) {
    header("Location: login.php");
    exit();
}
require '../db/database.php';

$companyID = $_SESSION['company_id'];
$stmt = $pdo->prepare("SELECT * FROM INTERNSHIPS WHERE CompanyID = ?");
$stmt->execute([$companyID]);
$internships = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Manage Internships</title>
</head>
<body>
    <h1>Manage Your Internships</h1>
    <table>
        <tr>
            <th>Duration</th>
            <th>Seats</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($internships as $internship) { ?>
            <tr>
                <td><?php echo $internship['Duration']; ?></td>
                <td><?php echo $internship['NoOfSeats']; ?></td>
                <td>
                    <a href="edit_internship.php?id=<?php echo $internship['InternshipID']; ?>">Edit</a>
                    <a href="delete_internship.php?id=<?php echo $internship['InternshipID']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <a href="add_internship.php">Add New Internship</a>
    <p><a href="../index.php">Home</a></p>
</body>
</html>
