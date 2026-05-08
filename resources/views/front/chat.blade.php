@extends('layouts.public')

@section('title', 'Chat Asisten Properti')
@section('meta_description', 'Tanya asisten AI Midland Properti tentang properti impian Anda. Dapatkan rekomendasi dan informasi lengkap secara instan, 24 jam sehari.')

@push('styles')
<style>
    .chat-page-wrap {
        height: calc(100vh - 72px);
        display: flex;
        overflow: hidden;
    }

    /* Sidebar */
    .chat-sidebar {
        width: 280px;
        flex-shrink: 0;
        background: var(--primary);
        color: #fff;
        display: flex;
        flex-direction: column;
        padding: 24px 20px;
        gap: 24px;
    }
    @media(max-width: 768px) { .chat-sidebar { display: none; } }

    .chat-sidebar .brand {
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem;
        color: var(--gold);
        font-weight: 700;
    }
    .chat-sidebar p { font-size: .82rem; color: rgba(255,255,255,.7); line-height: 1.6; }

    .chat-starter-btn {
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.15);
        color: rgba(255,255,255,.85);
        border-radius: 8px;
        padding: 8px 12px;
        font-size: .8rem;
        text-align: left;
        cursor: pointer;
        transition: background .2s;
        width: 100%;
    }
    .chat-starter-btn:hover { background: rgba(255,255,255,.15); color: #fff; }
    .chat-sidebar .wa-btn {
        background: #25d366;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: .82rem;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: auto;
    }
    .chat-sidebar .wa-btn:hover { background: #1db954; color: #fff; }

    /* Main chat area */
    .chat-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #f8fafc;
        overflow: hidden;
    }

    .chat-main-header {
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        padding: 14px 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .chat-main-header .avatar {
        width: 40px; height: 40px;
        border-radius: 50%;
        background: var(--primary);
        color: var(--gold);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .chat-main-header .info h5 { margin: 0; font-size: .95rem; color: var(--primary); }
    .chat-main-header .info small { color: var(--gray); font-size: .78rem; }

    #full-chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 14px;
        scroll-behavior: smooth;
    }

    .full-chat-msg {
        display: flex;
        gap: 10px;
        align-items: flex-end;
        max-width: 70%;
    }
    .full-chat-msg.user { align-self: flex-end; flex-direction: row-reverse; }
    .full-chat-msg.assistant { align-self: flex-start; }

    .full-chat-msg .bubble {
        padding: 12px 16px;
        border-radius: 16px;
        font-size: .88rem;
        line-height: 1.6;
        white-space: pre-wrap;
        word-break: break-word;
    }
    .full-chat-msg.user .bubble {
        background: var(--primary);
        color: #fff;
        border-bottom-right-radius: 4px;
    }
    .full-chat-msg.assistant .bubble {
        background: #fff;
        color: var(--dark);
        border: 1px solid #e5e7eb;
        border-bottom-left-radius: 4px;
        box-shadow: 0 1px 4px rgba(0,0,0,.05);
    }
    .full-chat-msg .avatar-sm {
        width: 30px; height: 30px;
        border-radius: 50%;
        background: var(--primary);
        color: var(--gold);
        font-size: .7rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .typing-indicator .bubble {
        background: #fff;
        border: 1px solid #e5e7eb;
        padding: 12px 18px;
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

    .chat-main-footer {
        background: #fff;
        border-top: 1px solid #e5e7eb;
        padding: 16px 24px;
    }
    .chat-input-row {
        display: flex;
        gap: 10px;
        align-items: flex-end;
    }
    #full-chat-input {
        flex: 1;
        padding: 12px 16px;
        border: 1.5px solid #d1d5db;
        border-radius: 12px;
        font-size: .9rem;
        resize: none;
        max-height: 140px;
        line-height: 1.5;
        outline: none;
        font-family: inherit;
    }
    #full-chat-input:focus { border-color: var(--primary); }
    #full-chat-send {
        width: 46px; height: 46px;
        border-radius: 12px;
        background: var(--primary);
        color: #fff;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: background .2s;
        font-size: 1rem;
    }
    #full-chat-send:hover { background: var(--primary-light); }
    #full-chat-send:disabled { background: #d1d5db; cursor: not-allowed; }
</style>
@endpush

@section('content')
<div class="chat-page-wrap">

    {{-- Sidebar --}}
    <aside class="chat-sidebar">
        <div>
            <div class="brand">Mida AI Assistant</div>
            <p class="mt-2">Asisten properti virtual Midland yang siap membantu Anda 24/7 menemukan properti impian.</p>
        </div>

        <div>
            <p class="mb-2" style="font-size:.75rem;text-transform:uppercase;letter-spacing:1px;opacity:.5">Tanya cepat</p>
            <div class="d-flex flex-column gap-2">
                @foreach([
                    '🏠 Properti apa yang tersedia saat ini?',
                    '💰 Berapa harga apartemen termurah?',
                    '📍 Proyek mana yang lokasinya strategis?',
                    '🏦 Bagaimana cara mengajukan KPR?',
                    '📋 Apa saja dokumen yang dibutuhkan?',
                ] as $q)
                <button class="chat-starter-btn" onclick="fullChatSend('{{ $q }}')">{{ $q }}</button>
                @endforeach
            </div>
        </div>

        @php $wa = preg_replace('/\D/', '', \App\Models\Setting::get('social_whatsapp', '6281234567890')); @endphp
        <a href="https://wa.me/{{ $wa }}" target="_blank" class="wa-btn">
            <i class="bi bi-whatsapp"></i> Hubungi via WhatsApp
        </a>
    </aside>

    {{-- Chat main --}}
    <div class="chat-main">
        <div class="chat-main-header">
            <div class="avatar">M</div>
            <div class="info">
                <h5>Mida – Asisten Properti AI</h5>
                <small><span style="color:#22c55e">●</span> Online · Siap membantu Anda</small>
            </div>
            <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary ms-auto">
                <i class="bi bi-arrow-left me-1"></i> Beranda
            </a>
        </div>

        <div id="full-chat-messages">
            {{-- Welcome --}}
            <div class="full-chat-msg assistant">
                <div class="avatar-sm">M</div>
                <div class="bubble">Halo! 👋 Saya <strong>Mida</strong>, asisten virtual Midland Properti.<br><br>Saya bisa membantu Anda mencari properti, menjelaskan detail proyek, menghitung estimasi KPR, dan menjawab pertanyaan seputar properti.<br><br>Apa yang bisa saya bantu hari ini?</div>
            </div>
        </div>

        <div class="chat-main-footer">
            <div class="chat-input-row">
                <textarea id="full-chat-input" rows="1"
                    placeholder="Ketik pertanyaan Anda... (Enter untuk kirim, Shift+Enter untuk baris baru)"
                    maxlength="1000"></textarea>
                <button id="full-chat-send" onclick="fullChatSend()" aria-label="Kirim">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
            <p class="text-muted mt-2 mb-0" style="font-size:.72rem;text-align:center">
                Dijawab oleh AI · Selalu verifikasi informasi penting dengan tim kami
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const SESSION_KEY   = 'mida_session';
    const ENDPOINT_SEND = '{{ route("chat.send") }}';
    const ENDPOINT_HIST = '{{ route("chat.history") }}';
    const CSRF          = '{{ csrf_token() }}';

    let sessionId = localStorage.getItem(SESSION_KEY);
    if (!sessionId) {
        sessionId = 'chat_' + Math.random().toString(36).slice(2) + Date.now();
        localStorage.setItem(SESSION_KEY, sessionId);
    }

    let isBusy = false;

    // Load history on page open
    fetch(`${ENDPOINT_HIST}?session_id=${sessionId}`)
        .then(r => r.json())
        .then(data => {
            if (data.messages && data.messages.length > 0) {
                const box = document.getElementById('full-chat-messages');
                box.innerHTML = '';
                data.messages.forEach(m => appendMsg(m.role, m.content));
                scrollBottom();
            }
        })
        .catch(() => {});

    window.fullChatSend = function (preset = null) {
        if (isBusy) return;
        const input = document.getElementById('full-chat-input');
        const text  = preset ?? input.value.trim();
        if (!text) return;

        input.value = '';
        autoResize(input);

        appendMsg('user', text);
        const typingEl = appendTyping();
        setBusy(true);

        fetch(ENDPOINT_SEND, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
            },
            body: JSON.stringify({ message: text, session_id: sessionId }),
        })
        .then(r => {
            if (r.status === 429) throw new Error('rate_limit');
            return r.json();
        })
        .then(data => {
            typingEl.remove();
            appendMsg('assistant', data.reply ?? 'Maaf ada gangguan. Coba lagi.');
        })
        .catch(err => {
            typingEl.remove();
            const msg = err.message === 'rate_limit'
                ? 'Anda terlalu sering mengirim pesan (batas 5 pesan/menit). Harap tunggu sebentar sebelum mencoba lagi.'
                : 'Koneksi bermasalah. Silakan coba lagi atau hubungi kami via WhatsApp.';
            appendMsg('assistant', msg);
        })
        .finally(() => setBusy(false));
    };

    function appendMsg(role, content) {
        const box = document.getElementById('full-chat-messages');
        const wrap = document.createElement('div');
        wrap.className = 'full-chat-msg ' + role;
        if (role === 'assistant') {
            const av = document.createElement('div');
            av.className = 'avatar-sm';
            av.textContent = 'M';
            wrap.appendChild(av);
        }
        const bubble = document.createElement('div');
        bubble.className = 'bubble';
        bubble.textContent = content;
        wrap.appendChild(bubble);
        box.appendChild(wrap);
        scrollBottom();
        return wrap;
    }

    function appendTyping() {
        const box  = document.getElementById('full-chat-messages');
        const wrap = document.createElement('div');
        wrap.className = 'full-chat-msg assistant typing-indicator';
        const av = document.createElement('div');
        av.className = 'avatar-sm';
        av.textContent = 'M';
        const bubble = document.createElement('div');
        bubble.className = 'bubble';
        bubble.innerHTML = '<span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span>';
        wrap.appendChild(av);
        wrap.appendChild(bubble);
        box.appendChild(wrap);
        scrollBottom();
        return wrap;
    }

    function scrollBottom() {
        const box = document.getElementById('full-chat-messages');
        box.scrollTop = box.scrollHeight;
    }

    function setBusy(busy) {
        isBusy = busy;
        document.getElementById('full-chat-send').disabled = busy;
    }

    function autoResize(el) {
        el.style.height = 'auto';
        el.style.height = Math.min(el.scrollHeight, 140) + 'px';
    }

    const input = document.getElementById('full-chat-input');
    input.addEventListener('keydown', e => {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); fullChatSend(); }
    });
    input.addEventListener('input', () => autoResize(input));
    input.focus();
})();
</script>
@endpush
