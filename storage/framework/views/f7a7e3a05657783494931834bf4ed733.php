<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <?php echo $__env->make('user.includes.general_style', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <title>Crypto Wallet</title>

    <!-- Optional: Add Font Awesome or Heroicons if you want more icons -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> -->
</head>

<body class="min-h-screen text-gray-200 flex items-start justify-center bg-gradient-to-b from-[#0B0B12] to-[#0F0F1E]">

    <div class="w-full max-w-[420px] min-h-screen relative" style="background: #0B0B12;">

        <?php echo $__env->make('user.includes.top_greetings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- ================== RED ELIGIBILITY MESSAGE BAR ================== -->
         <div class="px-4 mt-2 mb-2">
        <div class="flex items-center gap-3 px-4 py-3 bg-red-900/30 border border-red-700/40 rounded-lg text-red-200 text-sm mb-3">
            <div class="flex items-center justify-center gap-2.5 text-red-100 text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
                <span>You are not eligible for this plan currently</span>
            </div>
        </div>
         </div>

        <!-- ================== Crypto Content Starts Here ================== -->
        <div class="px-5 py-5 space-y-6" style="padding-bottom: 100px;">

            <!-- Balance Card -->
            <div class="bg-gradient-to-br from-indigo-950/70 to-purple-950/40 backdrop-blur-xl border border-indigo-500/20 rounded-2xl p-6 shadow-2xl">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm">Total Portfolio Value</p>

<h2 id="portfolioValue" class="text-3xl font-bold text-white mt-1">$12,847.32</h2>

<p id="portfolioChange" class="text-green-400 text-sm font-medium mt-1 flex items-center">
    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h3.586l-1.293-1.293a1 1 0 111.414-1.414l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L15.586 7H12zM5 13a1 1 0 100 2H8.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L4.414 15H8z" clip-rule="evenodd"/>
    </svg>
    +4.82% (24h)
</p>

<span id="portfolioBadge" class="text-xs bg-indigo-600/40 text-indigo-300 px-2.5 py-1 rounded-full">+2.1%</span>
                    </div>
                    <div class="text-right">
                        <span class="text-xs bg-indigo-600/40 text-indigo-300 px-2.5 py-1 rounded-full">+2.1%</span>
                    </div>
                </div>

                <!-- Mini Sparkline Chart (more realistic fake version) -->
                <div class="mt-5 h-20 bg-black/30 rounded-lg overflow-hidden border border-indigo-500/10 relative">
                    <svg class="w-full h-full" viewBox="0 0 300 80" preserveAspectRatio="none">

                        <!-- subtle grid -->
                        <g opacity="0.08" stroke="#4f46e5" stroke-width="0.5">
                            <line x1="0" y1="20" x2="300" y2="20" />
                            <line x1="0" y1="40" x2="300" y2="40" />
                            <line x1="0" y1="60" x2="300" y2="60" />
                        </g>

                        <defs>
                            <linearGradient id="grad" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#10b981" stop-opacity="0.35" />
                                <stop offset="100%" stop-color="#10b981" stop-opacity="0" />
                            </linearGradient>
                        </defs>

                        <!-- realistic fake volatility -->
                        <path d="
            M0,64
            L20,60
            L40,62
            L60,57
            L80,59
            L100,52
            L120,48
            L140,50
            L160,45
            L180,41
            L200,43
            L220,36
            L240,32
            L260,34
            L280,26
            L300,20"
                            fill="url(#grad)"
                            stroke="#10b981"
                            stroke-width="2.5"
                            stroke-linecap="round"
                            stroke-linejoin="round" />

                        <!-- current value dot -->
                        <circle cx="300" cy="20" r="4"
                            fill="#10b981"
                            filter="drop-shadow(0 0 6px #10b981)" />
                    </svg>

                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <span class="text-xs text-green-500/40 font-mono tracking-wider">↑ Portfolio Trend</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-4 gap-3">
                <button class="flex flex-col items-center py-3 bg-gray-900/60 border border-gray-700/50 rounded-xl hover:bg-indigo-900/40 transition">
                    <svg class="w-7 h-7 text-indigo-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="text-xs">Deposit</span>
                </button>
                <button class="flex flex-col items-center py-3 bg-gray-900/60 border border-gray-700/50 rounded-xl hover:bg-purple-900/40 transition">
                    <svg class="w-7 h-7 text-purple-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    <span class="text-xs">Withdraw</span>
                </button>
                <button class="flex flex-col items-center py-3 bg-gray-900/60 border border-gray-700/50 rounded-xl hover:bg-pink-900/40 transition">
                    <svg class="w-7 h-7 text-pink-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4 4m4-4l-4-4m-8 12h-4m0 0l4-4m-4 4l4 4" />
                    </svg>
                    <span class="text-xs">Swap</span>
                </button>
                <button class="flex flex-col items-center py-3 bg-gray-900/60 border border-gray-700/50 rounded-xl hover:bg-cyan-900/40 transition">
                    <svg class="w-7 h-7 text-cyan-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span class="text-xs">Send</span>
                </button>
            </div>

            <!-- Assets List -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <span>Your Assets</span>
                    <span class="ml-2 text-xs bg-gray-800 px-2 py-0.5 rounded-full text-gray-400">7 coins</span>
                </h3>

                <!-- Asset Item -->
                <div class="flex items-center justify-between bg-gray-900/50 border border-gray-800 rounded-xl p-4 hover:bg-gray-800/60 transition">
                    <div class="flex items-center">
                        <img src="/assets/images/btc.png" alt="BTC" class="w-10 h-10 mr-3">
                        <div>
                            <p class="font-medium">Bitcoin</p>
                            <p class="text-xs text-gray-500">BTC</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium">0.1842 BTC</p>
                        <p class="text-sm text-green-400">$12,340.11</p>
                        <p class="text-xs text-green-500">+3.41%</p>
                    </div>
                </div>

                <div class="flex items-center justify-between bg-gray-900/50 border border-gray-800 rounded-xl p-4 hover:bg-gray-800/60 transition">
                    <div class="flex items-center">
                        <img src="/assets/images/eth.png" alt="ETH" class="w-10 h-10 mr-3">
                        <div>
                            <p class="font-medium">Ethereum</p>
                            <p class="text-xs text-gray-500">ETH</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium">2.341 ETH</p>
                        <p class="text-sm text-white">$4,820.55</p>
                        <p class="text-xs text-red-400">-1.12%</p>
                    </div>
                </div>

                <div class="flex items-center justify-between bg-gray-900/50 border border-gray-800 rounded-xl p-4 hover:bg-gray-800/60 transition">
                    <div class="flex items-center">
                        <img src="/assets/images/usdt.png" alt="USDT" class="w-10 h-10 mr-3">
                        <div>
                            <p class="font-medium">Tether</p>
                            <p class="text-xs text-gray-500">USDT</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium">2,150 USDT</p>
                        <p class="text-sm text-white">$2,150.00</p>
                        <p class="text-xs text-green-400">+0.02%</p>
                    </div>
                </div>

                <div class="flex items-center justify-between bg-gray-900/50 border border-gray-800 rounded-xl p-4 hover:bg-gray-800/60 transition">
                    <div class="flex items-center">
                        <img src="/assets/images/bnb.png" class="w-10 h-10 mr-3">
                        <div>
                            <p class="font-medium">BNB</p>
                            <p class="text-xs text-gray-500">BNB</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium">5.73 BNB</p>
                        <p class="text-sm text-white">$2,640.21</p>
                        <p class="text-xs text-green-400">+1.74%</p>
                    </div>
                </div>

                <div class="flex items-center justify-between bg-gray-900/50 border border-gray-800 rounded-xl p-4 hover:bg-gray-800/60 transition">
                    <div class="flex items-center">
                        <img src="/assets/images/sol.png" class="w-10 h-10 mr-3">
                        <div>
                            <p class="font-medium">Solana</p>
                            <p class="text-xs text-gray-500">SOL</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium">18.24 SOL</p>
                        <p class="text-sm text-white">$2,018.50</p>
                        <p class="text-xs text-red-400">-0.92%</p>
                    </div>
                </div>

                <div class="flex items-center justify-between bg-gray-900/50 border border-gray-800 rounded-xl p-4 hover:bg-gray-800/60 transition">
                    <div class="flex items-center">
                        <img src="/assets/images/ada.png" class="w-10 h-10 mr-3">
                        <div>
                            <p class="font-medium">Cardano</p>
                            <p class="text-xs text-gray-500">ADA</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium">1,520 ADA</p>
                        <p class="text-sm text-white">$1,065.33</p>
                        <p class="text-xs text-green-400">+2.18%</p>
                    </div>
                </div>

                <div class="flex items-center justify-between bg-gray-900/50 border border-gray-800 rounded-xl p-4 hover:bg-gray-800/60 transition">
                    <div class="flex items-center">
                        <img src="/assets/images/xrp.png" class="w-10 h-10 mr-3">
                        <div>
                            <p class="font-medium">XRP</p>
                            <p class="text-xs text-gray-500">XRP</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium">3,420 XRP</p>
                        <p class="text-sm text-white">$2,412.90</p>
                        <p class="text-xs text-green-400">+4.11%</p>
                    </div>
                </div>

                <!-- Add more coins as needed: SOL, USDT, etc. -->
            </div>

        </div>
        <!-- ================== Content Ends Here ================== -->

        <?php echo $__env->make('user.includes.bottom_navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    </div> <!-- end container -->
<script>
function randomPortfolio() {

    // random value between 11000 and 15000
    let value = (11000 + Math.random() * 4000).toFixed(2);

    // random percent between -5 and +7
    let percent = (Math.random() * 12 - 5).toFixed(2);

    let formatted = Number(value).toLocaleString();

    document.getElementById("portfolioValue").innerText = "$" + formatted;

    let changeEl = document.getElementById("portfolioChange");
    let badgeEl = document.getElementById("portfolioBadge");

    let sign = percent > 0 ? "+" : "";
    let text = sign + percent + "% (24h)";

    changeEl.innerHTML = changeEl.innerHTML.split("</svg>")[0] + "</svg> " + text;

    badgeEl.innerText = sign + percent + "%";

    if (percent >= 0) {
        changeEl.classList.remove("text-red-400");
        changeEl.classList.add("text-green-400");
    } else {
        changeEl.classList.remove("text-green-400");
        changeEl.classList.add("text-red-400");
    }
}

randomPortfolio();
</script>
</body>

</html><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/user/crypto.blade.php ENDPATH**/ ?>