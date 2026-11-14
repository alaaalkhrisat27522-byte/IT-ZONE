@extends('layouts.app')

@section('title', $room->name . ' — غرفة الدراسة')

@section('content')
<div class="container mx-auto px-6 py-10">

    <div id="connection-warning" style="display:none;" class="max-w-2xl mx-auto mb-6 p-4 rounded-lg border border-amber-400/30 bg-amber-400/10 text-amber-300 text-sm">
        ⚠️ خادم المزامنة غير شغّال — شغّل <code dir="ltr">node server.js</code> لتفعيل العداد المشترك!
    </div>

    <div class="text-center mb-8">
        <h1 class="text-3xl font-black text-white mb-2">⏱️ {{ $room->name }}</h1>
        <p class="text-[#94a3b8]">{{ $room->description }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">

        <!-- العداد -->
        <div class="lg:col-span-2 neon-card p-8 text-center">
            <div id="phase-label" class="inline-block px-5 py-2 rounded-full text-sm font-bold mb-6"
                    style="background: rgba(0,212,255,.15); color: #00d4ff;">🧠 وقت التركيز</div>

            <div class="relative w-64 h-64 mx-auto mb-8">
                <svg viewBox="0 0 200 200" class="w-full h-full -rotate-90">
                    <circle cx="100" cy="100" r="90" fill="none" stroke="rgba(255,255,255,.08)" stroke-width="10"/>
                    <circle id="ring" cx="100" cy="100" r="90" fill="none" stroke="url(#g)" stroke-width="10"
                            stroke-linecap="round" stroke-dasharray="565" stroke-dashoffset="0"/>
                    <defs>
                        <linearGradient id="g" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#00d4ff"/><stop offset="100%" stop-color="#bc13fe"/>
                        </linearGradient>
                    </defs>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div id="timer-text" class="text-5xl font-black text-white font-mono" dir="ltr">25:00</div>
                </div>
            </div>

            <div class="flex justify-center gap-3">
                <button id="btn-start" class="neon-btn px-8 py-3.5 font-bold"><i class="fa-solid fa-play ml-2"></i>تشغيل</button>
                <button id="btn-pause" class="px-8 py-3.5 rounded-lg border border-white/10 text-[#94a3b8] hover:text-white"><i class="fa-solid fa-pause ml-2"></i>إيقاف</button>
                <button id="btn-reset" class="px-8 py-3.5 rounded-lg border border-white/10 text-[#94a3b8] hover:text-white"><i class="fa-solid fa-rotate-right ml-2"></i>تصفير</button>
            </div>

            <div class="mt-6 text-sm text-[#94a3b8]">
                👥 المشاركون الآن: <span id="participants-count" class="neon-blue font-bold">0</span>
            </div>
        </div>

        <!-- الشات -->
        <div class="neon-card p-5 flex flex-col" style="height: 520px;">
            <h3 class="font-bold text-white mb-4"><i class="fa-solid fa-comments ml-2 neon-purple"></i>شات الغرفة</h3>
            <div id="chat-messages" class="flex-1 overflow-y-auto space-y-2.5 mb-4" style="max-height: 380px;"></div>
            <form id="chat-form" class="flex gap-2">
                <input id="chat-input" type="text" placeholder="اكتب رسالة..." class="neon-input flex-1 px-4 py-2.5 text-sm">
                <button class="neon-btn px-4 py-2.5 text-sm">إرسال</button>
            </form>
        </div>
    </div>
</div>

<script src="{{ env('SOCKET_URL', 'http://localhost:3001') }}/socket.io/socket.io.js"></script>
<script>
(function () {
    var roomId = {{ $room->id }};
    var userName = @json(auth()->user()->full_name ?? 'ضيف');
    var focusMinutes = {{ $room->focus_minutes }};
    var breakMinutes = {{ $room->break_minutes }};
    var totalSeconds = focusMinutes * 60;

    var timerText = document.getElementById('timer-text');
    var ring = document.getElementById('ring');
    var phaseLabel = document.getElementById('phase-label');
    var chatBox = document.getElementById('chat-messages');

    var socket = io('{{ env('SOCKET_URL', 'http://localhost:3001') }}', { transports: ['websocket', 'polling'] });

    socket.on('connect_error', function () {
        document.getElementById('connection-warning').style.display = 'block';
    });
    socket.on('connect', function () {
        document.getElementById('connection-warning').style.display = 'none';
        socket.emit('join', { roomId: roomId, name: userName, focus: focusMinutes, break: breakMinutes });
    });

    function renderTimer(state) {
        var m = Math.floor(state.secondsLeft / 60);
        var s = state.secondsLeft % 60;
        timerText.textContent = (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
        var progress = 1 - (state.secondsLeft / state.total);
        ring.style.strokeDashoffset = (565 * progress).toString();

        if (state.phase === 'focus') {
            phaseLabel.textContent = '🧠 وقت التركيز';
            phaseLabel.style.background = 'rgba(0,212,255,.15)';
            phaseLabel.style.color = '#00d4ff';
        } else {
            phaseLabel.textContent = '☕ وقت الراحة';
            phaseLabel.style.background = 'rgba(188,19,254,.15)';
            phaseLabel.style.color = '#bc13fe';
        }
    }

    socket.on('timer', renderTimer);

    socket.on('participants', function (names) {
        document.getElementById('participants-count').textContent = names.length;
    });

    socket.on('chat', function (msg) {
        var div = document.createElement('div');
        var isMe = msg.name === userName;
        div.style.cssText = 'padding: 8px 12px; border-radius: 12px; font-size: 13px; line-height: 1.7; max-width: 90%;' +
            (isMe ? 'align-self: flex-end; background: rgba(0,212,255,.2); margin-right: auto;'
                  : 'background: rgba(255,255,255,.06); margin-right: auto;');
        div.textContent = msg.name + ': ' + msg.text;
        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    });

    document.getElementById('btn-start').onclick = function () { socket.emit('control', { roomId: roomId, action: 'start' }); };
    document.getElementById('btn-pause').onclick = function () { socket.emit('control', { roomId: roomId, action: 'pause' }); };
    document.getElementById('btn-reset').onclick = function () { socket.emit('control', { roomId: roomId, action: 'reset' }); };

    document.getElementById('chat-form').onsubmit = function (e) {
        e.preventDefault();
        var input = document.getElementById('chat-input');
        var text = input.value.trim();
        if (!text) return;
        socket.emit('chat', { roomId: roomId, name: userName, text: text });
        input.value = '';
    };
})();
</script>
@endsection
