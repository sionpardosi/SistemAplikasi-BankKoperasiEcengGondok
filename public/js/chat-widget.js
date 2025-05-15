document.addEventListener('DOMContentLoaded', function() {
    // Widget elements
    const chatWidgetButton = document.getElementById('chat-widget-button');
    const chatWidgetContainer = document.getElementById('chat-widget-container');
    const closeWidgetButton = document.getElementById('close-chat-widget');
    const chatWidgetForm = document.getElementById('chat-widget-form');
    const widgetMessageInput = document.getElementById('widget-message-input');
    const chatWidgetMessages = document.getElementById('chat-widget-messages');
    const widgetThreadId = document.getElementById('widget-thread-id');

    // Exit if any required element is missing
    if (!chatWidgetButton || !chatWidgetContainer || !closeWidgetButton ||
        !chatWidgetForm || !widgetMessageInput || !chatWidgetMessages || !widgetThreadId) {
        console.error('Some chat widget elements are missing');
        return;
    }

    // Event listeners
    chatWidgetButton.addEventListener('click', toggleWidget);
    closeWidgetButton.addEventListener('click', toggleWidget);
    chatWidgetForm.addEventListener('submit', sendWidgetMessage);

    function toggleWidget() {
        chatWidgetContainer.classList.toggle('d-none');

        // If opening the widget and no active thread, auto-create one
        if (!chatWidgetContainer.classList.contains('d-none') && !widgetThreadId.value) {
            // Create a thread if the user opens the widget for the first time
            createNewThread();
        }
    }

    function sendWidgetMessage(e) {
        e.preventDefault();

        const message = widgetMessageInput.value.trim();
        if (!message) return;

        // Add user message to chat
        addWidgetMessage('user', message);

        // Clear input
        widgetMessageInput.value = '';

        // Add loading indicator
        const loadingEl = document.createElement('div');
        loadingEl.className = 'message assistant';
        loadingEl.innerHTML = '<div class="message-content"><em>Mengetik...</em></div>';
        chatWidgetMessages.appendChild(loadingEl);

        // Scroll to bottom
        scrollWidgetToBottom();

        // Check CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        if (!csrfToken) {
            console.error('CSRF token not found');
            chatWidgetMessages.removeChild(loadingEl);
            addWidgetMessage('assistant', 'Maaf, terjadi kesalahan. CSRF token tidak ditemukan.');
            return;
        }

        // Send to server
        if (widgetThreadId.value) {
            // Continue existing thread
            fetch(`/chatbot/thread/${widgetThreadId.value}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ message })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Remove loading indicator
                chatWidgetMessages.removeChild(loadingEl);

                // Check for error in response
                if (data.error) {
                    throw new Error(data.error);
                }

                // Add assistant response
                if (data.thread_messages && data.thread_messages.length > 0) {
                    // Find the latest assistant message
                    const assistantMessages = data.thread_messages.filter(msg => msg.role === 'assistant');
                    if (assistantMessages.length > 0) {
                        const lastMessage = assistantMessages[assistantMessages.length - 1];
                        addWidgetMessage('assistant', lastMessage.content);
                    } else {
                        console.warn('No assistant message found in response');
                        addWidgetMessage('assistant', 'Maaf, saya tidak dapat memberikan respons saat ini.');
                    }
                } else {
                    console.error('Unexpected response format:', data);
                    addWidgetMessage('assistant', 'Maaf, terjadi kesalahan format respons.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Remove loading indicator if it still exists
                if (chatWidgetMessages.contains(loadingEl)) {
                    chatWidgetMessages.removeChild(loadingEl);
                }
                addWidgetMessage('assistant', 'Maaf, terjadi kesalahan. Silakan coba lagi.');
            });
        } else {
            // Create new thread
            fetch('/chatbot/thread', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ message })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Remove loading indicator
                chatWidgetMessages.removeChild(loadingEl);

                // Check for error in response
                if (data.error) {
                    throw new Error(data.error);
                }

                // Set current thread
                widgetThreadId.value = data.id;

                // Add assistant response
                if (data.thread_messages && data.thread_messages.length > 0) {
                    // Find the latest assistant message
                    const assistantMessages = data.thread_messages.filter(msg => msg.role === 'assistant');
                    if (assistantMessages.length > 0) {
                        const lastMessage = assistantMessages[assistantMessages.length - 1];
                        addWidgetMessage('assistant', lastMessage.content);
                    } else {
                        console.warn('No assistant message found in response');
                        addWidgetMessage('assistant', 'Maaf, saya tidak dapat memberikan respons saat ini.');
                    }
                } else {
                    console.error('Unexpected response format:', data);
                    addWidgetMessage('assistant', 'Maaf, terjadi kesalahan format respons.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Remove loading indicator if it still exists
                if (chatWidgetMessages.contains(loadingEl)) {
                    chatWidgetMessages.removeChild(loadingEl);
                }
                addWidgetMessage('assistant', 'Maaf, terjadi kesalahan. Silakan coba lagi.');
            });
        }
    }

    function createNewThread() {
        // Default first message about eceng gondok products
        const firstMessage = "Selamat datang! Saya asisten AI untuk produk eceng gondok. Apa yang ingin Anda ketahui tentang produk kerajinan eceng gondok kami?";

        // Check CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        if (!csrfToken) {
            console.error('CSRF token not found');
            addWidgetMessage('assistant', 'Maaf, terjadi kesalahan. CSRF token tidak ditemukan.');
            return;
        }

        // Add loading indicator
        const loadingEl = document.createElement('div');
        loadingEl.className = 'message assistant';
        loadingEl.innerHTML = '<div class="message-content"><em>Memulai percakapan...</em></div>';

        // Clear default welcome message and add loading
        chatWidgetMessages.innerHTML = '';
        chatWidgetMessages.appendChild(loadingEl);

        fetch('/chatbot/thread', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ message: firstMessage })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Remove loading indicator
            chatWidgetMessages.removeChild(loadingEl);

            // Check for error in response
            if (data.error) {
                throw new Error(data.error);
            }

            // Set current thread
            widgetThreadId.value = data.id;

            // Add messages from the thread
            if (data.thread_messages && data.thread_messages.length > 0) {
                // Add only the assistant messages for a cleaner interface
                const assistantMessages = data.thread_messages.filter(msg => msg.role === 'assistant');
                if (assistantMessages.length > 0) {
                    assistantMessages.forEach(message => {
                        addWidgetMessage('assistant', message.content);
                    });
                } else {
                    // Default welcome message if no assistant messages found
                    addWidgetMessage('assistant', 'Selamat datang! Saya asisten AI untuk produk eceng gondok. Apa yang ingin Anda ketahui tentang produk kerajinan eceng gondok kami?');
                }
            } else {
                // Default welcome message if no messages found
                addWidgetMessage('assistant', 'Selamat datang! Saya asisten AI untuk produk eceng gondok. Apa yang ingin Anda ketahui tentang produk kerajinan eceng gondok kami?');
            }
        })
        .catch(error => {
            console.error('Error creating thread:', error);
            chatWidgetMessages.innerHTML = '';
            addWidgetMessage('assistant', 'Selamat datang! Saya asisten AI untuk produk eceng gondok. Apa yang ingin Anda ketahui tentang produk kerajinan eceng gondok kami?');
        });
    }

    function addWidgetMessage(role, content) {
        const messageEl = document.createElement('div');
        messageEl.className = `message ${role}`;
        messageEl.innerHTML = `<div class="message-content">${content}</div>`;
        chatWidgetMessages.appendChild(messageEl);

        // Scroll to bottom
        scrollWidgetToBottom();
    }

    function scrollWidgetToBottom() {
        chatWidgetMessages.scrollTop = chatWidgetMessages.scrollHeight;
    }
});
