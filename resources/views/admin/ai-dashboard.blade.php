@extends('layouts.admin')

@section('content')
<style>
    .ai-dashboard-wrapper {
        padding: 24px;
        max-width: 1100px;
    }
    .ai-header {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        border-radius: 16px;
        padding: 28px 32px;
        margin-bottom: 24px;
        color: white;
        position: relative;
        overflow: hidden;
    }
    .ai-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(99,179,237,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }
    .ai-header h2 { font-size: 22px; font-weight: 700; margin: 0 0 6px 0; }
    .ai-header p  { font-size: 14px; opacity: 0.75; margin: 0; }
    .ai-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(99,179,237,0.2); border: 1px solid rgba(99,179,237,0.4);
        padding: 4px 12px; border-radius: 20px; font-size: 12px; margin-bottom: 12px;
    }
    .ai-badge .dot {
        width: 7px; height: 7px; border-radius: 50%;
        background: #68d391; animation: blink 2s infinite;
    }
    @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }

    /* Quick Stats */
    .quick-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
    .stat-card {
        background: #fff; border-radius: 12px; padding: 16px 20px;
        border: 1px solid #e9ecef; transition: all 0.2s;
    }
    .stat-card:hover { box-shadow: 0 4px 15px rgba(0,0,0,0.08); transform: translateY(-2px); }
    .stat-label { font-size: 12px; color: #6c757d; margin-bottom: 4px; }
    .stat-value { font-size: 18px; font-weight: 700; color: #1a1a2e; }
    .stat-icon  { font-size: 20px; margin-bottom: 8px; }

    /* Quick Questions */
    .quick-q-section { margin-bottom: 20px; }
    .quick-q-title { font-size: 13px; color: #6c757d; font-weight: 600; margin-bottom: 10px; }
    .quick-q-grid { display: flex; flex-wrap: wrap; gap: 8px; }
    .quick-q-btn {
        padding: 7px 14px; border-radius: 20px; font-size: 13px; cursor: pointer;
        border: 1px solid #dee2e6; background: #fff; color: #495057;
        transition: all 0.2s; white-space: nowrap;
    }
    .quick-q-btn:hover { background: #0f3460; color: #fff; border-color: #0f3460; }

    /* Chat Area */
    .chat-container {
        background: #fff; border-radius: 16px; border: 1px solid #e9ecef;
        overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }
    .chat-messages {
        height: 420px; overflow-y: auto; padding: 20px;
        display: flex; flex-direction: column; gap: 16px;
        background: #f8f9fa;
    }
    .chat-messages::-webkit-scrollbar { width: 5px; }
    .chat-messages::-webkit-scrollbar-thumb { background: #dee2e6; border-radius: 10px; }

    /* Message bubbles */
    .msg-user {
        align-self: flex-end; max-width: 75%;
        background: #0f3460; color: white;
        padding: 12px 16px; border-radius: 16px 16px 4px 16px;
        font-size: 14px; line-height: 1.5;
    }
    .msg-ai-wrapper { display: flex; gap: 10px; align-items: flex-start; max-width: 90%; }
    .msg-ai-avatar {
        width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
        background: linear-gradient(135deg, #1a1a2e, #0f3460);
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 16px; margin-top: 2px;
    }
    .msg-ai {
        background: #fff; border: 1px solid #e9ecef;
        padding: 14px 16px; border-radius: 4px 16px 16px 16px;
        font-size: 14px; line-height: 1.7; color: #343a40;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .msg-ai p  { margin: 0 0 8px 0; }
    .msg-ai p:last-child { margin: 0; }
    .msg-ai ul { margin: 6px 0; padding-left: 18px; }
    .msg-ai li { margin-bottom: 4px; }
    .msg-ai strong { color: #0f3460; }

    /* Loading bubble */
    .loading-bubble {
        background: #fff; border: 1px solid #e9ecef;
        padding: 14px 16px; border-radius: 4px 16px 16px 16px;
        display: flex; gap: 5px; align-items: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .loading-bubble span {
        width: 8px; height: 8px; border-radius: 50%; background: #0f3460;
        animation: bounce 1.4s infinite ease-in-out;
    }
    .loading-bubble span:nth-child(2) { animation-delay: 0.2s; }
    .loading-bubble span:nth-child(3) { animation-delay: 0.4s; }
    @keyframes bounce { 0%,80%,100%{transform:scale(0)} 40%{transform:scale(1)} }

    /* Input area */
    .chat-input-area {
        display: flex; gap: 10px; padding: 16px 20px;
        background: #fff; border-top: 1px solid #e9ecef;
    }
    .chat-input-wrap {
        flex: 1; display: flex; background: #f8f9fa;
        border: 1px solid #dee2e6; border-radius: 24px; overflow: hidden;
        transition: all 0.2s;
    }
    .chat-input-wrap:focus-within { border-color: #0f3460; box-shadow: 0 0 0 3px rgba(15,52,96,0.1); }
    #aiInput {
        flex: 1; border: none; background: transparent;
        padding: 11px 16px; font-size: 14px; outline: none;
    }
    #aiSendBtn {
        width: 44px; height: 44px; border-radius: 50%; border: none; cursor: pointer;
        background: linear-gradient(135deg, #1a1a2e, #0f3460);
        color: white; display: flex; align-items: center; justify-content: center;
        font-size: 16px; transition: all 0.2s; flex-shrink: 0;
    }
    #aiSendBtn:hover   { transform: scale(1.05); }
    #aiSendBtn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

    /* Welcome message */
    .welcome-msg {
        background: linear-gradient(135deg, #e8f4fd, #f0f7ff);
        border: 1px solid #b8d9f3; border-radius: 12px;
        padding: 16px 18px; margin-bottom: 4px;
    }
    .welcome-msg h6 { font-weight: 700; color: #0f3460; margin: 0 0 6px 0; font-size: 14px; }
    .welcome-msg p  { font-size: 13px; color: #495057; margin: 0; line-height: 1.5; }

    @media (max-width: 768px) {
        .quick-stats { grid-template-columns: repeat(2, 1fr); }
    }
</style>

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="ai-dashboard-wrapper">

            <!-- Header -->
            <div class="ai-header">
                <div class="ai-badge">
                    <div class="dot"></div>
                    <span>AI Online &bull; Claude Haiku</span>
                </div>
                <h2>🤖 AI Business Intelligence</h2>
                <p>Tanya apa saja tentang bisnis Bank Eceng Gondok — AI akan menjawab berdasarkan data nyata Anda.</p>
            </div>

            <!-- Quick Stats -->
            <div class="quick-stats" id="quickStats">
                <div class="stat-card">
                    <div class="stat-icon">📦</div>
                    <div class="stat-label">Total Pesanan</div>
                    <div class="stat-value" id="statOrders">—</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <div class="stat-label">Pendapatan Bulan Ini</div>
                    <div class="stat-value" id="statRevenue">—</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">🌿</div>
                    <div class="stat-label">Stok Bahan Baku</div>
                    <div class="stat-value" id="statStock">—</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">⭐</div>
                    <div class="stat-label">Rata-rata Rating</div>
                    <div class="stat-value" id="statRating">—</div>
                </div>
            </div>

            <!-- Quick Questions -->
            <div class="quick-q-section">
                <div class="quick-q-title">💡 Pertanyaan Cepat</div>
                <div class="quick-q-grid">
                    <button class="quick-q-btn" onclick="askQuick(this)">Produk terlaris bulan ini?</button>
                    <button class="quick-q-btn" onclick="askQuick(this)">Bagaimana tren pendapatan tahun ini?</button>
                    <button class="quick-q-btn" onclick="askQuick(this)">Produk mana yang paling banyak dikomplain?</button>
                    <button class="quick-q-btn" onclick="askQuick(this)">Berapa total pesanan pending saat ini?</button>
                    <button class="quick-q-btn" onclick="askQuick(this)">Kondisi stok bahan baku sekarang?</button>
                    <button class="quick-q-btn" onclick="askQuick(this)">Apa yang perlu diprioritaskan minggu ini?</button>
                    <button class="quick-q-btn" onclick="askQuick(this)">Perbandingan pendapatan bulan ini vs bulan lalu?</button>
                    <button class="quick-q-btn" onclick="askQuick(this)">Berikan ringkasan bisnis hari ini</button>
                </div>
            </div>

            <!-- Chat Container -->
            <div class="chat-container">
                <div class="chat-messages" id="chatMessages">
                    <div class="welcome-msg">
                        <h6>👋 Selamat datang di AI Dashboard</h6>
                        <p>Saya siap membantu Anda menganalisis data bisnis Bank Eceng Gondok. Silakan ketik pertanyaan atau pilih dari pertanyaan cepat di atas.</p>
                    </div>
                </div>
                <div class="chat-input-area">
                    <div class="chat-input-wrap">
                        <input type="text" id="aiInput"
                            placeholder="Contoh: Produk mana yang paling banyak terjual bulan ini?"
                            autocomplete="off">
                    </div>
                    <button id="aiSendBtn" onclick="sendQuestion()">
                        <i class="icon-send"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let chatHistory = [];
    let isLoading   = false;
    let msgCounter  = 0;

    // Kirim pertanyaan
    function sendQuestion() {
        const input = document.getElementById('aiInput');
        const question = input.value.trim();
        if (!question || isLoading) return;

        addUserMessage(question);
        input.value = '';
        getAIResponse(question);
    }

    // Quick question
    function askQuick(btn) {
        document.getElementById('aiInput').value = btn.textContent;
        sendQuestion();
    }

    // Tambah pesan user
    function addUserMessage(text) {
        const messages = document.getElementById('chatMessages');
        const div = document.createElement('div');
        div.className = 'msg-user';
        div.style.animation = 'fadeIn 0.3s ease';
        div.textContent = text;
        messages.appendChild(div);
        scrollToBottom();
    }

    // Tambah loading bubble
    function addLoadingBubble() {
        msgCounter++;
        const messages = document.getElementById('chatMessages');
        const wrapper  = document.createElement('div');
        wrapper.className = 'msg-ai-wrapper';
        wrapper.id = 'msg-' + msgCounter;
        wrapper.innerHTML = `
            <div class="msg-ai-avatar">🤖</div>
            <div class="loading-bubble">
                <span></span><span></span><span></span>
            </div>`;
        messages.appendChild(wrapper);
        scrollToBottom();
        return msgCounter;
    }

    // Update bubble dengan jawaban AI
    function updateBubble(id, text) {
        const wrapper = document.getElementById('msg-' + id);
        if (!wrapper) return;
        const formatted = formatAIText(text);
        wrapper.querySelector('.loading-bubble').outerHTML =
            `<div class="msg-ai">${formatted}</div>`;
        scrollToBottom();
    }

    // Format teks AI (markdown sederhana)
    function formatAIText(text) {
        return text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            .replace(/^### (.*$)/gm, '<h6 style="font-weight:700;color:#0f3460;margin:10px 0 4px">$1</h6>')
            .replace(/^## (.*$)/gm,  '<h5 style="font-weight:700;color:#0f3460;margin:10px 0 4px">$1</h5>')
            .replace(/^- (.*$)/gm,   '<li>$1</li>')
            .replace(/(<li>.*<\/li>)/s, '<ul>$1</ul>')
            .replace(/\n\n/g, '</p><p>')
            .replace(/\n/g, '<br>')
            .replace(/^(.)/s, '<p>$1')
            .replace(/(.)$/s, '$1</p>');
    }

    // Scroll ke bawah
    function scrollToBottom() {
        const messages = document.getElementById('chatMessages');
        messages.scrollTo({ top: messages.scrollHeight, behavior: 'smooth' });
    }

    // Panggil AI
    function getAIResponse(question) {
        isLoading = true;
        const btn = document.getElementById('aiSendBtn');
        btn.disabled = true;

        chatHistory.push({ role: 'user', content: question });
        const loadingId = addLoadingBubble();

        fetch('{{ route('admin.ai.ask') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                question: question,
                history: chatHistory.slice(-6)
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success') {
                chatHistory.push({ role: 'assistant', content: data.reply });
                updateBubble(loadingId, data.reply);

                // Update quick stats jika ada
                if (data.data_snapshot) {
                    document.getElementById('statOrders').textContent  = data.data_snapshot.total_orders;
                    document.getElementById('statRevenue').textContent = data.data_snapshot.monthly_revenue;
                    document.getElementById('statStock').textContent   = data.data_snapshot.total_stock;
                    document.getElementById('statRating').textContent  = data.data_snapshot.avg_rating + '/5';
                }
            } else {
                updateBubble(loadingId, '❌ ' + (data.message || 'Terjadi kesalahan.'));
            }
        })
        .catch(() => {
            updateBubble(loadingId, '❌ Gagal menghubungi AI. Periksa koneksi server.');
        })
        .finally(() => {
            isLoading = false;
            btn.disabled = false;
            document.getElementById('aiInput').focus();
        });
    }

    // Enter key
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('aiInput').addEventListener('keypress', e => {
            if (e.key === 'Enter') sendQuestion();
        });
    });
</script>

<style>
@keyframes fadeIn {
    from { opacity:0; transform:translateY(8px); }
    to   { opacity:1; transform:translateY(0); }
}
</style>
@endpush
