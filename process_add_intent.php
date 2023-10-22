<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // get form data
    $tag = $_POST["tag"];
    $patterns = explode(", ", $_POST["patterns"]);
    $responses = explode(", ", $_POST["responses"]);

    // loading data
    $json_data = file_get_contents("intents.json");
    $intents = json_decode($json_data, true);

    // adding the intent
    $new_intent = array(
        "tag" => $tag,
        "patterns" => $patterns,
        "responses" => $responses
    );
    $intents['intents'][] = $new_intent;

    file_put_contents("intents.json", json_encode($intents, JSON_PRETTY_PRINT));

    //alert
    echo '<script>alert("Intent added successfully, click the train button to refresh the data.");</script>';
    echo '<script>window.location.href = "trainbtn.php";</script>';
    exit();
}
?>
