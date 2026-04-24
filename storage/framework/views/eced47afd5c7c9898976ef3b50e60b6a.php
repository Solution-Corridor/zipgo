<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <?php echo $__env->make('user.includes.general_style', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <title>Lucky Spin</title>

    <!-- Tailwind + DaisyUI or your own styles assumed via general_style -->
    <style>
        .wheel-container {
            aspect-ratio: 1 / 1;
            max-width: 220px; /* reduced from 280px */
            margin: 0.5rem auto; /* reduced from 1.5rem */
            filter: drop-shadow(0 8px 12px rgba(0, 0, 0, 0.6));
        }
        .prize-badge {
            @apply badge badge-lg text-base font-semibold px-4 py-3 m-1.5 min-w-[90px] shadow-md;
        }
        .selected {
            @apply ring-2 ring-offset-2 ring-offset-base-100 ring-primary scale-110;
        }
        /* New style for the center dot – metallic gradient */
        .center-dot {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 1.25rem;   /* 20px */
            height: 1.25rem;
            background: radial-gradient(circle at 30% 30%, #f0e68c, #b8860b);
            border-radius: 9999px;
            box-shadow: 0 0 10px #ffd700, inset 0 -2px 5px rgba(0,0,0,0.3);
            border: 2px solid #fff3c9;
            z-index: 10;
        }
        /* Pointer – more stylish */
        .pointer {
            position: absolute;
            top: -6px;          /* lift slightly above the wheel */
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 14px solid transparent;
            border-right: 14px solid transparent;
            border-top: 28px solid #ff8c00;  /* vibrant orange */
            filter: drop-shadow(0 4px 4px rgba(0,0,0,0.5));
            z-index: 20;
        }
        /* Add a tiny white highlight to the pointer tip */
        .pointer::after {
            content: '';
            position: absolute;
            top: -26px;
            left: -6px;
            width: 12px;
            height: 12px;
            background: radial-gradient(circle at 30% 30%, #fff8e7, #ffaa33);
            border-radius: 50%;
            filter: blur(2px);
            opacity: 0.8;
        }
    </style>
</head>
<body class="min-h-screen text-gray-200 flex items-start justify-center">

<div class="w-full max-w-[420px] min-h-screen relative" style="background: #0B0B12;">

    <?php echo $__env->make('user.includes.top_greetings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>  

    <!-- Main Content -->
    <div class="px-5 " style="padding-bottom: 90px;">

        <div class="w-full max-w-md mx-auto px-4 pt-1 pb-6">  <!-- reduced pb from 10 to 6 -->

            <!-- Balance + Selected amount – more compact -->
            <div class="flex items-center justify-between mb-0.5 bg-base-800/70 rounded-xl px-3 py-0.5 border border-base-700/50 shadow-sm">
                <div class="flex items-center gap-1.5">
                    <div class="text-xs text-gray-400 font-medium">Balance:</div>
                    <div id="balanceAmount" class="text-lg font-bold text-emerald-400 tracking-tight">
                        Rs <?php echo e(number_format(auth()->user()->balance ?? 0)); ?>

                    </div>
                </div>
                <!-- Selected amount (shows only after selection) -->
                <div id="selectedAmount" class="text-sm font-semibold text-amber-300 hidden">
                    Selected: <span id="selectedValue">-</span>
                </div>
            </div>

            <!-- Status message – smaller & tighter -->
            <div id="status" class="text-center text-sm text-gray-300 mb-0.5 min-h-[1.2rem]">
                Choose amount to spin
            </div>

            <!-- Amount buttons – smaller & tighter grid -->
            <div class="grid grid-cols-3 sm:grid-cols-4 gap-2 mb-4 auto-rows-fr">
                <?php $__currentLoopData = [50, 100, 200, 500, 1000, 2000, 3000, 4000, 5000, 8000, 10000]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button 
                        type="button"
                        class="h-9 sm:h-10 text-xs sm:text-sm font-semibold rounded-lg px-1 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2 focus:ring-offset-gray-950 disabled:opacity-55 disabled:cursor-not-allowed"
                        data-amount="<?php echo e($amount); ?>"
                        <?php echo e($amount > (auth()->user()->balance ?? 0) ? 'disabled' : ''); ?>

                    >
                        Rs <?php echo e(number_format($amount)); ?>

                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Spin button – shorter -->
            <button
                id="spinBtn"
                class="w-full max-w-xs mx-auto h-12 text-lg font-bold tracking-widest uppercase text-white bg-gradient-to-br from-purple-600 to-indigo-700 rounded-xl shadow-lg shadow-purple-900/40 ring-2 ring-purple-400/30 ring-offset-2 ring-offset-gray-950 hover:ring-purple-400/60 hover:ring-offset-purple-950/50 hover:bg-gradient-to-br hover:from-purple-500 hover:to-indigo-600 active:scale-95 transition-all duration-200 disabled:opacity-60 disabled:ring-0 disabled:ring-offset-0 disabled:hover:bg-gradient-to-br disabled:from-purple-600 disabled:to-indigo-700 disabled:cursor-not-allowed flex items-center justify-center gap-3 mb-0"
                disabled
            >
                <span>SPIN NOW</span>
                <svg id="spinLoader" class="hidden size-5 animate-spin text-white/80" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8h8a8 8 0 01-16 0z"></path>
                </svg>
            </button>

        </div> <!-- end of inner container -->

        <!-- Result area – smaller text -->
        <div id="result" 
     class="text-center text-xl font-bold text-white tracking-wide -mt-4 mb-4
            [text-shadow:0_2px_8px_rgba(0,0,0,0.7)]
            transition-opacity duration-300">
    <!-- filled by JS – example: You won 500 Rs!  or  Better luck next time... -->
</div>

        <!-- 🎰 Spin Wheel – smaller and with less margin -->
        <div class="wheel-container relative mx-auto max-w-[280px] mt-1 mb-1">
            <canvas id="wheelCanvas" width="280" height="280" class="w-full h-full"></canvas>
            <!-- Center dot with metallic gradient -->
            <div class="center-dot"></div>
            <!-- Pointer with highlight -->
            <div class="pointer"></div>
        </div>

        

    </div> <!-- end of flex column -->

    <?php echo $__env->make('user.includes.bottom_navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>  <!-- if this has internal padding, consider reducing it (e.g., py-1 instead of py-2) -->

</div> <!-- end of main container -->

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    
    // ----- DOM elements (unchanged) -----
    const statusEl = document.getElementById('status');
    const spinBtn = document.getElementById('spinBtn');
    const resultEl = document.getElementById('result');
    const prizeBtns = document.querySelectorAll('[data-amount]');
    const balanceStat = document.getElementById('balanceAmount');
    const canvas = document.getElementById('wheelCanvas');
    const ctx = canvas.getContext('2d');

    if (!spinBtn || !resultEl || prizeBtns.length === 0 || !canvas) {
        console.error('Required elements missing – cannot initialise Lucky Spin.');
        return;
    }

    // ----- State -----
    let selectedAmount = null;
    let currentSegments = [];               
    let currentColors = [];                  
    let currentRotation = 0;                 
    let isSpinning = false;
    let animationFrame = null;


    // ==============================================================
    //    ←←←  PUT THE AUTO-SPIN CODE HERE  ←←←
    // ==============================================================

    // ==================== AUTO SPIN FROM DASHBOARD POPUP ====================
    const urlParams = new URLSearchParams(window.location.search);
    const shouldAutoSpin = urlParams.get('auto') === 'true';
    const autoAmountStr = urlParams.get('amount');

    if (shouldAutoSpin && autoAmountStr) {
        const autoAmount = parseInt(autoAmountStr, 10);

        if (!isNaN(autoAmount)) {
            setTimeout(() => {
                const targetButton = Array.from(prizeBtns).find(btn => 
                    parseInt(btn.dataset.amount, 10) === autoAmount && !btn.disabled
                );

                if (targetButton) {
                    console.log(`[AUTO] Selecting Rs ${autoAmount}`);
                    targetButton.click();

                    setTimeout(() => {
                        if (!isSpinning && !spinBtn.disabled) {
                            console.log(`[AUTO] Starting spin for Rs ${autoAmount}`);
                            statusEl.textContent = `Auto-spinning Rs ${autoAmount.toLocaleString('en-IN')}...`;
                            spinBtn.click();
                        } else {
                            console.warn('[AUTO] Spin button not ready yet', { isSpinning, disabled: spinBtn.disabled });
                        }
                    }, 1200);   // increased slightly — gives wheel time to draw

                } else {
                    console.warn(`[AUTO] No enabled button found for ${autoAmount}. Balance may be too low.`);
                    
                    // Fallback: highest possible
                    const highest = [...prizeBtns]
                        .filter(b => !b.disabled)
                        .sort((a,b) => Number(b.dataset.amount) - Number(a.dataset.amount))[0];

                    if (highest) {
                        console.log(`[AUTO] Falling back to ${highest.dataset.amount}`);
                        highest.click();
                        setTimeout(() => {
                            if (!spinBtn.disabled) spinBtn.click();
                        }, 1200);
                    }
                }
            }, 400);
        }
    }
    // =====================================================================


    // ----- Audio setup -----
    const spinStartSound = new Audio('/assets/sounds/spin-start.wav');
    const spinLoopSound = new Audio('/assets/sounds/spin-loop.wav');
    spinLoopSound.loop = true;
    const spinEndSound = new Audio('/assets/sounds/spin-end.wav');

    // Helper to stop and reset the loop sound
    function stopLoopSound() {
        spinLoopSound.pause();
        spinLoopSound.currentTime = 0;
    }

    // ----- Constants -----
    const SEGMENT_COUNT = 8;                  

    // ==================== UPDATED: Fixed vibrant color palette ====================
    function getColorsForAmount(amount) {
        // Fixed set of rich, gaming‑style colors – independent of the bet amount
        return [
            '#FBBF24', // amber
            '#EF4444', // red
            '#3B82F6', // blue
            '#10B981', // green
            '#8B5CF6', // purple
            '#EC4899', // pink
            '#F97316', // orange
            '#06B6D4'  // cyan
        ];
    }

    // ----- Helper: update prize buttons based on balance (unchanged) -----
    function updatePrizeButtonsState() {
        const balanceText = balanceStat?.textContent || '';
        const balance = parseFloat(balanceText.replace(/[^0-9.-]/g, '')) || 0;
        prizeBtns.forEach(btn => {
            const amount = parseInt(btn.dataset.amount, 10);
            if (amount > balance) {
                btn.disabled = true;
                btn.classList.remove(
                    'bg-purple-700', 'hover:bg-purple-600', 'bg-purple-600',
                    'shadow-lg', 'scale-105', 'ring-2', 'ring-purple-300'
                );
                btn.classList.add('bg-gray-800', 'text-gray-400', 'border', 'border-gray-700', 'cursor-not-allowed');
            } else {
                btn.disabled = false;
                btn.classList.remove(
                    'bg-gray-800', 'text-gray-400', 'border', 'border-gray-700', 'cursor-not-allowed',
                    'bg-purple-600', 'shadow-lg', 'scale-105', 'ring-2', 'ring-purple-300'
                );
                btn.classList.add('bg-purple-700', 'hover:bg-purple-600', 'text-white', 'cursor-pointer');
            }
        });
    }

    // ==================== MODIFIED FUNCTION ====================
    // ----- Generate prize segments – first segment always Rs 10 -----
    function generateSegments(amount) {
        // Multipliers for the other 7 segments
        const multipliers = [0.2, 0.4, 0.5, 0.7, 1, 2, 3];
        // Build 8 segments: first is fixed 10, rest are based on multipliers
        const segments = [
            { label: 'Rs 10', value: 10 }  // fixed win instead of "Lose"
        ];
        multipliers.forEach(mult => {
            const prize = Math.round(amount * mult);
            segments.push({ label: `Rs ${prize}`, value: prize });
        });
        return segments;
    }
    // ============================================================

    // ==================== ENHANCED DRAW FUNCTION ====================
    function drawWheel(segments, rotation = 0) {
        if (!ctx) return;
        const width = canvas.width;
        const height = canvas.height;
        const centerX = width / 2;
        const centerY = height / 2;
        const radius = width * 0.4;
        const angleStep = (Math.PI * 2) / segments.length;

        ctx.clearRect(0, 0, width, height);

        // Add a subtle shadow to the wheel for depth
        ctx.shadowColor = 'rgba(0, 0, 0, 0.6)';
        ctx.shadowBlur = 10;
        ctx.shadowOffsetX = 2;
        ctx.shadowOffsetY = 2;

        for (let i = 0; i < segments.length; i++) {
            const startAngle = i * angleStep + rotation;
            const endAngle = startAngle + angleStep;

            // Draw segment
            ctx.beginPath();
            ctx.moveTo(centerX, centerY);
            ctx.arc(centerX, centerY, radius, startAngle, endAngle);
            ctx.closePath();
            ctx.fillStyle = currentColors[i] || '#CCCCCC';
            ctx.fill();
            ctx.strokeStyle = '#1F2937';
            ctx.lineWidth = 2;
            ctx.stroke();

            // Draw text with black outline (no shadow on text to keep it crisp)
            ctx.save();
            ctx.translate(centerX, centerY);
            ctx.rotate(startAngle + angleStep / 2);
            ctx.textAlign = 'center';
            ctx.font = 'bold 11px "Segoe UI", "Poppins", sans-serif';
            
            // Black outline
            ctx.strokeStyle = '#000000';
            ctx.lineWidth = 3;
            ctx.strokeText(segments[i].label, radius * 0.7, 8);
            // White fill
            ctx.fillStyle = '#FFFFFF';
            ctx.fillText(segments[i].label, radius * 0.7, 8);
            
            ctx.restore();
        }

        // Remove shadow for the center dot (already drawn via CSS)
        ctx.shadowColor = 'transparent';
        
        // (Optional) add a tiny glossy overlay at the center – the CSS dot covers it, but we can draw a subtle highlight
        ctx.beginPath();
        ctx.arc(centerX, centerY, 14, 0, 2 * Math.PI);
        ctx.fillStyle = 'rgba(255, 255, 255, 0.1)';
        ctx.fill();
    }

// ----- Animate spin with many rotations and longer duration -----
function spinToSegment(targetIndex, duration = 4000, spins = 30, onComplete = null) {
    if (isSpinning) return;
    isSpinning = true;

    const segments = currentSegments;
    const angleStep = (Math.PI * 2) / segments.length;
    
    // The angle where the pointer (top) points to the center of the target segment
    const targetAngle = (-Math.PI / 2) - (targetIndex * angleStep) - (angleStep / 2);
    let targetRotation = targetAngle % (2 * Math.PI);
    if (targetRotation < 0) targetRotation += 2 * Math.PI;

    const startRotation = currentRotation;

    // Compute the shortest angular distance from start to target (without extra spins)
    let baseDelta = (targetRotation - startRotation + 2 * Math.PI) % (2 * Math.PI);
    // Add the desired number of full rotations
    const delta = baseDelta + spins * 2 * Math.PI;

    const startTime = performance.now();

    function animateSpin(now) {
        const elapsed = now - startTime;
        const progress = Math.min(elapsed / duration, 1);
        // Easing for a natural slowdown
        const easeProgress = 1 - Math.pow(1 - progress, 3);
        currentRotation = startRotation + delta * easeProgress;

        drawWheel(segments, currentRotation);

        if (progress < 1) {
            animationFrame = requestAnimationFrame(animateSpin);
        } else {
            currentRotation = targetRotation; // ensure final exact alignment
            drawWheel(segments, currentRotation);
            isSpinning = false;
            animationFrame = null;
            if (onComplete) onComplete();
        }
    }

    animationFrame = requestAnimationFrame(animateSpin);
}

    // ----- Update wheel when amount changes (unchanged) -----
    function updateWheelForAmount(amount) {
        currentSegments = generateSegments(amount);
        currentColors = getColorsForAmount(amount);
        drawWheel(currentSegments, currentRotation);
    }

    // ----- Initialisation (unchanged) -----
    updatePrizeButtonsState();
    const defaultAmount = [...prizeBtns].find(btn => !btn.disabled)?.dataset.amount || 100;
    selectedAmount = parseInt(defaultAmount, 10);
    updateWheelForAmount(selectedAmount);

    // ----- Amount selection (unchanged) -----
    prizeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (btn.disabled) return;

            prizeBtns.forEach(b => {
                b.classList.remove(
                    'bg-purple-600', 'shadow-lg', 'scale-105',
                    'ring-2', 'ring-purple-300', 'ring-offset-2', 'ring-offset-gray-950'
                );
                if (!b.disabled) {
                    b.classList.add('bg-purple-700', 'hover:bg-purple-600');
                }
            });
            btn.classList.remove('bg-purple-700', 'hover:bg-purple-600');
            btn.classList.add(
                'bg-purple-600', 'shadow-lg', 'scale-105',
                'ring-2', 'ring-purple-300', 'ring-offset-2', 'ring-offset-gray-950'
            );

            selectedAmount = parseInt(btn.dataset.amount, 10);
            statusEl.textContent = `Selected: Rs ${selectedAmount.toLocaleString('en-IN')}`;
            spinBtn.disabled = false;
            resultEl.classList.add('hidden');

            if (!isSpinning) {
                updateWheelForAmount(selectedAmount);
            }
        });
    });

    // ==================== MODIFIED SPIN LOGIC ====================
    // ----- Spin with "never lose" conversion -----
    spinBtn.addEventListener('click', async () => {
        if (!selectedAmount || isSpinning) return;

        // Stop any previous loop sound and reset
        stopLoopSound();

        // Play start sound (user interaction makes this possible)
        spinStartSound.play().catch(e => console.log('Start sound error:', e));
        // Play loop sound (will continue until we stop it)
        spinLoopSound.play().catch(e => console.log('Loop sound error:', e));

        spinBtn.disabled = true;
        spinBtn.innerHTML = '<span class="loading loading-spinner"></span> Spinning...';
        statusEl.textContent = 'Spinning...';
        resultEl.classList.add('hidden');

        // Save current balance before spinning
        const oldBalanceText = balanceStat.textContent.replace(/[^0-9.-]/g, '');
        const oldBalance = parseFloat(oldBalanceText) || 0;

        try {
            const response = await fetch('/lucky-spin', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                },
                body: JSON.stringify({ amount: selectedAmount })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Something went wrong');
            }

            // ----- CONVERT LOSS TO WIN OF ₹10 -----
            if (!data.win) {
                data.win = true;
                data.prize = 10;
            }

            // Find the segment index that best matches the prize (for wheel animation)
            const segments = currentSegments;
            let targetIndex = 0;
            let minDiff = Infinity;
            segments.forEach((seg, idx) => {
                const diff = Math.abs(seg.value - data.prize);
                if (diff < minDiff) {
                    minDiff = diff;
                    targetIndex = idx;
                }
            });

            // Spin with 5 seconds duration and 40 full rotations
            spinToSegment(targetIndex, 5000, 40, () => {
                // This callback runs when animation finishes
                stopLoopSound();                     // stop the continuous spin sound
                spinEndSound.play().catch(e => console.log('End sound error:', e));

                // Always show a winning message
                resultEl.innerHTML = `🎉 <span class="text-success">CONGRATULATIONS!</span><br>You won Rs ${data.prize}!`;
                resultEl.classList.remove('hidden', 'text-error');
                resultEl.classList.add('text-success');

                // Calculate new balance: old - bet + prize
                const newBalance = oldBalance - selectedAmount + data.prize;
                balanceStat.textContent = 'Rs ' + newBalance.toLocaleString('en-IN');

                // Refresh prize buttons state (enable/disable based on new balance)
                updatePrizeButtonsState();

                // Re‑enable spin button only if selected amount still affordable
                if (selectedAmount <= newBalance) {
                    spinBtn.disabled = false;
                    spinBtn.innerHTML = 'SPIN NOW';
                    statusEl.textContent = `Selected: Rs ${selectedAmount.toLocaleString('en-IN')}`;
                } else {
                    spinBtn.disabled = true;
                    spinBtn.innerHTML = 'SPIN NOW';
                    statusEl.textContent = 'Insufficient balance for selected amount';
                }
            });

        } catch (err) {
            // If error occurs, stop sounds and re-enable button appropriately
            stopLoopSound();
            resultEl.innerHTML = `Error: ${err.message}`;
            resultEl.classList.remove('hidden');
            resultEl.classList.add('text-error');
            spinBtn.disabled = true;  // keep disabled until new selection
            spinBtn.innerHTML = 'SPIN NOW';
            statusEl.textContent = 'Choose amount to spin';
        }
    });
    // ==============================================================
});
</script>



</body>
</html><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/user/games/lucky_spin.blade.php ENDPATH**/ ?>