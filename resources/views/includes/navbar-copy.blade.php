@auth
@php
$userId = auth()->user()->id;
@endphp
@endauth

<!-- Top Header -->
<header class="top-header top-header-bg">
    <div class="container">
        <!-- Desktop Layout (single row) -->
        <div class="desktop-header d-none d-md-flex align-items-center justify-content-between">
            <!-- Left Section (Contact + Social) -->
            <div class="d-flex align-items-center gap-4">
                <div class="top-contact">
                    <h3 class="mb-0" style="font-size: 1.0rem;"><i class="bx bx-phone text-white"></i>&nbsp; <a href="tel:+447412803448">0320 4444 778</a></h3>
                </div>
                <div class="top-header-social">
                    <ul class="list-unstyled d-flex gap-3 mb-0">
                        <li><a href="https://facebook.com/" target="_blank"><i class="bx bxl-facebook"></i></a></li>
                        <li><a href="https://www.instagram.com/" target="_blank"><i class="bx bxl-instagram"></i></a></li>
                        <li><a href="https://www.tiktok.com/" target="_blank"><i class="bx bxl-tiktok"></i></a></li>
                    </ul>
                </div>
            </div>

            <!-- Center Section (Search) -->
            <div class="top-header-search mx-4 flex-grow-1" style="max-width: 500px;">
                <form action="/market/search" method="GET" class="search-form position-relative">
                    <input type="text" name="query" class="form-control pr-5" placeholder="Search product..." required>
                    <button type="submit" class="btn position-absolute end-0 top-50 translate-middle-y border-0 bg-transparent">
                        <i class="bx bx-search"></i>
                    </button>
                </form>
            </div>

            <!-- Right Section (Auth) -->
            <div class="top-header-auth">
                @auth
                @if(auth()->user()->level == 0)
                <a href="/dashboard" class="default-btn btn-bg-two border-radius-5 {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
                    Dashboard <i class="bx bx-chevron-right"></i>
                </a>
                @elseif(auth()->user()->level == 1)
                <a href="/user_dashboard" class="default-btn btn-bg-two border-radius-5 {{ request()->segment(1) == 'user_dashboard' ? 'active' : '' }}">
                    Dashboard <i class="bx bx-chevron-right"></i>
                </a>
                @endif
                <a href="/logout" class="default-btn btn-bg-two border-radius-5">Logout <i class="bx bx-chevron-right"></i></a>
                @else
                <a href="/login" class="default-btn btn-bg-two border-radius-5">Login <i class="bx bx-chevron-right"></i></a>
                @endauth
            </div>
        </div>

        <!-- Mobile Layout (search above, rest in compact row) -->
        <div class="mobile-header d-md-none">


            <!-- Compact Bottom Row -->
            <div class="d-flex justify-content-between align-items-center">
                <!-- Contact -->
                <div class="top-contact">
                    <h3 class="mb-0"><a href="tel:+447412803448"><i class="bx bx-phone"></i> 0320 4444 778</a></h3>
                </div>

                <!-- Social -->
                <div class="top-header-social">
                    <ul class="list-unstyled d-flex gap-3 mb-0">
                        <li><a href="https://facebook.com" target="_blank"><i class="bx bxl-facebook"></i></a></li>
                        <li><a href="https://www.instagram.com" target="_blank"><i class="bx bxl-instagram"></i></a></li>
                        <li><a href="https://www.tiktok.com" target="_blank"><i class="bx bxl-tiktok"></i></a></li>
                    </ul>
                </div>

                <!-- Auth -->
                <div class="top-header-auth">
                    @auth
                    <a href="{{ auth()->user()->level == 0 ? '/dashboard' : '/user_dashboard' }}" class="default-btn btn-bg-two border-radius-5">
                        Dashboard
                    </a>
                    <a href="/logout" class="default-btn btn-bg-two border-radius-5">
                        Logout
                    </a>
                    @else
                    <a href="/login" class="default-btn btn-bg-two border-radius-5">
                        Login
                    </a>
                    @endauth
                </div>

            </div>

            <!-- Search Bar (Top) -->
            <div class="top-header-search mb-1 mt-2">
                <form action="/market/search" method="GET" class="search-form position-relative">
                    <input type="text" name="query" class="form-control pr-5" placeholder="Search product..." required>
                    <button type="submit" class="btn position-absolute end-0 top-50 translate-middle-y border-0 bg-transparent">
                        <i class="bx bx-search"></i>
                    </button>
                </form>
            </div>


        </div>
    </div>
</header>

<style>
    .top-header {
        background-color: rgb(23, 32, 42);
        color: white;
    }

    .top-header a {
        color: white;
        text-decoration: none;
    }

    .top-header a:hover {
        color: #4dabf7;
    }

    /* Desktop Styles */
    .desktop-header {
        display: flex;
    }

    .top-header-search input.form-control {
        padding-right: 40px;
        border-radius: 5px;
    }

    .top-header-search .btn {
        color: #6c757d;
    }

    .top-header-social i {
        font-size: 1rem;
    }

    .default-btn {
        padding: 6px 12px;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    /* Mobile Styles */
    .mobile-header {
        padding: 8px 0;
    }

    .mobile-header .top-header-search {
        width: 100%;
    }

    .mobile-header .top-contact h3 {
        font-size: 1rem;
    }

    .mobile-header .default-btn {
        padding: 2px 4px;
        min-width: auto;
    }

    .mobile-header .default-btn i {
        margin-right: 0;
        font-size: 1rem;
    }

    .mobile-header .default-btn span {
        display: none;
    }

    /* Responsive Visibility */
    .desktop-header {
        display: none;
    }

    .mobile-header {
        display: block;
    }

    @media (min-width: 768px) {
        .desktop-header {
            display: flex;
        }

        .mobile-header {
            display: none;
        }
    }
</style>

<!-- Main Navbar -->
<nav class="custom-navbar">
    <div class="custom-nav-container">
        <a href="/" class="custom-brand">
            <img src="/assets/images/logo.png" alt="Logo" class="custom-logo">
            <span class="custom-brand-text">One Stop Solutions</span>
        </a>

        <button class="custom-mobile-menu-button" aria-label="Toggle menu" aria-expanded="false">
            <span class="custom-menu-icon"></span>
            <span class="custom-menu-icon"></span>
            <span class="custom-menu-icon"></span>
        </button>

        <div class="custom-nav-links-container">
            <ul class="custom-nav-links">
                <li>
                    <a href="{{ route('market.home') }}" class="{{ request()->segment(2) == '' ? 'active' : '' }}">Home</a>
                </li>

                <li>
                    <a href="{{ route('market.products') }}" class="{{ request()->segment(2) == 'products' ? 'active' : '' }}">Products</a>
                </li>

                <li>
                    <a href="{{ route('market.categories') }}" class="{{ request()->segment(2) == 'categories' ? 'active' : '' }}">Categories</a>
                </li>


                
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Reset and base styles */
    :root {
        --primary-color: #2563eb;
        --primary-hover: #1d4ed8;
        --text-color: #333;
        --text-light: #666;
        --bg-light: #f8fafc;
        --border-color: #e2e8f0;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --transition: all 0.3s ease;
    }

    /* Main navbar styles */
    .custom-navbar {
        background-color: white;
        box-shadow: var(--shadow);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .custom-nav-container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .custom-brand {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: var(--text-color);
    }

    .custom-logo {
        height: 50px;
        margin-right: 10px;
    }

    .custom-brand-text {
        font-weight: 600;
        display: none;
    }

    .custom-mobile-menu-button {
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
    }

    .custom-menu-icon {
        display: block;
        width: 25px;
        height: 2px;
        background-color: var(--text-color);
        margin: 5px 0;
        transition: var(--transition);
    }

    .custom-nav-links-container {
        display: block;
        z-index: 1001;
        background-color: white;
    }

    .custom-nav-links {
        display: flex;
        list-style: none;
        gap: 20px;
    }

    .custom-nav-links>li {
        position: relative;
    }

    .custom-nav-links a {
        text-decoration: none;
        color: var(--text-color);
        font-weight: 500;
        padding: 8px 0;
        display: inline-block;
        transition: var(--transition);
    }

    .custom-nav-links a:hover,
    .custom-nav-links a.active {
        color: var(--primary-color);
    }

    /* Dropdown styles */
    .custom-dropdown {
        position: relative;
    }

    .custom-dropdown-trigger {
        display: flex;
        align-items: center;
    }

    .custom-dropdown-button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 1002;
        pointer-events: auto;
    }

    .custom-dropdown-icon {
        display: inline-block;
        width: 12px;
        height: 12px;
        margin-left: 5px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        transition: var(--transition);
    }

    .custom-dropdown-icon.nested {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='9 18 15 12 9 6'%3E%3C/polyline%3E%3C/svg%3E");
    }

    .custom-dropdown.active>.custom-dropdown-trigger>.custom-dropdown-button>.custom-dropdown-icon {
        transform: rotate(180deg);
    }

    .custom-nested-dropdown.active>.custom-dropdown-trigger>.custom-dropdown-button>.custom-dropdown-icon.nested {
        transform: rotate(90deg);
    }

    /* Dropdown menu styles */
    .custom-dropdown-menu {
        min-width: 200px;
        background-color: white;
        box-shadow: var(--shadow);
        border-radius: 4px;
        padding: 10px 0;
        list-style: none;
        transition: var(--transition);
        z-index: 100;
    }

    .custom-dropdown-menu a {
        padding: 8px 20px;
        width: 100%;
        display: block;
        font-size: 14px;
        color: var(--text-color);
        transition: var(--transition);
    }

    .custom-dropdown-menu a:hover {
        background-color: var(--bg-light);
        color: var(--primary-color);
    }

    /* Desktop dropdown */
    .custom-dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
    }

    .custom-dropdown:hover>.custom-dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    /* Third-level dropdown styling */
    .custom-nested-dropdown .custom-dropdown-menu {
        top: 0;
        left: 100%;
        min-width: 180px;
        background-color: #f9fafb;
        border-left: 2px solid var(--primary-color);
        padding: 8px 0;
        opacity: 0;
        visibility: hidden;
        transform: translateX(10px);
    }

    .custom-nested-dropdown:hover>.custom-dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateX(0);
    }

    .custom-nested-dropdown .custom-dropdown-menu li {
        padding-left: 10px;
    }

    .custom-nested-dropdown .custom-dropdown-menu a {
        font-size: 13px;
        padding: 6px 20px;
    }

    /* Mobile-specific adjustments */
    @media (max-width: 768px) {
        .custom-mobile-menu-button {
            display: block;
        }

        .custom-nav-links-container {
            position: fixed;
            top: 0;
            left: -100%;
            width: 80%;
            max-width: 300px;
            height: 100vh;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
            overflow-y: auto;
            padding: 20px;
        }

        .custom-nav-links-container.active {
            left: 0;
        }

        .custom-nav-links {
            flex-direction: column;
            gap: 0;
        }

        .custom-nav-links>li {
            border-bottom: 1px solid var(--border-color);
        }

        .custom-nav-links a {
            padding: 12px 0;
            display: block;
        }

        .custom-dropdown-trigger {
            justify-content: space-between;
            width: 100%;
        }

        .custom-dropdown-menu {
            position: static;
            box-shadow: none;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
            padding: 0;
            background-color: #fff;
        }

        .custom-dropdown.active>.custom-dropdown-menu {
            max-height: 1000px;
            padding: 10px 0 10px 15px;
        }

        .custom-nested-dropdown .custom-dropdown-menu {
            background-color: #f9fafb;
            padding: 0;
            max-height: 0;
            border-left: 2px solid var(--primary-color);
        }

        .custom-nested-dropdown.active>.custom-dropdown-menu {
            max-height: 1000px;
            padding: 8px 0 8px 15px;
        }

        .custom-nested-dropdown .custom-dropdown-menu li {
            padding-left: 15px;
            即将
        }

        .custom-nested-dropdown .custom-dropdown-menu a {
            font-size: 13px;
            padding: 6px 15px;
        }

        .custom-brand-text {
            display: block;
            margin-left: 20px;
        }

        /* Mobile menu button animation */
        .custom-mobile-menu-button.active .custom-menu-icon:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .custom-mobile-menu-button.active .custom-menu-icon:nth-child(2) {
            opacity: 0;
        }

        .custom-mobile-menu-button.active .custom-menu-icon:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
        }

        .custom-nav-overlay {
            z-index: 1000;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .custom-nav-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        body.no-scroll {
            overflow: hidden;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.querySelector('.custom-mobile-menu-button');
        const navLinksContainer = document.querySelector('.custom-nav-links-container');
        const navOverlay = document.createElement('div');
        navOverlay.className = 'custom-nav-overlay';
        document.body.appendChild(navOverlay);

        function toggleMenu() {
            const isOpen = navLinksContainer.classList.contains('active');
            mobileMenuButton.classList.toggle('active', !isOpen);
            navLinksContainer.classList.toggle('active', !isOpen);
            navOverlay.classList.toggle('active', !isOpen);
            document.body.classList.toggle('no-scroll', !isOpen);
            // Close all dropdowns when main menu toggles
            document.querySelectorAll('.custom-dropdown, .custom-nested-dropdown').forEach(d => {
                d.classList.remove('active');
            });
        }

        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleMenu();
            });
        }

        navOverlay.addEventListener('click', function(e) {
            toggleMenu();
        });

        // Dropdown toggle functionality for mobile
        document.querySelectorAll('.custom-dropdown-button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const dropdown = this.closest('.custom-dropdown, .custom-nested-dropdown');
                const isActive = dropdown.classList.contains('active');

                // Close all sibling dropdowns at the same level
                dropdown.parentElement.querySelectorAll('.custom-dropdown, .custom-nnested-dropdown').forEach(sibling => {
                    if (sibling !== dropdown) {
                        sibling.classList.remove('active');
                        // Close nested dropdowns within siblings
                        sibling.querySelectorAll('.custom-nested-dropdown').forEach(nested => {
                            nested.classList.remove('active');
                        });
                    }
                });

                // For categories, close all nested dropdowns when toggling
                if (dropdown.classList.contains('custom-dropdown') && !dropdown.classList.contains('custom-nested-dropdown')) {
                    dropdown.querySelectorAll('.custom-nested-dropdown').forEach(nested => {
                        nested.classList.remove('active');
                    });
                }

                // Toggle current dropdown
                dropdown.classList.toggle('active', !isActive);
            });
        });

        // Close menu when clicking links on mobile
        document.querySelectorAll('.custom-nav-links a').forEach(link => {
            link.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    toggleMenu();
                }
            });
        });

        // Prevent sidebar click propagation
        navLinksContainer.addEventListener(' קlick', function(e) {
            e.stopPropagation();
        });

        // Close all dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.custom-nav-links-container')) {
                document.querySelectorAll('.custom-dropdown, .custom-nested-dropdown').forEach(dropdown => {
                    dropdown.classList.remove('active');
                });
            }
        });

        // Desktop hover handling
        document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
            dropdown.addEventListener('mouseenter', function() {
                if (window.innerWidth > 768) {
                    this.classList.add('active');
                    this.querySelectorAll('.custom-nested-dropdown').forEach(nested => {
                        nested.classList.remove('active');
                    });
                }
            });
            dropdown.addEventListener('mouseleave', function() {
                if (window.innerWidth > 768) {
                    this.classList.remove('active');
                    this.querySelectorAll('.custom-nested-dropdown').forEach(nested => {
                        nested.classList.remove('active');
                    });
                }
            });
        });

        // Nested dropdown hover handling
        document.querySelectorAll('.custom-nested-dropdown').forEach(nestedDropdown => {
            nestedDropdown.addEventListener('mouseenter', function() {
                if (window.innerWidth > 768) {
                    this.classList.add('active');
                }
            });
            nestedDropdown.addEventListener('mouseleave', function() {
                if (window.innerWidth > 768) {
                    this.classList.remove('active');
                }
            });
        });
    });
</script>