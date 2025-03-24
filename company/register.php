<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Company Registration</title>
</head>
<body>
    <h1>Company Registration</h1>
    <form action="register_action.php" method="POST">
        <input type="text" name="CompanyName" placeholder="Company Name" required>
        <input type="text" name="PhoneNo" placeholder="Phone Number" required>
        <input type="email" name="EmailID" placeholder="Email ID" required>
        <input type="password" name="Password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
