<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('user.includes.general_style')
    <title>My Tasks</title>
    <style>
        .task-card {
            transition: all 0.2s;
        }

        .task-card:not(.locked):hover {
            transform: scale(1.02);
        }

        .locked {
            opacity: 0.5;
            pointer-events: none;
        }

        #taskModal {
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-[#0A0A0F]">

    <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

        @include('user.includes.top_greetings')

        <!-- MAIN CONTENT -->
        <div class="px-5 pt-6 pb-28 flex flex-col min-h-[60vh]">
            @include('includes.success')

            <!-- Earnings Stats Card -->
            <div class="mb-4 px-1">
                <div class="bg-gradient-to-br from-gray-900/80 via-gray-950/90 to-black/80 
                rounded-2xl border border-gray-800/70 shadow-xl shadow-black/40 
                backdrop-blur-sm overflow-hidden">
                    <div class="px-4 py-1 flex items-center justify-between relative gap-3">

                        <!-- Remaining Tasks -->
                        <div class="text-center flex-1">
                            <p class="text-[10px] uppercase tracking-wider text-gray-400 font-medium mb-0.5">Remaining</p>
                            <p class="text-lg md:text-lg font-bold text-emerald-400 tracking-tight">
                                {{ max(0, $totalDailyTasks - $todayClaimedCount) }}
                            </p>
                            <p class="text-[10px] text-gray-400 mt-0.5">out of {{$totalDailyTasks}}</p>
                        </div>

                        <!-- Vertical Divider -->
                        <div class="h-10 w-px bg-gradient-to-b from-transparent via-gray-700 to-transparent"></div>

                        <!-- Today Earned -->
                        <div class="text-center flex-1">
                            <p class="text-[10px] uppercase tracking-wider text-gray-400 font-medium mb-0.5">Earned</p>
                            <p class="text-lg md:text-lg font-bold text-emerald-400 tracking-tight">
                                Rs {{number_format($todayClaimedAmount,0)}}
                            </p>
                            <p class="text-[10px] text-gray-400 mt-0.5">Tasks: {{$todayClaimedCount}}</p>
                        </div>

                        <!-- Vertical Divider -->
                        <div class="h-10 w-px bg-gradient-to-b from-transparent via-gray-700 to-transparent"></div>

                        <!-- Active Plans -->
                        <div class="text-center flex-1">
                            <p class="text-[10px] uppercase tracking-wider text-gray-400 font-medium mb-0.5">Active Plans</p>
                            <p class="text-lg md:text-lg font-bold text-emerald-400 tracking-tight">
                                {{$activePayments->count()}}
                            </p>
                        </div>

                        <!-- Background Glow -->
                        <div class="absolute inset-0 pointer-events-none 
                        bg-gradient-to-br from-violet-500/5 via-transparent to-fuchsia-500/5 opacity-50"></div>
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

            @if($allTasks->isEmpty())
            <div class="flex flex-col items-center text-center mt-12">
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-900/40 to-indigo-900/30 flex items-center justify-center mb-6 border border-indigo-500/30 animate-pulse-slow">
                    <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white mb-3">No Tasks Available</h2>
                <p class="text-gray-400">Check your active plans or wait for more tasks to become available.</p>
            </div>
            @else
            <!-- Hidden data for first-task timer (only when locked) -->
            @if(!$canClaimNow)
            @php $firstTask = $allTasks->first(); @endphp
            @if($firstTask)
            <div class="hidden" id="firstTaskTimerData" data-time-left="{{ $timeLeftToNext }}"></div>
            @endif
            @endif

            <!-- TASKS GRID -->
            <div class="grid grid-cols-2 gap-4 w-full">
                @foreach($allTasks as $task)
                @php
                $ext = strtolower(pathinfo($task->file_path ?? '', PATHINFO_EXTENSION));
                $isVideo = in_array($ext, ['mp4', 'webm', 'ogg', 'mov', 'avi']);
                @endphp

                <div class="task-card relative bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl overflow-hidden shadow-lg border border-gray-800
{{ ($loop->first && $canClaimNow) ? 'cursor-pointer active:scale-[0.98]' : 'locked' }}"
                    data-task-id="{{ $task->id }}"
                    data-duration="{{ $task->duration ?? 30 }}"
                    data-price="{{ $task->task_price }}"
                    data-package-id="{{ $task->package_id ?? '' }}"
                    data-payment-id="{{ $task->payment_id ?? '' }}"
                    data-file-path="{{ asset($task->file_path) }}"
                    data-name="{{ $task->name ?? 'Task #' . $task->id }}"
                    onclick="{{ ($loop->first && $canClaimNow) ? 'openTask(this)' : 'event.preventDefault()' }}">

                    <!-- Reward Badge -->
                    <div class="absolute top-2 right-2 z-10 bg-emerald-600 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-md">
                        Rs {{ number_format($task->task_price, 0) }}
                    </div>

                    <!-- Thumbnail / Video -->
                    <div class="relative h-32 bg-black">
                        @if($isVideo)
                        <video src="{{ asset($task->file_path) }}"
                            class="w-full h-full object-cover"
                            muted loop playsinline autoplay></video>
                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                            <svg class="w-10 h-10 text-white/70" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </div>
                        @else
                        <img src="{{ asset($task->file_path) }}"
                            class="w-full h-full object-cover"
                            alt="{{ $task->name ?? 'Task' }}">
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="p-3">
                        <div class="flex items-center justify-between text-xs text-gray-300">
                            <div class="flex items-center gap-1.5">
                                <span>⏱</span>
                                <span>{{ $task->duration ?? '?' }} sec</span>
                            </div>
                            <span class="text-emerald-400 font-medium">Start →</span>
                        </div>
                    </div>

                    <!-- Timer on first card when locked -->
                    @if($loop->first && !$canClaimNow)
                    <div class="absolute top-2 left-2 z-20
            bg-black/70 text-emerald-400 text-xs font-semibold
            px-2 py-1 rounded-md"
                        id="firstTaskTimer">
                        calculating...
                    </div>
                    @endif

                    @if(!$loop->first || !$canClaimNow)
                    <div class="absolute inset-0 flex items-center justify-center bg-black/40">
                        🔒 Locked
                    </div>
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

            </div>

            <!-- Inside mediaContainer or as overlay -->
            <div id="soundToggle" class="absolute top-4 right-4 bg-black/60 text-white px-3 py-1.5 rounded-2xl text-sm flex items-center gap-2 cursor-pointer hidden">
                <span id="soundIcon">🔇</span>
                <span id="soundText">Sound Off</span>
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
                <div class="flex items-center justify-between mt-3">

                    <p class="text-gray-400 text-sm">
                        Complete to earn reward
                    </p>

                    <button onclick="closeTaskModal()"
                        class="text-white text-sm bg-gray-800 hover:bg-gray-700 px-3 py-1.5 rounded-lg">
                        ✕
                    </button>

                </div>
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
                        <button id="claimBtn"
                            onclick="claimReward(this)"
                            class="flex-1 py-4 text-white bg-gradient-to-r from-emerald-500 to-cyan-500 
               hover:brightness-110 rounded-2xl font-semibold text-lg
               disabled:opacity-60 disabled:cursor-not-allowed disabled:hover:brightness-100">
                            Claim Reward
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>

// ───────────────── FIRST TASK COOLDOWN TIMER ─────────────────
@if(!$canClaimNow && isset($firstTask) && $timeLeftToNext > 0)
let timeLeft = Math.floor({{ $timeLeftToNext }});
const timerEl = document.getElementById('firstTaskTimer');

function formatTimeLeft(seconds) {
    if (seconds <= 0) return "Now!";
    const m = Math.floor(seconds / 60);
    const s = seconds % 60;
    return `Next ${m}m ${s.toString().padStart(2,'0')}s`;
}

function updateFirstTaskTimer(){
    if(!timerEl) return;
    timerEl.textContent = formatTimeLeft(timeLeft);
    if(timeLeft <= 0){
        location.reload();
        return;
    }
    timeLeft--;
}

updateFirstTaskTimer();
setInterval(updateFirstTaskTimer, 1000);
@endif

// ───────────────── TASK SYSTEM ─────────────────
let currentTask = null;
let timerInterval = null;
let currentVideo = null;   // Store reference to current video

let remainingTime = 0;
let totalDuration = 0;
let timerPaused = false;

// OPEN TASK
function openTask(el){
    currentTask = {
        id: el.dataset.taskId,
        filePath: el.dataset.filePath,
        duration: parseInt(el.dataset.duration),
        price: parseFloat(el.dataset.price),
        name: el.dataset.name,
        package_id: el.dataset.packageId
    };

    fetch(`/tasks/${currentTask.id}/start`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            price: currentTask.price,
            package_id: currentTask.package_id,
            payment_id: el.dataset.paymentId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert(data.message || "Cannot start task");
            return;
        }
        openTaskModal();
    })
    .catch(err => {
        console.error("Start task failed:", err);
        alert("Failed to start task");
    });
}

// OPEN MODAL
function openTaskModal(){
    const modal = document.getElementById('taskModal');
    modal.classList.remove('hidden');

    document.getElementById('rewardAmount').textContent = currentTask.price.toFixed(0);

    // Fake views
    const views = Math.floor(Math.random()*8000) + 6000;
    document.getElementById('fakeViews').textContent = views.toLocaleString();

    // Load media
    const container = document.getElementById('mediaContainer');
    container.innerHTML = "";
    container.style.position = "relative";

    const ext = currentTask.filePath.split('.').pop().toLowerCase();
    const videoTypes = ['mp4', 'webm', 'ogg', 'mov', 'avi'];

    if (videoTypes.includes(ext)) {
        const vid = document.createElement("video");
        vid.src = currentTask.filePath;
        vid.autoplay = true;
        vid.playsInline = true;
        vid.loop = true;
        vid.muted = false;           // ← Sound ON by default
        vid.className = "w-full h-full object-contain";

        currentVideo = vid;

        // Try to play with sound
        vid.addEventListener('loadedmetadata', () => {
            vid.play().catch(err => {
                console.log("Autoplay with sound was blocked by browser:", err);
                // If blocked, force muted and let user enable sound
                vid.muted = true;
                updateSoundToggle();
            });
        });

        container.appendChild(vid);

        // Create Sound Toggle Button
        const soundToggle = document.createElement("div");
        soundToggle.id = "soundToggle";
        soundToggle.className = "absolute top-4 right-4 bg-black/70 hover:bg-black/90 text-white px-4 py-2 rounded-2xl text-sm flex items-center gap-2 cursor-pointer z-10 transition";
        soundToggle.innerHTML = `<span id="soundIcon">🔊</span><span id="soundText">Sound On</span>`;

        container.appendChild(soundToggle);

        // Sound Toggle Click Handler
        soundToggle.addEventListener('click', () => {
            if (currentVideo) {
                currentVideo.muted = !currentVideo.muted;
                updateSoundToggle();
            }
        });

    } else {
        // Image
        const img = document.createElement("img");
        img.src = currentTask.filePath;
        img.className = "w-full h-full object-contain";
        container.appendChild(img);
    }

    startTimer(currentTask.duration);
}

// Update sound toggle icon and text
function updateSoundToggle() {
    const icon = document.getElementById('soundIcon');
    const text = document.getElementById('soundText');
    if (!icon || !text || !currentVideo) return;

    if (currentVideo.muted) {
        icon.textContent = '🔇';
        text.textContent = 'Sound Off';
    } else {
        icon.textContent = '🔊';
        text.textContent = 'Sound On';
    }
}

// TIMER
function startTimer(seconds){
    remainingTime = seconds;
    totalDuration = seconds;

    const timerEl = document.getElementById('timer');
    const progress = document.getElementById('progress');

    clearInterval(timerInterval);

    timerInterval = setInterval(() => {
        if (timerPaused) return;

        let m = Math.floor(remainingTime / 60);
        let s = remainingTime % 60;

        timerEl.textContent = m.toString().padStart(2,'0') + ":" + s.toString().padStart(2,'0');

        let percent = ((totalDuration - remainingTime) / totalDuration) * 100;
        progress.style.width = percent + "%";

        if (remainingTime <= 0) {
            clearInterval(timerInterval);
            document.getElementById('claimSection').classList.remove('hidden');
            return;
        }
        remainingTime--;
    }, 1000);
}

// Visibility change
document.addEventListener("visibilitychange", () => {
    timerPaused = document.hidden;
});

// CLOSE MODAL - Stops video completely
function closeTaskModal(){
    clearInterval(timerInterval);

    if (currentVideo) {
        currentVideo.pause();
        currentVideo.src = "";
        currentVideo.load();
        currentVideo = null;
    }

    document.getElementById('taskModal').classList.add('hidden');
    document.getElementById('claimSection').classList.add('hidden');
}

// CLAIM REWARD
async function claimReward(button) {
    if (button.disabled) return;

    button.disabled = true;
    const originalText = button.textContent;
    button.textContent = "Processing...";

    try {
        const response = await fetch(`/tasks/${currentTask.id}/claim`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            location.reload();
        } else {
            alert(data.message || "Failed to claim reward");
            button.disabled = false;
            button.textContent = originalText;
        }
    } catch (err) {
        console.error("Claim error:", err);
        alert("Failed to claim reward");
        button.disabled = false;
        button.textContent = originalText;
    }
}

// ESC key
document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
        closeTaskModal();
    }
});

</script>
</body>

</html>