<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="https://cvsu.edu.ph/wp-content/uploads/2018/01/CvSU-logo-trans.png" sizes="192x192">
    <style>
        /* Add your custom styles here */
        #page-content-wrapper form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* ... (your existing CSS styles) ... */

        /* Style for the training console */
        #training-console {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <!-- User Settings Modal -->
    <div class="modal fade" id="userSettingsModal" tabindex="-1" aria-labelledby="userSettingsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userSettingsModalLabel">User Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add your user settings form or content here -->
                    <!-- For example, change password, update profile, etc. -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
                <img src="static/images/CvSU-logo-trans.png" alt="image" width="50" height="40"> CVSU
            </div>
            <div class="list-group list-group-flush my-3">
                <a href="dashboardAdmin.php" class="list-group-item list-group-item-action bg-transparent second-text active">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
                <a href="trainAdmin.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                    <i class="fas fa-project-diagram me-2"></i> Add Response
                </a>
                <a href="train.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                    <i class="fas fa-brain"></i> Train
                </a>
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                    <i class="fas fa-paperclip me-2"></i> Reports
                </a>
               
                <a href="logout.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"
                    onclick="return confirm('Are you sure you want to logout?');">
                    <i class="fas fa-power-off me-2"></i> Logout
                </a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Admin Dashboard</h2>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i> <?php echo $_SESSION['user_name']; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#userSettingsModal">Settings</a>
                                <script>
                                    function confirmLogout() {
                                        if (confirm('Are you sure you want to logout?')) {
                                            // If the user confirms, proceed with the logout by redirecting to the logout script
                                            window.location.href = "logout.php";
                                        }
                                    }
                                </script>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="confirmLogout()">Logout</a>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

    

            <!-- Display training console here -->
            <div id="training-console">
            <?php
if (isset($_POST['train_chatbot'])) {
    try {
        // Execute the Python training script and capture output and errors
        $output = shell_exec("python train.py 2>&1");

        // Check if there was an error
        if ($output === null) {
            throw new Exception("Command execution failed");
        }

        // Display the training progress or logs (including errors)
        echo '<div class="container mt-5">';
        echo '<div class="row justify-content-center">';
        echo '<div class="col-md-8">';
        echo '<pre>' . $output . '</pre>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    } catch (Exception $e) {
        // Handle the exception (e.g., display an error message)
        echo '<div class="container mt-5">';
        echo '<div class="row justify-content-center">';
        echo '<div class="col-md-8">';
        echo '<div class="alert alert-danger" role="alert">';
        echo 'An error occurred: ' . $e->getMessage();
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
?>

            </div>

            <div class="d-flex align-items-center">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <!-- The train chatbot button -->
                    <button id="trainButton" class="btn btn-success btn-md" type="submit" name="train_chatbot"
                        style="color: rgb(174, 173, 170); background-color: rgb(24, 101, 41); border-color: rgb(28, 117, 48);">
                        Train Chatbot
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- train button function (takes time) -->
    <script>
    document.getElementById('trainButton').addEventListener('click', function() {
        fetch('http://127.0.0.1:5000/train', {
            method: 'POST'
        })
        .then(function(response) {
            console.log('Response:', response); // Log the response
            if (response.ok) {
                alert('Training started successfully.');
            } else {
                console.error('Error starting training:', response.statusText);
                // You can choose to display an alert here if needed
            }
        });
    });
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");
        
        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script>
</body>
</html>
<?php 
} else {
    header("Location: loginAdmin.php");
    exit();
}
?>