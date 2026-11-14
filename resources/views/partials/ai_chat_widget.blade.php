{{-- زر ومحادثة المساعد الذكي — تظهر بكل الصفحات --}}

<button id="ai-chat-toggle"
        style="position: fixed; bottom: 1.5rem; left: 1.5rem; z-index: 60; width: 60px; height: 60px; border-radius: 50%;
               background: linear-gradient(135deg, #00d4ff, #bc13fe); color: #05050a; font-size: 26px; border: none;
               cursor: pointer; box-shadow: 0 0 30px rgba(0,212,255,.5);">
    🤖
</button>

<div id="ai-chat-panel"
     style="display: none; position: fixed; bottom: 6rem; left: 1.5rem; z-index: 60; width: 360px; max-width: calc(100vw - 3rem);
            height: 520px; max-height: calc(100vh - 8rem); border-radius: 18px; overflow: hidden;
            background: linear-gradient(160deg, #0d1022, #12162f); border: 1px solid rgba(0,212,255,.35);
            box-shadow: 0 0 50px rgba(0,212,255,.25); display: none; flex-direction: column;">

    <div style="padding: 16px 18px; border-bottom: 1px solid rgba(0,212,255,.15); display: flex; align-items: center; gap: 10px;">
        <div style="width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #00d4ff, #bc13fe);
                    display: flex; align-items: center; justify-content: center;">🤖</div>
        <div>
            <div style="font-weight: 700; color: #fff; font-size: 14px;">مساعد IT Zone الذكي</div>
            <div style="font-size: 11px; color: #8b93b8;">اسألني أي شي عن دراستك ✨</div>
        </div>
    </div>

    <div id="ai-chat-messages" style="flex: 1; overflow-y: auto; padding: 16px; display: flex; flex-direction: column; gap: 10px;">
        <div class="ai-bubble-bot" style="align-self: flex-start; max-width: 85%; background: rgba(0,212,255,.12); border: 1px solid rgba(0,212,255,.25);
             color: #e2e8f0; padding: 10px 14px; border-radius: 14px 14px 14px 4px; font-size: 13px; line-height: 1.8;">
            مرحباً! 👋 أنا مساعد IT Zone — اسألني عن المواد، المتطلبات، الشروحات، أو أي شي بالمنصة!
        </div>
    </div>

    <form id="ai-chat-form" style="padding: 12px; border-top: 1px solid rgba(0,212,255,.15); display: flex; gap: 8px;">
        <input id="ai-chat-input" type="text" placeholder="اكتب سؤالك..." autocomplete="off"
               style="flex: 1; background: rgba(5,5,10,.7); border: 1px solid rgba(0,212,255,.25); border-radius: 12px;
                      color: #e2e8f0; padding: 11px 14px; font-size: 13px; outline: none; font-family: inherit;">
        <button type="submit"
                style="background: linear-gradient(135deg, #00d4ff, #bc13fe); color: #05050a; border: none; border-radius: 12px;
                       padding: 0 16px; font-weight: 700; cursor: pointer;">إرسال</button>
    </form>
</div>

<script>
(function () {
    var toggle = document.getElementById('ai-chat-toggle');
    var panel = document.getElementById('ai-chat-panel');
    var form = document.getElementById('ai-chat-form');
    var input = document.getElementById('ai-chat-input');
    var messages = document.getElementById('ai-chat-messages');
    var history = [];
    var busy = false;

    toggle.addEventListener('click', function () {
        var open = panel.style.display === 'flex';
        panel.style.display = open ? 'none' : 'flex';
        toggle.textContent = open ? '🤖' : '✕';
        if (!open) input.focus();
    });

    function addBubble(text, isUser) {
        var div = document.createElement('div');
        div.textContent = text;
        div.style.cssText = 'max-width: 85%; padding: 10px 14px; border-radius: 14px 14px ' +
            (isUser ? '4px 14px' : '14px 4px') + '; font-size: 13px; line-height: 1.8; white-space: pre-wrap; word-break: break-word;' +
            (isUser
                ? 'align-self: flex-end; background: linear-gradient(135deg, rgba(0,212,255,.35), rgba(188,19,254,.35)); color: #fff;'
                : 'align-self: flex-start; background: rgba(0,212,255,.12); border: 1px solid rgba(0,212,255,.25); color: #e2e8f0;');
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
        return div;
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        var text = input.value.trim();
        if (!text || busy) return;

        busy = true;
        input.value = '';
        addBubble(text, true);

        var typing = addBubble('يكتب الآن... ⏳', false);

        try {
            var res = await fetch('/api/ai-assistant/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ message: text, history: history.slice(-8) })
            });

            var data = await res.json();
            typing.remove();

            if (data.reply) {
                addBubble(data.reply, false);
                history.push({ role: 'user', text: text }, { role: 'model', text: data.reply });
            } else {
                addBubble('⚠️ صار خطأ — جرّب مرة ثانية.', false);
            }
        } catch (err) {
            typing.remove();
            addBubble('⚠️ تعذر الاتصال — تأكد إن السيرفر شغّال.', false);
        }

        busy = false;
    });
})();
</script>
