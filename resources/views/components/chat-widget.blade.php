<!-- Bank Eceng Gondok Chatbot Widget -->
<div
    style="position: fixed; bottom: 50px; right: 50px; z-index: 9999; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
    <!-- Chat Widget Button - Circular with Label -->
    <div id="chatbotButton"
        style="position: absolute; bottom: 0; right: 0; display: flex; align-items: center; cursor: pointer; transition: all 0.3s ease;"
        aria-label="Chat dengan AI Bank Eceng Gondok" role="button" tabindex="0">
        <!-- Text Label -->
        <div class="button-label"
            style="background: linear-gradient(135deg, #956a3b, #7a552f); color: #ffffff; padding: 8px 16px; border-radius: 20px; margin-right: 10px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15); font-weight: 500; font-size: 14px; opacity: 1; transition: all 0.3s ease;">
            Chat dengan AI
        </div>
        <!-- Button Circle -->
        <div
            style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #956a3b, #7a552f); color: #ffffff; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15); display: flex; align-items: center; justify-content: center; position: relative;">
            <div
                style="position: relative; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                <div
                    style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; z-index: 2;">
                    <i class="fas fa-robot" style="font-size: 24px; color: #ffffff;"></i>
                </div>
                <div id="buttonPulse"
                    style="position: absolute; width: 100%; height: 100%; border-radius: 50%; background: rgba(255, 255, 255, 0.2); z-index: 1; animation: pulse 2s infinite;">
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Widget Box -->
    <div id="chatbotBox"
        style="position: absolute; bottom: 80px; right: 0; width: 380px; height: 550px; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12); display: flex; flex-direction: column; opacity: 0; transform: translateY(20px) scale(0.9); pointer-events: none; transition: all 0.3s ease; border: 1px solid #e9ecef;">
        <!-- Chat Header -->
        <div
            style="background: linear-gradient(135deg, #956a3b, #7a552f); color: #ffffff; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div
                    style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-robot" style="font-size: 20px;"></i>
                </div>
                <div style="display: flex; flex-direction: column;">
                    <span style="font-weight: 600; font-size: 16px;">Asisten AI Bank Eceng Gondok</span>
                    <span style="font-size: 12px; opacity: 0.8; display: flex; align-items: center;">
                        <span
                            style="content: ''; display: inline-block; width: 8px; height: 8px; background: #00D9C5; border-radius: 50%; margin-right: 5px; animation: blink 2s infinite;"></span>
                        Online
                    </span>
                </div>
            </div>
            <div style="display: flex; gap: 10px;">
                <button id="chatMinimize"
                    style="background: transparent; border: none; color: #ffffff; cursor: pointer; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: all 0.3s ease;"
                    aria-label="Minimize">
                    <i class="fas fa-minus"></i>
                </button>
                <button id="chatClose"
                    style="background: transparent; border: none; color: #ffffff; cursor: pointer; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: all 0.3s ease;"
                    aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Chat Quick Options -->
        <div id="quickOptions" style="padding: 15px; background-color: #f0f2f5; border-bottom: 1px solid #e9ecef;">
            <div
                style="font-size: 14px; color: #343a40; margin-bottom: 12px; font-weight: 500; display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-lightbulb" style="color: #956a3b;"></i> Apa yang ingin Anda ketahui?
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <button class="quick-option" data-query="Bagaimana cara menjadi pemasok eceng gondok?"
                    style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 12px; background: #ffffff; border-radius: 12px; border: 1px solid #e9ecef; transition: all 0.3s ease; cursor: pointer; text-align: center;">
                    <i class="fas fa-leaf" style="font-size: 18px; margin-bottom: 6px; color: #956a3b;"></i>
                    <span style="font-size: 12px; font-weight: 500; color: #343a40;">Jadi Pemasok</span>
                </button>
                <button class="quick-option" data-query="Berapa harga per kg eceng gondok?"
                    style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 12px; background: #ffffff; border-radius: 12px; border: 1px solid #e9ecef; transition: all 0.3s ease; cursor: pointer; text-align: center;">
                    <i class="fas fa-coins" style="font-size: 18px; margin-bottom: 6px; color: #956a3b;"></i>
                    <span style="font-size: 12px; font-weight: 500; color: #343a40;">Harga Eceng</span>
                </button>
                <button class="quick-option" data-query="Apa produk kerajinan yang dibuat?"
                    style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 12px; background: #ffffff; border-radius: 12px; border: 1px solid #e9ecef; transition: all 0.3s ease; cursor: pointer; text-align: center;">
                    <i class="fas fa-shopping-bag" style="font-size: 18px; margin-bottom: 6px; color: #956a3b;"></i>
                    <span style="font-size: 12px; font-weight: 500; color: #343a40;">Produk Kerajinan</span>
                </button>
                <button class="quick-option" data-query="Kapan jadwal penjemputan eceng gondok?"
                    style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 12px; background: #ffffff; border-radius: 12px; border: 1px solid #e9ecef; transition: all 0.3s ease; cursor: pointer; text-align: center;">
                    <i class="fas fa-truck" style="font-size: 18px; margin-bottom: 6px; color: #956a3b;"></i>
                    <span style="font-size: 12px; font-weight: 500; color: #343a40;">Jadwal Jemput</span>
                </button>
            </div>
        </div>

        <!-- Chat Content -->
        <div id="content"
            style="flex: 1; padding: 15px; overflow-y: auto; display: flex; flex-direction: column; gap: 15px; background-color: #f8f9fa;">
            <div
                style="display: flex; background: #f8f9fa; border-radius: 12px; padding: 15px; margin-bottom: 15px; animation: fadeIn 0.5s ease-out;">
                <div
                    style="width: 50px; height: 50px; min-width: 50px; background: rgba(149, 106, 59, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                    <i class="fas fa-robot" style="font-size: 24px; color: #956a3b;"></i>
                </div>
                <div>
                    <h4 style="margin: 0 0 8px 0; color: #343a40; font-size: 16px;">Selamat Datang di Bank Koperasi
                        Eceng Gondok!</h4>
                    <p style="margin: 0; color: #6c757d; font-size: 14px; line-height: 1.5;">Saya asisten AI yang siap
                        membantu Anda dengan informasi seputar program pemasok eceng gondok dan produk kerajinan kami.
                        Bergabunglah dengan kami dalam melestarikan Danau Toba! 👋</p>
                </div>
            </div>
            <div
                style="display: flex; align-items: flex-start; max-width: 85%; align-self: flex-start; animation: messageIn 0.3s ease-out forwards;">
                <i class="fas fa-robot"
                    style="width: 32px; height: 32px; background: rgba(149, 106, 59, 0.1); color: #956a3b; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 10px; font-size: 16px;"></i>
                <div
                    style="padding: 12px 16px; border-radius: 18px; font-size: 14px; line-height: 1.5; word-wrap: break-word; background: #ffffff; color: #343a40; border-top-left-radius: 4px; box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);">
                    Silakan pilih topik di atas atau ketik pertanyaan Anda langsung.</div>
            </div>
            <!-- Messages will be added here dynamically -->
        </div>

        <!-- Chat Footer/Form -->
        <div style="display: flex; padding: 15px; background: #ffffff; border-top: 1px solid #e9ecef; gap: 10px;">
            <div
                style="flex: 1; position: relative; display: flex; background: #f8f9fa; border-radius: 24px; overflow: hidden; transition: all 0.3s ease; border: 1px solid #e9ecef;">
                <input type="text" id="chatInput" placeholder="Ketik pesan Anda di sini..." autocomplete="off"
                    style="flex: 1; border: none; background: transparent; padding: 12px 15px; outline: none; font-size: 14px;">
                <div style="display: flex; align-items: center; padding-right: 10px;">
                    <button
                        style="background: transparent; border: none; color: #6c757d; cursor: pointer; padding: 5px; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;"
                        aria-label="Attachment">
                        <i class="fas fa-paperclip"></i>
                    </button>
                </div>
            </div>
            <button id="sendButton"
                style="width: 45px; height: 45px; border-radius: 50%; background: linear-gradient(135deg, #956a3b, #7a552f); color: #ffffff; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);"
                aria-label="Send">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>

        <!-- Powered By Section -->
        <div
            style="padding: 10px; text-align: center; font-size: 12px; color: #6c757d; background: #ffffff; border-top: 1px solid #e9ecef;">
            <span>Didukung oleh</span>
            <strong>AI Assistant for Eceng Gondok @2025</strong>
        </div>
    </div>
</div>

<!-- Include FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
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

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.9);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes slideOut {
        from {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        to {
            opacity: 0;
            transform: translateY(20px) scale(0.9);
        }
    }

    @keyframes blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.4;
        }
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

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    /* Animation for button label */
    @keyframes labelFadeIn {
        from {
            opacity: 0;
            transform: translateX(10px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes labelFadeOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }

        to {
            opacity: 0;
            transform: translateX(10px);
        }
    }

    /* Hover effect for button */
    #chatbotButton:hover .button-label {
        animation: labelFadeIn 0.3s forwards;
    }

    /* Chat button hover effects */
    #chatMinimize:hover,
    #chatClose:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    /* Quick option hover effects */
    .quick-option:hover {
        background: #f8f9fa;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
</style>

<script>
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
    const buttonLabel = document.querySelector('.button-label');

    // State Variables
    let isAnswerLoading = false;
    let answerSectionId = 0;
    let chatHistory = [];
    let isChatOpen = false;

    // Initialize chat state
    function initializeChatState() {
        isChatOpen = false;
        chatbotBox.style.opacity = '0';
        chatbotBox.style.transform = 'translateY(20px) scale(0.9)';
        chatbotBox.style.pointerEvents = 'none';
        buttonLabel.style.opacity = '1';
        buttonLabel.style.display = 'block';
    }

    // Toggle Chatbox Visibility - Improved function
    function toggleChatbox() {
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
        chatbotBox.style.animation = 'slideIn 0.3s forwards';

        // Hide the label with animation
        buttonLabel.style.animation = 'labelFadeOut 0.3s forwards';
        setTimeout(() => {
            buttonLabel.style.opacity = '0';
            buttonLabel.style.display = 'none';
        }, 300);

        // Focus on input when opened
        setTimeout(() => chatInput.focus(), 300);
    }

    // Close chatbox
    function closeChatbox() {
        isChatOpen = false;
        chatbotBox.style.animation = 'slideOut 0.3s forwards';

        setTimeout(() => {
            chatbotBox.style.opacity = '0';
            chatbotBox.style.transform = 'translateY(20px) scale(0.9)';
            chatbotBox.style.pointerEvents = 'none';
        }, 100);

        // Show the label with animation
        buttonLabel.style.display = 'block';
        buttonLabel.style.animation = 'labelFadeIn 0.3s forwards';
        setTimeout(() => {
            buttonLabel.style.opacity = '1';
        }, 100);
    }

    // Minimize Chatbox - Same as close
    function minimizeChatbox() {
        closeChatbox();
    }

    // Event Listeners - Fixed to prevent multiple listeners
    function setupEventListeners() {
        // Remove existing listeners if any
        chatbotButton.removeEventListener('click', toggleChatbox);
        chatMinimize.removeEventListener('click', minimizeChatbox);
        chatClose.removeEventListener('click', closeChatbox);

        // Add new listeners
        chatbotButton.addEventListener('click', toggleChatbox);
        chatMinimize.addEventListener('click', minimizeChatbox);
        chatClose.addEventListener('click', closeChatbox);

        sendButton.addEventListener('click', handleSendMessage);
        chatInput.addEventListener('keypress', event => {
            if (event.key === 'Enter') {
                handleSendMessage();
            }
        });

        // Setup Quick Options
        quickOptions.forEach(option => {
            option.addEventListener('click', () => {
                const query = option.getAttribute('data-query');
                if (query) {
                    chatInput.value = query;
                    handleSendMessage();
                }
            });
        });

        // Hover effects for button
        chatbotButton.addEventListener('mouseenter', () => {
            if (!isChatOpen) {
                buttonLabel.style.display = 'block';
                buttonLabel.style.animation = 'labelFadeIn 0.3s forwards';
                buttonLabel.style.opacity = '1';
            }
        });
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
                            "content": "Anda adalah asisten AI Bank Koperasi Eceng Gondok yang ramah, profesional, dan berpengetahuan luas. Tugas utama Anda adalah memberikan informasi akurat dan bantuan terkait program pemasok eceng gondok, kerajinan eceng gondok, dan dampak positif dari inisiatif kami terhadap ekosistem Danau Toba. Tentang Bank Koperasi Eceng Gondok: Didirikan pada akhir 2023 oleh Sumondang Tabita Nainggolan di Sitanggang Bau, Pangururan, Samosir Merupakan inisiatif inovatif untuk mengatasi masalah lingkungan eceng gondok yang merusak ekosistem Danau Toba Mengubah eceng gondok dari gulma menjadi produk kerajinan bernilai tinggi Memberdayakan masyarakat lokal melalui kerajinan dan program pemasok Mengembangkan sistem koperasi digital terintegrasi untuk efisiensi operasional Program Pemasok Eceng Gondok: Pembayaran langsung: Rp 60.000 per kilogram eceng gondok Alternatif: Diskon spesial untuk pembelian produk kerajinan kami Penjemputan gratis ke lokasi pemasok Kontak langsung melalui WhatsApp setelah pengisian formulir Minimal 1 kg untuk diterima Penjemputan setiap hari Sabtu, pukul 08.00-17.00 WIB Area layanan: Samosir dan sekitarnya Dampak Eceng Gondok di Danau Toba: Menutupi 60% permukaan air, menghalangi sinar matahari Mengurangi oksigen yang penting bagi kehidupan akuatik Pertumbuhan pesat dalam hitungan hari, merusak keindahan panorama Setiap tanaman menyerap hingga 20 liter air per hari Mengganggu keseimbangan ekosistem danau Produk Kerajinan Eceng Gondok: Sandal Tas Keranjang Aksesori rumah Produk dekoratif Sovenir khas Danau Toba Proses Produksi: Pengeringan eceng gondok Penghalusan material Penganyaman dengan teknik tradisional Finishing dan quality control Pemasaran lokal dan online Tips Cara Menjawab: Selalu gunakan bahasa Indonesia yang sopan dan ramah Berikan informasi singkat, padat, dan bermanfaat Tawarkan bantuan lebih lanjut jika diperlukan Sisipkan fakta menarik tentang eceng gondok atau Danau Toba Ajak pengguna untuk bergabung sebagai pemasok atau membeli produk kerajinan Tekankan manfaat lingkungan dari program pemasok eceng gondok Tunjukkan bagaimana program ini membantu masyarakat lokal Berikan informasi kontak jika ada pertanyaan lebih lanjut Ingatlah bahwa Anda adalah wajah digital dari Bank Koperasi Eceng Gondok yang mendorong pelestarian lingkungan dan pemberdayaan masyarakat. Berikan layanan terbaik dan informasi yang akurat kepada semua pengguna yang berinteraksi dengan Anda."
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

    // Add Question to Chat
    function addQuestionSection(message) {
        // Create question element with animation
        const sectionElement = document.createElement('div');
        sectionElement.style.display = 'flex';
        sectionElement.style.alignItems = 'flex-start';
        sectionElement.style.maxWidth = '85%';
        sectionElement.style.alignSelf = 'flex-end';
        sectionElement.style.flexDirection = 'row-reverse';
        sectionElement.style.animation = 'messageIn 0.3s ease-out forwards';
        sectionElement.style.marginBottom = '15px';

        sectionElement.innerHTML = `
          <i class="fas fa-user" style="width: 32px; height: 32px; background: #956a3b; color: #ffffff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-left: 10px; font-size: 16px;"></i>
          <div style="padding: 12px 16px; border-radius: 18px; font-size: 14px; line-height: 1.5; word-wrap: break-word; background: #956a3b; color: #ffffff; border-top-right-radius: 4px; box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);">${message}</div>
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
        sectionElement.style.display = 'flex';
        sectionElement.style.alignItems = 'flex-start';
        sectionElement.style.maxWidth = '85%';
        sectionElement.style.alignSelf = 'flex-start';
        sectionElement.style.animation = 'messageIn 0.3s ease-out forwards';
        sectionElement.style.marginBottom = '15px';
        sectionElement.id = `answer-${answerSectionId}`;

        sectionElement.innerHTML = `
          <i class="fas fa-robot" style="width: 32px; height: 32px; background: rgba(149, 106, 59, 0.1); color: #956a3b; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 10px; font-size: 16px;"></i>
          <div class="loading-bubble" style="padding: 12px 16px; border-radius: 18px; font-size: 14px; line-height: 1.5; word-wrap: break-word; background: #ffffff; color: #343a40; border-top-left-radius: 4px; box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08); display: flex; gap: 5px; align-items: center;">
              <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #956a3b; animation: bounce 1.5s infinite ease-in-out;"></span>
              <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #956a3b; animation: bounce 1.5s infinite ease-in-out; animation-delay: 0.2s;"></span>
              <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #956a3b; animation: bounce 1.5s infinite ease-in-out; animation-delay: 0.4s;"></span>
          </div>
      `;

        content.appendChild(sectionElement);
    }

    // Update Answer with Response
    function updateAnswerSection(message) {
        const answerSectionElement = document.getElementById(`answer-${answerSectionId}`);
        if (answerSectionElement) {
            const loadingBubble = answerSectionElement.querySelector('.loading-bubble');
            loadingBubble.innerHTML = message;
            loadingBubble.style.display = 'block';
        }
    }

    // Scroll Chat to Bottom
    function scrollToBottom() {
        content.scrollTo({
            top: content.scrollHeight,
            behavior: 'smooth'
        });
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        // Initialize chat state
        initializeChatState();

        // Setup event listeners
        setupEventListeners();

        // Hide quick options when user starts typing
        chatInput.addEventListener('input', () => {
            if (chatInput.value.trim().length > 0) {
                document.getElementById('quickOptions').style.display = 'none';
            }
        });
    });
</script>

