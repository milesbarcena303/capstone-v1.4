<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
    // Regenerate session ID to prevent session fixation
    session_regenerate_id(true);

    // Set a session timeout (e.g., 30 minutes)
    $sessionTimeout = 30 * 60; // 30 minutes in seconds
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $sessionTimeout) {
        session_unset();
        session_destroy();
        header("Location: loginAdmin.php"); // Redirect to login page
        exit;
    }
    $_SESSION['last_activity'] = time();
    

} else {
    header("Location: loginAdmin.php");
    exit;
}
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://cvsu.edu.ph/wp-content/uploads/2018/01/CvSU-logo-trans.png" sizes="192x192">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>CVSU Admin Dashboard</title>
   
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
                    <button id="darkModeToggle" class="btn btn-primary">Toggle Dark Mode</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Training console within a modal -->
    <div class="modal fade" id="trainingConsoleModal" tabindex="-1" aria-labelledby="trainingConsoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="trainingConsoleModalLabel">Training Console</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column align-items-center">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <!-- The train chatbot button -->
                        <button id="trainButton" class="btn btn-success btn-md" type="submit" name="train_chatbot" style="color: rgb(174, 173, 170); background-color: rgb(24, 101, 41); border-color: rgb(28, 117, 48);">
                            Train Chatbot
                        </button>
                    </form>
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
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript to update the console in real-time -->
    <script>
        // Function to update the training console with new text
        function updateTrainingConsole(text) {
            const trainingConsole = document.getElementById("training-console");
            trainingConsole.innerHTML += text;
        }

        document.getElementById('trainButton').addEventListener('click', function () {
            // Clear the existing console output
            document.getElementById("training-console").innerHTML = "";

            // Function to fetch updates and update the console
            function fetchUpdates() {
                fetch('http://127.0.0.1:5000/train', {
                    method: 'POST'
                })
                    .then(function (response) {
                        if (response.ok) {
                            return response.text(); // Convert the response to text
                        } else {
                            console.error('Error starting training:', response.statusText);
                        }
                    })
                    .then(function (data) {
                        // Update the console with new data
                        updateTrainingConsole(data);

                        // Continue fetching updates every 1 second (adjust as needed)
                        setTimeout(fetchUpdates, 1000);
                    });
            }

            // Start fetching updates
            fetchUpdates();
        });

         // Dark mode toggle functionality
         const darkModeToggle = document.getElementById('darkModeToggle');
        const body = document.body;

        darkModeToggle.addEventListener('click', function () {
            body.classList.toggle('dark-mode');
            const isDarkMode = body.classList.contains('dark-mode');
            // Store user's preference in localStorage
            localStorage.setItem('darkMode', isDarkMode);
        });

        // Check the user's dark mode preference from localStorage
        const isDarkMode = localStorage.getItem('darkMode') === 'true';
        if (isDarkMode) {
            body.classList.add('dark-mode');
            
        }
    </script>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-transparent text-dark" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
                <img src="static/images/CvSU-logo-trans.png" alt="image" width="50" height="40"> CVSU
            </div>
            <div class="list-group list-group-flush my-3">
                <a href="dashboardAdmin.php" class="list-group-item list-group-item-action bg-transparent second-text second-text active">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
                <a href="trainAdmin.php" class="list-group-item list-group-item-action bg-transparent second-text active">
                    <i class="fas fa-project-diagram me-2"></i> Add Response
                </a>
                <button class="list-group-item list-group-item-action bg-transparent second-text active"
                    data-bs-toggle="modal" data-bs-target="#trainingConsoleModal">
                    <i class="fas fa-brain me-2"></i> Train
                </button>
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text active">
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
                                <li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#userSettingsModal">Settings</a></li>
                                <li><a class="dropdown-item" href="logout.php" onclick="return confirm('Are you sure you want to logout?');">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- Page Content (below the navigation bar) -->
            
            <div class="row my-5">
    <h3 class="fs-4 mb-3 col-md-8" style= " padding-left: 30px;">Automatic Response System Dataset</h3>

    <!-- Smaller Search Bar with Search Icon (aligned to the right) -->
    <div class="col-sm-4 d-inline-flex justify-content-end" style= " padding-right: 30px">
        <div class="input-group">
            <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search...">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
    </div>
</div>

                <div class="col">
                    <table class="table bg-white rounded shadow-sm table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col">Tags</th>
                                <th scope="col">Patterns</th>
                                <th scope="col">Responses</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $json_data = file_get_contents("intents.json");
                            $intents = json_decode($json_data, true);
                            if (isset($intents['intents']) && is_array($intents['intents'])) {
                                $rowNumber = 1; // Initialize a counter variable
                                foreach ($intents['intents'] as $intent) {
                                    echo '<tr>';
                                    echo '<th scope="row">' . $rowNumber . '</th>';
                                    echo '<td>' . $intent['tag'] . '</td>';
                                    echo '<td>' . implode(", ", $intent['patterns']) . '</td>';
                                    echo '<td>' . implode(", ", $intent['responses']) . '</td>';
                                    echo '</tr>';
                                    $rowNumber++; // Increment the counter variable
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");
        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };

        const searchInput = document.getElementById("searchInput");
    searchInput.addEventListener("input", function () {
        const searchText = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll("table tbody tr");

        rows.forEach(function (row) {
            const columns = row.getElementsByTagName("td");
            let found = false;

            // Loop through columns and check if any contains the search text
            for (let i = 0; i < columns.length; i++) {
                if (columns[i].textContent.toLowerCase().includes(searchText)) {
                    found = true;
                    break;
                }
            }

            // Show or hide the row based on search results
            if (found) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
    </script>
</body>
</html>
