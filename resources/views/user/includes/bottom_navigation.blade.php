<style>
    /* Floating WhatsApp Button - Mobile Friendly */
.whatsapp-float {
    box-shadow: 0 10px 25px -5px rgba(37, 211, 102, 0.45),
                0 4px 10px -2px rgba(0, 0, 0, 0.15);
}

.whatsapp-float:hover {
    box-shadow: 0 15px 30px -8px rgba(37, 211, 102, 0.55);
    transform: scale(1.12) !important;
}

/* Gentle bounce animation */
@keyframes whatsappBounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
}

.whatsapp-float {
    animation: whatsappBounce 3s ease-in-out infinite;
}
</style>
<!-- Floating WhatsApp Button (Aligned with 420px container) -->
<!-- Simple WhatsApp Floating Button -->
<a href="https://wa.me/+971543041994?text=Hello%2C%20I%20need%20help%20with%20a%20service%20on%20ZipGo!" 
   target="_blank"
   class="fixed bottom-24 z-50 flex items-center justify-center w-12 h-12 
          bg-[#25D366] hover:bg-[#20ba5a] text-white rounded-2xl shadow-lg 
          transition-colors duration-200"
   style="right: calc(50% - 210px + 24px);">
    
    <i class="fab fa-whatsapp text-3xl"></i>
</a>

<!-- Optional Tooltip -->
<div class="fixed bottom-40 z-50 bg-gray-800 text-white text-xs px-3 py-1.5 rounded-xl 
            opacity-0 group-hover:opacity-100 pointer-events-none transition-all duration-200 
            whitespace-nowrap shadow-md hidden md:block"
     style="right: calc(50% - 210px + 90px);">
    Chat with us on WhatsApp
</div>


<div class="mx-4 mb-10">&nbsp;</div>

<nav class="fixed bottom-0 left-0 right-0 z-50 pointer-events-none" style="max-width: 420px; margin-left: auto; margin-right: auto;">
    <div class="bg-white/95 backdrop-blur-xl rounded-t-3xl py-2 px-2 flex justify-between items-center border-t border-[#EAE0D5] shadow-lg shadow-black/5 pointer-events-auto">

        @php
            $currentRoute = request()->route()->getName();
        @endphp

        <!-- Home (flat) -->
        <a href="{{ route('user.dashboard') }}"
           class="nav-item flex flex-col items-center justify-center flex-1 py-2 rounded-xl transition-all duration-300 group @if($currentRoute == 'user.dashboard') active @endif">
            <i data-lucide="home" class="w-5 h-5 transition-all duration-300 group-hover:scale-110"></i>
            <span class="text-[10px] mt-1 font-medium transition-all duration-300 group-hover:text-[#FF6B6B]">Home</span>
        </a>

        <!-- Explore (flat) -->
        <a href="{{ route('user.explore') }}"
           class="nav-item flex flex-col items-center justify-center flex-1 py-2 rounded-xl transition-all duration-300 group @if($currentRoute == 'user.explore') active @endif">
            <i data-lucide="compass" class="w-5 h-5 transition-all duration-300 group-hover:scale-110"></i>
            <span class="text-[10px] mt-1 font-medium transition-all duration-300 group-hover:text-[#FF6B6B]">Explore</span>
        </a>

        <!-- FIND – Prominent Center Button (Coral/Teal theme) -->
        <a href="{{ route('user.search') }}"
           class="find-btn flex flex-col items-center justify-center -mt-6 flex-1 relative @if($currentRoute == 'user.search') active-find @endif">
            <div class="w-14 h-14 rounded-2xl 
                        bg-gradient-to-br from-[#FF6B6B] to-[#4ECDC4] 
                        flex items-center justify-center 
                        shadow-lg shadow-[#FF6B6B]/30 
                        hover:shadow-[#FF6B6B]/50 
                        border-4 border-white 
                        transition-all duration-300 
                        group-hover:scale-105 group-active:scale-95
                        @if($currentRoute == 'user.search') ring-2 ring-[#FFE66D] ring-offset-2 ring-offset-white scale-105 @endif">
                <i data-lucide="search" class="w-7 h-7 text-white"></i>
            </div>
            <span class="text-[10px] mt-1 font-semibold transition-all duration-300 
                         @if($currentRoute == 'user.search') text-[#FFE66D] 
                         @else text-[#FF6B6B] group-hover:text-[#ff5252] @endif">Find</span>
        </a>

        <!-- Bookings (flat) -->
        <a href="{{ route('user.bookings') }}"
           class="nav-item flex flex-col items-center justify-center flex-1 py-2 rounded-xl transition-all duration-300 group @if($currentRoute == 'user.bookings') active @endif">
            <i data-lucide="calendar-check" class="w-5 h-5 transition-all duration-300 group-hover:scale-110"></i>
            <span class="text-[10px] mt-1 font-medium transition-all duration-300 group-hover:text-[#FF6B6B]">Bookings</span>
        </a>

        <!-- Profile (flat) -->
        <a href="{{ route('user.profile') }}"
           class="nav-item flex flex-col items-center justify-center flex-1 py-2 rounded-xl transition-all duration-300 group @if($currentRoute == 'user.profile') active @endif">
            <i data-lucide="user" class="w-5 h-5 transition-all duration-300 group-hover:scale-110"></i>
            <span class="text-[10px] mt-1 font-medium transition-all duration-300 group-hover:text-[#FF6B6B]">Profile</span>
        </a>

    </div>
</nav>

<style>
    /* ===== FLAT NAVIGATION ITEMS (Home, Explore, Bookings, Profile) ===== */
    .nav-item {
        position: relative;
        color: #6B5B50; /* warm gray */
        transition: all 0.2s ease;
    }

    .nav-item i {
        transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    /* Active flat item */
    .nav-item.active i {
        color: #FF6B6B;
        stroke: #FF6B6B;
        filter: drop-shadow(0 0 6px rgba(255, 107, 107, 0.5));
        transform: scale(1.1);
    }

    .nav-item.active span {
        color: #FF6B6B;
        font-weight: 600;
    }

    /* Active indicator line for flat items */
    .nav-item.active::after {
        content: '';
        position: absolute;
        bottom: -6px;
        left: 50%;
        transform: translateX(-50%);
        width: 24px;
        height: 3px;
        background: linear-gradient(90deg, #FF6B6B, #4ECDC4);
        border-radius: 4px;
        box-shadow: 0 0 8px rgba(255, 107, 107, 0.5);
        animation: slideUp 0.2s ease-out;
    }

    /* Hover effect for flat items */
    .nav-item:not(.active):hover i {
        color: #4ECDC4;
        transform: translateY(-2px) scale(1.1);
    }

    .nav-item:not(.active):hover span {
        color: #2C1810;
    }

    /* ===== PROMINENT FIND BUTTON ===== */
    .find-btn {
        transition: all 0.2s ease;
    }

    /* Pulsing shadow animation for the Find button */
    .find-btn .w-14 {
        transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        animation: softGlow 2s infinite;
    }

    .find-btn:hover .w-14 {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(255, 107, 107, 0.5);
    }

    .find-btn:active .w-14 {
        transform: scale(0.96);
    }

    /* Active state for Find button */
    .find-btn.active-find .w-14 {
        background: linear-gradient(135deg, #ff5252, #3bb8b0);
        box-shadow: 0 0 25px rgba(255, 230, 109, 0.5);
    }

    .find-btn.active-find span {
        color: #FFE66D;
        text-shadow: 0 0 4px #FFE66D;
    }

    @keyframes softGlow {
        0% {
            box-shadow: 0 0 0 0 rgba(255, 107, 107, 0.3);
        }
        70% {
            box-shadow: 0 0 0 8px rgba(255, 107, 107, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(255, 107, 107, 0);
        }
    }

    @keyframes slideUp {
        0% {
            width: 0;
            opacity: 0;
        }
        100% {
            width: 24px;
            opacity: 1;
        }
    }

    /* Light glass morphism */
    nav .bg-white\/95 {
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(20px);
    }

    /* Safe area for notches */
    @supports (padding-bottom: env(safe-area-inset-bottom)) {
        nav .bg-white\/95 {
            padding-bottom: env(safe-area-inset-bottom);
        }
    }

    .nav-item:active, .find-btn:active {
        transform: scale(0.98);
        transition: transform 0.05s;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>