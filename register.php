<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <!-- Add your CSS styles here -->
</head>
<body>
    <h2>Registration</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        
        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        
        <button type="submit">Register</button>
    </form>
    <?php
    session_start();
    include "db_conn.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve and validate user input
        $username = validate($_POST['username']);
        $password = validate($_POST['password']);
        $confirm_password = validate($_POST['confirm_password']);

        if (empty($username)) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?error=Username is required");
            exit();
        } elseif (empty($password)) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?error=Password is required");
            exit();
        } elseif ($password !== $confirm_password) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?error=Passwords do not match");
            exit();
        }

        // Hash the password before inserting it into the database
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert the user into the database
        $sql = "INSERT INTO users (user_name, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: login.php?success=Registration successful. Please log in.");
            exit();
        } else {
            header("Location: " . $_SERVER['PHP_SELF'] . "?error=Registration failed");
            exit();
        }
    }

    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>
</body>
</html>
