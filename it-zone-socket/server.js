// ===== خادم المزامنة المباشرة — IT Zone Study Rooms =====
const express = require('express');
const http = require('http');
const { Server } = require('socket.io');

const app = express();
const server = http.createServer(app);
const io = new Server(server, { cors: { origin: '*' } });

// حالة كل غرفة بالذاكرة
const rooms = new Map();

function getRoom(roomId) {
    if (!rooms.has(roomId)) {
        rooms.set(roomId, {
            phase: 'focus',
            secondsLeft: 25 * 60,
            total: 25 * 60,
            running: false,
            settings: { focus: 25, break: 5 },
            participants: new Map(),
        });
    }
    return rooms.get(roomId);
}

// نبضة كل ثانية — تبعت الحالة للجميع
setInterval(() => {
    for (const [roomId, room] of rooms) {
        if (!room.running || room.secondsLeft <= 0) continue;

        room.secondsLeft--;

        if (room.secondsLeft === 0) {
            // تبديل المرحلة تلقائياً
            room.phase = room.phase === 'focus' ? 'break' : 'focus';
            room.total = (room.phase === 'focus' ? room.settings.focus : room.settings.break) * 60;
            room.secondsLeft = room.total;
        }

        io.to(String(roomId)).emit('timer', {
            phase: room.phase,
            secondsLeft: room.secondsLeft,
            total: room.total,
            running: room.running,
        });
    }
}, 1000);

io.on('connection', (socket) => {
    console.log('🟢 متصل:', socket.id);

    socket.on('join', ({ roomId, name, focus, break: breakMin }) => {
        const room = getRoom(roomId);
        room.settings = { focus: focus || 25, break: breakMin || 5 };
        room.participants.set(socket.id, name || 'ضيف');

        socket.join(String(roomId));

        // ابعت الحالة الحالية للعضو الجديد
        socket.emit('timer', {
            phase: room.phase,
            secondsLeft: room.secondsLeft,
            total: room.total,
            running: room.running,
        });

        // تحديث عدد المشاركون للجميع
        io.to(String(roomId)).emit('participants', [...room.participants.values()]);
        console.log(`👤 ${name} دخل الغرفة ${roomId}`);
    });

    socket.on('control', ({ roomId, action }) => {
        const room = getRoom(roomId);

        if (action === 'start') room.running = true;
        if (action === 'pause') room.running = false;
        if (action === 'reset') {
            room.running = false;
            room.phase = 'focus';
            room.total = room.settings.focus * 60;
            room.secondsLeft = room.total;
        }

        io.to(String(roomId)).emit('timer', {
            phase: room.phase,
            secondsLeft: room.secondsLeft,
            total: room.total,
            running: room.running,
        });
    });

    socket.on('chat', ({ roomId, name, text }) => {
        io.to(String(roomId)).emit('chat', { name, text });
    });

    socket.on('disconnecting', () => {
        for (const roomId of socket.rooms) {
            const room = rooms.get(roomId);
            if (room) {
                room.participants.delete(socket.id);
                io.to(roomId).emit('participants', [...room.participants.values()]);
            }
        }
    });
});
// صفحة تحقق للمضيف
app.get('/', (req, res) => res.send('IT Zone Socket OK'));

const PORT = 3001;
server.listen(PORT, () => {
    console.log(`⚡ خادم IT Zone المباشر شغّال على المنفذ ${PORT}`);
});
