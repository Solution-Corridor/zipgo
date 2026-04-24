<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    @include('user.includes.general_style')
    <title>Change Password</title>
</head>

<body class="min-h-screen bg-[#0A0A0F]">

    <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

        <!-- Top Greeting -->
        @include('user.includes.top_greetings')

        <div class="px-4 pt-6 pb-24"> <!-- Consistent padding with your profile page -->

            <!-- Back / Title Area (optional but improves UX) -->
            <div class="flex items-center justify-between mb-6">
                
                <h1 class="text-xl font-bold text-white">Change Password</h1>
                <div class="w-10"></div> <!-- spacer -->
            </div>

            <!-- Change Password Card -->
            <div class="card rounded-xl overflow-hidden glow">
                <div class="p-5">
                    @include('includes.success') 

                    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf

                        <!-- Current Password -->
                        <div>
                            <label class="block text-[10px] text-gray-400 mb-1 uppercase tracking-wide">CURRENT PASSWORD</label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    name="current_password" 
                                    id="current_password"
                                    required
                                    placeholder="Current Password"
                                    autocomplete="current-password"
                                    class="w-full bg-gray-900/60 border border-gray-700/60 rounded-lg px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-purple-500/70 transition pr-11">
                                <button 
                                    type="button"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-200 focus:outline-none"
                                    onclick="togglePassword('current_password', this)"
                                >
                                    <i data-lucide="eye" class="w-5 h-5 eye-icon"></i>
                                    <i data-lucide="eye-off" class="w-5 h-5 hidden eye-icon"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label class="block text-[10px] text-gray-400 mb-1 uppercase tracking-wide">NEW PASSWORD</label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="new_password"
                                    required
                                    placeholder="New Password"
                                    minlength="6"
                                    autocomplete="new-password"
                                    class="w-full bg-gray-900/60 border border-gray-700/60 rounded-lg px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-purple-500/70 transition pr-11">
                                <button 
                                    type="button"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-200 focus:outline-none"
                                    onclick="togglePassword('new_password', this)"
                                >
                                    <i data-lucide="eye" class="w-5 h-5 eye-icon"></i>
                                    <i data-lucide="eye-off" class="w-5 h-5 hidden eye-icon"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div>
                            <label class="block text-[10px] text-gray-400 mb-1 uppercase tracking-wide">CONFIRM NEW PASSWORD</label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    name="password_confirmation" 
                                    id="confirm_password"
                                    required
                                    placeholder="Confirm New Password"
                                    autocomplete="new-password"
                                    class="w-full bg-gray-900/60 border border-gray-700/60 rounded-lg px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-purple-500/70 transition pr-11">
                                <button 
                                    type="button"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-200 focus:outline-none"
                                    onclick="togglePassword('confirm_password', this)"
                                >
                                    <i data-lucide="eye" class="w-5 h-5 eye-icon"></i>
                                    <i data-lucide="eye-off" class="w-5 h-5 hidden eye-icon"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button 
                            type="submit" 
                            class="w-full mt-6 py-3.5 rounded-xl font-semibold text-white bg-gradient-to-r from-red-700 to-red-900 hover:from-red-600 hover:to-red-800 shadow-lg active:scale-[0.98] transition">
                            Update Password
                        </button>
                    </form>
                </div>
            </div>
            @include('user.includes.profile_bottom_nav')

        </div>

        <!-- Bottom Navigation -->
        @include('user.includes.bottom_navigation')

    </div>

    <!-- Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>

    <!-- Password Toggle Script -->
    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icons = button.querySelectorAll('.eye-icon');

            if (input.type === 'password') {
                input.type = 'text';
                icons[0].classList.add('hidden');     // hide eye
                icons[1].classList.remove('hidden');  // show eye-off
            } else {
                input.type = 'password';
                icons[0].classList.remove('hidden');  // show eye
                icons[1].classList.add('hidden');     // hide eye-off
            }
        }
    </script>

</body>
</html>