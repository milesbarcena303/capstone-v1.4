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

        #page-content-wrapper form label,
        #page-content-wrapper form input {
            display: block;
            margin-bottom: 10px;
            width: calc(100% - 20px);
        }

        #page-content-wrapper form input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        #page-content-wrapper form input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            padding: 10px 20px;
        }

        #page-content-wrapper form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #trainButton {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            padding: 10px 20px;
            margin-left: 10px;
        }

        #trainButton:hover {
            background-color: #0056b3;
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

        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Admin Dashboard</h2>
                </div>
               
            </nav>

            <form action="process_add_intent.php" method="POST">
                <label for="tag">Tag:</label>
                <input type="text" id="tag" name="tag" required><br>

                <label for="patterns">Patterns (comma-separated):</label>
                <input type="text" id="patterns" name="patterns" required><br>

                <label for="responses">Responses (comma-separated):</label>
                <input type="text" id="responses" name="responses" required><br>

                <input class="btn btn-success btn-md" type="submit"     style="color: rgb(174, 173, 170); background-color: rgb(24, 101, 41); border-color: rgb(28, 117, 48);" type="submit" value="Add Intent">
                
            </form>
            <div class="d-flex align-items-center">
                    
                   
                </div>
        </div>
        
    </div>

    <!-- train button function (takes time) -->
    <script>
        document.getElementById('trainButton').addEventListener('click', function() {
            fetch('http://127.0.0.1:5000/train', {
                method: 'POST'
            })
            .then(response => {
                console.log('Response:', response); // Log the response
                if (response.ok) {
                    alert('Training started successfully.');
                } else {
                    alert('Error starting training.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Check the console for details.');
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
