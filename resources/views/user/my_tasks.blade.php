<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    @include('user.includes.general_style')
    <title>My Tasks</title>
    <style>
        .task-card { transition: all 0.2s; }
        .task-card:hover { transform: scale(1.02); }
        #taskModal { animation: fadeIn 0.3s; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body class="min-h-screen bg-[#0A0A0F]">

    <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

        @include('user.includes.top_greetings')

        <!-- MAIN CONTENT -->
        <div class="px-5 pt-6 pb-28 flex flex-col min-h-[60vh]">
@include('includes.success')

<!-- Earnings Stats Card -->
<div class="mb-6 px-1">
    <div class="bg-gradient-to-br from-gray-900/80 via-gray-950/90 to-black/80 rounded-2xl border border-gray-800/70 shadow-xl shadow-black/40 backdrop-blur-sm overflow-hidden">
        <div class="px-5 py-5 flex items-center justify-between relative">

            <!-- Today Earned -->
            <div class="text-center flex-1">
                <p class="text-xs uppercase tracking-wider text-gray-400 font-medium mb-1">Earned Today</p>
                <p class="text-2xl md:text-3xl font-bold text-emerald-400 tracking-tight">
                    Rs {{ number_format($earnedToday, 2) }}
                </p>
                <p class="text-xs text-gray-400 mt-1">Today: {{ $tasksCompletedToday }}</p>
            </div>

            <!-- Vertical Divider -->
            <div class="h-12 w-px bg-gradient-to-b from-transparent via-gray-700 to-transparent mx-3"></div>

            <!-- Total Earned -->
            <div class="text-center flex-1">
                <p class="text-xs uppercase tracking-wider text-gray-400 font-medium mb-1">Total Earned</p>
                <p class="text-2xl md:text-3xl font-bold text-emerald-400 tracking-tight">
                    Rs {{ number_format($earnedAll, 2) }}
                </p>
                <p class="text-xs text-gray-400 mt-1">All: {{ $tasksCompletedAll }}</p>
            </div>

            <!-- Optional subtle shine/glow effect layer -->
            <div class="absolute inset-0 pointer-events-none bg-gradient-to-br from-violet-500/5 via-transparent to-fuchsia-500/5 opacity-50"></div>
        </div>

        
    </div>
</div>

            @if($tasks->isEmpty())
               <div class="flex flex-col items-center text-center">
            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-900/40 to-indigo-900/30 flex items-center justify-center mb-6 border border-indigo-500/30 animate-pulse-slow">
                <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-white mb-3">Stay Tuned!</h2>
            <p class="text-gray-400 mb-8 max-w-md">
                More tasks are coming soon...<br>
                Come back a bit later or
            </p>

            <button onclick="location.reload()"
                    class="bg-gray-700 hover:bg-gray-600 text-white px-8 py-4 rounded-xl font-medium transition flex items-center gap-2 shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Refresh Now
            </button>

            <!-- Optional auto-refresh after 60–180 seconds -->
            <meta http-equiv="refresh" content="90">
        </div>
            @else
                <!-- TASKS GRID -->
                <div class="w-full">

@foreach($tasks as $task)
@php
    $ext = strtolower(pathinfo($task->file_path, PATHINFO_EXTENSION));
    $isVideo = in_array($ext, ['mp4', 'webm', 'ogg', 'mov', 'avi']);
@endphp

<div class="task-card relative bg-gradient-to-br from-gray-900 to-gray-800 rounded-3xl overflow-hidden cursor-pointer shadow-2xl border border-gray-800 active:scale-[0.98] transition-all duration-200"
     data-task-id="{{ $task->id }}"
     data-duration="{{ $task->duration }}"
     data-price="{{ $task->price }}"
     data-file-path="{{ asset($task->file_path) }}"
     data-name="{{ $task->name }}"
     onclick="openTask(this)">

    <!-- Reward Badge -->
    <div class="absolute top-4 right-4 z-10 bg-emerald-500 text-white text-sm font-bold px-4 py-1.5 rounded-full shadow-lg">
        + Rs {{ number_format($task->price, 0) }}
    </div>

    <!-- Thumbnail -->
    <div class="relative h-64 bg-black">
        @if($isVideo)
            <video src="{{ asset($task->file_path) }}"
                   class="w-full h-full object-cover"
                   muted loop playsinline></video>

            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-9 h-9 text-white"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132z" />
                    </svg>
                </div>
            </div>
        @else
            <img src="{{ asset($task->file_path) }}"
                 class="w-full h-full object-cover"
                 alt="{{ $task->name }}">
        @endif
    </div>

    <!-- Info Section -->
    <div class="p-6">

        <!-- Title -->
        <h3 class="text-white text-xl font-bold mb-4 leading-tight">
            {{ $task->name }}
        </h3>

        <!-- Duration + CTA -->
        <div class="flex items-center justify-between">

            <div class="flex items-center gap-2 text-gray-400 text-sm">
                <span>⏱</span>
                <span>{{ $task->duration }} seconds</span>
            </div>

            <div class="px-5 py-2 bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white text-sm font-semibold rounded-full shadow-lg">
                Start Task →
            </div>

        </div>
    </div>

    <!-- Glow Hover Effect -->
    <div class="absolute inset-0 rounded-3xl border border-transparent hover:border-violet-500/40 transition-all pointer-events-none"></div>
</div>

@endforeach

                </div>
            @endif
        </div>

        <!-- BOTTOM NAV -->
        @include('user.includes.bottom_navigation')

    </div>

    <!-- TASK MODAL -->
<div id="taskModal"
     class="fixed inset-0 bg-black/95 hidden z-[100] flex items-end justify-center sm:items-center p-0 sm:p-4">

    <div class="bg-[#0A0A0F] w-full max-w-[420px] 
                h-[100dvh] sm:h-auto sm:max-h-[90vh]
                rounded-t-3xl sm:rounded-3xl
                shadow-2xl flex flex-col overflow-hidden">

        <!-- HEADER -->
        <div class="flex-shrink-0 flex items-center justify-between px-6 py-4 border-b border-gray-800">
                <button onclick="closeTaskModal()" class="text-white p-2 -ml-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <div id="modalTitle" class="font-bold text-white text-lg"></div>
                <div class="w-6"></div>
            </div>

            <!-- MEDIA -->
            <div id="mediaContainer" class="flex-1 bg-black flex items-center justify-center overflow-hidden">
                <!-- JS inserts img/video here -->
            </div>

            <!-- TIMER -->
            <div class="px-6 py-8 bg-gradient-to-b from-transparent to-[#0A0A0F]">
                <div id="timer" class="text-5xl md:text-6xl font-mono font-bold text-center text-white tracking-widest mb-6">00:00</div>
                <div class="w-full h-1.5 bg-gray-800 rounded-full overflow-hidden">
                    <div id="progress" class="h-full bg-gradient-to-r from-violet-500 to-fuchsia-500 w-0 transition-all"></div>
                </div>
                <p class="text-center text-gray-400 text-sm mt-3">Complete to earn reward</p>
            </div>

            <!-- CLAIM SECTION (hidden until done) -->
            <div id="claimSection" class="hidden px-6 py-8 border-t border-gray-800">
                <div class="text-center">
                    <div class="text-emerald-400 text-4xl mb-2">🎉</div>
                    <div class="text-2xl font-bold text-white mb-1">Task Completed!</div>
                    <div class="text-4xl font-bold text-emerald-400 mb-8">+ Rs<span id="rewardAmount"></span></div>
                    
                    <div class="flex gap-3">
                        <button onclick="closeTaskModal()" 
                                class="flex-1 py-4 text-white bg-gray-800 hover:bg-gray-700 rounded-2xl font-semibold text-lg">
                            Close
                        </button>
                        <button onclick="claimReward()" 
                                class="flex-1 py-4 text-white bg-gradient-to-r from-emerald-500 to-cyan-500 hover:brightness-110 rounded-2xl font-semibold text-lg">
                            Claim Reward
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentTask = null;
        let timerInterval = null;
        let startTime = null;

function openTask(el) {
    currentTask = {
        id: el.dataset.taskId,
        filePath: el.dataset.filePath,
        duration: parseInt(el.dataset.duration),
        price: parseFloat(el.dataset.price),
        name: el.dataset.name
    };

    // Immediately show loading or disable card
    el.style.opacity = '0.6';
    el.style.pointerEvents = 'none';

    fetch(`/tasks/${currentTask.id}/start`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(r => {
        if (!r.ok) throw new Error('Start failed');
        return r.json();
    })
    .then(data => {
        if (!data.success) {
            showToast(data.message || 'Could not start task', 'error');
            // Re-enable card
            el.style.opacity = '1';
            el.style.pointerEvents = 'auto';
            return;
        }

        // ONLY NOW open modal and start client timer
        document.getElementById('taskModal').classList.remove('hidden');
        document.getElementById('modalTitle').textContent = currentTask.name;
        document.getElementById('claimSection').classList.add('hidden');
        document.getElementById('rewardAmount').textContent = currentTask.price;
        

        

                // Load media
                const container = document.getElementById('mediaContainer');
                container.innerHTML = '';

                const ext = currentTask.filePath.split('.').pop().toLowerCase();
                const isVideo = ['mp4','webm','ogg','mov','avi'].includes(ext);

                if (isVideo) {
                    const vid = document.createElement('video');
                    vid.src = currentTask.filePath;
                    vid.className = 'w-full h-full object-contain';
                    vid.autoplay = true;
                    vid.muted = true;
                    vid.playsInline = true;
                    container.appendChild(vid);
                } else {
                    const img = document.createElement('img');
                    img.src = currentTask.filePath;
                    img.className = 'w-full h-full object-contain';
                    container.appendChild(img);
                }

                // Start timer
                startTimer(currentTask.duration);
    })
    .catch(err => {
        console.error(err);
        showToast('Failed to start task. Please try again.', 'error');
        el.style.opacity = '1';
        el.style.pointerEvents = 'auto';
    });
}

        function startTimer(totalSeconds) {
    if (timerInterval) clearInterval(timerInterval);

    let timeLeft = totalSeconds;
    let paused = false;
    let pauseStart = 0;

    startTime = Date.now();
    const timerEl = document.getElementById('timer');
    const progressEl = document.getElementById('progress');

    function updateTimer() {
        const now = Date.now();
        const elapsed = Math.floor((now - startTime) / 1000);

        timeLeft = Math.max(0, totalSeconds - elapsed);
        const mins = Math.floor(timeLeft / 60);
        const secs = timeLeft % 60;

        timerEl.textContent = `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        const percent = Math.min(100, ((totalSeconds - timeLeft) / totalSeconds) * 100);
        progressEl.style.width = `${percent}%`;

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            document.getElementById('rewardAmount').textContent = currentTask.price;
            document.getElementById('claimSection').classList.remove('hidden');
        }
    }

    // Main interval (runs every 250ms)
    timerInterval = setInterval(() => {
        if (!paused) updateTimer();
    }, 250);

    // Listen for tab visibility changes
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            // Pause timer
            paused = true;
            pauseStart = Date.now();
        } else {
            // Resume timer
            paused = false;
            const pauseDuration = Math.floor((Date.now() - pauseStart) / 1000);
            startTime += pauseDuration * 1000; // adjust startTime to account for pause
        }
    });
}


        function closeTaskModal() {
            document.getElementById('taskModal').classList.add('hidden');
            if (timerInterval) clearInterval(timerInterval);
        }

        function claimReward() {
            fetch(`/tasks/${currentTask.id}/claim`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showToast(`🎉 Reward claimed! + Rs${currentTask.price}`, 'success');
                    closeTaskModal();
                    location.reload(); // Refresh to remove claimed task
                } else {
                    alert(data.message || 'Failed to claim');
                }
            });
        }

        // Close modal on ESC
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeTaskModal();
        });
    </script>

    

    <script>
        lucide.createIcons();
    </script>
</body>
</html>