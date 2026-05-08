{{-- Floating chat widget – included in public layout --}}
<style>
    #chat-bubble {
        position: fixed;
        bottom: 28px;
        right: 28px;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: var(--primary);
        color: #fff;
        border: none;
        font-size: 1.4rem;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(0,0,0,.2);
        z-index: 9998;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform .2s, background .2s;
    }
    #chat-bubble:hover { background: var(--primary-light); transform: scale(1.08); }

    #chat-panel {
        position: fixed;
        bottom: 96px;
        right: 24px;
        width: 360px;
        max-width: calc(100vw - 32px);
        height: 480px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 8px 40px rgba(0,0,0,.15);
        z-index: 9999;
        display: none;
        flex-direction: column;
        overflow: hidden;
    }
    #chat-panel.open { display: flex; }

    .chat-panel-header {
        background: var(--primary);
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .chat-panel-header .avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--gold);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: .9rem;
        flex-shrink: 0;
    }
    .chat-panel-header .info { flex: 1; }
    .chat-panel-header .info h6 { color: #fff; margin: 0; font-size: .9rem; }
    .chat-panel-header .info small { color: rgba(255,255,255,.7); font-size: .72rem; }
    .chat-panel-header .close-btn {
        background: none;
        border: none;
        color: rgba(255,255,255,.7);
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0;
        line-height: 1;
    }
    .chat-panel-header .close-btn:hover { color: #fff; }

    #chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 10px;
        scroll-behavior: smooth;
    }

    .chat-msg {
        max-width: 82%;
        padding: 10px 13px;
        border-radius: 12px;
        font-size: .85rem;
        line-height: 1.5;
        word-break: break-word;
        white-space: pre-wrap;
    }
    .chat-msg.user {
        background: var(--primary);
        color: #fff;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
    }
    .chat-msg.assistant {
        background: #fff;
        color: var(--dark);
        border: 1px solid #e5e7eb;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
    }
    .chat-msg.typing {
        background: #fff;
        border: 1px solid #e5e7eb;
        align-self: flex-start;
        padding: 10px 16px;
    }
    .typing-dot {
        display: inline-block;
        width: 7px; height: 7px;
        border-radius: 50%;
        background: var(--gray);
        margin: 0 2px;
        animation: blink 1.2s infinite;
    }
    .typing-dot:nth-child(2) { animation-delay: .2s; }
    .typing-dot:nth-child(3) { animation-delay: .4s; }
    @keyframes blink { 0%,80%,100% { opacity: .2; } 40% { opacity: 1; } }

    .chat-panel-footer {
        padding: 10px 12px;
        border-top: 1px solid #e5e7eb;
        background: #fff;
        display: flex;
        gap: 8px;
        align-items: center;
    }
    #chat-input {
        flex: 1;
        padding: 9px 12px;
        border: 1px solid #d1d5db;
        border-radius: 20px;
        font-size: .85rem;
        outline: none;
        resize: none;
        max-height: 100px;
    }
    #chat-input:focus { border-color: var(--primary); }
    #chat-send-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--primary);
        color: #fff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
        transition: background .2s;
    }
    #chat-send-btn:hover { background: var(--primary-light); }
    #chat-send-btn:disabled { background: #d1d5db; cursor: not-allowed; }

    .chat-panel-footer .full-chat-link {
        font-size: .7rem;
        color: var(--gray);
        text-align: center;
        width: 100%;
        display: block;
        margin-top: 6px;
    }
</style>

{{-- Bubble trigger --}}
<button id="chat-bubble" onclick="toggleChatPanel()" aria-label="Chat Asisten">
    <i class="bi bi-chat-dots-fill" id="bubble-icon"></i>
</button>

{{-- Floating panel --}}
<div id="chat-panel" role="dialog" aria-label="Chat Asisten Properti">
    <div class="chat-panel-header">
        <div class="avatar">M</div>
        <div class="info">
            <h6>Mida – Asisten Properti</h6>
            <small><span class="badge bg-success" style="font-size:.65rem;padding:2px 6px">● Online</span> &nbsp;Siap membantu Anda</small>
        </div>
        <button class="close-btn" onclick="toggleChatPanel()" aria-label="Tutup">&times;</button>
    </div>

    <div id="chat-messages">
        {{-- Welcome message --}}
        <div class="chat-msg assistant">
            Halo! 👋 Saya <strong>Mida</strong>, asisten virtual Midland Properti.<br><br>
            Saya siap membantu Anda menemukan properti impian. Apa yang bisa saya bantu hari ini?
        </div>
    </div>

    <div class="chat-panel-footer">
        <textarea id="chat-input" rows="1" placeholder="Tanya tentang properti..." maxlength="1000"></textarea>
        <button id="chat-send-btn" onclick="chatSend()" aria-label="Kirim">
            <i class="bi bi-send-fill" style="font-size:.85rem"></i>
        </button>
    </div>
</div>

<script>
(function () {
    const SESSION_KEY  = 'mida_session';
    const PANEL_KEY    = 'mida_open';
    const ENDPOINT_SEND = '{{ route("chat.send") }}';
    const ENDPOINT_HIST = '{{ route("chat.history") }}';
    const CSRF          = '{{ csrf_token() }}';

    // Generate or retrieve a stable session ID for this browser
    let sessionId = localStorage.getItem(SESSION_KEY);
    if (!sessionId) {
        sessionId = 'chat_' + Math.random().toString(36).slice(2) + Date.now();
        localStorage.setItem(SESSION_KEY, sessionId);
    }

    let isOpen   = false;
    let isBusy   = false;
    let histLoaded = false;

    window.toggleChatPanel = function () {
        isOpen = !isOpen;
        document.getElementById('chat-panel').classList.toggle('open', isOpen);
        document.getElementById('bubble-icon').className = isOpen ? 'bi bi-x-lg' : 'bi bi-chat-dots-fill';
        if (isOpen && !histLoaded) loadHistory();
    };

    function loadHistory() {
        histLoaded = true;
        fetch(`${ENDPOINT_HIST}?session_id=${sessionId}`)
            .then(r => r.json())
            .then(data => {
                if (data.messages && data.messages.length > 0) {
                    // Clear welcome-only and restore history
                    const box = document.getElementById('chat-messages');
                    box.innerHTML = '';
                    data.messages.forEach(m => appendMessage(m.role, m.content));
                    scrollBottom();
                }
            })
            .catch(() => {});
    }

    window.chatSend = function () {
        if (isBusy) return;
        const input = document.getElementById('chat-input');
        const msg   = input.value.trim();
        if (!msg) return;

        input.value = '';
        autoResize(input);

        appendMessage('user', msg);
        const typingEl = appendTyping();
        setBusy(true);

        fetch(ENDPOINT_SEND, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
            },
            body: JSON.stringify({ message: msg, session_id: sessionId }),
        })
        .then(r => {
            if (r.status === 429) throw new Error('rate_limit');
            return r.json();
        })
        .then(data => {
            typingEl.remove();
            appendMessage('assistant', data.reply ?? 'Maaf, ada gangguan. Coba lagi.');
        })
        .catch(err => {
            typingEl.remove();
            const msg = err.message === 'rate_limit'
                ? 'Anda terlalu sering mengirim pesan. Harap tunggu sebentar sebelum mencoba lagi.'
                : 'Koneksi bermasalah. Silakan coba lagi.';
            appendMessage('assistant', msg);
        })
        .finally(() => setBusy(false));
    };

    function appendMessage(role, content) {
        const box = document.getElementById('chat-messages');
        const div = document.createElement('div');
        div.className = 'chat-msg ' + role;
        div.textContent = content;
        box.appendChild(div);
        scrollBottom();
        return div;
    }

    function appendTyping() {
        const box = document.getElementById('chat-messages');
        const div = document.createElement('div');
        div.className = 'chat-msg typing';
        div.innerHTML = '<span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span>';
        box.appendChild(div);
        scrollBottom();
        return div;
    }

    function scrollBottom() {
        const box = document.getElementById('chat-messages');
        box.scrollTop = box.scrollHeight;
    }

    function setBusy(busy) {
        isBusy = busy;
        const btn = document.getElementById('chat-send-btn');
        btn.disabled = busy;
    }

    function autoResize(el) {
        el.style.height = 'auto';
        el.style.height = Math.min(el.scrollHeight, 100) + 'px';
    }

    // Enter to send (Shift+Enter for newline)
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('chat-input');
        if (!input) return;
        input.addEventListener('keydown', e => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                chatSend();
            }
        });
        input.addEventListener('input', () => autoResize(input));
    });
})();
</script>
