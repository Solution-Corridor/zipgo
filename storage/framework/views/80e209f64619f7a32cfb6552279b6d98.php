<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <?php echo $__env->make('user.includes.general_style', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Pre Dashboard | Compact</title>
    <style>
        /* compact, scroll-minimized style for all option boxes */
        .option-box {
            background: linear-gradient(145deg, #1a1f2e, #0f172a);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 20px;
            padding: 10px 6px;
            text-align: center;
            transition: all 0.2s ease;
            color: white;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .option-box:hover {
            background: linear-gradient(145deg, #232a3b, #111827);
            transform: translateY(-2px);
            border-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.4);
        }

        .option-box .icon {
            font-size: 1.9rem;
            margin-bottom: 6px;
            display: block;
            filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.3));
        }

        .option-box .title {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: -0.2px;
            margin-bottom: 2px;
        }

        .option-box .subtitle {
            font-size: 0.65rem;
            color: #a0aec0;
            font-weight: 500;
            line-height: 1.2;
        }

        /* recharge gradient */
        .recharge-special {
            background: linear-gradient(135deg, #7c3aed, #a855f7);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .recharge-special:hover {
            background: linear-gradient(135deg, #8b5cf6, #c084fc);
        }

        .recharge-special .subtitle {
            color: #e9d5ff;
        }

        /* my orders accent */
        .orders-accent {
            background: linear-gradient(145deg, #1e2438, #13182a);
            border-bottom: 2px solid #f59e0b30;
        }

        .orders-accent:hover {
            border-bottom-color: #f59e0b;
        }

        /* grid */
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.7rem;
        }

        .compact-content {
            padding: 0.75rem 1rem 85px 1rem;
        }

        /* ============== BIG FOLLOW US BOX ============== */
        .follow-us-box {
            background: linear-gradient(145deg, #1a1f2e, #0f172a);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 20px 16px;
            margin: 20px 0 15px 0;
            text-align: center;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }

        .follow-us-box h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 4px;
            color: #e0f2fe;
        }

        .follow-us-box p {
            font-size: 0.8rem;
            color: #94a3b8;
            margin-bottom: 16px;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .social-icons a {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #cbd5e1;
            text-decoration: none;
            font-size: 0.75rem;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            color: #60a5fa;
            transform: translateY(-3px);
        }

        .social-icons i {
            font-size: 1.4rem;
            /* Slightly larger for Lucide */
            margin-bottom: 5px;
        }

        /* Platform specific hover colors */
        .social-icons .icon {
            font-size: 1.4rem;
            margin-bottom: 6px;
            display: block;
            line-height: 1;
        }

        /* Keep your hover colors */
        .social-icons a.facebook:hover {
            color: #1877f2;
        }

        .social-icons a.instagram:hover {
            color: #e1306c;
        }

        .social-icons a.youtube:hover {
            color: #ff0000;
        }

        .social-icons a.pinterest:hover {
            color: #e60023;
        }

        .social-icons a.tiktok:hover {
            color: #000000;
        }
    </style>
</head>

<body class="min-h-screen text-gray-200 flex items-start justify-center">
    <div class="w-full max-w-[420px] min-h-screen relative" style="background: #0B0B12;">

        <?php echo $__env->make('user.includes.top_greetings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- ========== COMPACT CONTENT ========== -->
        <div class="compact-content">

            <!-- Options Grid -->
            <div class="grid">
                <!-- Shopping -->
                <a href="<?php echo e(route('home')); ?>" class="option-box">
                    <div class="icon">🛍️</div>
                    <div class="title">Shopping</div>
                    <div class="subtitle">Earn & Shop</div>
                </a>

                <!-- Games -->
                <a href="<?php echo e(route('games')); ?>" class="option-box">
                    <div class="icon">🎮</div>
                    <div class="title">Games</div>
                    <div class="subtitle">Play & Earn</div>
                </a>

                <!-- Tasks -->
                <a href="<?php echo e(route('my_tasks')); ?>" class="option-box">
                    <div class="icon">✅</div>
                    <div class="title">Tasks</div>
                    <div class="subtitle">Complete & Earn</div>
                </a>

                <!-- Crypto -->
                <a href="<?php echo e(route('crypto')); ?>" class="option-box">
                    <div class="icon">₿</div>
                    <div class="title">Crypto</div>
                    <div class="subtitle">Trade & Invest</div>
                </a>

                <!-- Recharge Account -->
                <a href="<?php echo e(route('market.recharge')); ?>" class="option-box recharge-special">
                    <div class="icon">⚡📱</div>
                    <div class="title">Recharge Account</div>
                    <div class="subtitle">Add funds & pay</div>
                </a>

                <!-- My Orders -->
                <a href="<?php echo e(route('my_orders')); ?>" class="option-box orders-accent">
                    <div class="icon">📦🧾</div>
                    <div class="title">My Orders</div>
                    <div class="subtitle">Track & history</div>
                </a>
            </div>

            <!-- ================= BIG FOLLOW US BOX ================= -->
            <div class="follow-us-box">
                <h3>Follow Us</h3>
                <p>Stay updated with latest offers, news & rewards</p>

                <div class="social-icons">
                    <a href="https://www.facebook.com/FeaturedeskOfficial" target="_blank" rel="nofollow noopener noreferrer" class="facebook">
                        <i class="fab fa-facebook-f"></i> <!-- Facebook -->
                        <span>Facebook</span>
                    </a>

                    <a href="https://www.instagram.com/featuredeskofficial/" target="_blank" rel="nofollow noopener noreferrer" class="instagram">
                        <i class="fab fa-instagram"></i> <!-- Instagram -->
                        <span>Instagram</span>
                    </a>

                    <a href="https://www.youtube.com/@featuredeskofficial" target="_blank" rel="nofollow noopener noreferrer" class="youtube">
                        <i class="fab fa-youtube"></i> <!-- YouTube -->
                        <span>YouTube</span>
                    </a>

                    <a href="https://www.pinterest.com/FeaturedeskOfficial/" target="_blank" rel="nofollow noopener noreferrer" class="pinterest">
                        <i class="fab fa-pinterest"></i> <!-- Pinterest -->
                        <span>Pinterest</span>
                    </a>

                    <a href="https://www.tiktok.com/@featuredeskofficial" target="_blank" rel="nofollow noopener noreferrer" class="tiktok">
                        <i class="fab fa-tiktok"></i> <!-- TikTok -->
                        <span>TikTok</span>
                    </a>
                </div>
            </div>

        </div>

        <?php echo $__env->make('user.includes.bottom_navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    <!-- Make sure Lucide icons are loaded -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/user/pre_dashboard.blade.php ENDPATH**/ ?>