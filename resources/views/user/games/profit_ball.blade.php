<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    @include('user.includes.general_style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profit Balls Game</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Existing styles remain... */
        .game-card {
            background: linear-gradient(145deg, #14122a 0%, #0f0e1a 100%);
            border: 1px solid rgba(139, 92, 246, 0.45);
            border-radius: 32px;
            backdrop-filter: blur(6px);
            box-shadow: 0 20px 35px -12px rgba(0,0,0,0.6), inset 0 1px 0 rgba(255,255,255,0.03);
        }
        .sidebar-card {
            background: rgba(15, 14, 26, 0.75);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(139, 92, 246, 0.35);
            border-radius: 28px;
        }
        /* Circular balls */
        .ball-card {
            background: radial-gradient(circle at 30% 30%, #facc15, #ca8a04);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            border: 2px solid rgba(255,255,255,0.3);
            font-weight: bold;
            font-size: 1.2rem;
            color: #1e293b;
        }
        .ball-card.selected {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(250,204,21,0.8);
            border-color: #fff;
        }
        @media (max-width: 480px) {
            .ball-card { width: 70px; height: 70px; font-size: 1rem; }
        }

        /* Falling container */
        .falling-container {
            position: relative;
            background: #0B0B12;
            border-radius: 24px;
            overflow: hidden;
            height: 300px;
            margin-top: 16px;
            border: 1px solid rgba(139, 92, 246, 0.4);
        }
        .bonus-list {
            position: relative;
            height: 100%;
            width: 100%;
        }
        .bonus-item {
            position: absolute;
            background: rgba(0,0,0,0.7);
            border-radius: 30px;
            padding: 6px 12px;
            font-weight: bold;
            color: #ffd966;
            border: 1px solid #ffd966;
            transition: 0.1s linear;
            cursor: pointer;
            transform: translateX(-50%);
            white-space: nowrap;
        }
        .bonus-item.collected {
            background: #10b981;
            color: white;
            border-color: #6ee7b7;
            opacity: 0.5;
            transform: scale(0.9);
        }
        .ball {
            position: absolute;
            top: 0;
            left: 50%;
            width: 40px;
            height: 40px;
            background: radial-gradient(circle at 30% 30%, #facc15, #ca8a04);
            border-radius: 50%;
            box-shadow: 0 0 15px rgba(250,204,21,0.8);
            transition: top 0.03s linear, left 0.03s linear;
            z-index: 10;
        }
        /* Control buttons placed inline with heading */
        .control-buttons {
            display: flex;
            gap: 10px;
        }
        .control-btn {
            background: rgba(30,27,58,0.9);
            border: 1px solid rgba(139,92,246,0.6);
            border-radius: 40px;
            padding: 6px 16px;
            font-size: 1.3rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.1s;
        }
        .control-btn:active {
            transform: scale(0.95);
        }
        .action-btn {
            background: linear-gradient(90deg, #4f46e5, #c026d3);
            transition: all 0.25s;
            box-shadow: 0 8px 18px -6px rgba(79, 70, 229, 0.5);
        }
        .action-btn:active { transform: scale(0.96); }
        .secondary-btn {
            background: rgba(30, 27, 58, 0.9);
            border: 1px solid rgba(139, 92, 246, 0.6);
        }
    </style>
</head>
<body class="min-h-screen text-gray-200 flex items-start justify-center">
    <div class="w-full max-w-[420px] min-h-screen relative" style="background: #0B0B12;">
        @include('user.includes.top_greetings')

        <div class="mb-20 px-3 py-2 space-y-5">
            <!-- Balance Card -->
            <div class="game-card px-4 py-3 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <i class="fas fa-coins text-amber-400 text-xl"></i>
                    <span class="text-sm font-medium text-gray-300">MY BALANCE</span>
                </div>
                <div class="text-2xl font-black bg-gradient-to-r from-yellow-300 to-amber-400 bg-clip-text text-transparent" id="balanceDisplay">
                    Rs {{ number_format(auth()->user()->balance ?? 0) }}
                </div>
            </div>

            <!-- Ball Selection -->
            <div class="game-card p-4 space-y-3">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold flex items-center gap-2">
                        <i class="fas fa-volleyball-ball text-purple-400"></i> Choose a Ball
                    </h3>
                    <span id="selectedBallCost" class="text-sm text-amber-300">–</span>
                </div>
                <div class="grid grid-cols-4 sm:grid-cols-4 gap-3" id="ballsGrid"></div>
                <div class="flex gap-2 pt-2 border-t border-purple-500/30">
                    <button id="startBtn" class="action-btn flex-1 py-2 rounded-full font-bold flex items-center justify-center gap-2">
                        <i class="fas fa-play"></i> START
                    </button>
                    <button id="newRoundBtn" class="secondary-btn px-4 py-2 rounded-full font-semibold">
                        <i class="fas fa-undo-alt"></i> New
                    </button>
                </div>
                <div id="resultMessage" class="text-center text-sm font-medium p-2 rounded-xl bg-black/40 text-cyan-300 transition-all">
                    🎈 Select a ball, then click START!
                </div>
            </div>

            <!-- Falling Arena -->
            <div class="sidebar-card p-4">
                <div class="flex justify-between items-center mb-2">
                    <h4 class="font-bold"><i class="fas fa-arrow-down text-green-400"></i> Falling Bonuses</h4>
                    <div class="control-buttons">
                        <button class="control-btn" id="moveLeftBtn">←</button>
                        <button class="control-btn" id="moveRightBtn">→</button>
                    </div>
                </div>
                <div class="falling-container" id="fallingContainer">
                    <div class="bonus-list" id="bonusList"></div>
                    <div class="ball" id="ball"></div>
                </div>
                <div class="flex justify-between mt-2 text-sm">
                    <span>Collected: <span id="collectedTotal">0</span></span>
                </div>
            </div>
        </div>

        @include('user.includes.bottom_navigation')
    </div>

    <script>
        // State variables
        let userBalance = @json(auth()->user()->balance ?? 0);
        let balls = [];
        let selectedBall = null;
        let gameInProgress = false;
        let animationId = null;
        let bonuses = [];          // each: { element, value, xPercent, yPos, collected }
        let collectedTotal = 0;
        let ballX = 50;            // percentage (0-100) of container width
        let ballY = 0;
        const ballWidth = 40;
        let containerRect = null;

        // DOM elements
        const balanceSpan = document.getElementById('balanceDisplay');
        const ballsGrid = document.getElementById('ballsGrid');
        const startBtn = document.getElementById('startBtn');
        const newRoundBtn = document.getElementById('newRoundBtn');
        const resultDiv = document.getElementById('resultMessage');
        const bonusListDiv = document.getElementById('bonusList');
        const ballDiv = document.getElementById('ball');
        const selectedBallCostSpan = document.getElementById('selectedBallCost');
        const collectedTotalSpan = document.getElementById('collectedTotal');
        const fallingContainer = document.getElementById('fallingContainer');
        const moveLeftBtn = document.getElementById('moveLeftBtn');
        const moveRightBtn = document.getElementById('moveRightBtn');

        function formatRs(amount) { return 'Rs ' + amount; }
        function updateBalanceUI() { balanceSpan.innerText = formatRs(userBalance); }

        // Generate balls (3 or 4 based on balance)
        function generateBalls(balance) {
            if (balance < 1) return [];
            let count = balance >= 50 ? 4 : 3;
            let costs = [];
            if (count === 3) {
                costs = [
                    Math.max(1, Math.floor(balance * 0.05)),
                    Math.max(1, Math.floor(balance * 0.1)),
                    Math.max(1, Math.floor(balance * 0.2))
                ];
            } else {
                costs = [
                    Math.max(1, Math.floor(balance * 0.02)),
                    Math.max(1, Math.floor(balance * 0.05)),
                    Math.max(1, Math.floor(balance * 0.1)),
                    Math.max(1, Math.floor(balance * 0.2))
                ];
            }
            costs = costs.map(c => Math.min(c, balance));
            costs = [...new Set(costs)];
            while (costs.length < count) costs.push(Math.min(5, balance));
            costs.sort((a,b)=>a-b);
            return costs.map((cost, idx) => ({ id: idx+1, cost }));
        }

        function renderBalls() {
            ballsGrid.innerHTML = '';
            balls.forEach(ball => {
                const card = document.createElement('div');
                card.className = 'ball-card';
                if (selectedBall && selectedBall.id === ball.id) card.classList.add('selected');
                card.innerHTML = `<span>${ball.cost}</span>`;
                card.addEventListener('click', () => {
                    if (gameInProgress) {
                        resultDiv.innerHTML = '⏳ Game in progress! Wait or click New.';
                        return;
                    }
                    selectedBall = ball;
                    selectedBallCostSpan.innerText = formatRs(ball.cost);
                    renderBalls();
                });
                ballsGrid.appendChild(card);
            });
        }

        // ----- Interactive Falling -----
        function startFalling(bonusData) {
            // Clear previous
            bonusListDiv.innerHTML = '';
            bonuses = [];
            collectedTotal = 0;
            collectedTotalSpan.innerText = '0';
            ballX = 50;
            ballY = 0;
            updateBallPosition();

            // Get container dimensions
            containerRect = fallingContainer.getBoundingClientRect();

            // Create bonus elements
            bonusData.forEach((b, idx) => {
                const item = document.createElement('div');
                item.className = 'bonus-item';
                item.innerText = `+${b.value}`;
                const leftPercent = b.xPercent;
                const topPercent = (idx / bonusData.length) * 100; // distribute evenly
                item.style.left = `${leftPercent}%`;
                item.style.top = `${topPercent}%`;
                item.style.transform = 'translateX(-50%)';
                bonusListDiv.appendChild(item);
                bonuses.push({
                    element: item,
                    value: b.value,
                    yPercent: topPercent,
                    xPercent: leftPercent,
                    collected: false
                });
            });

            // Start animation
            let startTime = null;
            const duration = 1200; // ⚡ Faster fall: 1.5 seconds instead of 2

            function step(timestamp) {
                if (!startTime) startTime = timestamp;
                const elapsed = timestamp - startTime;
                const progress = Math.min(1, elapsed / duration);
                ballY = progress * 100; // 0% to 100% of container height
                updateBallPosition();

                // Collision detection
                const ballRect = ballDiv.getBoundingClientRect();
                for (let i = 0; i < bonuses.length; i++) {
                    const b = bonuses[i];
                    if (b.collected) continue;
                    const bonusRect = b.element.getBoundingClientRect();
                    // Simple axis-aligned rectangle collision
                    if (ballRect.right > bonusRect.left && ballRect.left < bonusRect.right &&
                        ballRect.bottom > bonusRect.top && ballRect.top < bonusRect.bottom) {
                        b.collected = true;
                        b.element.classList.add('collected');
                        collectedTotal += b.value;
                        collectedTotalSpan.innerText = collectedTotal;
                    }
                }

                if (progress < 1) {
                    animationId = requestAnimationFrame(step);
                } else {
                    animationId = null;
                    finishGame(collectedTotal);
                }
            }
            animationId = requestAnimationFrame(step);
        }

        function updateBallPosition() {
            if (containerRect) {
                const containerWidthPx = containerRect.width;
                const leftPx = (ballX / 100) * containerWidthPx - (ballWidth / 2);
                ballDiv.style.left = `${leftPx}px`;
            } else {
                ballDiv.style.left = `${ballX}%`;
            }
            ballDiv.style.top = `${ballY}%`;
        }

        function moveLeft() {
            if (!gameInProgress) return;
            ballX = Math.max(0, ballX - 3); // 🐢 Slower horizontal movement (was 8)
            updateBallPosition();
        }
        function moveRight() {
            if (!gameInProgress) return;
            ballX = Math.min(100, ballX + 3); // 🐢 Slower horizontal movement (was 8)
            updateBallPosition();
        }

        function finishGame(collected) {
            gameInProgress = false;
            startBtn.disabled = false;
            startBtn.innerHTML = '<i class="fas fa-play"></i> START';

            // Send collected amount to server to update balance
            fetch('/games/profit-balls/finish', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    ball_id: selectedBall.id,
                    cost: selectedBall.cost,
                    collected: collected
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    userBalance = data.new_balance;
                    updateBalanceUI();
                    const net = collected - selectedBall.cost;
                    if (net >= 0) {
                        resultDiv.innerHTML = `🎉 You collected ${formatRs(collected)}! Net profit +${net}. New balance: ${formatRs(userBalance)}`;
                    } else {
                        resultDiv.innerHTML = `😢 You collected ${formatRs(collected)}. Net loss ${net}. New balance: ${formatRs(userBalance)}`;
                    }
                } else {
                    resultDiv.innerHTML = `❌ ${data.message}`;
                }
            })
            .catch(err => {
                console.error(err);
                resultDiv.innerHTML = '❌ Network error. Please try again.';
            });
        }

        // Start game: fetch bonus data from server
        function startGame() {
            if (!selectedBall) {
                resultDiv.innerHTML = '❌ Please select a ball first!';
                return;
            }
            if (selectedBall.cost > userBalance) {
                resultDiv.innerHTML = `⚠️ Insufficient balance! Need ${formatRs(selectedBall.cost)}.`;
                return;
            }
            if (gameInProgress) return;

            gameInProgress = true;
            startBtn.disabled = true;
            startBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            resultDiv.innerHTML = '🎲 Dropping ball... Steer with buttons!';

            fetch('/games/profit-balls/start', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    ball_id: selectedBall.id,
                    cost: selectedBall.cost,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    gameInProgress = false;
                    startBtn.disabled = false;
                    startBtn.innerHTML = '<i class="fas fa-play"></i> START';
                    resultDiv.innerHTML = `❌ ${data.message}`;
                    return;
                }
                // Deduct cost immediately (optional, we can also do it at finish)
                userBalance = data.new_balance;
                updateBalanceUI();

                startFalling(data.bonus_list);
            })
            .catch(err => {
                console.error(err);
                gameInProgress = false;
                startBtn.disabled = false;
                startBtn.innerHTML = '<i class="fas fa-play"></i> START';
                resultDiv.innerHTML = '❌ Network error. Please try again.';
            });
        }

        function newRound() {
            if (animationId) cancelAnimationFrame(animationId);
            gameInProgress = false;
            selectedBall = null;
            selectedBallCostSpan.innerText = '–';
            bonusListDiv.innerHTML = '';
            collectedTotalSpan.innerText = '0';
            ballDiv.style.top = '0px';
            resultDiv.innerHTML = '🎈 Select a ball and click START!';
            balls = generateBalls(userBalance);
            renderBalls();
        }

        // Event listeners
        moveLeftBtn.addEventListener('click', moveLeft);
        moveRightBtn.addEventListener('click', moveRight);
        window.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') moveLeft();
            if (e.key === 'ArrowRight') moveRight();
        });

        function init() {
            balls = generateBalls(userBalance);
            renderBalls();
            startBtn.addEventListener('click', startGame);
            newRoundBtn.addEventListener('click', newRound);
            updateBalanceUI();
        }
        init();
    </script>
</body>
</html>