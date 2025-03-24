<?php
require '../db/database.php';

try {
    // Prepare and execute the SQL query to fetch all available internships
    $stmt = $pdo->query("SELECT i.InternshipID, i.Duration, i.NoOfSeats, c.CompanyName
                         FROM INTERNSHIPS i
                         JOIN COMPANY c ON i.CompanyID = c.CompanyID");
    $internships = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>View Internships</title>
</head>
<body>
    <h1>Available Internships</h1>
    <?php if (!empty($internships)): ?>
        <table>
            <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Duration</th>
                    <th>Number of Seats</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($internships as $internship): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($internship['CompanyName']); ?></td>
                        <td><?php echo htmlspecialchars($internship['Duration']); ?></td>
                        <td><?php echo htmlspecialchars($internship['NoOfSeats']); ?></td>
                        <td>
                            <form action="apply_internship.php" method="POST" style="display: inline;">
                                <input type="hidden" name="InternshipID" value="<?php echo htmlspecialchars($internship['InternshipID']); ?>">
                                <button type="submit">Apply</button>
                            </form>
                            <form action="../reviews/view_reviews.php" method="GET" style="display: inline;">
                                <input type="hidden" name="internship_id" value="<?php echo htmlspecialchars($internship['InternshipID']); ?>">
                                <button type="submit">View Reviews</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No internships available at the moment.</p>
    <?php endif; ?>
</body>
</html>
