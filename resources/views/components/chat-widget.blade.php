<!-- Bank Eceng Gondok Chatbot Widget -->
<div id="eceng-chatbot-container" class="chat-widget-container">
    <!-- Chat Widget Button - Floating and Draggable -->
    <div id="chatbotButton" class="chat-button">
        <div class="button-label">Chat dengan AI</div>
        <div class="button-circle">
            <div class="button-icon">
                <i class="fas fa-robot"></i>
            </div>
        </div>
    </div>

    <!-- Chat Widget Box -->
    <div id="chatbotBox" class="chat-box">
        <!-- Chat Header -->
        <div class="chat-header">
            <div class="header-avatar">
                <div class="avatar-circle">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="header-info">
                    <span class="header-title">Asisten AI Bank Eceng Gondok</span>
                    <span class="header-status">
                        <span class="status-dot"></span>
                        Online
                    </span>
                </div>
            </div>
            <div class="header-controls">
                <button id="chatMinimize" aria-label="Minimize">
                    <i class="fas fa-minus"></i>
                </button>
                <button id="chatClose" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Chat Quick Options -->
        <div id="quickOptions" class="quick-options">
            <div class="options-header">
                <i class="fas fa-lightbulb"></i> Apa yang ingin Anda ketahui?
            </div>
            <div class="options-grid">
                <button class="quick-option" data-query="Bagaimana cara menjadi pemasok eceng gondok?">
                    <i class="fas fa-leaf"></i>
                    <span>Jadi Pemasok</span>
                </button>
                <button class="quick-option" data-query="Berapa harga per kg eceng gondok?">
                    <i class="fas fa-coins"></i>
                    <span>Harga Eceng</span>
                </button>
                <button class="quick-option" data-query="Apa produk kerajinan yang dibuat?">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Produk Kerajinan</span>
                </button>
                <button class="quick-option" data-query="Kapan jadwal penjemputan eceng gondok?">
                    <i class="fas fa-truck"></i>
                    <span>Jadwal Jemput</span>
                </button>
            </div>
        </div>

        <!-- Chat Content -->
        <div id="content" class="chat-content">
            <div class="welcome-message">
                <div class="welcome-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="welcome-text">
                    <h4>Selamat Datang di Bank Koperasi Eceng Gondok!</h4>
                    <p>Saya asisten AI yang siap membantu Anda dengan informasi seputar program pemasok eceng gondok dan produk kerajinan kami. Bergabunglah dengan kami dalam melestarikan Danau Toba! 👋</p>
                </div>
            </div>
            <div class="message bot-message">
                <i class="fas fa-robot"></i>
                <div class="message-bubble">Silakan pilih topik di atas atau ketik pertanyaan Anda langsung.</div>
            </div>
            <!-- Messages will be added here dynamically -->
        </div>

        <!-- Chat Footer/Form -->
        <div class="chat-footer">
            <div class="input-container">
                <input type="text" id="chatInput" placeholder="Ketik pesan Anda di sini..." autocomplete="off">
                <button class="attachment-button" aria-label="Attachment">
                    <i class="fas fa-paperclip"></i>
                </button>
            </div>
            <button id="sendButton" class="send-button" aria-label="Send">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>

        <!-- Powered By Section -->
        <div class="powered-by">
            <span>Didukung oleh</span>
            <strong>AI Assistant for Eceng Gondok @2025</strong>
        </div>
    </div>
</div>

<style>
    /* Base Reset */
    #eceng-chatbot-container * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    /* Container for the entire chatbot */
    .chat-widget-container {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        user-select: none;
    }

    /* Draggable Chat Button */
    .chat-button {
        position: absolute;
        bottom: 0;
        right: 0;
        cursor: grab;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .chat-button:active {
        cursor: grabbing;
    }

    /* Button Label */
    .button-label {
        background: linear-gradient(135deg, #956a3b, #7a552f);
        color: #ffffff;
        padding: 8px 16px;
        border-radius: 20px;
        margin-right: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        font-weight: 500;
        font-size: 14px;
        opacity: 0;
        transform: translateX(10px);
        transition: all 0.3s ease;
        pointer-events: none;
    }

    /* Button Circle */
    .button-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #956a3b, #7a552f);
        color: #ffffff;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        z-index: 1;
    }

    .button-circle::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        z-index: -1;
        animation: pulse 2s infinite;
    }

    .button-icon {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .button-icon i {
        font-size: 22px;
        color: #ffffff;
    }

    /* Chat Box */
    .chat-box {
        position: absolute;
        bottom: 80px;
        right: 0;
        width: 350px;
        height: 500px;
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        display: flex;
        flex-direction: column;
        opacity: 0;
        transform: translateY(20px) scale(0.95);
        pointer-events: none;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }

    /* Chat Header */
    .chat-header {
        background: linear-gradient(135deg, #956a3b, #7a552f);
        color: #ffffff;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-avatar {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .avatar-circle {
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .avatar-circle i {
        font-size: 18px;
    }

    .header-info {
        display: flex;
        flex-direction: column;
    }

    .header-title {
        font-weight: 600;
        font-size: 15px;
    }

    .header-status {
        font-size: 12px;
        opacity: 0.8;
        display: flex;
        align-items: center;
    }

    .status-dot {
        content: '';
        display: inline-block;
        width: 8px;
        height: 8px;
        background: #00D9C5;
        border-radius: 50%;
        margin-right: 5px;
        animation: blink 2s infinite;
    }

    .header-controls {
        display: flex;
        gap: 8px;
    }

    .header-controls button {
        background: transparent;
        border: none;
        color: #ffffff;
        cursor: pointer;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    /* Quick Options */
    .quick-options {
        padding: 15px;
        background-color: #f0f2f5;
        border-bottom: 1px solid #e9ecef;
    }

    .options-header {
        font-size: 14px;
        color: #343a40;
        margin-bottom: 12px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .options-header i {
        color: #956a3b;
    }

    .options-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .quick-option {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 12px;
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
        cursor: pointer;
        text-align: center;
    }

    .quick-option i {
        font-size: 18px;
        margin-bottom: 6px;
        color: #956a3b;
    }

    .quick-option span {
        font-size: 12px;
        font-weight: 500;
        color: #343a40;
    }

    /* Chat Content */
    .chat-content {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 15px;
        background-color: #f8f9fa;
    }

    .welcome-message {
        display: flex;
        background: #f8f9fa;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 10px;
        animation: fadeIn 0.5s ease-out;
    }

    .welcome-avatar {
        width: 45px;
        height: 45px;
        min-width: 45px;
        background: rgba(149, 106, 59, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }

    .welcome-avatar i {
        font-size: 22px;
        color: #956a3b;
    }

    .welcome-text h4 {
        margin: 0 0 8px 0;
        color: #343a40;
        font-size: 15px;
    }

    .welcome-text p {
        margin: 0;
        color: #6c757d;
        font-size: 13px;
        line-height: 1.5;
    }

    .message {
        display: flex;
        align-items: flex-start;
        max-width: 85%;
        animation: messageIn 0.3s ease-out forwards;
    }

    .bot-message {
        align-self: flex-start;
    }

    .user-message {
        align-self: flex-end;
        flex-direction: row-reverse;
    }

    .message i {
        width: 30px;
        height: 30px;
        background: rgba(149, 106, 59, 0.1);
        color: #956a3b;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 8px;
        font-size: 14px;
    }

    .user-message i {
        margin-right: 0;
        margin-left: 8px;
        background: #956a3b;
        color: #ffffff;
    }

    .message-bubble {
        padding: 10px 14px;
        border-radius: 18px;
        font-size: 14px;
        line-height: 1.5;
        word-wrap: break-word;
        background: #ffffff;
        color: #343a40;
        border-top-left-radius: 4px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .user-message .message-bubble {
        background: #956a3b;
        color: #ffffff;
        border-top-left-radius: 18px;
        border-top-right-radius: 4px;
    }

    /* Chat Footer */
    .chat-footer {
        display: flex;
        padding: 12px 15px;
        background: #ffffff;
        border-top: 1px solid #e9ecef;
        gap: 10px;
    }

    .input-container {
        flex: 1;
        position: relative;
        display: flex;
        background: #f8f9fa;
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }

    .input-container:focus-within {
        border-color: rgba(149, 106, 59, 0.5);
        box-shadow: 0 0 0 2px rgba(149, 106, 59, 0.1);
    }

    #chatInput {
        flex: 1;
        border: none;
        background: transparent;
        padding: 10px 15px;
        outline: none;
        font-size: 14px;
    }

    .attachment-button {
        background: transparent;
        border: none;
        color: #6c757d;
        cursor: pointer;
        padding: 5px 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .send-button {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #956a3b, #7a552f);
        color: #ffffff;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
    }

    /* Powered By */
    .powered-by {
        padding: 8px;
        text-align: center;
        font-size: 11px;
        color: #6c757d;
        background: #ffffff;
        border-top: 1px solid #e9ecef;
    }

    /* Animations */
    @keyframes pulse {
        0% {
            transform: scale(0.95);
            opacity: 0.7;
        }
        50% {
            transform: scale(1.1);
            opacity: 0.3;
        }
        100% {
            transform: scale(0.95);
            opacity: 0.7;
        }
    }

    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes messageIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Hover Effects */
    .header-controls button:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .quick-option:hover {
        background: #f8f9fa;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .chat-button:hover .button-label {
        opacity: 1;
        transform: translateX(0);
    }

    .chat-button:hover .button-circle {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(149, 106, 59, 0.3);
    }

    .send-button:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(149, 106, 59, 0.3);
    }

    .attachment-button:hover {
        color: #956a3b;
    }

    /* Responsive Adjustments */
    @media (max-width: 576px) {
        .chat-box {
            width: 300px;
            height: 450px;
            bottom: 70px;
        }

        .button-circle {
            width: 50px;
            height: 50px;
        }

        .button-icon {
            width: 35px;
            height: 35px;
        }

        .button-icon i {
            font-size: 18px;
        }

        .chat-widget-container {
            bottom: 20px;
            right: 20px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // API Key Configuration
        const API_KEY = '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';

        // DOM Elements
        const chatbotButton = document.getElementById('chatbotButton');
        const chatbotBox = document.getElementById('chatbotBox');
        const chatMinimize = document.getElementById('chatMinimize');
        const chatClose = document.getElementById('chatClose');
        const content = document.getElementById('content');
        const chatInput = document.getElementById('chatInput');
        const sendButton = document.getElementById('sendButton');
        const quickOptions = document.querySelectorAll('.quick-option');
        const chatbotContainer = document.getElementById('eceng-chatbot-container');

        // State Variables
        let isAnswerLoading = false;
        let answerSectionId = 0;
        let chatHistory = [];
        let isChatOpen = false;

        // Draggable functionality
        let isDragging = false;
        let offsetX, offsetY;
        let currentX = 0, currentY = 0;

        // Draggable Implementation
        function initDraggable() {
            // Mouse events
            chatbotButton.addEventListener('mousedown', startDrag);
            document.addEventListener('mousemove', drag);
            document.addEventListener('mouseup', endDrag);

            // Touch events for mobile
            chatbotButton.addEventListener('touchstart', startDragTouch);
            document.addEventListener('touchmove', dragTouch);
            document.addEventListener('touchend', endDrag);
        }

        function startDrag(e) {
            e.preventDefault();
            isDragging = true;

            // Get the current position of the chat button
            const rect = chatbotContainer.getBoundingClientRect();

            // Calculate the offset from the mouse position to the container position
            offsetX = e.clientX - rect.left;
            offsetY = e.clientY - rect.top;

            // Change cursor to grabbing
            chatbotButton.style.cursor = 'grabbing';
        }

        function startDragTouch(e) {
            // For touch devices
            if (e.touches.length === 1) {
                isDragging = true;

                const touch = e.touches[0];
                const rect = chatbotContainer.getBoundingClientRect();

                offsetX = touch.clientX - rect.left;
                offsetY = touch.clientY - rect.top;
            }
        }

        function drag(e) {
            if (!isDragging) return;

            // Calculate new position
            currentX = e.clientX - offsetX;
            currentY = e.clientY - offsetY;

            // Apply constraints to keep the chat on screen
            const maxX = window.innerWidth - chatbotContainer.offsetWidth;
            const maxY = window.innerHeight - chatbotContainer.offsetHeight;

            currentX = Math.min(Math.max(0, currentX), maxX);
            currentY = Math.min(Math.max(0, currentY), maxY);

            // Set the new position
            chatbotContainer.style.left = currentX + 'px';
            chatbotContainer.style.top = currentY + 'px';
            chatbotContainer.style.bottom = 'auto';
            chatbotContainer.style.right = 'auto';
        }

        function dragTouch(e) {
            if (!isDragging || e.touches.length !== 1) return;

            const touch = e.touches[0];

            // Calculate new position
            currentX = touch.clientX - offsetX;
            currentY = touch.clientY - offsetY;

            // Apply constraints
            const maxX = window.innerWidth - chatbotContainer.offsetWidth;
            const maxY = window.innerHeight - chatbotContainer.offsetHeight;

            currentX = Math.min(Math.max(0, currentX), maxX);
            currentY = Math.min(Math.max(0, currentY), maxY);

            // Set the new position
            chatbotContainer.style.left = currentX + 'px';
            chatbotContainer.style.top = currentY + 'px';
            chatbotContainer.style.bottom = 'auto';
            chatbotContainer.style.right = 'auto';

            // Prevent scrolling when dragging
            e.preventDefault();
        }

        function endDrag() {
            isDragging = false;
            chatbotButton.style.cursor = 'grab';
        }

        // Initialize chat state
        function initializeChatState() {
            isChatOpen = false;
            chatbotBox.style.opacity = '0';
            chatbotBox.style.transform = 'translateY(20px) scale(0.95)';
            chatbotBox.style.pointerEvents = 'none';
        }

        // Toggle Chatbox Visibility
        function toggleChatbox(e) {
            // Prevent handling this event if we were dragging
            if (isDragging) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }

            if (isChatOpen) {
                closeChatbox();
            } else {
                openChatbox();
            }
        }

        // Open chatbox
        function openChatbox() {
            isChatOpen = true;
            chatbotBox.style.opacity = '1';
            chatbotBox.style.transform = 'translateY(0) scale(1)';
            chatbotBox.style.pointerEvents = 'all';

            // Focus on input when opened
            setTimeout(() => chatInput.focus(), 300);
        }

        // Close chatbox
        function closeChatbox() {
            isChatOpen = false;
            chatbotBox.style.opacity = '0';
            chatbotBox.style.transform = 'translateY(20px) scale(0.95)';
            chatbotBox.style.pointerEvents = 'none';
        }

        // Handle Send Message
        function handleSendMessage() {
            // Get the user input and remove leading/trailing space
            const question = chatInput.value.trim();

            // Prevent sending empty message
            if (question === '' || isAnswerLoading) return;

            // Disable UI send button
            sendButton.style.opacity = '0.5';
            sendButton.style.cursor = 'not-allowed';
            sendButton.style.backgroundColor = '#6c757d';

            // Add question to chat history
            chatHistory.push({
                role: 'user',
                content: question
            });

            // Hide quick options after first message
            document.getElementById('quickOptions').style.display = 'none';

            // Display the question
            addQuestionSection(question);
            chatInput.value = '';
            chatInput.focus();

            // Get answer from API
            getAnswer(question);
        }

        // Add Question to Chat
        function addQuestionSection(message) {
            // Create question element with animation
            const sectionElement = document.createElement('div');
            sectionElement.className = 'message user-message';

            sectionElement.innerHTML = `
                <i class="fas fa-user"></i>
                <div class="message-bubble">${message}</div>
            `;

            content.appendChild(sectionElement);

            // Add temporary answer section
            addAnswerSection();
            scrollToBottom();
        }

        // Add Answer Loading Placeholder
        function addAnswerSection() {
            // Increment answer section ID for tracking
            answerSectionId++;

            // Create loading answer section
            const sectionElement = document.createElement('div');
            sectionElement.className = 'message bot-message';
            sectionElement.id = `answer-${answerSectionId}`;

            sectionElement.innerHTML = `
                <i class="fas fa-robot"></i>
                <div class="message-bubble loading-bubble">
                    <span class="loading-dot"></span>
                    <span class="loading-dot"></span>
                    <span class="loading-dot"></span>
                </div>
            `;

            content.appendChild(sectionElement);

            // Add loading dots animation with CSS
            const style = document.createElement('style');
            style.textContent = `
                .loading-dot {
                    width: 8px;
                    height: 8px;
                    border-radius: 50%;
                    background-color: #956a3b;
                    display: inline-block;
                    margin-right: 3px;
                }

                .loading-dot:nth-child(1) {
                    animation: bounce 1.5s infinite ease-in-out;
                }

                .loading-dot:nth-child(2) {
                    animation: bounce 1.5s infinite ease-in-out 0.2s;
                }

                .loading-dot:nth-child(3) {
                    animation: bounce 1.5s infinite ease-in-out 0.4s;
                }

                @keyframes bounce {
                    0%, 100% { transform: translateY(0); }
                    50% { transform: translateY(-8px); }
                }
            `;
            document.head.appendChild(style);
        }

        // Get Answer from API
        function getAnswer(question) {
            isAnswerLoading = true;

            fetch("https://openrouter.ai/api/v1/chat/completions", {
                    method: "POST",
                    headers: {
                        "Authorization": `Bearer ${API_KEY}`,
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        "model": "deepseek/deepseek-r1-distill-llama-70b:free",
                        "messages": [
                            // System message
                            {
                                "role": "system",
                                "content": "Anda adalah asisten AI Bank Koperasi Eceng Gondok yang ramah, profesional, dan berpengetahuan luas."
                            },
                            // Previous messages for context
                            ...chatHistory.slice(-4), // Include up to 4 previous messages
                            // Current question
                            {
                                "role": "user",
                                "content": question
                            }
                        ]
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Get response message
                    const resultData = data.choices[0].message.content;

                    // Add answer to chat history
                    chatHistory.then(data => {
                    // Get response message
                    const resultData = data.choices[0].message.content;

                    // Add answer to chat history
                    chatHistory.push({
                        role: 'assistant',
                        content: resultData
                    });

                    // Update the answer in chat
                    isAnswerLoading = false;
                    updateAnswerSection(resultData);
                })
                .catch(error => {
                    console.error("Error fetching answer:", error);
                    isAnswerLoading = false;
                    updateAnswerSection("Maaf, terjadi kesalahan saat menghubungi layanan. Silakan coba lagi nanti.");
                })
                .finally(() => {
                    scrollToBottom();
                    sendButton.style.opacity = '1';
                    sendButton.style.cursor = 'pointer';
                    sendButton.style.background = 'linear-gradient(135deg, #956a3b, #7a552f)';
                });
        }

        // Update Answer with Response
        function updateAnswerSection(message) {
            const answerSectionElement = document.getElementById(`answer-${answerSectionId}`);
            if (answerSectionElement) {
                const loadingBubble = answerSectionElement.querySelector('.loading-bubble');
                loadingBubble.innerHTML = message;
                loadingBubble.style.display = 'block';

                // Remove the loading dots animation
                loadingBubble.classList.remove('loading-bubble');
            }
        }

        // Scroll Chat to Bottom
        function scrollToBottom() {
            content.scrollTo({
                top: content.scrollHeight,
                behavior: 'smooth'
            });
        }

        // Handle Quick Option Click
        function handleQuickOption(query) {
            chatInput.value = query;
            handleSendMessage();
        }

        // Setup Event Listeners
        function setupEventListeners() {
            // Button events
            chatbotButton.addEventListener('click', toggleChatbox);
            chatMinimize.addEventListener('click', closeChatbox);
            chatClose.addEventListener('click', closeChatbox);

            // Send message events
            sendButton.addEventListener('click', handleSendMessage);
            chatInput.addEventListener('keypress', event => {
                if (event.key === 'Enter') {
                    handleSendMessage();
                }
            });

            // Quick option events
            quickOptions.forEach(option => {
                option.addEventListener('click', () => {
                    const query = option.getAttribute('data-query');
                    if (query) {
                        handleQuickOption(query);
                    }
                });
            });

            // Hide quick options when user starts typing
            chatInput.addEventListener('input', () => {
                if (chatInput.value.trim().length > 0) {
                    document.getElementById('quickOptions').style.display = 'none';
                }
            });

            // Button hover effects
            chatbotButton.addEventListener('mouseenter', () => {
                const buttonLabel = chatbotButton.querySelector('.button-label');
                if (!isChatOpen && buttonLabel) {
                    buttonLabel.style.opacity = '1';
                    buttonLabel.style.transform = 'translateX(0)';
                }
            });

            chatbotButton.addEventListener('mouseleave', () => {
                const buttonLabel = chatbotButton.querySelector('.button-label');
                if (!isChatOpen && buttonLabel) {
                    buttonLabel.style.opacity = '0';
                    buttonLabel.style.transform = 'translateX(10px)';
                }
            });

            // Make sure the draggable doesn't interfere with button clicks
            chatbotButton.addEventListener('click', (e) => {
                if (!isDragging) {
                    toggleChatbox(e);
                }
            });
        }

        // Reset position when window is resized
        function handleWindowResize() {
            window.addEventListener('resize', () => {
                // If the chatbot is positioned off-screen after resize, reset its position
                const rect = chatbotContainer.getBoundingClientRect();
                const windowWidth = window.innerWidth;
                const windowHeight = window.innerHeight;

                if (rect.right > windowWidth || rect.bottom > windowHeight) {
                    // Reset to default bottom-right position
                    chatbotContainer.style.left = 'auto';
                    chatbotContainer.style.top = 'auto';
                    chatbotContainer.style.right = '30px';
                    chatbotContainer.style.bottom = '30px';
                }
            });
        }

        // Initialize Everything
        function init() {
            // Set initial state
            initializeChatState();

            // Setup draggable functionality
            initDraggable();

            // Setup all event listeners
            setupEventListeners();

            // Handle window resize
            handleWindowResize();

            // Add fade-in animation to chatbot button
            chatbotButton.style.animation = 'fadeIn 0.5s ease-out forwards';
        }

        // Start everything when DOM is loaded
        init();
    });
// Enhanced Draggable Functionality
function enhanceDraggable() {
    const chatbotButton = document.getElementById('chatbotButton');
    const chatbotContainer = document.getElementById('eceng-chatbot-container');

    let isDragging = false;
    let offsetX, offsetY;
    let lastX = 0, lastY = 0;
    let velocityX = 0, velocityY = 0;
    let animationFrame;
    let lastTimestamp = 0;

    // Save and load position from localStorage
    function savePosition() {
        const position = {
            left: chatbotContainer.style.left,
            top: chatbotContainer.style.top,
            right: chatbotContainer.style.right,
            bottom: chatbotContainer.style.bottom
        };
        localStorage.setItem('ecengChatbotPosition', JSON.stringify(position));
    }

    function loadPosition() {
        try {
            const savedPosition = localStorage.getItem('ecengChatbotPosition');
            if (savedPosition) {
                const position = JSON.parse(savedPosition);
                chatbotContainer.style.left = position.left || 'auto';
                chatbotContainer.style.top = position.top || 'auto';
                chatbotContainer.style.right = position.right || '30px';
                chatbotContainer.style.bottom = position.bottom || '30px';
            }
        } catch (e) {
            console.error("Error loading saved position:", e);
            resetPosition();
        }
    }

    function resetPosition() {
        chatbotContainer.style.left = 'auto';
        chatbotContainer.style.top = 'auto';
        chatbotContainer.style.right = '30px';
        chatbotContainer.style.bottom = '30px';
        savePosition();
    }

    // Start dragging
    function startDrag(e) {
        if (e.target.closest('.chat-box')) return; // Don't drag if clicking inside the chat box

        e.preventDefault();
        isDragging = true;

        // Add dragging class for visual feedback
        chatbotButton.classList.add('dragging');

        // Get the current position of the chat button
        const rect = chatbotContainer.getBoundingClientRect();

        // Calculate the offset from the mouse position to the container position
        if (e.type === 'mousedown') {
            offsetX = e.clientX - rect.left;
            offsetY = e.clientY - rect.top;
        } else if (e.type === 'touchstart') {
            const touch = e.touches[0];
            offsetX = touch.clientX - rect.left;
            offsetY = touch.clientY - rect.top;
        }

        // Set initial position and velocity
        lastX = rect.left;
        lastY = rect.top;
        velocityX = 0;
        velocityY = 0;
        lastTimestamp = performance.now();

        // Cancel any ongoing animation
        if (animationFrame) {
            cancelAnimationFrame(animationFrame);
        }
    }

    // During drag
    function drag(e) {
        if (!isDragging) return;

        let clientX, clientY;

        if (e.type === 'mousemove') {
            clientX = e.clientX;
            clientY = e.clientY;
        } else if (e.type === 'touchmove') {
            const touch = e.touches[0];
            clientX = touch.clientX;
            clientY = touch.clientY;
            e.preventDefault(); // Prevent scrolling on touch devices
        }

        // Calculate new position
        const newX = clientX - offsetX;
        const newY = clientY - offsetY;

        // Calculate velocity
        const now = performance.now();
        const dt = now - lastTimestamp;

        if (dt > 0) {
            velocityX = (newX - lastX) / dt * 15; // Scaling factor for momentum
            velocityY = (newY - lastY) / dt * 15;
        }

        lastX = newX;
        lastY = newY;
        lastTimestamp = now;

        // Apply constraints to keep the chat on screen
        const maxX = window.innerWidth - chatbotContainer.offsetWidth;
        const maxY = window.innerHeight - chatbotContainer.offsetHeight;

        const constrainedX = Math.min(Math.max(0, newX), maxX);
        const constrainedY = Math.min(Math.max(0, newY), maxY);

        // Set the new position
        chatbotContainer.style.left = constrainedX + 'px';
        chatbotContainer.style.top = constrainedY + 'px';
        chatbotContainer.style.bottom = 'auto';
        chatbotContainer.style.right = 'auto';
    }

    // End dragging with momentum
    function endDrag() {
        if (!isDragging) return;

        isDragging = false;
        chatbotButton.classList.remove('dragging');

        // Apply momentum effect
        let momentum = {
            x: velocityX,
            y: velocityY
        };

        // Apply momentum if velocity is significant
        if (Math.abs(velocityX) > 0.5 || Math.abs(velocityY) > 0.5) {
            applyMomentum(momentum);
        } else {
            // Just save the final position
            savePosition();
        }
    }

    // Apply momentum effect with bounce
    function applyMomentum(momentum) {
        const rect = chatbotContainer.getBoundingClientRect();
        let x = rect.left;
        let y = rect.top;

        // Friction factor
        const friction = 0.95;

        function momentumStep() {
            // Apply friction
            momentum.x *= friction;
            momentum.y *= friction;

            // Update position
            x += momentum.x;
            y += momentum.y;

            // Apply constraints with bounce
            const maxX = window.innerWidth - chatbotContainer.offsetWidth;
            const maxY = window.innerHeight - chatbotContainer.offsetHeight;

            // Bounce off edges
            if (x < 0) {
                x = 0;
                momentum.x = -momentum.x * 0.5; // Bounce with energy loss
            } else if (x > maxX) {
                x = maxX;
                momentum.x = -momentum.x * 0.5;
            }

            if (y < 0) {
                y = 0;
                momentum.y = -momentum.y * 0.5;
            } else if (y > maxY) {
                y = maxY;
                momentum.y = -momentum.y * 0.5;
            }

            // Set the new position
            chatbotContainer.style.left = x + 'px';
            chatbotContainer.style.top = y + 'px';

            // Continue animation if velocity is still significant
            if (Math.abs(momentum.x) > 0.1 || Math.abs(momentum.y) > 0.1) {
                animationFrame = requestAnimationFrame(momentumStep);
            } else {
                // Save final position
                savePosition();
            }
        }

        // Start animation
        animationFrame = requestAnimationFrame(momentumStep);
    }

    // Double click to reset position
    function handleDoubleClick(e) {
        if (e.target.closest('.chat-box')) return;
        resetPosition();
    }

    // Setup event listeners for enhanced dragging
    function setupDragListeners() {
        // Mouse events
        chatbotButton.addEventListener('mousedown', startDrag);
        document.addEventListener('mousemove', drag);
        document.addEventListener('mouseup', endDrag);

        // Touch events for mobile
        chatbotButton.addEventListener('touchstart', startDrag, { passive: false });
        document.addEventListener('touchmove', drag, { passive: false });
        document.addEventListener('touchend', endDrag);

        // Double click to reset position
        chatbotButton.addEventListener('dblclick', handleDoubleClick);

        // Load saved position on init
        loadPosition();

        // Handle window resize
        window.addEventListener('resize', function() {
            const rect = chatbotContainer.getBoundingClientRect();
            const maxX = window.innerWidth - chatbotContainer.offsetWidth;
            const maxY = window.innerHeight - chatbotContainer.offsetHeight;

            // If chat is off-screen after resize, move it into view
            if (rect.right > window.innerWidth || rect.bottom > window.innerHeight) {
                chatbotContainer.style.left = Math.min(rect.left, maxX) + 'px';
                chatbotContainer.style.top = Math.min(rect.top, maxY) + 'px';
                savePosition();
            }
        });
    }

    // Initialize enhanced dragging
    setupDragListeners();
}

// Call this function after the DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    enhanceDraggable();
});
