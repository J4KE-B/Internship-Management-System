<?php
session_start();
if (!isset($_SESSION['company_id'])) {
    header("Location: login.php");
    exit();
}
require '../db/database.php';

// Check if 'id' parameter is present in the URL
if (!isset($_GET['id'])) {
    // Redirect or handle the error as appropriate
    header("Location: manage_internships.php");
    exit();
}

$internshipID = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM INTERNSHIPS WHERE InternshipID = ?");
$stmt->execute([$internshipID]);
$internship = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $duration = $_POST['Duration'];
    $noOfSeats = $_POST['NoOfSeats'];

    $stmt = $pdo->prepare("UPDATE INTERNSHIPS SET Duration = ?, NoOfSeats = ? WHERE InternshipID = ?");
    $stmt->execute([$duration, $noOfSeats, $internshipID]);
    // Use header after output buffer
    header("Location: manage_internships.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Edit Internship</title>
</head>
<body>
    <h1>Edit Internship</h1>
    <form action="edit_internship.php?id=<?php echo urlencode($internshipID); ?>" method="POST">
        <input type="text" name="Duration" value="<?php echo htmlspecialchars($internship['Duration']); ?>" required>
        <input type="number" name="NoOfSeats" value="<?php echo htmlspecialchars($internship['NoOfSeats']); ?>" required>
        <button type="submit">Update Internship</button>
    </form>
    <p><a href="manage_internships.php">Back to Manage Internships</a></p>
</body>
</html>
