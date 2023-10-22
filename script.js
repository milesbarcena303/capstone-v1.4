document.addEventListener("DOMContentLoaded", function() {
    var responseList = document.getElementById("responseList");
    var addResponseBtn = document.getElementById("addResponseBtn");

    function fetchResponses() {
        fetch("/responses")
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                responseList.innerHTML = "";
                data.intents.forEach(function(intent) {
                    var li = document.createElement("li");
                    var patterns = intent.patterns.join(", ");
                    var responses = intent.responses.join(", ");
                    li.innerHTML = `
                        <strong>Tag:</strong> ${intent.tag}<br>
                        <strong>Patterns:</strong> ${patterns}<br>
                        <strong>Responses:</strong> ${responses}
                    `;
                    responseList.appendChild(li);
                });
            });
    }

    fetchResponses();

    addResponseBtn.addEventListener("click", function() {
        var tag = document.getElementById("tag").value;
        var patterns = document.getElementById("patterns").value.split(",");
        var responses = document.getElementById("responses").value.split(",");
        var newResponse = { tag: tag, patterns: patterns, responses: responses };

        fetch("/responses", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(newResponse),
        })
        .then(function() {
            fetchResponses();
            document.getElementById("tag").value = "";
            document.getElementById("patterns").value = "";
            document.getElementById("responses").value = "";
        })
        .catch(function(error) {
            console.error(error);
        });
    });
});
