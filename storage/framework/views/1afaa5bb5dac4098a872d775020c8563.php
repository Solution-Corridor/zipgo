<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: #f5f5f5;
    }

    .feature-desk-navbar {
        background: linear-gradient(135deg, #1f2937, #111827);
        height: 60px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        padding: 0 16px;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        transition: height 0.3s ease;
    }

    .feature-desk-logo {
        width: 60px;
        margin: 0 10px;
        height: 32px;
        background: transparent;
        /* background: #8A2BE2; */
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 15px;
        flex-shrink: 0;
    }

    .nav-links {
        display: flex;
        gap: 20px;
        color: white;
        font-size: 14px;
        font-weight: 500;
    }

    .nav-links a {
        color: white;
        text-decoration: none;
        position: relative;
        padding: 8px 0;
        transition: opacity 0.2s;
    }

    .nav-links a:hover {
        opacity: 0.85;
    }

    .nav-links a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: white;
        transition: width 0.25s ease-out;
        transform: translateX(-50%);
    }

    .nav-links a:hover::after {
        width: 100%;
    }

    .categories-btn {
        background: none;
        border: none;
        color: white;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 8px 0;
        position: relative;
    }

    .categories-btn::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: white;
        transition: width 0.25s ease-out;
        transform: translateX(-50%);
    }

    .categories-btn:hover::after {
        width: 100%;
    }

    /* Search */
    .search-container {
        flex: 1;
        max-width: 680px;
        margin: 0 20px;
        position: relative;
    }

    .search-bar {
        width: 100%;
        height: 40px;
        background: white;
        border-radius: 5px;
        padding: 0 45px 0 20px;
        border: none;
        font-size: 15px;
        outline: none;
    }

    .search-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        background: #333;
        mask: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z'/%3E%3C/svg%3E") center/20px no-repeat;
        cursor: pointer;
    }

    .navbar-right {
        display: flex;
        gap: 16px;
        align-items: center;
        color: white;
        font-size: 14px;
    }

    .navbar-right a {
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Hamburger Menu (Mobile) */
    .hamburger {
        display: none;
        flex-direction: column;
        gap: 4px;
        cursor: pointer;
    }

    .hamburger span {
        width: 25px;
        height: 3px;
        background: white;
        border-radius: 2px;
        transition: 0.3s;
    }

    /* Mobile Menu Overlay */
    .mobile-menu {
        position: fixed;
        top: 40px;
        left: 0;
        right: 0;
        background: linear-gradient(135deg, #1f2937 0%, #1a2433 25%, #141c2b 50%, #0f172a 75%, #020617 100%);
        padding: 20px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        transform: translateY(-100%);
        transition: transform 0.35s ease;
        z-index: 999;
    }

    .mobile-menu.active {
        transform: translateY(0);
    }

    .mobile-menu a {
        display: block;
        padding: 14px 0;
        color: #fff;
        font-size: 16px;
        border-bottom: 1px solid #eee;
    }

    /* Dropdown (Desktop + Mobile) */
    .categories-dropdown {
        position: relative;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        width: 220px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        padding: 12px 0;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.22s ease-out;
        z-index: 999;
        color: #333;
    }

    .dropdown-menu a {
        padding: 10px 20px;
        display: block;
        color: inherit;
    }

    .dropdown-menu a:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .dropdown-menu:hover {
        background: #000 !important;
        color: white !important;
    }

    .categories-dropdown.active .dropdown-menu,
    .categories-dropdown:hover .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    /* RESPONSIVE BREAKPOINTS */
    @media (max-width: 1024px) {
        .nav-links {
            gap: 16px;
            font-size: 13.5px;
        }

        .search-container {
            margin: 0 16px;
        }
    }

    @media (max-width: 900px) {

        .nav-links,
        .navbar-right>a:not(:last-child) {
            display: none;
        }

        .hamburger {
            display: flex;
        }

        .search-container {
            margin: 0 12px;
            max-width: none;
        }

        .feature-desk-navbar {
            justify-content: space-between;
        }
    }

    @media (max-width: 480px) {
        .feature-desk-navbar {
            height: 56px;
            padding: 0 12px;
        }

        .feature-desk-logo {
            width: 80px;
            font-size: 13px;
        }

        .search-bar {
            height: 38px;
            font-size: 14px;
        }
    }
</style>

<nav class="feature-desk-navbar">
    <div class="navbar-right">
        <div class="hamburger">
            <span></span><span></span><span></span>
        </div>
    </div>
    
    <div class="nav-links">
        <a href="/quick-selling">Quick Selling</a>
        <a href="/high-rated">High Rated</a>
        <a href="/new-products">New Arrival</a>
        <a href="/categories">Categories</a>
        <?php if(auth()->guard()->guest()): ?>
        <a href="/login">Login</a>
        <a href="/register">Register</a>
        <?php endif; ?>
        <?php if(auth()->guard()->check()): ?>
        <?php if(auth()->user()->type == 0): ?>
        <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
        <?php else: ?>
        <a href="<?php echo e(route('user_dashboard')); ?>">Dashboard</a>
        <?php endif; ?>
            <a href="/logout" class="text-danger">Logout</a>
        <?php endif; ?>
    </div>

    <div class="search-container">
        <form action="/search" method="GET" class="search-form position-relative">
            <input type="text" name="query" class="search-bar" placeholder="Search Feature Desk" required>
        </form>
        <div class="search-icon"></div>
    </div>

    <a href="/">
        <div class="feature-desk-logo">
            <img src="/assets/images/logo.png" alt="feature-desk-logo" title="Feature Desk Logo">
        </div>
    </a>

    
</nav>

<!-- Mobile Menu -->
<div class="mobile-menu">
    
    <?php if(auth()->guard()->guest()): ?>
    <a href="/login"><i class="fa fa-sign-in-alt"></i> Login</a>
    <a href="/register"><i class="fa fa-user-plus"></i> Register</a>
    <?php endif; ?>

    <?php if(auth()->guard()->check()): ?>
        <?php if(auth()->user()->type == 0): ?>
            <a href="<?php echo e(route('dashboard')); ?>" style="color: #fc0;">
                <i class="fa fa-tachometer-alt"></i> Dashboard
            </a>
        <?php else: ?>
            <a href="<?php echo e(route('user_dashboard')); ?>" style="color: #fc0;">
                <i class="fa fa-user-circle"></i> Dashboard
            </a>
        <?php endif; ?>
    <?php endif; ?>

    <a href="/quick-selling">
        <i class="fa fa-bolt"></i> Quick Selling
    </a>

    <a href="/high-rated">
        <i class="fa fa-star"></i> High Rated
    </a>

    <a href="/new-products">
        <i class="fa fa-box-open"></i> New Arrival
    </a>

    <a href="/categories">
        <i class="fa fa-th-large"></i> Categories
    </a>

    <?php if(auth()->guard()->check()): ?>
    <a href="/logout" style="color: #f00;">
        <i class="fa fa-sign-out-alt"></i> Logout
    </a>
    <?php endif; ?>

</div>

<script>
    // Mobile menu toggle
    document.querySelector('.hamburger').addEventListener('click', function(e) {
        e.stopPropagation();
        document.querySelector('.mobile-menu').classList.toggle('active');
    });

    // Categories dropdown (desktop + mobile click)
    document.querySelector('.categories-btn').addEventListener('click', function(e) {
        e.stopPropagation();
        document.querySelector('.categories-dropdown').classList.toggle('active');
    });

    // Close everything on outside click
    document.addEventListener('click', function() {
        document.querySelector('.categories-dropdown').classList.remove('active');
        document.querySelector('.mobile-menu').classList.remove('active');
    });
</script><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/market/website/includes/navbar.blade.php ENDPATH**/ ?>