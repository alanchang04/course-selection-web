function appendMessage(message, sender) {
    const chatContainer = document.getElementById('chat-container');
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message', sender);

    const contentDiv = document.createElement('div');
    contentDiv.classList.add('content');

    contentDiv.innerHTML = message.replace(/\n/g, '<br>');

    const timestampDiv = document.createElement('div');
    const now = new Date();
    timestampDiv.classList.add('timestamp');
    timestampDiv.textContent = now.toLocaleTimeString();

    contentDiv.appendChild(timestampDiv);
    messageDiv.appendChild(contentDiv);
    chatContainer.appendChild(messageDiv);

    chatContainer.scrollTop = chatContainer.scrollHeight;
}

function sendMessage() {
    const input = document.getElementById('userInput');
    const message = input.value;
    if (message.trim() !== '') {
        appendMessage(message, 'user');
        input.value = '';

        fetch('chatbox_api.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ message })
        })
        .then(response => response.json())
        .then(data => appendMessage(data.reply, 'bot'))
        .catch(error => console.error('Error:', error));
    }
}
