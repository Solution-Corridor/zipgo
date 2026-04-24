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
                    <div class="px-5 py-2 flex items-center justify-between relative">

                        <!-- Remaining Tasks -->
                        <div class="text-center flex-1">
                            <p class="text-xs uppercase tracking-wider text-gray-400 font-medium mb-1">Remaining Tasks</p>
                            <p class="text-lg md:text-xl font-bold text-emerald-400 tracking-tight">
                                {{ $remainingTasks }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">out of {{ $tasksNum }}</p>
                        </div>

                        <!-- Vertical Divider -->
                        <div class="h-12 w-px bg-gradient-to-b from-transparent via-gray-700 to-transparent mx-3"></div>

                        <!-- Today Earned -->
                        <div class="text-center flex-1">
                            <p class="text-xs uppercase tracking-wider text-gray-400 font-medium mb-1">Earned Today</p>
                            <p class="text-lg md:text-lg font-bold text-emerald-400 tracking-tight">
                                Rs {{ number_format($earnedToday, 0) }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">Tasks: {{ $tasksCompletedToday }}</p>
                        </div>

                        <!-- Vertical Divider -->
                        <div class="h-12 w-px bg-gradient-to-b from-transparent via-gray-700 to-transparent mx-3"></div>

                        <!-- Total Earned -->
                        <div class="text-center flex-1">
                            <p class="text-xs uppercase tracking-wider text-gray-400 font-medium mb-1">Total Earned</p>
                            <p class="text-lg md:text-lg font-bold text-emerald-400 tracking-tight">
                                Rs {{ number_format($earnedAll, 0) }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">All: {{ $tasksCompletedAll }}</p>
                        </div>

                        <div class="absolute inset-0 pointer-events-none bg-gradient-to-br from-violet-500/5 via-transparent to-fuchsia-500/5 opacity-50"></div>
                    </div>
                </div>
            </div>


        <div class="flex justify-end mb-4">
            <button onclick="location.reload()"
                    class="bg-blue-700 hover:bg-blue-600 text-white px-4 py-2 rounded-xl font-medium transition flex items-center gap-2 shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Refresh Tasks
            </button>
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

                    <meta http-equiv="refresh" content="90">
                </div>
            @else

            

                <!-- TASKS GRID -->
                <div class="grid grid-cols-2 gap-4 w-full">

                    @foreach($tasks as $task)
                        @php
                            $ext = strtolower(pathinfo($task->file_path, PATHINFO_EXTENSION));
                            $isVideo = in_array($ext, ['mp4', 'webm', 'ogg', 'mov', 'avi']);
                        @endphp

                        

                        <div class="task-card relative bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl overflow-hidden shadow-lg border border-gray-800 transition-all duration-200
                                    {{ $task->status !== 'active' ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer active:scale-[0.98]' }}"
                             data-task-id="{{ $task->id }}"
                             data-duration="{{ $task->duration }}"
                             data-price="{{ $task->task_price ?? $perTaskPrice }}"
                             data-file-path="{{ asset($task->file_path) }}"
                             data-name="{{ $task->name }}"
                             @if($task->status === 'active')
                                 onclick="openTask(this)"
                             @endif>

                            <!-- Reward Badge -->
                            <div class="absolute top-2 right-2 z-10 bg-emerald-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-md">
                                Rs {{ number_format($task->task_price ?? $perTaskPrice, 0) }}
                            </div>

                            <!-- Thumbnail / Video -->
                            <div class="relative h-32 bg-black">
                                @if($isVideo)
                                    <video src="{{ asset($task->file_path) }}"
                                           class="w-full h-full object-cover"
                                           muted loop playsinline></video>
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                        <div class="w-8 h-8 bg-white/20 backdrop-blur rounded-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132z" />
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
                            <div class="p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2 text-gray-400 text-xs">
                                        <span>⏱</span>
                                        <span>{{ $task->duration }} sec</span>
                                    </div>

                                    @if($task->status === 'active')
                                        <div class="px-3 py-1 bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white text-xs font-semibold rounded-full shadow-md">
                                            Start
                                        </div>
                                    @else
                                        <div class="px-3 py-1 bg-gray-700 text-gray-400 text-xs font-semibold rounded-full shadow-md">
                                            {{ $task->status === 'locked' ? 'Locked' : 'Claimed' }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Overlays -->
                            @if($task->status === 'claimed_today')
                                <div class="absolute inset-0 bg-black/70 flex items-center justify-center z-20 flex-col gap-2">
                                    <svg class="w-12 h-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-white font-medium text-sm">Claimed Today</span>
                                </div>
                            <!-- Inside locked overlay, you can keep it or remove $loop->first condition -->
            @elseif($task->status === 'locked')
                <div class="absolute inset-0 bg-black/70 flex items-center justify-center z-20 flex-col gap-3">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>

                    <!-- Optional: keep per-task countdown only if you want -->
                    @if($timeLeftToNext > 0 && $loop->first)
                        <div class="text-center text-white px-3 py-2">
                            <div class="text-sm font-medium mb-1 opacity-90">Next in</div>
                            <div class="text-lg font-bold tracking-wide text-emerald-400" id="globalCountdown">
                                calculating...
                            </div>
                        </div>
                    @else
                        <span class="text-gray-300 text-sm">Locked</span>
                    @endif
                </div>
            @endif

                            <!-- Glow only for active -->
                            @if($task->status === 'active')
                                <div class="absolute inset-0 rounded-2xl border border-transparent hover:border-violet-500/40 transition-all pointer-events-none"></div>
                            @endif

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

            <!-- ← New fake views line -->
    <div class="text-center mb-4">
        <p class="text-sm text-gray-300">
            <span class="font-bold text-violet-400" id="fakeViews">5,247</span> views
        </p>
    </div>

                <div id="timer" class="text-2xl md:text-2xl font-mono font-bold text-center text-white tracking-widest mb-6">00:00</div>
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
// Global countdown (shown at top when cooldown active)
@if($timeLeftToNext > 0)
    let timeLeft = Math.floor({{ $timeLeftToNext }});

    function formatTimeLeftGlobal(seconds) {
        if (seconds <= 0) return "Now!";

        const h = Math.floor(seconds / 3600);
        const m = Math.floor((seconds % 3600) / 60);
        const s = seconds % 60;

        let str = '';
        if (h > 0) str += h + (h === 1 ? 'h ' : 'h ');
        if (m > 0 || h > 0) str += m.toString().padStart(2, '0') + 'm ';
        str += s.toString().padStart(2, '0') + 's';

        return str.trim();
    }

    function updateGlobalCountdown() {
        const el = document.getElementById('globalCountdown');
        if (!el) return;

        el.textContent = formatTimeLeftGlobal(timeLeft);

        if (timeLeft <= 0) {
            el.textContent = "Now!";
            setTimeout(() => location.reload(), 1500);
            return;
        }

        timeLeft -= 1;
    }

    updateGlobalCountdown();
    const globalTimer = setInterval(() => {
        updateGlobalCountdown();
        if (timeLeft <= 0) clearInterval(globalTimer);
    }, 1000);
@endif
</script>

    <script>
        let currentTask = null;
        let timerInterval = null;
        let startTime = null;

        

        function openTask(el) {
    //         alert("CLICK DETECTED!\nTask ID: " + el.dataset.taskId + "\nName: " + el.dataset.name);
    // console.log("openTask called with element:", el);
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
                },
                body: JSON.stringify({
            price: currentTask.price                     // ← send the displayed price
        })
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

                // ── NEW: Generate fake view count when modal opens ─────────────────
        const baseViews = Math.floor(Math.random() * 4000) + 5200;     // 5200–9200
        // or more dramatic:  Math.floor(Math.random() * 15000) + 8000;  // 8000–23000
        document.getElementById('fakeViews').textContent = baseViews.toLocaleString();

        // Optional: animate the number counting up a bit (looks more real)
        animateCounter('fakeViews', 4200, baseViews, 1800); // from 4200 → real number in 1.8s

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

        // Optional: nice counting animation
function animateCounter(id, start, end, duration) {
    const obj = document.getElementById(id);
    if (!obj) return;

    let startTime = null;
    const step = (timestamp) => {
        if (!startTime) startTime = timestamp;
        const progress = Math.min((timestamp - startTime) / duration, 1);
        const current = Math.floor(progress * (end - start) + start);
        obj.textContent = current.toLocaleString();
        if (progress < 1) {
            requestAnimationFrame(step);
        } else {
            obj.textContent = end.toLocaleString();
        }
    };
    requestAnimationFrame(step);
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
            
            // Wait 2.5 seconds before reload – DB needs time to settle
            setTimeout(() => {
                location.reload();
            }, 2500);
        } else {
            alert(data.message || 'Failed to claim');
        }
    })
    .catch(() => {
        alert('Failed to claim');
    });
}

        // Close modal on ESC
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeTaskModal();
        });
   
    </script>

    
</body>
</html>