<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    @include('includes.header_links')
    <title>Login</title>
</head>

<body class="body body5 bg-[#0A0A0F] text-white">
    <main class="mx-auto max-w-md p-4 min-h-screen">
        <!--=====progress END=======-->
        <div class="paginacontainer"></div>
        @include('includes.navbar')

<div class="min-h-screen bg-[#0A0A0F] flex flex-col">
            
            <div class="flex-1 justify-center px-6 relative z-10">
                <div class="w-full max-w-[360px] mx-auto py-2">
                    <div class="text-center mb-8">
                        <h1 class="text-[28px] font-bold text-white mb-2">Welcome Back!</h1>
                        <p class="text-white/50 text-sm">Sign in to continue</p>
                    </div>

                    @include('includes.success')

                    <div class="mt-4 text-center">
    @if (session('attempts_left') !== null)
        <p class="text-yellow-400 text-sm font-medium">
            Attempts left: <strong>{{ session('attempts_left') }}</strong>
        </p>
    @endif

    
</div>

                    <form action="{{ route('postLogin') }}" method="post" class="space-y-4">
                        @csrf

                        <div class="space-y-2">
                            <label class="text-xs font-medium text-white/60 block px-1">Username / Mobile</label>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                    <i class="fas fa-user text-white/40"></i>
                                </div>
                                <input 
    type="text"
    name="login"
    value=""
    placeholder="Enter username or mobile"
    **pattern="[A-Za-z0-9_.-]+"
    title="Username can only contain letters, numbers, underscores, dots and hyphens (no spaces)"**
    class="w-full bg-white/[0.06] border rounded-2xl pl-12 pr-4 py-4 text-[15px] text-white placeholder:text-white/30 focus:outline-none focus:border-primary/50 focus:bg-white/[0.08] transition-all border-white/[0.08]" required />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between items-center px-1">
                                <label class="text-xs font-medium text-white/60">Password</label>
                                <!-- you can add "Forgot password?" link here later if you want -->
                            </div>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                    <i class="fas fa-lock text-white/40"></i>
                                </div>
                                <input
                                    type="password"
                                    name="password"
                                    id="id_password"
                                    autocomplete="off"
                                    placeholder="Enter any password"
                                    class="w-full bg-white/[0.06] border border-white/[0.08] rounded-2xl pl-12 pr-12 py-4 text-[15px] text-white placeholder:text-white/30 focus:outline-none focus:border-primary/50 focus:bg-white/[0.08] transition-all" required />
                                    
                                <button
                                    type="button"
                                    id="togglePassword"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 p-1 text-white/40 hover:text-white/70 transition-colors">
                                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye">
                                        <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <a href="/forgot-password" 
   class="text-xs text-primary/80 hover:text-primary font-medium transition-colors">
    Forgot password?
</a>

                        
                        <button type="submit" id="submitBtn"
                            class="w-full bg-gradient-primary text-white font-semibold py-4 rounded-2xl flex items-center justify-center gap-2 mt-6 shadow-[0_8px_30px_rgba(124,58,237,0.3)] hover:shadow-[0_8px_40px_rgba(124,58,237,0.4)] active:scale-[0.98] transition-all disabled:opacity-60 disabled:cursor-not-allowed cursor-pointer">
                            Log In
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right">
                                <path d="m9 18 6-6-6-6"></path>
                            </svg>
                        </button>
                    </form>

                    <div class="mt-8 text-center">
                        <p class="text-white/40 text-sm">
                            Don't have an account? 
                            <a class="text-primary font-semibold hover:text-accent transition-colors" href="/register" data-discover="true">Register</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-6 pb-8 relative z-10">
                <p class="text-center text-xs text-white/30">
                    By continuing, you agree to our 
                    <a href="/terms" class="text-white/50 hover:text-white/70">Terms</a> &amp; 
                    <a href="/privacy" class="text-white/50 hover:text-white/70">Privacy Policy</a>
                </p>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const passwordInput = document.getElementById('id_password');
                const toggleButton = document.getElementById('togglePassword');
                const eyeIcon    = document.getElementById('eyeIcon');

                if (!passwordInput || !toggleButton || !eyeIcon) return;

                toggleButton.addEventListener('click', function() {
                    // Toggle input type
                    const type = passwordInput.type === 'password' ? 'text' : 'password';
                    passwordInput.type = type;

                    // Swap eye ↔ eye-off icon
                    if (type === 'text') {
                        // Show eye-off (hide password)
                        eyeIcon.innerHTML = `
                            <path d="M2 2 22 22"></path>
                            <path d="M6.712 6.72C3.664 8.126 2 12 2 12s3.182 6 10 6c2.117 0 3.92-.576 5.288-1.28"></path>
                            <path d="M9.01 9.02a3 3 0 0 0 4.982 4.982"></path>
                            <path d="M17.288 17.28c3.048-1.405 4.712-5.28 4.712-5.28s-3.182-6-10-6c-1.379 0-2.597.315-3.712.82"></path>
                        `;
                        eyeIcon.setAttribute('class', 'lucide lucide-eye-off');
                    } else {
                        // Show eye (show password)
                        eyeIcon.innerHTML = `
                            <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        `;
                        eyeIcon.setAttribute('class', 'lucide lucide-eye');
                    }
                });
            });
        </script>

        <script>
document.addEventListener('DOMContentLoaded', () => {
    const usernameInput = document.querySelector('input[name="login"]');
    
    if (!usernameInput) return;

    usernameInput.addEventListener('input', function(e) {
        // Remove all spaces in real time
        this.value = this.value.replace(/\s+/g, '');
        
        // Optional: also force lowercase (many apps do this)
        // this.value = this.value.toLowerCase();
    });
});
</script>

        @include('includes.footer_links')
    </main>
</body>

</html>