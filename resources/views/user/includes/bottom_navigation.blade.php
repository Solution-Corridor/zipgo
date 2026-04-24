<!-- Professional Bottom Navigation -->
<nav class="fixed bottom-0 left-0 right-0 z-50 pointer-events-none" style="max-width: 420px; margin-left: auto; margin-right: auto;">
    <div class="bg-slate-950/95 backdrop-blur-2xl rounded-t-3xl py-3 px-4 flex justify-between items-center border-t border-slate-700 shadow-2xl pointer-events-auto relative">
        
        <!-- Home -->
        <a href="{{ route('user_dashboard') }}" 
           class="flex flex-col items-center text-slate-400 hover:text-white transition-all flex-1">
            <i data-lucide="home" class="w-6 h-6"></i>
            <span class="text-[10px] mt-1 font-medium">Home</span>
        </a>

        <!-- Membership / Plans -->
        <a href="" 
           class="flex flex-col items-center text-slate-400 hover:text-cyan-400 transition-all flex-1">
            <i data-lucide="award" class="w-6 h-6"></i>
            <span class="text-[10px] mt-1 font-medium">Membership</span>
        </a>

        <!-- Tasks (Center Highlighted Button) -->
        <a href="" 
           class="flex flex-col items-center group -mt-8 flex-1">
            <div class="w-14 h-14 rounded-2xl 
                        bg-gradient-to-br from-violet-500 to-indigo-600 
                        flex items-center justify-center 
                        shadow-xl shadow-violet-500/50
                        hover:shadow-violet-400/70
                        border-4 border-slate-950 
                        transition-all duration-300 
                        group-hover:scale-105 group-active:scale-95">
                <i data-lucide="clipboard-list" class="w-7 h-7 text-white"></i>
            </div>
            <span class="text-[10px] mt-1 text-slate-400 font-medium">Tasks</span>
        </a>

        <!-- Pre Dashboard -->
        <a href="{{ route('pre_dashboard') }}" 
           class="flex flex-col items-center text-slate-400 hover:text-purple-400 transition-all flex-1">
            <i data-lucide="layout-grid" class="w-6 h-6"></i>
            <span class="text-[10px] mt-1 font-medium">Explore</span>
        </a>

        <!-- Profile -->
        <a href="{{ route('user_profile') }}" 
           class="flex flex-col items-center text-slate-400 hover:text-white transition-all flex-1">
            <i data-lucide="user" class="w-6 h-6"></i>
            <span class="text-[10px] mt-1 font-medium">Profile</span>
        </a>

    </div>
</nav>


<style>
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slide-in {
    animation: slideIn 0.25s ease-out;
}
</style>

<!-- Toast Container -->
<div id="toastContainer"
     class="fixed top-5 left-1/2 -translate-x-1/2 z-50 flex flex-col space-y-3 w-[90%] max-w-sm">
</div>
<script>
function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');

    const colors = {
        success: 'bg-emerald-600',
        error: 'bg-rose-600',
        warning: 'bg-amber-500',
        info: 'bg-indigo-600'
    };

    const toast = document.createElement('div');
    toast.className = `
        ${colors[type] || colors.success}
        text-white px-5 py-4 rounded-2xl shadow-2xl
        flex items-center justify-between
        animate-slide-in
        backdrop-blur-lg
    `;

    toast.innerHTML = `
        <div class="text-sm font-medium">${message}</div>
        <button class="ml-4 text-white/80 hover:text-white text-lg leading-none">&times;</button>
    `;

    // Close button
    toast.querySelector('button').onclick = () => {
        toast.remove();
    };

    container.appendChild(toast);

    // Auto remove after 3s
    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-2');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>
  <script>
    lucide.createIcons();
  </script>