<?php
session_start();
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        header("Location: loginAdmin.php?error=User Name is required");
        exit();
    } elseif (empty($pass)) {
        header("Location: loginAdmin.php?error=Password is required");
        exit();
    } else {
        // Use MySQLi with prepared statements for improved security
        $sql = "SELECT * FROM users WHERE user_name = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $uname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($pass, $user['password'])) {
            // Password matches; set session variables
            $_SESSION['user_name'] = $user['user_name'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['id'] = $user['id'];

            // Regenerate session ID for security
            session_regenerate_id();

            header("Location: dashboardAdmin.php");
            exit();
        } else {
            header("Location: loginAdmin.php?error=Incorrect username or password");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="icon" href="https://cvsu.edu.ph/wp-content/uploads/2018/01/CvSU-logo-trans.png" sizes="192x192">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="https://cvsu.edu.ph/wp-content/uploads/2018/01/CvSU-logo-trans.png" sizes="192x192">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>
        /* Add your CSS styles here */
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            background-image: linear-gradient(to right, #376d1d, #83ce21, #aff331, #a2bb32, #58c01c);
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 90%;
            max-width: 400px;
            padding: 20px;
            background: linear-gradient(to bottom, yellow, green);
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto 20px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            border: none;
            border-radius: 3px;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="static/images/CvSU-logo-trans.png" alt="image">
        <form action="loginAdmin.php" method="post">
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>

            <label for="uname">Username</label>
            <input type="text" id="uname" name="uname" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button class="btn btn-success btn-md" type="submit" style="color: rgb(174, 173, 170); background-color: rgb(24, 101, 41); border-color: rgb(28, 117, 48);">Login</button>
        </form>
    </div>
</body>
</html>
