import json
import random
import torch
from better_profanity import profanity
from model import NeuralNet
from nltk_utils import bag_of_words, tokenize

device = torch.device('cuda' if torch.cuda.is_available() else 'cpu')

# Load intents and model data
with open('intents.json', 'r') as json_data:
    intents = json.load(json_data)

FILE = "data.pth"
data = torch.load(FILE)

input_size = data["input_size"]
hidden_size = data["hidden_size"]
output_size = data["output_size"]
all_words = data['all_words']
tags = data['tags']
model_state = data["model_state"]

model = NeuralNet(input_size, hidden_size, output_size).to(device)
model.load_state_dict(model_state)
model.eval()

bot_name = "CVSU Admission System"

# Initialize the profanity filter
profanity.load_censor_words_from_file('profanity_wordlist.txt')

def is_profane(msg):
    return profanity.contains_profanity(msg)

def censor_message(msg):
    censored_msg = profanity.censor(msg)
    return censored_msg

def get_response(msg, conversation_context):
    if is_profane(msg):
        censored_msg = censor_message(msg)
        return "I'm sorry, but I can't engage in discussions or respond to offensive language. If you have any other questions or need assistance with something else, please feel free to ask, and I'll be happy to help."

    sentence = tokenize(msg)
    X = bag_of_words(sentence, all_words)
    X = X.reshape(1, X.shape[0])
    X = torch.from_numpy(X).to(device)

    output = model(X)
    _, predicted = torch.max(output, dim=1)

    confidence_threshold = 0.75

    if output[0][predicted.item()] >= confidence_threshold:
        tag = tags[predicted.item()]
        for intent in intents['intents']:
            if tag == intent["tag"]:
                response = random.choice(intent['responses'])
                if is_profane(response):
                    response = censor_message(response)
                return response

    return "I do not understand... please specify your message"

if __name__ == "__main__":
    print(f"Welcome to {bot_name}! Type 'quit' to exit.")
    conversation_context = []

    # Greet the user
    print(f"{bot_name}: Hello! How can I assist you today?")

    while True:
        sentence = input("You: ")
        conversation_context.append(sentence)
        if sentence.lower() == "quit":
            break

        response = get_response(sentence, conversation_context)
        conversation_context.append(response)
        print(f"{bot_name}: {response}")
