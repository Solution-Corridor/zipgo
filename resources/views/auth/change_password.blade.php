<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style')
  <title>Change Password</title>
</head>

<body class="min-h-screen bg-[#e6e5e3]">

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#e6e5e3] shadow-2xl shadow-black/5 relative">

    @include('user.includes.top_greetings')

    <div class="px-4 pt-6 pb-24">

      <!-- Header with back link -->
      <div class="flex items-center justify-between mb-6">
        <a href="{{ route('user.profile') }}" class="text-[#FF6B6B] text-sm flex items-center gap-1 hover:text-[#ff5252] transition">
          <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Profile
        </a>
        <h1 class="text-xl font-bold text-[#2C1810]">Change Password</h1>
        <div class="w-10"></div>
      </div>

      <!-- Change Password Card -->
      <div class="card rounded-xl overflow-hidden glow bg-white border border-[#EAE0D5] shadow-sm">
        <div class="p-5">
          @include('includes.success')

          <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf

            <!-- Current Password -->
            <div class="mb-4">
              <label class="block text-[10px] text-[#6B5B50] mb-1 uppercase tracking-wide">CURRENT PASSWORD</label>
              <div class="relative">
                <input type="password" name="current_password" id="current_password" required placeholder="Current Password" autocomplete="current-password" class="w-full bg-white border border-[#EAE0D5] rounded-lg px-4 py-3 text-sm text-[#2C1810] placeholder-[#6B5B50] focus:outline-none focus:border-[#FF6B6B]/70 transition pr-11">
                <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#6B5B50] hover:text-[#FF6B6B] focus:outline-none" onclick="togglePassword('current_password', this)">
                  <i data-lucide="eye" class="w-5 h-5 eye-icon"></i>
                  <i data-lucide="eye-off" class="w-5 h-5 hidden eye-icon"></i>
                </button>
              </div>
              @error('current_password')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- New Password -->
            <div class="mb-4">
              <label class="block text-[10px] text-[#6B5B50] mb-1 uppercase tracking-wide">NEW PASSWORD</label>
              <div class="relative">
                <input type="password" name="password" id="new_password" required placeholder="New Password" minlength="6" autocomplete="new-password" class="w-full bg-white border border-[#EAE0D5] rounded-lg px-4 py-3 text-sm text-[#2C1810] placeholder-[#6B5B50] focus:outline-none focus:border-[#FF6B6B]/70 transition pr-11">
                <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#6B5B50] hover:text-[#FF6B6B] focus:outline-none" onclick="togglePassword('new_password', this)">
                  <i data-lucide="eye" class="w-5 h-5 eye-icon"></i>
                  <i data-lucide="eye-off" class="w-5 h-5 hidden eye-icon"></i>
                </button>
              </div>
              @error('password')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Confirm New Password -->
            <div class="mb-4">
              <label class="block text-[10px] text-[#6B5B50] mb-1 uppercase tracking-wide">CONFIRM NEW PASSWORD</label>
              <div class="relative">
                <input type="password" name="password_confirmation" id="confirm_password" required placeholder="Confirm New Password" autocomplete="new-password" class="w-full bg-white border border-[#EAE0D5] rounded-lg px-4 py-3 text-sm text-[#2C1810] placeholder-[#6B5B50] focus:outline-none focus:border-[#FF6B6B]/70 transition pr-11">
                <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#6B5B50] hover:text-[#FF6B6B] focus:outline-none" onclick="togglePassword('confirm_password', this)">
                  <i data-lucide="eye" class="w-5 h-5 eye-icon"></i>
                  <i data-lucide="eye-off" class="w-5 h-5 hidden eye-icon"></i>
                </button>
              </div>
              @error('password_confirmation')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Submit Button (Coral gradient) -->
            <button type="submit" class="w-full mt-6 py-3.5 rounded-xl font-semibold text-white bg-gradient-to-r from-[#FF6B6B] to-[#ff5252] hover:from-[#ff5252] hover:to-[#FF6B6B] shadow-md active:scale-[0.98] transition">
              Update Password
            </button>
          </form>
        </div>
      </div>
    </div>

    @include('user.includes.bottom_navigation')
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      if (typeof lucide !== 'undefined') lucide.createIcons();
    });

    function togglePassword(inputId, button) {
      const input = document.getElementById(inputId);
      const icons = button.querySelectorAll('.eye-icon');
      if (input.type === 'password') {
        input.type = 'text';
        if (icons[0]) icons[0].classList.add('hidden');
        if (icons[1]) icons[1].classList.remove('hidden');
      } else {
        input.type = 'password';
        if (icons[0]) icons[0].classList.remove('hidden');
        if (icons[1]) icons[1].classList.add('hidden');
      }
    }
  </script>
</body>

</html>