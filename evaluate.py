import json

def evaluate_chatbot(test_data, intents):
    correct_responses = 0
    total_responses = len(test_data)

    for input_message, expected_responses in test_data:
        # Get the chatbot's response for the input message
        chatbot_response = get_chatbot_response(input_message, intents)

        # Check if the chatbot's response is in the list of expected responses
        if chatbot_response in expected_responses:
            correct_responses += 1

    accuracy = (correct_responses / total_responses) * 100
    return accuracy

def get_chatbot_response(input_message, intents):
    # Replace this with your chatbot's response generation logic
    # This function should take an input message and return the chatbot's response
    for intent_data in intents["intents"]:
        if any(pattern.lower() in input_message.lower() for pattern in intent_data["patterns"]):
            return intent_data["responses"][0]  # For simplicity, returning the first response

# Load intents from the 'intents.json' file
with open('intents.json', 'r') as json_data:
    intents = json.load(json_data)

# Example test data (input messages and expected responses)
test_data = [
    ("Hi", ["Hello!", "Hi there!", "Hey! How can I assist you?"]),
    ("What's your name?", ["I do not understand."]),  # Example of a case where chatbot response is not in expected responses
    # Add more test cases here
]

# Calculate accuracy
accuracy = evaluate_chatbot(test_data, intents)

print(f"Chatbot Accuracy: {accuracy:.2f}%")
