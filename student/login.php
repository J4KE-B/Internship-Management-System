<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Student Login</title>
</head>
<body>
    <h1>Student Login</h1>
    <form action="login_action.php" method="POST">
        <input type="email" name="EmailID" placeholder="Email ID" required>
        <input type="password" name="Password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>
