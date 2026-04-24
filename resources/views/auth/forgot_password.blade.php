<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    @include('includes.header_links')
    <title>Forgot Password</title>
</head>

<body class="body body5 bg-[#0A0A0F] text-white">
<main class="mx-auto max-w-md p-4 min-h-screen">

    @include('includes.navbar')


            <!-- Logo -->
            <div class="flex justify-center mb-8">
                <div class="relative">
                    <div class="w-20 h-20 rounded-[28px] bg-gradient-primary-br flex items-center justify-center shadow-[0_0_60px_rgba(124,58,237,0.4)]">
                        <!-- Your wallet SVG icon here -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                        </svg>
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-emerald-500 rounded-full border-2 border-[#0A0A0F]"></div>
                </div>
            </div>

            <!-- Heading -->
            <div class="text-center mb-8">
                <h1 class="text-[28px] font-bold text-white mb-2">Reset Password</h1>
                <p class="text-white/50 text-sm">
                    Enter your username or mobile number to receive an OTP
                </p>
            </div>

            <!-- Success Message -->
            @if (session('status'))
                <div class="bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 px-4 py-3 rounded-xl mb-6 text-center">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @include('includes.success')

            <!-- Form -->
            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="text-xs font-medium text-white/60 block px-1">
                        Username / Mobile
                    </label>

                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2">
                            <i class="fas fa-user text-white/40"></i>
                        </div>

                        <input 
                            type="text"
                            name="login"
                            value="{{ old('login') }}"
                            placeholder="Enter username or mobile"
                            class="w-full bg-white/[0.06] border rounded-2xl pl-12 pr-4 py-4 text-[15px] text-white placeholder:text-white/30 focus:outline-none focus:border-primary/50 focus:bg-white/[0.08] transition-all border-white/[0.08]"
                            required
                        />
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-primary text-white font-semibold py-4 rounded-2xl flex items-center justify-center gap-2 shadow-[0_8px_30px_rgba(124,58,237,0.3)] hover:shadow-[0_8px_40px_rgba(124,58,237,0.4)] transition-all">
                    Send OTP
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-primary hover:text-accent transition-colors">
                    Back to Login
                </a>
            </div>



    @include('includes.footer_links')

</main>
</body>
</html>