{{-- Chatbot Widget - King Gitar AI (Gemini-powered) --}}
{{-- Pure inline-CSS widget, works on all pages regardless of CSS framework --}}

{{-- Icons Library (added here to ensure it works on all pages) --}}
<script src="https://unpkg.com/@phosphor-icons/web"></script>

<div id="kg-chat-widget" style="position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;align-items:flex-end;font-family:'Poppins','Inter',sans-serif;">

    {{-- Chat Window --}}
    <div id="kg-chat-window" style="display:none;width:340px;max-width:calc(100vw - 16px);background:#fff;border-radius:24px;box-shadow:0 10px 40px rgba(0,0,0,0.15);border:1px solid #f0f0f0;overflow:hidden;margin-bottom:16px;transition:all 0.3s;flex-direction:column;max-height:520px;">

        {{-- Header --}}
        <div style="background:linear-gradient(135deg,#D4AF37,#B8960C);padding:20px;display:flex;justify-content:space-between;align-items:center;color:white;position:relative;overflow:hidden;">
            <div style="position:absolute;inset:0;opacity:0.1;background-image:radial-gradient(circle at 2px 2px,white 1px,transparent 0);background-size:16px 16px;"></div>
            <div style="display:flex;align-items:center;gap:12px;position:relative;z-index:1;">
                <div style="width:40px;height:40px;background:white;border-radius:12px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(0,0,0,0.1);padding:4px;">
                    <img src="{{ asset('Foto/Logo.png') }}" style="width:100%;height:100%;object-fit:contain;" alt="King Gitar">
                </div>
                <div>
                    <div style="font-weight:700;font-size:15px;letter-spacing:0.5px;font-family:'Playfair Display', serif;">KING GITAR AI</div>
                    <div style="font-size:11px;opacity:0.9;">Online, siap membantu!</div>
                </div>
            </div>
            <button onclick="toggleKgChat()" style="background:none;border:none;cursor:pointer;width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;opacity:0.8;transition:opacity 0.2s;position:relative;z-index:1;" onmouseover="this.style.background='rgba(255,255,255,0.15)'" onmouseout="this.style.background='none'">
                <i class="ph-bold ph-x" style="font-size:16px;"></i>
            </button>
        </div>


        {{-- Messages --}}
        <div id="kg-chat-messages" style="padding:20px;overflow-y:auto;background:#faf9f6;display:flex;flex-direction:column;gap:12px;min-height:200px;max-height:320px;">
            {{-- Welcome message --}}
            <div style="background:white;padding:16px;border-radius:0 16px 16px 16px;border:1px solid #f0f0f0;border-left:3px solid #D4AF37;font-size:13px;max-width:85%;box-shadow:0 1px 4px rgba(0,0,0,0.04);line-height:1.6;color:#374151;">
                Halo, Sobat Gitaris! 🎸 Saya asisten AI pintar dari King Gitar. Ada yang bisa saya bantu atau rekomendasikan untuk Anda hari ini?
            </div>
            {{-- Prompt recommendations --}}
            <div id="kg-chat-prompts" style="display:flex;flex-direction:column;gap:8px;">
                <p style="font-size:11px;color:#9ca3af;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin:4px 4px 0;">💡 Prompt Recommendations</p>
                <button onclick="kgSendPrompt('Rekomendasi gitar akustik pemula')" style="display:flex;align-items:center;gap:12px;width:100%;text-align:left;padding:12px;background:white;border:1px solid rgba(212,175,55,0.2);border-radius:12px;cursor:pointer;font-size:13px;font-weight:500;color:#374151;transition:all 0.25s;" onmouseover="this.style.borderColor='#D4AF37';this.style.boxShadow='0 2px 8px rgba(212,175,55,0.15)'" onmouseout="this.style.borderColor='rgba(212,175,55,0.2)';this.style.boxShadow='none'">
                    <span style="width:32px;height:32px;min-width:32px;background:#fff3ea;color:#ea580c;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;"><i class="ph-fill ph-fire"></i></span>
                    <span>Rekomendasi gitar akustik pemula</span>
                </button>
                <button onclick="kgSendPrompt('Perbedaan Telecaster dan Stratocaster')" style="display:flex;align-items:center;gap:12px;width:100%;text-align:left;padding:12px;background:white;border:1px solid rgba(212,175,55,0.2);border-radius:12px;cursor:pointer;font-size:13px;font-weight:500;color:#374151;transition:all 0.25s;" onmouseover="this.style.borderColor='#D4AF37';this.style.boxShadow='0 2px 8px rgba(212,175,55,0.15)'" onmouseout="this.style.borderColor='rgba(212,175,55,0.2)';this.style.boxShadow='none'">
                    <span style="width:32px;height:32px;min-width:32px;background:#eff6ff;color:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;"><i class="ph-fill ph-scales"></i></span>
                    <span>Perbedaan Telecaster & Stratocaster</span>
                </button>
            </div>
        </div>

        {{-- Input area --}}
        <div style="padding:16px;background:white;border-top:1px solid #f0f0f0;display:flex;align-items:center;gap:8px;">
            <input type="text" id="kg-chat-input" placeholder="Tanya saya apapun..." maxlength="1000"
                onkeydown="if(event.key==='Enter')kgSendMessage()"
                style="flex:1;background:#f9fafb;border:1.5px solid #e5e7eb;border-radius:12px;padding:12px 16px;font-size:13px;outline:none;transition:border 0.2s;font-family:inherit;color:#374151;"
                onfocus="this.style.borderColor='#D4AF37';this.style.boxShadow='0 0 0 3px rgba(212,175,55,0.1)'"
                onblur="this.style.borderColor='#e5e7eb';this.style.boxShadow='none'">
            <button id="kg-chat-send" onclick="kgSendMessage()"
                style="width:44px;height:44px;min-width:44px;background:#1a1a1a;color:white;border:none;border-radius:12px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background 0.2s;"
                onmouseover="this.style.background='#D4AF37'" onmouseout="this.style.background='#1a1a1a'">
                <i class="ph-fill ph-paper-plane-right" style="font-size:18px;"></i>
            </button>
        </div>
    </div>

    {{-- FAB button --}}
    <button onclick="toggleKgChat()" id="kg-chat-fab"
        style="width:64px;height:64px;background:#D4AF37;border:none;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.3s;position:relative;"
        onmouseover="this.style.background='#C5A028';this.style.transform='scale(1.1) translateY(-3px)'"
        onmouseout="this.style.background='#D4AF37';this.style.transform='scale(1) translateY(0)'">
        <i class="ph-fill ph-sparkle" id="kg-fab-sparkle" style="font-size:28px;color:white;transition:transform 0.5s;"></i>
        <span id="kg-chat-badge" style="position:absolute;top:2px;right:2px;width:14px;height:14px;background:#ef4444;border:2px solid white;border-radius:50%;display:block;"></span>
    </button> <!-- box-shadow:0 8px 30px rgba(212,175,55,0.45); -->
</div>

<style>
    #kg-chat-messages::-webkit-scrollbar { width: 4px; }
    #kg-chat-messages::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
    @keyframes kg-bounce { 0%,60%,100%{transform:translateY(0)} 30%{transform:translateY(-5px)} }
    .kg-dot { width:7px;height:7px;background:#bbb;border-radius:50%;display:inline-block;animation:kg-bounce 1.4s infinite; }
    .kg-dot:nth-child(2){animation-delay:.2s}
    .kg-dot:nth-child(3){animation-delay:.4s}
</style>

<script>
(function() {
    var kgHistory = [];
    var kgIsOpen = false;

    window.toggleKgChat = function() {
        var win = document.getElementById('kg-chat-window');
        var badge = document.getElementById('kg-chat-badge');
        kgIsOpen = !kgIsOpen;

        if (kgIsOpen) {
            win.style.display = 'flex';
            if (badge) badge.style.display = 'none';
            setTimeout(function() {
                document.getElementById('kg-chat-input').focus();
            }, 50);
        } else {
            win.style.display = 'none';
        }
    };

    window.kgSendPrompt = function(text) {
        var prompts = document.getElementById('kg-chat-prompts');
        if (prompts) prompts.remove();
        document.getElementById('kg-chat-input').value = text;
        kgSendMessage();
    };

    function kgAddMsg(text, isUser) {
        var container = document.getElementById('kg-chat-messages');
        var prompts = document.getElementById('kg-chat-prompts');
        if (prompts) prompts.remove();

        // Minimal markdown: **bold**, *italic*, newlines
        var html = text
            .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
            .replace(/\*\*(.+?)\*\*/g,'<strong>$1</strong>')
            .replace(/\*(.+?)\*/g,'<em>$1</em>')
            .replace(/\n/g,'<br>');

        var wrap = document.createElement('div');
        wrap.style.cssText = 'display:flex;' + (isUser ? 'justify-content:flex-end;' : '');

        var bubble = document.createElement('div');
        bubble.innerHTML = html;
        bubble.style.cssText = isUser
            ? 'background:#1a1a1a;color:white;padding:12px 16px;border-radius:16px 0 16px 16px;font-size:13px;max-width:85%;line-height:1.6;'
            : 'background:white;color:#374151;padding:12px 16px;border-radius:0 16px 16px 16px;font-size:13px;max-width:85%;border:1px solid #f0f0f0;border-left:3px solid #D4AF37;box-shadow:0 1px 4px rgba(0,0,0,0.04);line-height:1.6;';

        wrap.appendChild(bubble);
        container.appendChild(wrap);
        container.scrollTop = container.scrollHeight;
    }

    function kgShowTyping() {
        var container = document.getElementById('kg-chat-messages');
        var div = document.createElement('div');
        div.id = 'kg-typing';
        div.innerHTML = '<div style="background:white;padding:12px 18px;border-radius:0 16px 16px 16px;border:1px solid #f0f0f0;border-left:3px solid #D4AF37;display:inline-flex;align-items:center;gap:4px;"><span class=\'kg-dot\'></span><span class=\'kg-dot\'></span><span class=\'kg-dot\'></span></div>';
        container.appendChild(div);
        container.scrollTop = container.scrollHeight;
    }

    function kgRemoveTyping() {
        var el = document.getElementById('kg-typing');
        if (el) el.remove();
    }

    window.kgSendMessage = async function() {
        var input = document.getElementById('kg-chat-input');
        var sendBtn = document.getElementById('kg-chat-send');
        var message = input.value.trim();
        if (!message) return;

        input.value = '';
        input.disabled = true;
        sendBtn.disabled = true;
        sendBtn.style.opacity = '0.5';

        kgAddMsg(message, true);
        kgHistory.push({ role: 'user', text: message });
        kgShowTyping();

        try {
            var response = await fetch('/api/v1/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    message: message,
                    history: kgHistory.slice(-20),
                }),
            });

            kgRemoveTyping();
            var data = await response.json();

            if (data.success && data.data && data.data.reply) {
                kgAddMsg(data.data.reply, false);
                kgHistory.push({ role: 'model', text: data.data.reply });
            } else {
                kgAddMsg(data.message || 'Maaf, terjadi kesalahan. Silakan coba lagi. 😔', false);
            }
        } catch (err) {
            kgRemoveTyping();
            kgAddMsg('Tidak dapat terhubung ke server. Periksa koneksi internet Anda. 🌐', false);
        }

        input.disabled = false;
        sendBtn.disabled = false;
        sendBtn.style.opacity = '1';
        input.focus();
    };
})();
</script>
