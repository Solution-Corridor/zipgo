<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    @include('user.includes.general_style')
    <title>Games</title>
    <style>
        .games-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(92px, 1fr));
            gap: 14px;
        }

        .game-card {
            background: linear-gradient(145deg, #1a1a2e, #0f1629);
            border-radius: 14px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 
                0 8px 25px rgba(0, 0, 0, 0.6),
                inset 0 1px 0 rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.07);
            position: relative;
        }
        
        .game-card:hover {
            transform: translateY(-6px) scale(1.04);
            box-shadow: 
                0 15px 35px rgba(0, 0, 0, 0.7),
                0 0 30px rgba(255,255,255,0.1);
        }

        .game-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(
                120deg,
                transparent,
                rgba(255,255,255,0.2),
                transparent
            );
            transition: 0.6s;
            z-index: 2;
        }

        .game-card:hover::before {
            left: 150%;
        }

        .game-card .image-container {
            height: 60px;           /* ← Reduced height */
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .game-card .image-container::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(255,255,255,0.22) 0%,
                rgba(255,255,255,0.06) 50%,
                transparent 70%
            );
            z-index: 1;
        }

        .game-card .image-container::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.85), transparent 70%);
            z-index: 1;
        }

        .neon-text {
            font-size: 1.15rem;     /* Smaller neon text */
            font-weight: 900;
            text-shadow: 
                0 0 15px currentColor,
                0 0 30px currentColor;
            letter-spacing: -1px;
            z-index: 2;
            position: relative;
        }

        .game-title {
            font-size: 0.89rem;     /* Smaller title */
            font-weight: 700;
            line-height: 1.1;
            text-shadow: 0 2px 8px rgba(0,0,0,0.7);
        }

        .category-badge {
            font-size: 8.5px;
            font-weight: 600;
            padding: 2px 9px;
            border-radius: 9999px;
            background: rgba(255,255,255,0.09);
            border: 1px solid rgba(255,255,255,0.12);
            margin-top: 6px;
            display: inline-block;
        }
    </style>
</head>

<body class="min-h-screen text-gray-200 flex items-start justify-center">

    <div class="w-full max-w-[420px] min-h-screen relative" style="background: #0B0B12;">

        @include('user.includes.top_greetings')

        <!-- ================== GAME ZONE ================== -->
        <div class="mb-20 px-4 py-6">

            @include('includes.success')

            <!-- Games Grid -->
            <div class="games-grid">

                <!-- Original 3 Games -->
                <a href="{{ route('games.burst-numbers') }}" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-purple-600 via-violet-600 to-pink-600">
                        <div class="neon-text text-white/95">BURST</div>
                        <div class="absolute bottom-2 right-2 text-4xl">💥</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Burst Numbers</h2>
                        <span class="category-badge text-purple-300">ACTION</span>
                    </div>
                </a>

                <a href="{{ route('games.profit-ball') }}" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-emerald-500 via-cyan-500 to-teal-600">
                        <div class="neon-text text-white/95">PROFIT</div>
                        <div class="absolute bottom-2 right-2 text-4xl">⚽💰</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Profit Ball</h2>
                        <span class="category-badge text-emerald-300">MULTIPLIER</span>
                    </div>
                </a>

                <a href="{{ route('games.lucky-spin') }}" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-amber-500 via-orange-500 to-red-500">
                        <div class="neon-text text-white/95 tracking-widest">SPIN</div>
                        <div class="absolute bottom-1 text-5xl">🎡</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Lucky Spin</h2>
                        <span class="category-badge text-amber-300">FORTUNE</span>
                    </div>
                </a>

                <!-- 17 New Compact Games -->
                <a href="#" onclick="showBalanceAlert(); return false;" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700">
                        <div class="neon-text text-white/95">CRASH</div>
                        <div class="absolute bottom-2 right-2 text-4xl">🚀</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Rocket Crash</h2>
                        <span class="category-badge text-blue-300">CRASH</span>
                    </div>
                </a>

                <a href="#" onclick="showBalanceAlert(); return false;" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-red-600 via-rose-600 to-pink-600">
                        <div class="neon-text text-white/95">MINE</div>
                        <div class="absolute bottom-2 right-2 text-4xl">💣</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Mine Blast</h2>
                        <span class="category-badge text-red-300">MINES</span>
                    </div>
                </a>

                <a href="#" onclick="showBalanceAlert(); return false;" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-yellow-500 via-amber-500 to-orange-600">
                        <div class="neon-text text-white/95">DICE</div>
                        <div class="absolute bottom-2 right-2 text-4xl">🎲</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Lucky Dice</h2>
                        <span class="category-badge text-amber-300">DICE</span>
                    </div>
                </a>

                <a href="#" onclick="showBalanceAlert(); return false;" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-cyan-500 via-sky-500 to-blue-600">
                        <div class="neon-text text-white/95">PLINKO</div>
                        <div class="absolute bottom-2 right-2 text-4xl">🔽</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Plinko Rush</h2>
                        <span class="category-badge text-cyan-300">PLINKO</span>
                    </div>
                </a>

                <a href="#" onclick="showBalanceAlert(); return false;" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-lime-500 via-green-500 to-emerald-600">
                        <div class="neon-text text-white/95">TOWER</div>
                        <div class="absolute bottom-2 right-2 text-4xl">🏗️</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Tower Climb</h2>
                        <span class="category-badge text-lime-300">TOWER</span>
                    </div>
                </a>

                <a href="#" onclick="showBalanceAlert(); return false;" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-violet-600 via-purple-600 to-fuchsia-600">
                        <div class="neon-text text-white/95">KENO</div>
                        <div class="absolute bottom-2 right-2 text-4xl">🎯</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Lightning Keno</h2>
                        <span class="category-badge text-violet-300">KENO</span>
                    </div>
                </a>

                <a href="#" onclick="showBalanceAlert(); return false;" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-orange-600 via-red-600 to-rose-700">
                        <div class="neon-text text-white/95">FLIP</div>
                        <div class="absolute bottom-2 right-2 text-4xl">🪙</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Coin Flip</h2>
                        <span class="category-badge text-orange-300">50/50</span>
                    </div>
                </a>

                <a href="#" onclick="showBalanceAlert(); return false;" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-teal-500 via-cyan-500 to-sky-600">
                        <div class="neon-text text-white/95">AVI</div>
                        <div class="absolute bottom-2 right-2 text-4xl">✈️</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Aviator X</h2>
                        <span class="category-badge text-teal-300">CRASH</span>
                    </div>
                </a>

                <a href="#" onclick="showBalanceAlert(); return false;" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-pink-600 via-rose-600 to-purple-700">
                        <div class="neon-text text-white/95">SLOTS</div>
                        <div class="absolute bottom-2 right-2 text-4xl">🎰</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Mega Slots</h2>
                        <span class="category-badge text-pink-300">SLOTS</span>
                    </div>
                </a>

                <a href="#" onclick="showBalanceAlert(); return false;" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-indigo-600 via-blue-600 to-cyan-600">
                        <div class="neon-text text-white/95">GOAL</div>
                        <div class="absolute bottom-2 right-2 text-4xl">⚽</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Penalty Shot</h2>
                        <span class="category-badge text-indigo-300">SPORTS</span>
                    </div>
                </a>

                <a href="#" onclick="showBalanceAlert(); return false;" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-amber-600 via-yellow-500 to-orange-500">
                        <div class="neon-text text-white/95">HI-LO</div>
                        <div class="absolute bottom-2 right-2 text-4xl">⬆️⬇️</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Hi Lo</h2>
                        <span class="category-badge text-amber-300">CARD</span>
                    </div>
                </a>

                <a href="#" onclick="showBalanceAlert(); return false;" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-700">
                        <div class="neon-text text-white/95">WHEEL</div>
                        <div class="absolute bottom-2 right-2 text-4xl">🎡</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Lucky Wheel</h2>
                        <span class="category-badge text-emerald-300">WHEEL</span>
                    </div>
                </a>

                <a href="#" onclick="showBalanceAlert(); return false;" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-purple-700 via-violet-700 to-fuchsia-700">
                        <div class="neon-text text-white/95">BATTLE</div>
                        <div class="absolute bottom-2 right-2 text-4xl">⚔️</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Battle Arena</h2>
                        <span class="category-badge text-purple-300">PVP</span>
                    </div>
                </a>

                <a href="#" onclick="showBalanceAlert(); return false;" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-rose-500 via-pink-500 to-purple-600">
                        <div class="neon-text text-white/95">BJ</div>
                        <div class="absolute bottom-2 right-2 text-4xl">♠️</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Blackjack</h2>
                        <span class="category-badge text-rose-300">TABLE</span>
                    </div>
                </a>

                <a href="#" onclick="showBalanceAlert(); return false;" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-sky-600 via-blue-600 to-indigo-700">
                        <div class="neon-text text-white/95">PREDICT</div>
                        <div class="absolute bottom-2 right-2 text-4xl">🔮</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Number Predict</h2>
                        <span class="category-badge text-sky-300">PREDICT</span>
                    </div>
                </a>

                <a href="#" onclick="showBalanceAlert(); return false;" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-lime-600 via-green-600 to-emerald-700">
                        <div class="neon-text text-white/95">HAMMER</div>
                        <div class="absolute bottom-2 right-2 text-4xl">🔨</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Hammer Smash</h2>
                        <span class="category-badge text-lime-300">ARCADE</span>
                    </div>
                </a>

                <a href="#" onclick="showBalanceAlert(); return false;" class="game-card block">
                    <div class="image-container bg-gradient-to-br from-fuchsia-600 via-pink-600 to-rose-600">
                        <div class="neon-text text-white/95">JACK</div>
                        <div class="absolute bottom-2 right-2 text-4xl">💎</div>
                    </div>
                    <div class="p-2.5 text-center">
                        <h2 class="game-title text-white">Diamond Jackpot</h2>
                        <span class="category-badge text-fuchsia-300">JACKPOT</span>
                    </div>
                </a>

            </div>

        </div>

        @include('user.includes.bottom_navigation')
    </div>
<!-- SweetAlert2 CDN - Latest version -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
    function showBalanceAlert() {
        Swal.fire({
            title: 'Insufficient Balance',
            text: 'Your Balance is not enough for this game.',
            icon: 'warning',
            confirmButtonText: 'OK',
            confirmButtonColor: '#f59e0b',     // Nice orange/gold color
            background: '#1a1a2e',
            color: '#e2e8f0',
            iconColor: '#f59e0b',
            customClass: {
                popup: 'mobile-sweetalert',
                title: 'swal-title',
                htmlContainer: 'swal-text',
                confirmButton: 'swal-confirm-btn'
            },
            width: '90%',                      // Better for mobile
            padding: '1.8rem',
            showCloseButton: true,
            timer: 4000,                       // Auto close after 4 seconds
            timerProgressBar: true,
            backdrop: 'rgba(0,0,0,0.85)'
        });
    }

    // Optional: Add some extra mobile-friendly CSS
    const style = document.createElement('style');
    style.innerHTML = `
        .mobile-sweetalert {
            border-radius: 20px !important;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6) !important;
        }
        .swal-title {
            font-size: 1.35rem !important;
            font-weight: 700 !important;
        }
        .swal-text {
            font-size: 1.05rem !important;
            line-height: 1.5 !important;
        }
        .swal-confirm-btn {
            padding: 12px 28px !important;
            font-size: 1.1rem !important;
            border-radius: 9999px !important;
            font-weight: 600 !important;
        }
        @media (max-width: 480px) {
            .swal-popup {
                width: 92% !important;
                margin: 0 auto !important;
            }
        }
    `;
    document.head.appendChild(style);
</script>

</body>
</html>