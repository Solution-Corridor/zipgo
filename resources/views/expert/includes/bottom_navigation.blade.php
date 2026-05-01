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
<a href="https://wa.me/+971543041994?text=Hello%2C%20I%20need%20help%20with%20a%20service%20on%20ZipGo!" 
   target="_blank"
   class="fixed bottom-24 z-50 flex items-center justify-center w-14 h-14 
          bg-[#25D366] hover:bg-[#20ba5a] text-white rounded-2xl shadow-xl 
          transition-all duration-300 hover:scale-110 active:scale-95 
          group whatsapp-float"
   style="right: calc(50% - 210px + 24px);">
    
    <i class="fab fa-whatsapp text-3xl"></i>
    
    <!-- Pulse Animation -->
    <span class="absolute -top-1 -right-1 flex h-5 w-5">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-5 w-5 bg-green-500"></span>
    </span>
</a>

<!-- Optional Tooltip -->
<div class="fixed bottom-40 z-50 bg-gray-800 text-white text-xs px-3 py-1.5 rounded-xl 
            opacity-0 group-hover:opacity-100 pointer-events-none transition-all duration-200 
            whitespace-nowrap shadow-md hidden md:block"
     style="right: calc(50% - 210px + 90px);">
    Chat with us on WhatsApp
</div>


<div class="mx-4 mb-10">&nbsp;</div>

<!-- Expert Bottom Navigation (Navy/Gold, uniform, no special button) -->
<nav class="fixed bottom-0 left-0 right-0 z-50 pointer-events-none" style="max-width: 420px; margin-left: auto; margin-right: auto;">
    <div class="bg-[#0B1C3F]/95 backdrop-blur-xl rounded-t-3xl py-2 px-2 flex justify-between items-center border-t border-[#2A3A5A]/50 shadow-2xl shadow-black/50 pointer-events-auto">
        @php $currentRoute = request()->route()->getName(); @endphp

        <a href="{{ route('expert.dashboard') }}" class="nav-item flex flex-col items-center justify-center flex-1 py-2 group @if($currentRoute == 'expert.dashboard') active @endif">
            <i data-lucide="home" class="w-5 h-5 transition-all group-hover:scale-110"></i>
            <span class="text-[10px] mt-1 font-medium">Home</span>
        </a>
        <a href="{{ route('expert.jobs') }}" class="nav-item flex flex-col items-center justify-center flex-1 py-2 group @if($currentRoute == 'expert.jobs' || str_starts_with($currentRoute, 'expert.jobs.')) active @endif">
            <i data-lucide="briefcase" class="w-5 h-5 transition-all group-hover:scale-110"></i>
            <span class="text-[10px] mt-1 font-medium">Jobs</span>
        </a>
        <a href="{{ route('expert.earnings') }}" class="nav-item flex flex-col items-center justify-center flex-1 py-2 group @if($currentRoute == 'expert.earnings') active @endif">
            <i data-lucide="wallet" class="w-5 h-5 transition-all group-hover:scale-110"></i>
            <span class="text-[10px] mt-1 font-medium">Earnings</span>
        </a>
        <a href="{{ route('expert.rates') }}" class="nav-item flex flex-col items-center justify-center flex-1 py-2 group @if($currentRoute == 'expert.rates' || str_starts_with($currentRoute, 'expert.rates.')) active @endif">
            <i data-lucide="credit-card" class="w-5 h-5 transition-all group-hover:scale-110"></i>
            <span class="text-[10px] mt-1 font-medium">Rates</span>
        </a>
        <a href="{{ route('expert.profile') }}" class="nav-item flex flex-col items-center justify-center flex-1 py-2 group @if($currentRoute == 'expert.profile') active @endif">
            <i data-lucide="user" class="w-5 h-5 transition-all group-hover:scale-110"></i>
            <span class="text-[10px] mt-1 font-medium">Profile</span>
        </a>
    </div>
</nav>

<style>
    .nav-item {
        position: relative;
        color: #8A9BB5; /* muted blue-gray */
        transition: all 0.2s ease;
    }

    .nav-item i {
        transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .nav-item.active i {
        color: #F4A261; /* gold */
        stroke: #F4A261;
        filter: drop-shadow(0 0 6px rgba(244, 162, 97, 0.5));
        transform: scale(1.1);
    }

    .nav-item.active span {
        color: #F4A261;
        font-weight: 600;
    }

    .nav-item.active::after {
        content: '';
        position: absolute;
        bottom: -6px;
        left: 50%;
        transform: translateX(-50%);
        width: 24px;
        height: 3px;
        background: linear-gradient(90deg, #F4A261, #E08E3E);
        border-radius: 4px;
        box-shadow: 0 0 8px rgba(244, 162, 97, 0.5);
        animation: slideUp 0.2s ease-out;
    }

    .nav-item:not(.active):hover i {
        color: #E08E3E; /* darker gold */
        transform: translateY(-2px) scale(1.1);
    }

    .nav-item:not(.active):hover span {
        color: #E8EDF2; /* off-white */
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

    nav .bg-\[#0B1C3F\]\/95 {
        background: rgba(11, 28, 63, 0.96);
        backdrop-filter: blur(20px);
    }

    @supports (padding-bottom: env(safe-area-inset-bottom)) {
        nav .bg-\[#0B1C3F\]\/95 {
            padding-bottom: env(safe-area-inset-bottom);
        }
    }

    .nav-item:active {
        transform: scale(0.98);
        transition: transform 0.05s;
    }
</style>