from flask import Flask, render_template, request, jsonify
from flask_cors import CORS
from chat import get_response  # Import your chatbot logic
import subprocess

app = Flask(__name__)
CORS(app, resources={r"/train": {"origins": "*"}})  # Allow requests to /train from any origin

# Initialize a global conversation context list
conversation_context = []

@app.route("/")
def index_get():
    return render_template("base.php")

@app.route("/predict", methods=["POST"])
def predict():
    data = request.get_json()
    if "message" in data:
        text = data["message"]

        # Greet the user
        if not conversation_context:
            conversation_context.append(f"{text} (Greeting)")
            response = get_response(text, conversation_context)
            conversation_context.append(response)
            message = {"answer": response}
        else:
            response = get_response(text, conversation_context)
            conversation_context.extend([text, response])  # Add user input and bot response to context
            message = {"answer": response}

        return jsonify(message)
    else:
        return jsonify({"error": "Invalid request data."}), 400

@app.route("/train", methods=["POST"])
def train_chatbot():
    try:
        # Execute the training script asynchronously
        subprocess.Popen(['python', 'train.py'])
        return 'Training started', 200
    except Exception as e:
        return f"Error starting training: {str(e)}", 500

if __name__ == "__main__":
    app.run(debug=True)
