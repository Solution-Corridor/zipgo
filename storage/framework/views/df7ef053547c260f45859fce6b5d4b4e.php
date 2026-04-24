<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <?php echo $__env->make('user.includes.general_style', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Number Burst Game</title>

    <!-- Font Awesome 6 (free icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* ===== GAME CUSTOM STYLES (keeps dark glam theme) ===== */
        .game-card {
            background: linear-gradient(145deg, #14122a 0%, #0f0e1a 100%);
            border: 1px solid rgba(139, 92, 246, 0.45);
            border-radius: 32px;
            backdrop-filter: blur(6px);
            box-shadow: 0 20px 35px -12px rgba(0,0,0,0.6), inset 0 1px 0 rgba(255,255,255,0.03);
            transition: all 0.2s ease;
        }

        .sidebar-card {
            background: rgba(15, 14, 26, 0.75);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(139, 92, 246, 0.35);
            border-radius: 28px;
        }

        .number-tile {
            background: rgba(20, 18, 42, 0.8);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(139, 92, 246, 0.5);
            border-radius: 5px;
            transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            cursor: pointer;
            box-shadow: 0 6px 12px -6px rgba(0,0,0,0.4);
        }

        .number-tile.selected {
            background: linear-gradient(135deg, #7c3aed, #a855f7);
            border-color: #f0abfc;
            box-shadow: 0 0 12px rgba(168, 85, 247, 0.6);
            transform: scale(0.98);
        }

        /* win / lose burst styles */
        .number-tile.win-burst {
            background: linear-gradient(145deg, #10b981, #059669);
            border-color: #6ee7b7;
            box-shadow: 0 0 16px #10b981aa;
            animation: burstPop 0.35s ease-out;
        }

        .number-tile.lose-burst {
            background: linear-gradient(145deg, #ef4444, #b91c1c);
            border-color: #fca5a5;
            box-shadow: 0 0 14px #ef4444aa;
            animation: burstPop 0.35s ease-out;
        }

        @keyframes burstPop {
            0% { transform: scale(0.88); opacity: 0.7; }
            60% { transform: scale(1.06); }
            100% { transform: scale(1); opacity: 1; }
        }

        .burst-particle {
            animation: particleFlash 0.4s forwards;
        }

        .action-btn {
            background: linear-gradient(90deg, #4f46e5, #c026d3);
            transition: all 0.25s;
            box-shadow: 0 8px 18px -6px rgba(79, 70, 229, 0.5);
        }

        .action-btn:active {
            transform: scale(0.96);
        }

        .secondary-btn {
            background: rgba(30, 27, 58, 0.9);
            border: 1px solid rgba(139, 92, 246, 0.6);
            transition: all 0.2s;
        }

        .secondary-btn:active {
            transform: scale(0.96);
        }

        .prize-badge {
    font-size: 9px;
    background: rgba(0,0,0,0.6);
    border-radius: 6px;
    padding: 2px 4px;
    font-weight: 600;
    white-space: nowrap;
}

        /* scrollbar tiny */
        ::-webkit-scrollbar {
            width: 3px;
        }

        .sidebar-list {
            max-height: 260px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .sidebar-list-item {
            background: rgba(0,0,0,0.3);
            border-radius: 60px;
            margin-bottom: 6px;
            padding: 6px 12px;
            font-size: 0.8rem;
            font-weight: 500;
            border-left: 3px solid #a855f7;
        }
    </style>
</head>
<body class="min-h-screen text-gray-200 flex items-start justify-center">

<div class="w-full max-w-[420px] min-h-screen relative" style="background: #0B0B12;">
    
    <?php echo $__env->make('user.includes.top_greetings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- ================== GAME ZONE ================== -->
    <div class="mb-20 px-3 py-2 space-y-5">
        
        <!-- BALANCE & STATS PANEL -->
        <div class="game-card px-4 py-3 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="fas fa-coins text-amber-400 text-xl"></i>
                <span class="text-sm font-medium text-gray-300">MY BALANCE</span>
            </div>
            <div class="text-2xl font-black bg-gradient-to-r from-yellow-300 to-amber-400 bg-clip-text text-transparent" id="balanceDisplay">Rs <?php echo e(number_format(auth()->user()->balance ?? 0)); ?></div>
            
        </div>

        <!-- MAIN GAME CARD: NUMBERS GRID + BURST ACTION -->
        <div class="game-card p-5 space-y-5">
            <div class="flex items-center justify-between gap-2">
    
    <h3 class="text-sm sm:text-lg font-bold flex items-center gap-2 whitespace-nowrap">
        <i class="fas fa-dice-d6 text-purple-400"></i>
        <span class="gradient-title">NUMBER BURST</span>
    </h3>

    <div class="bg-black/40 rounded-full px-2 py-1 text-xs sm:text-sm whitespace-nowrap">
        <i class="fas fa-hand-pointer text-pink-400 mr-1"></i>
        <span id="selectedCount">0</span> selected
    </div>

</div>
            
            <!-- dynamic number grid (1-12) each tile shows cost & prize -->
            <div class="grid grid-cols-3 sm:grid-cols-4 gap-2" id="numbersGrid"></div>

            <div class="flex items-center justify-between gap-2 pt-2 border-t border-purple-500/30">
    
    <!-- LEFT: cost -->
    <div class="flex flex-col leading-tight whitespace-nowrap">
        <p class="text-[10px] text-gray-400">Total</p>
        <p class="text-sm font-bold text-purple-300" id="totalCostPreview">0</p>
    </div>

    <!-- RIGHT: buttons -->
    <div class="flex items-center gap-2 whitespace-nowrap">
        
        <button id="burstBtn"
            class="action-btn px-3 py-1.5 text-xs rounded-full font-bold flex items-center gap-1">
            <i class="fas fa-bomb text-xs"></i>
            <span>BURST</span>
        </button>

        <button id="newRoundBtn"
            class="secondary-btn px-2 py-1.5 text-xs rounded-full font-semibold flex items-center gap-1">
            <i class="fas fa-undo-alt text-xs"></i>
            <span>New</span>
        </button>

    </div>

</div>

            <!-- Result message -->
            <div id="resultMessage" class="text-center text-sm font-medium p-2 rounded-xl bg-black/40 text-cyan-300 transition-all">
                ⚡ Select your lucky numbers & hit BURST!
            </div>
        </div>

        <!-- ========== SIDEBAR (numbers pricing) ========== -->
        <div class="sidebar-card p-4">
            <div class="flex items-center gap-2 border-b border-purple-500/30 pb-2 mb-3">
                <i class="fas fa-chart-line text-pink-400"></i>
                <h4 class="font-bold text-sm">💰 Numbers Pricing & Win Prize</h4>
                <i class="fas fa-arrow-right text-xs text-purple-300 ml-auto"></i>
            </div>
            <div class="sidebar-list" id="pricingSidebar">
                <!-- dynamic list of numbers with cost & win prize -->
            </div>
            <p class="text-[11px] text-gray-500 mt-3 text-center"><i class="fas fa-info-circle"></i> Each number: <strong class="text-white">cost to bet</strong> & <strong class="text-green-300">win prize</strong> shown above</p>
        </div>

        <!-- small tip card -->
        <div class="text-center text-[11px] text-gray-500 flex justify-center gap-3">
            <span><i class="fas fa-star text-yellow-500"></i> Win = earn prize</span>
            <span><i class="fas fa-skull text-red-400"></i> Lose = cost deducted</span>
        </div>
    </div>

    <?php echo $__env->make('user.includes.bottom_navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>

<script>
    // Get user balance from PHP (passed as JSON)
    let userBalance = <?php echo json_encode(auth()->user()->balance ?? 0, 15, 512) ?>;

    // ----- DYNAMIC NUMBER GENERATION -----
function generateNumbersData(balance) {
    const count = 12;

    // Use only 85% of balance for costs (15% house edge)
        const usableBalance = Math.floor(balance * 0.85);

    // Minimum required sum for uniqueness
    const minSum = (count * (count + 1)) / 2;

    if (usableBalance < minSum) {
        throw new Error("Balance too low for unique distribution");
    }

    // Step 1: Start with unique base values [1..12]
    let costs = Array.from({ length: count }, (_, i) => i + 1);

    let remaining = usableBalance - minSum;

    // Step 2: Randomly distribute remaining balance
    while (remaining > 0) {
        let i = Math.floor(Math.random() * count);

        // Try increasing this index while keeping uniqueness
        let canIncrease = true;

        // Ensure it doesn't collide with next number
        if (i < count - 1 && costs[i] + 1 >= costs[i + 1]) {
            canIncrease = false;
        }

        if (canIncrease) {
            costs[i]++;
            remaining--;
        }
    }

    // Step 3: Shuffle for randomness
    costs.sort(() => Math.random() - 0.5);

    // Step 4: Build final data
    const numbers = costs.map((cost, index) => {
        const multiplier = 1.1 + Math.random();
        let prize = Math.floor(cost * multiplier);

        const value = Math.floor(Math.random() * 99) + 1;

        return {
            id: index + 1,
            value: value,
            cost: cost,
            prize: prize
        };
    });

    // Optional: sort ascending for UI
    numbers.sort((a, b) => a.cost - b.cost);

    // Reassign IDs
    numbers.forEach((item, index) => {
        item.id = index + 1;
    });

    return numbers;
}

    // Initialise numbers based on current balance
    let numbersData = generateNumbersData(userBalance);

    // App state
    let selectedNumbers = new Set();     // store number ids
    let burstActive = false;              // if true, cannot select or burst until new round
    let lastWinLossMap = new Map();       // store win/lose status per number id after burst

    // DOM elements
    const numbersGrid = document.getElementById('numbersGrid');
    const balanceSpan = document.getElementById('balanceDisplay');
    const selectedCountSpan = document.getElementById('selectedCount');
    const totalCostPreviewSpan = document.getElementById('totalCostPreview');
    const burstBtn = document.getElementById('burstBtn');
    const newRoundBtn = document.getElementById('newRoundBtn');
    const resultMessageDiv = document.getElementById('resultMessage');
    const pricingSidebar = document.getElementById('pricingSidebar');

    // Helper: update balance UI
    function updateBalanceUI() {
        balanceSpan.innerText = 'Rs ' + userBalance;
    }

    // Helper: compute total cost of currently selected numbers
    function computeTotalCost() {
        let total = 0;
        for (let id of selectedNumbers) {
            const num = numbersData.find(n => n.id === id);
            if (num) total += num.cost;
        }
        return total;
    }

    // update selection UI (count & total cost preview)
    function updateSelectionInfo() {
        selectedCountSpan.innerText = selectedNumbers.size;
        const totalCost = computeTotalCost();
        totalCostPreviewSpan.innerText = 'Rs ' + totalCost;
        return totalCost;
    }

    // render main number grid (tiles) with win/loss status if burstActive
    function renderNumberGrid() {
        numbersGrid.innerHTML = '';
        numbersData.forEach(num => {
            const tile = document.createElement('div');
            tile.className = 'number-tile p-1 text-center transition-all cursor-pointer';
            if (selectedNumbers.has(num.id) && !burstActive) {
                tile.classList.add('selected');
            }
            // if burst happened, show win/lose styling
            if (burstActive && lastWinLossMap.has(num.id)) {
                const status = lastWinLossMap.get(num.id);
                if (status === 'win') {
                    tile.classList.add('win-burst');
                } else if (status === 'lose') {
                    tile.classList.add('lose-burst');
                }
                // remove selection glow to avoid confusion after burst
                tile.classList.remove('selected');
            } else if (!burstActive && selectedNumbers.has(num.id)) {
                tile.classList.add('selected');
            }

            // inner html: number + cost & prize tiny
            tile.innerHTML = `
                <div class="text-2xl font-black">${num.value}</div>
                <div class="flex justify-center gap-2 mt-1 text-[9px] font-semibold">
                    <span class="prize-badge text-amber-300">Rs ${num.cost}</span>
                    <span class="prize-badge text-green-300"><i class="fas fa-gem"></i> ${num.prize}</span>
                </div>
            `;

            // click handler only if burst not active
            tile.addEventListener('click', (e) => {
                e.stopPropagation();
                if (burstActive) {
                    resultMessageDiv.innerHTML = '⛔ Burst is active! Start a <strong>New Round</strong> to pick fresh numbers.';
                    resultMessageDiv.classList.add('text-orange-300');
                    setTimeout(() => {
                        if (!burstActive) resultMessageDiv.classList.remove('text-orange-300');
                    }, 1500);
                    return;
                }
                toggleNumberSelection(num.id);
                renderNumberGrid();
                updateSelectionInfo();
            });
            numbersGrid.appendChild(tile);
        });
    }

    // toggle number selection (burstActive guard handled before)
    function toggleNumberSelection(id) {
        if (selectedNumbers.has(id)) {
            selectedNumbers.delete(id);
        } else {
            selectedNumbers.add(id);
        }
        updateSelectionInfo();
    }

    // render sidebar pricing list (cost & win prize)
    function renderPricingSidebar() {
        pricingSidebar.innerHTML = '';
        numbersData.forEach(num => {
            const item = document.createElement('div');
            item.className = 'sidebar-list-item flex justify-between items-center';
            item.innerHTML = `
                <div class="flex items-center gap-2">
                    <span class="bg-purple-800/60 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">${num.value}</span>
                    <span class="text-gray-300 text-xs">Rs.</span>
                    <span class="text-amber-300 font-mono">${num.cost}</span>
                </div>
                <div class="flex items-center gap-1">
                    <span class="text-gray-400 text-xs">Win:</span>
                    <span class="text-green-400 font-bold text-sm">${num.prize}</span>
                </div>
            `;
            pricingSidebar.appendChild(item);
        });
    }

    // BURST CORE LOGIC: random win/loss per number, deduct selected costs, add prize for selected winners
    function performBurst() {
        if (burstActive) {
            resultMessageDiv.innerHTML = '🎲 A burst already happened! Press "New Round" to play again.';
            return;
        }
        if (selectedNumbers.size === 0) {
            resultMessageDiv.innerHTML = '❌ Please select at least one number before bursting!';
            return;
        }

        const totalCost = computeTotalCost();
        if (totalCost > userBalance) {
            resultMessageDiv.innerHTML = `⚠️ Insufficient balance! Need ${totalCost} credits.`;
            return;
        }

        // Disable burst button while processing
        burstBtn.disabled = true;
        burstBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

        // Prepare data to send
        const payload = {
            selected_numbers: Array.from(selectedNumbers),
            numbers_data: numbersData.map(num => ({
                id: num.id,
                value: num.value,
                cost: num.cost,
                prize: num.prize,
            })),
        };

        fetch('/games/burst-record', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify(payload),
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                // Show error (e.g., insufficient balance)
                resultMessageDiv.innerHTML = `❌ ${data.message}`;
                burstBtn.disabled = false;
                burstBtn.innerHTML = '<i class="fas fa-bomb text-xs"></i> BURST';
                return;
            }

            // Update balance from server response
            userBalance = data.new_balance;
            updateBalanceUI();

            // Store win/loss map for animation
            lastWinLossMap.clear();
            Object.entries(data.win_loss_map).forEach(([id, status]) => {
                lastWinLossMap.set(parseInt(id), status);
            });

            // Set burst active
            burstActive = true;

            // Re‑render grid with win/loss styling
            renderNumberGrid();

            // Build result message
            const profitSign = data.net_change >= 0 ? '+' : '';
            const winLoseText = Array.from(selectedNumbers)
                .map(id => {
                    const num = numbersData.find(n => n.id === id);
                    const status = lastWinLossMap.get(id) === 'win' ? '🏆 WON' : '💀 LOST';
                    return `#${num.value} ${status}`;
                })
                .join(', ');

            resultMessageDiv.innerHTML = `
                <div class="flex flex-col gap-1">
                    <div><i class="fas fa-chart-line"></i> Burst complete! ${data.win_count}/${selectedNumbers.size} selected numbers won.</div>
                    <div><span class="text-amber-300">Cost: -${data.total_cost}</span> | <span class="text-green-300">Winnings: +${data.total_win_gain}</span> | Net: <strong class="${data.net_change>=0?'text-green-400':'text-red-400'}">${profitSign}${data.net_change}</strong></div>
                    <div class="text-xs text-gray-300 mt-1">${winLoseText}</div>
                </div>
            `;

            // Add burst animations
            const tiles = document.querySelectorAll('.number-tile');
            tiles.forEach(tile => {
                tile.style.animation = 'none';
                tile.offsetHeight;
                if (tile.classList.contains('win-burst') || tile.classList.contains('lose-burst')) {
                    tile.style.animation = 'burstPop 0.35s ease-out';
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
            resultMessageDiv.innerHTML = '❌ Network error. Please try again.';
        })
        .finally(() => {
            burstBtn.disabled = false;
            burstBtn.innerHTML = '<i class="fas fa-bomb text-xs"></i> BURST';
        });
    }

    // extra: dynamic checking for new round after burst, also prevent double burst
    function initEventListeners() {
        burstBtn.addEventListener('click', () => {
            if (burstActive) {
                resultMessageDiv.innerHTML = '⏳ Game already burst! Click "New Round" to play again.';
                resultMessageDiv.classList.add('text-orange-300');
                setTimeout(() => {
                    if (burstActive) resultMessageDiv.classList.remove('text-orange-300');
                }, 1500);
                return;
            }
            performBurst();
        });

        newRoundBtn.addEventListener('click', () => {
            window.location.reload();
        });
    }

    // initial render
    function initGame() {
        renderPricingSidebar();
        renderNumberGrid();
        updateSelectionInfo();
        updateBalanceUI();
        initEventListeners();
        burstActive = false;
        lastWinLossMap.clear();
        selectedNumbers.clear();
    }

    initGame();
</script>
</body>
</html><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/user/games/burst_numbers.blade.php ENDPATH**/ ?>