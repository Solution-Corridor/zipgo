<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style')
  <title>Profile</title>
</head>

<body class="min-h-screen bg-[#e6e5e3]">

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#e6e5e3] shadow-2xl shadow-black/5 relative">

    @include('user.includes.top_greetings')

    <div class="px-4 pt-4 pb-24">
      <!-- Profile Update Form -->
      <form method="POST" action="{{ route('user_profile.update') }}" enctype="multipart/form-data" class="mb-5">
        @csrf

        <div class="card rounded-xl overflow-hidden glow bg-white border border-[#EAE0D5] shadow-sm">
          <div class="p-6">
            @include('includes.success')

                        <!-- Avatar + User Info Section -->
                        <div class="flex items-start gap-5 mb-8">
                            <div class="relative group flex-shrink-0">
                                <input type="file" name="pic" id="avatar" accept="image/*" class="hidden">
                                @if (auth()->user()->pic)
                                    <img id="avatar-preview" src="/{{ auth()->user()->pic }}" class="w-28 h-28 rounded-2xl object-cover shadow-lg ring-2 ring-emerald-500/40" alt="Profile photo">
                                    <div id="avatar-initials" class="hidden w-28 h-28 rounded-2xl bg-gradient-to-br from-emerald-700 to-teal-800 flex items-center justify-center text-4xl font-bold shadow-xl">
                                        {{ strtoupper(substr(auth()->user()->username ?? 'U', 0, 1)) }}
                                    </div>
                                @else
                                    <div id="avatar-initials" class="w-28 h-28 rounded-2xl bg-gradient-to-br from-emerald-700 to-teal-800 flex items-center justify-center text-4xl font-bold shadow-xl">
                                        {{ strtoupper(substr(auth()->user()->username ?? 'U', 0, 1)) }}
                                    </div>
                                    <img id="avatar-preview" src="" class="hidden w-28 h-28 rounded-2xl object-cover shadow-lg" alt="Profile preview">
                                @endif
                                <label for="avatar" class="absolute inset-0 cursor-pointer rounded-2xl opacity-0 group-hover:opacity-100 bg-black/60 flex items-center justify-center transition-all duration-300">
                                    <i data-lucide="camera" class="w-10 h-10 text-white"></i>
                                </label>
                            </div>
                            <div class="flex-1 min-w-0 pt-1">
                                <h2 class="text-2xl font-bold text-white tracking-tight">{{ auth()->user()->username ?? 'User' }}</h2>
                                <p class="text-xs text-gray-400 mt-4">Since {{ auth()->user()->created_at->format('d M Y') }}</p>
                                <p class="text-[10px] text-emerald-400 mt-1 flex items-center gap-1"><i data-lucide="info" class="w-3 h-3"></i> Tap to change photo</p>
                            </div>
                        </div>

                        <!-- Form fields -->
                        <div class="space-y-5">
                            <div class="space-y-1.5">
                                <label class="block text-[10px] text-gray-400 mb-1 uppercase tracking-wide">USERNAME</label>
                                <div class="relative">
                                    <input type="text" name="username" id="username" value="{{ old('username', auth()->user()->username ?? '') }}" placeholder="Your username" pattern="[A-Za-z0-9_.-]+" class="w-full bg-gray-900/60 border border-gray-700/60 rounded-lg px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-emerald-500/70 transition pr-10" />
                                    <div id="username-feedback" class="absolute right-3 top-1/2 -translate-y-1/2 text-sm pointer-events-none"></div>
                                </div>
                                <div id="username-error" class="text-red-400 text-xs mt-1 px-1">@error('username') {{ $message }} @enderror</div>
                            </div>
                            <div>
                                <label class="block text-[10px] text-gray-400 mb-1 uppercase tracking-wide">PHONE</label>
                                <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" placeholder="03001234567" class="w-full bg-gray-900/60 border border-gray-700/60 rounded-lg px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-emerald-500/70 transition">
                                @error('phone') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[10px] text-gray-400 mb-1 uppercase tracking-wide">WHATSAPP</label>
                                <input type="tel" name="whatsapp" value="{{ old('whatsapp', auth()->user()->whatsapp ?? '') }}" placeholder="03001234567" class="w-full bg-gray-900/60 border border-gray-700/60 rounded-lg px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-emerald-500/70 transition">
                                @error('whatsapp') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[10px] text-gray-400 mb-1 uppercase tracking-wide">EMAIL</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" placeholder="Enter your email address" class="w-full bg-gray-900/60 border border-gray-700/60 rounded-lg px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-emerald-500/70 transition">
                                @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Save Changes Button -->
                        <button type="submit" class="w-full mt-7 py-3.5 rounded-xl font-semibold text-white bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 shadow-lg shadow-emerald-900/40 active:scale-[0.98] transition">
                            Save Changes
                        </button>

                        </form>

                        <!-- Change Password Button (links to separate page) -->
                        <div class="mt-5">
                            <a href="{{ route('user.change_password') }}" class="w-full py-2.5 rounded-xl font-medium bg-emerald-900/40 hover:bg-emerald-800/60 text-emerald-300 border border-emerald-700/50 shadow-md hover:shadow-emerald-900/20 transition active:scale-[0.98] flex items-center justify-center gap-2">
                                <i class="fas fa-key"></i> Change Password
                            </a>
                        </div>

                        <!-- Logout (40%) & Delete Account (60%) -->
                        <div class="mt-3 flex gap-3">
                            <form method="POST" action="{{ route('logout') }}" class="w-[0%]">
                                @csrf
                                <button type="submit" class="w-full py-2.5 rounded-xl font-medium bg-gray-800 hover:bg-gray-700 text-gray-200 border border-gray-700 shadow-md hover:shadow-emerald-900/20 transition active:scale-[0.98]">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                            <form method="POST" action="{{ route('user.delete_account') }}" class="w-[100%]" onsubmit="return confirm('Are you sure you want to permanently delete your account? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full py-2.5 rounded-xl font-medium bg-red-900/40 hover:bg-red-800/60 text-red-300 border border-red-700/50 shadow-md hover:shadow-red-900/20 transition active:scale-[0.98]">
                                    <i class="fas fa-trash-alt mr-2"></i> Delete Account
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            
        </div>

            <!-- Form fields -->
            <div class="space-y-5">
              <div class="space-y-1.5">
                <label class="block text-[10px] text-[#6B5B50] mb-1 uppercase tracking-wide">USERNAME</label>
                <div class="relative">
                  <input type="text" name="username" id="username" value="{{ old('username', auth()->user()->username ?? '') }}" placeholder="Your username" pattern="[A-Za-z0-9_.-]+" class="w-full bg-white border border-[#EAE0D5] rounded-lg px-4 py-3 text-sm text-[#2C1810] placeholder-[#6B5B50] focus:outline-none focus:border-[#FF6B6B]/70 transition pr-10" />
                  <div id="username-feedback" class="absolute right-3 top-1/2 -translate-y-1/2 text-sm pointer-events-none"></div>
                </div>
                <div id="username-error" class="text-red-500 text-xs mt-1 px-1">@error('username') {{ $message }} @enderror</div>
              </div>
              <div>
                <label class="block text-[10px] text-[#6B5B50] mb-1 uppercase tracking-wide">PHONE</label>
                <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" placeholder="03001234567" class="w-full bg-white border border-[#EAE0D5] rounded-lg px-4 py-3 text-sm text-[#2C1810] placeholder-[#6B5B50] focus:outline-none focus:border-[#FF6B6B]/70 transition">
                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
              </div>
              <div>
                <label class="block text-[10px] text-[#6B5B50] mb-1 uppercase tracking-wide">WHATSAPP</label>
                <input type="tel" name="whatsapp" value="{{ old('whatsapp', auth()->user()->whatsapp ?? '') }}" placeholder="03001234567" class="w-full bg-white border border-[#EAE0D5] rounded-lg px-4 py-3 text-sm text-[#2C1810] placeholder-[#6B5B50] focus:outline-none focus:border-[#FF6B6B]/70 transition">
                @error('whatsapp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
              </div>
              <div>
                <label class="block text-[10px] text-[#6B5B50] mb-1 uppercase tracking-wide">EMAIL</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" placeholder="Enter your email address" class="w-full bg-white border border-[#EAE0D5] rounded-lg px-4 py-3 text-sm text-[#2C1810] placeholder-[#6B5B50] focus:outline-none focus:border-[#FF6B6B]/70 transition">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
              </div>
            </div>

            <!-- Save Changes Button -->
            <button type="submit" class="w-full mt-7 py-3.5 rounded-xl font-semibold text-white bg-gradient-to-r from-[#FF6B6B] to-[#ff5252] hover:from-[#ff5252] hover:to-[#FF6B6B] shadow-md active:scale-[0.98] transition">
              Save Changes
            </button>
          </div>
        </div>
      </form>


      <div class="card rounded-xl overflow-hidden glow bg-white border border-[#EAE0D5] shadow-sm">
        <div class="p-6">

          <!-- Change Password Button -->
          <a href="{{ route('user.change_password') }}" class="w-full py-2.5 rounded-xl font-medium bg-[#FFE66D]/30 hover:bg-[#FFE66D]/50 text-[#2C1810] border border-[#FFE66D] shadow-sm transition active:scale-[0.98] flex items-center justify-center gap-2">
            <i class="fas fa-key"></i> Change Password
          </a>

          <!-- Logout (40%) & Delete Account (60%) -->
          <div class="mt-3 flex gap-3">
            <form method="POST" action="{{ route('logout') }}" class="w-[40%]">
              @csrf
              <button type="submit" class="w-full py-2.5 rounded-xl font-medium bg-gray-100 hover:bg-gray-200 text-[#2C1810] border border-[#EAE0D5] shadow-sm transition active:scale-[0.98]">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
              </button>
            </form>
            <form method="POST" action="{{ route('user.delete_account') }}" class="w-[60%]" onsubmit="return confirm('Are you sure you want to permanently delete your account? This action cannot be undone.');">
              @csrf
              @method('DELETE')
              <button type="submit" class="w-full py-2.5 rounded-xl font-medium bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 shadow-sm transition active:scale-[0.98]">
                <i class="fas fa-trash-alt mr-2"></i> Delete Account
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    @include('user.includes.bottom_navigation')
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Username availability check
      const usernameInput = document.getElementById('username');
      const feedback = document.getElementById('username-feedback');
      const errorDiv = document.getElementById('username-error');
      if (usernameInput) {
        usernameInput.addEventListener('input', function() {
          this.value = this.value.replace(/\s+/g, '');
          clearFeedback();
        });
        usernameInput.addEventListener('blur', async function() {
          const username = this.value.trim();
          const original = "{{ auth()->user()->username ?? '' }}";
          if (!username || username === original) {
            clearFeedback();
            return;
          }
          if (username.length < 3) {
            showError('Username must be at least 3 characters');
            return;
          }
          feedback.innerHTML = '<i class="fas fa-circle-notch fa-spin text-yellow-600"></i>';
          errorDiv.textContent = '';
          try {
            const response = await fetch('{{ route("user.username.check") }}', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              body: JSON.stringify({
                username: username
              })
            });
            const data = await response.json();
            if (data.available) {
              feedback.innerHTML = '<i class="fas fa-check-circle text-green-600"></i>';
              errorDiv.textContent = '';
              usernameInput.classList.remove('border-red-500');
              usernameInput.classList.add('border-green-500/50');
            } else {
              feedback.innerHTML = '<i class="fas fa-times-circle text-red-500"></i>';
              errorDiv.textContent = data.message || 'This username is already taken';
              usernameInput.classList.remove('border-green-500/50');
              usernameInput.classList.add('border-red-500');
            }
          } catch (err) {
            feedback.innerHTML = '<i class="fas fa-exclamation-triangle text-orange-500"></i>';
            errorDiv.textContent = 'Could not check availability';
          }
        });

        function clearFeedback() {
          feedback.innerHTML = '';
          errorDiv.textContent = '';
          usernameInput.classList.remove('border-red-500', 'border-green-500/50');
        }

        function showError(msg) {
          feedback.innerHTML = '<i class="fas fa-times-circle text-red-500"></i>';
          errorDiv.textContent = msg;
          usernameInput.classList.add('border-red-500');
        }
      }

      lucide.createIcons();

      const avatarInput = document.getElementById('avatar');
      const preview = document.getElementById('avatar-preview');
      const initials = document.getElementById('avatar-initials');
      if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
          if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(ev) {
              preview.src = ev.target.result;
              preview.classList.remove('hidden');
              initials.classList.add('hidden');
            }
            reader.readAsDataURL(e.target.files[0]);
          }
        });
      }
    });
  </script>

</body>

</html>