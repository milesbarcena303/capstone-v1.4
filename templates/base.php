<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="https://cvsu.edu.ph/wp-content/uploads/2018/01/CvSU-logo-trans.png" sizes="192x192">

    <link rel="stylesheet" href="{{ url_for('static', filename='style.css') }}">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="starter-template.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../assets/js/vendor/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <title>CvSU Online Student Admission System</title>
</head>

<body>

    <div class="container">
        <div class="chatbox">
            <div class="chatbox__support">
                <div class="chatbox__header">
                    <div class="chatbox__image--header">
                        <img src="static/images/CvSU-logo-trans.png" alt="image" width="50" height="40">
                    </div>
                    <div class="chatbox__content--header">
                        <h4 class="chatbox__heading--header">Chat support</h4>
                        <p class="chatbox__description--header">CVSU ADMISSION RESPONSE SYSTEM</p>
                    </div>
                </div>
                <div class="chatbox__messages">
                    <div></div>
                </div>
                <div class="chatbox__footer">
                    <input type="text" placeholder="Write a message...">
                    <button class="chatbox__send--footer send__button">Send</button>
                </div>
            </div>
            <div class="chatbox__button">
                <button><img src="{{ url_for('static', filename='images/CvSU-logo-trans.png') }}" width="50"
                        height="40" /></button>
            </div>
        </div>
    </div>

    <script>
        $SCRIPT_ROOT = {{ request.script_root|tojson }};
    </script>
    <script type="text/javascript" src="{{ url_for('static', filename='app.js') }}"></script>

</body>

</html>
