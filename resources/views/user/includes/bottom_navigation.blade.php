<!-- Professional Bottom Navigation - Foodpanda Style with Custom Color Scheme -->
<nav class="fixed bottom-0 left-0 right-0 z-50 pointer-events-none" style="max-width: 420px; margin-left: auto; margin-right: auto;">
    <div class="bg-[#0F0F13]/95 backdrop-blur-xl rounded-t-3xl py-2 px-2 flex justify-between items-center border-t border-white/10 shadow-2xl shadow-black/50 pointer-events-auto relative">

        @php
            $currentRoute = request()->route()->getName();
        @endphp

        <!-- Home -->
        <a href="{{ route('user.dashboard') }}"
           class="nav-item flex flex-col items-center justify-center flex-1 py-1 rounded-xl transition-all duration-200 group @if($currentRoute == 'user.dashboard') active-nav-item @endif">
            <div class="icon-wrapper w-10 h-10 rounded-full flex items-center justify-center transition-all duration-200">
                <i data-lucide="home" class="w-5 h-5 transition-all duration-200"></i>
            </div>
            <span class="text-[10px] mt-0.5 font-medium transition-all duration-200">Home</span>
        </a>

        <!-- Membership / Plans -->
        <a href="{{ route('user.plans') }}"
           class="nav-item flex flex-col items-center justify-center flex-1 py-1 rounded-xl transition-all duration-200 group @if($currentRoute == 'user.plans') active-nav-item @endif">
            <div class="icon-wrapper w-10 h-10 rounded-full flex items-center justify-center transition-all duration-200">
                <i data-lucide="award" class="w-5 h-5 transition-all duration-200"></i>
            </div>
            <span class="text-[10px] mt-0.5 font-medium transition-all duration-200">Membership</span>
        </a>

        <!-- Tasks (Center Highlighted Button - Foodpanda Style Prominent Action) -->
        <a href="{{ route('user.my_tasks') }}"
           class="flex flex-col items-center group -mt-8 flex-1 relative @if($currentRoute == 'user.my_tasks') active-center-btn @endif">
            <div class="w-14 h-14 rounded-2xl 
                        bg-gradient-to-br from-emerald-500 to-green-600 
                        flex items-center justify-center 
                        shadow-xl shadow-emerald-500/40
                        hover:shadow-emerald-400/60
                        border-4 border-[#0F0F13] 
                        transition-all duration-300 
                        group-hover:scale-105 group-active:scale-95
                        @if($currentRoute == 'user.my_tasks') ring-2 ring-white/30 ring-offset-2 ring-offset-[#0F0F13] scale-105 @endif">
                <i data-lucide="clipboard-list" class="w-7 h-7 text-white"></i>
            </div>
            <span class="text-[10px] mt-1 text-slate-400 font-medium transition-all duration-200 group-hover:text-white @if($currentRoute == 'user.my_tasks') text-emerald-400 font-semibold @endif">Tasks</span>
        </a>

        <!-- Explore / Pre Dashboard -->
        <a href="{{ route('pre_dashboard') }}"
           class="nav-item flex flex-col items-center justify-center flex-1 py-1 rounded-xl transition-all duration-200 group @if($currentRoute == 'pre_dashboard') active-nav-item @endif">
            <div class="icon-wrapper w-10 h-10 rounded-full flex items-center justify-center transition-all duration-200">
                <i data-lucide="layout-grid" class="w-5 h-5 transition-all duration-200"></i>
            </div>
            <span class="text-[10px] mt-0.5 font-medium transition-all duration-200">Explore</span>
        </a>

        <!-- Profile -->
        <a href="{{ route('user_profile') }}"
           class="nav-item flex flex-col items-center justify-center flex-1 py-1 rounded-xl transition-all duration-200 group @if($currentRoute == 'user_profile') active-nav-item @endif">
            <div class="icon-wrapper w-10 h-10 rounded-full flex items-center justify-center transition-all duration-200">
                <i data-lucide="user" class="w-5 h-5 transition-all duration-200"></i>
            </div>
            <span class="text-[10px] mt-0.5 font-medium transition-all duration-200">Profile</span>
        </a>

    </div>
</nav>

<style>
    /* Foodpanda Style Bottom Navigation - Enhanced with Custom Color Scheme */
    .nav-item {
        position: relative;
    }
    
    /* Active state styling - Foodpanda inspired */
    .nav-item.active-nav-item .icon-wrapper {
        background: rgba(16, 185, 129, 0.15);
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3);
    }
    
    .nav-item.active-nav-item i {
        color: #10b981;
        stroke: #10b981;
        filter: drop-shadow(0 0 4px rgba(16, 185, 129, 0.5));
    }
    
    .nav-item.active-nav-item span {
        color: #10b981;
        font-weight: 600;
        text-shadow: 0 0 8px rgba(16, 185, 129, 0.3);
    }
    
    /* Hover effects for non-active items */
    .nav-item:not(.active-nav-item):hover .icon-wrapper {
        background: rgba(255, 255, 255, 0.05);
        transform: translateY(-2px);
    }
    
    .nav-item:not(.active-nav-item):hover i {
        color: #34d399;
        stroke: #34d399;
    }
    
    .nav-item:not(.active-nav-item):hover span {
        color: #e5e7eb;
    }
    
    /* Center button active state enhancement */
    .active-center-btn .w-14 {
        box-shadow: 0 0 20px rgba(16, 185, 129, 0.6);
        background: linear-gradient(135deg, #059669, #10b981);
    }
    
    .active-center-btn span {
        color: #10b981 !important;
        font-weight: 600;
    }
    
    /* Smooth transitions for all interactive elements */
    .nav-item, .nav-item * {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Ripple effect on click */
    .nav-item:active .icon-wrapper {
        transform: scale(0.95);
    }
    
    /* Glass morphism enhancement */
    nav .bg-\[#0F0F13\]\/95 {
        background: rgba(15, 15, 19, 0.96);
        backdrop-filter: blur(20px);
    }
    
    /* Bottom navigation border gradient */
    nav .border-t-white\/10 {
        border-image: linear-gradient(90deg, transparent, rgba(16, 185, 129, 0.5), rgba(139, 92, 246, 0.5), transparent) 1;
    }
    
    /* Tooltip like hover effect */
    @media (hover: hover) {
        .nav-item:hover span {
            transform: translateY(-1px);
        }
    }
    
    /* Active indicator dot - Foodpanda style accent */
    .nav-item.active-nav-item::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 3px;
        background: linear-gradient(90deg, #10b981, #34d399);
        border-radius: 3px;
        box-shadow: 0 0 8px rgba(16, 185, 129, 0.6);
    }
    
    /* Remove active dot from center button as it has different styling */
    .active-center-btn::after {
        display: none;
    }
    
    /* Safe area for notches */
    @supports (padding-bottom: env(safe-area-inset-bottom)) {
        nav .bg-\[#0F0F13\]\/95 {
            padding-bottom: env(safe-area-inset-bottom);
        }
    }
    
    /* Pulse animation for center button when active */
    @keyframes softPulse {
        0% {
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
        }
        70% {
            box-shadow: 0 0 0 8px rgba(16, 185, 129, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
        }
    }
    
    .active-center-btn .w-14 {
        animation: softPulse 1.5s infinite;
    }
    
    /* Custom scrollbar for consistency */
    ::-webkit-scrollbar {
        width: 4px;
    }
    
    ::-webkit-scrollbar-track {
        background: #1f1f2e;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #10b981;
        border-radius: 4px;
    }
</style>

<script>
    // Re-initialize Lucide icons after DOM updates (for dynamic navigation)
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined' && lucide.createIcons) {
            lucide.createIcons();
        }
        
        // Add subtle haptic feedback simulation for mobile (optional)
        const navItems = document.querySelectorAll('.nav-item, .active-center-btn');
        navItems.forEach(item => {
            item.addEventListener('click', function(e) {
                // Add a tiny vibration-like class for tactile feedback
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 120);
            });
        });
    });
</script>