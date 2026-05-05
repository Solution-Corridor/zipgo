<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style')
  <title>Profile</title>
  <style>
    .glow {
      transition: box-shadow 0.2s ease;
    }

    .glow:hover {
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
    }

    input,
    button {
      transition: all 0.2s ease;
    }

    .ring-emerald-500\/40 {
      --tw-ring-color: rgb(16 185 129 / 0.4);
    }
  </style>
</head>

<body class="min-h-screen bg-[#e6e5e3] font-sans antialiased">

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#e6e5e3] shadow-2xl shadow-black/5 relative">

    @include('user.includes.top_greetings')

    <div class="px-4 pt-4 pb-24">
      @include('includes.success')

      <!-- Main Profile Update Card (no duplicate fields) -->
      <div class="card rounded-2xl overflow-hidden glow bg-white border border-[#EAE0D5] shadow-md mb-5">
        <div class="p-6">
          <form method="POST" action="{{ route('user_profile.update') }}" enctype="multipart/form-data" id="profileUpdateForm">
            @csrf

            <!-- Avatar + User Info -->
            <div class="flex items-start gap-5 mb-8">
              <div class="relative group flex-shrink-0">
                <input type="file" name="pic" id="avatar" accept="image/*" class="hidden">
                @if (auth()->user()->pic)
                <img id="avatar-preview" src="/{{ auth()->user()->pic }}" class="w-28 h-28 rounded-2xl object-cover shadow-lg ring-2 ring-emerald-500/40" alt="Profile photo">
                <div id="avatar-initials" class="hidden w-28 h-28 rounded-2xl bg-gradient-to-br from-emerald-700 to-teal-800 flex items-center justify-center text-4xl font-bold shadow-xl text-white">
                  {{ strtoupper(substr(auth()->user()->username ?? 'U', 0, 1)) }}
                </div>
                @else
                <div id="avatar-initials" class="w-28 h-28 rounded-2xl bg-gradient-to-br from-emerald-700 to-teal-800 flex items-center justify-center text-4xl font-bold shadow-xl text-white">
                  {{ strtoupper(substr(auth()->user()->username ?? 'U', 0, 1)) }}
                </div>
                <img id="avatar-preview" src="" class="hidden w-28 h-28 rounded-2xl object-cover shadow-lg" alt="Profile preview">
                @endif
                <label for="avatar" class="absolute inset-0 cursor-pointer rounded-2xl opacity-0 group-hover:opacity-100 bg-black/60 flex items-center justify-center transition-all duration-300 backdrop-blur-sm">
                  <i data-lucide="camera" class="w-10 h-10 text-white"></i>
                </label>
              </div>
              <div class="flex-1 min-w-0 pt-1">
                <h2 class="text-2xl font-bold text-[#2C1810] tracking-tight">{{ auth()->user()->username ?? 'User' }}</h2>
                <p class="text-xs text-gray-500 mt-1">Member since {{ auth()->user()->created_at->format('d M Y') }}</p>
                <p class="text-[11px] text-emerald-600 mt-1.5 flex items-center gap-1.5">
                  <i data-lucide="camera" class="w-3.5 h-3.5"></i>
                  <span>Tap the photo to update</span>
                </p>
              </div>
            </div>

            <!-- Form fields (single occurrence, no duplication) -->
            <div class="space-y-5">
              <div class="space-y-1.5">
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide">USERNAME</label>
                <div class="relative">
                  <input type="text" name="username" id="username"
                    value="{{ old('username', auth()->user()->username ?? '') }}"
                    placeholder="Your unique username"
                    pattern="[A-Za-z0-9_.-]+"
                    class="w-full bg-white border border-[#EAE0D5] rounded-xl px-4 py-3.5 text-sm text-[#2C1810] placeholder:text-gray-400 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/30 transition-all pr-11" />
                  <div id="username-feedback" class="absolute right-3 top-1/2 -translate-y-1/2 text-base pointer-events-none"></div>
                </div>
                <div id="username-error" class="text-red-500 text-xs mt-1 px-1">@error('username') {{ $message }} @enderror</div>
              </div>

              <div>
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide">PHONE NUMBER</label>
                <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}"
                  placeholder="03XX 1234567"
                  class="w-full bg-white border border-[#EAE0D5] rounded-xl px-4 py-3.5 text-sm text-[#2C1810] placeholder:text-gray-400 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/30 transition-all">
                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
              </div>

              <div>
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide">WHATSAPP (optional)</label>
                <input type="tel" name="whatsapp" value="{{ old('whatsapp', auth()->user()->whatsapp ?? '') }}"
                  placeholder="Same as phone or alternative"
                  class="w-full bg-white border border-[#EAE0D5] rounded-xl px-4 py-3.5 text-sm text-[#2C1810] placeholder:text-gray-400 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/30 transition-all">
                @error('whatsapp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
              </div>

              <div>
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide">EMAIL ADDRESS</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}"
                  placeholder="hello@example.com"
                  class="w-full bg-white border border-[#EAE0D5] rounded-xl px-4 py-3.5 text-sm text-[#2C1810] placeholder:text-gray-400 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/30 transition-all">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
              </div>
            </div>

            <button type="submit" class="w-full mt-8 py-3.5 rounded-xl font-semibold text-white bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 shadow-lg shadow-emerald-900/30 active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2">
              <i data-lucide="save" class="w-4 h-4"></i>
              Save Changes
            </button>
          </form>
        </div>
      </div>

      <!-- Action Cards: Change Password + Logout / Delete Account -->
      <div class="card rounded-2xl overflow-hidden glow bg-white border border-[#EAE0D5] shadow-sm">
        <div class="p-5">
          <a href="{{ route('user.change_password') }}"
            class="w-full py-3 rounded-xl font-medium bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 shadow-sm transition-all active:scale-[0.98] flex items-center justify-center gap-2 group">
            <i data-lucide="key" class="w-4 h-4 group-hover:scale-105 transition"></i>
            Change Password
          </a>

          <div class="relative my-5">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-[#EAE0D5]"></div>
            </div>
            <div class="relative flex justify-center text-xs">
              <span class="bg-white px-3 text-gray-400">account management</span>
            </div>
          </div>

          <div class="flex gap-3">
            <form method="POST" action="{{ route('logout') }}" class="w-[40%]">
              @csrf
              <button type="submit" class="w-full py-2.5 rounded-xl font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 border border-gray-200 shadow-sm transition active:scale-[0.97] flex items-center justify-center gap-1.5">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                Logout
              </button>
            </form>

            <form method="POST" action="{{ route('user.delete_account') }}" class="w-[60%]" onsubmit="return confirm('⚠️ PERMANENT ACTION: Are you absolutely sure you want to delete your account? All data will be lost forever.');">
              @csrf
              @method('DELETE')
              <button type="submit" class="w-full py-2.5 rounded-xl font-medium bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 shadow-sm transition active:scale-[0.97] flex items-center justify-center gap-1.5">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
                Delete Account
              </button>
            </form>
          </div>
          <p class="text-[10px] text-gray-400 text-center mt-4">Deleting account removes profile & all associated info</p>
        </div>
      </div>
    </div>

    @include('user.includes.bottom_navigation')
  </div>

  <script>
    (function() {
      // ---------- FIX: Remove any "leave page" warnings ----------
      // Remove any existing beforeunload listeners that might have been added by other scripts
      window.removeEventListener('beforeunload', window.onbeforeunload);
      // Also override the onbeforeunload property to null
      window.onbeforeunload = null;

      // For extra safety: Disable the beforeunload event for this page entirely
      // This prevents browser from showing "Leave site? Changes may not be saved"
      window.addEventListener('beforeunload', function(e) {
        // Do nothing - effectively no confirmation dialog
        // But we must also ensure there is no custom message
        delete e.returnValue;
      });

      // Ensure that when the main form is submitted, there is absolutely no beforeunload conflict
      const mainForm = document.getElementById('profileUpdateForm');
      if (mainForm) {
        mainForm.addEventListener('submit', function() {
          // Temporarily remove any remaining beforeunload handlers just before submit
          window.onbeforeunload = null;
        });
      }

      // ---------- AVATAR PREVIEW (unchanged) ----------
      const avatarInput = document.getElementById('avatar');
      const previewImg = document.getElementById('avatar-preview');
      const initialsDiv = document.getElementById('avatar-initials');
      if (avatarInput && previewImg && initialsDiv) {
        avatarInput.addEventListener('change', function(e) {
          if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(ev) {
              previewImg.src = ev.target.result;
              previewImg.classList.remove('hidden');
              initialsDiv.classList.add('hidden');
            };
            reader.readAsDataURL(e.target.files[0]);
          } else {
            const hasOriginalPic = "{{ auth()->user()->pic ? 'yes' : 'no' }}" === 'yes';
            if (!hasOriginalPic) {
              previewImg.classList.add('hidden');
              initialsDiv.classList.remove('hidden');
            } else {
              previewImg.classList.remove('hidden');
              initialsDiv.classList.add('hidden');
            }
          }
        });
      }

      // ---------- USERNAME AVAILABILITY CHECK (no dirty state) ----------
      const usernameField = document.getElementById('username');
      const feedbackSpan = document.getElementById('username-feedback');
      const errorContainer = document.getElementById('username-error');
      const originalUsername = "{{ addslashes(auth()->user()->username ?? '') }}";

      function clearFeedback() {
        if (feedbackSpan) feedbackSpan.innerHTML = '';
        if (errorContainer) errorContainer.innerHTML = '';
        if (usernameField) {
          usernameField.classList.remove('border-red-500', 'border-green-500');
          usernameField.classList.add('border-[#EAE0D5]');
        }
      }

      function showError(msg) {
        if (feedbackSpan) feedbackSpan.innerHTML = '<i data-lucide="x-circle" class="w-5 h-5 text-red-500"></i>';
        if (errorContainer) errorContainer.innerHTML = msg;
        if (usernameField) {
          usernameField.classList.remove('border-[#EAE0D5]', 'border-green-500');
          usernameField.classList.add('border-red-500');
        }
        if (typeof lucide !== 'undefined') lucide.createIcons();
      }

      function showLoading() {
        if (feedbackSpan) feedbackSpan.innerHTML = '<i data-lucide="loader-circle" class="w-5 h-5 text-amber-500 animate-spin"></i>';
        if (errorContainer) errorContainer.innerHTML = '';
        if (typeof lucide !== 'undefined') lucide.createIcons();
      }

      function showSuccess() {
        if (feedbackSpan) feedbackSpan.innerHTML = '<i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>';
        if (errorContainer) errorContainer.innerHTML = '';
        if (usernameField) {
          usernameField.classList.remove('border-red-500', 'border-[#EAE0D5]');
          usernameField.classList.add('border-green-500');
        }
        if (typeof lucide !== 'undefined') lucide.createIcons();
      }

      if (usernameField) {
        usernameField.addEventListener('input', function() {
          this.value = this.value.replace(/\s+/g, '');
          clearFeedback();
          if (this.value.trim() === originalUsername) {
            clearFeedback();
            usernameField.classList.remove('border-red-500', 'border-green-500');
            usernameField.classList.add('border-[#EAE0D5]');
          }
        });

        usernameField.addEventListener('blur', async function() {
          const newUsername = this.value.trim();
          if (newUsername === "") {
            clearFeedback();
            showError('Username cannot be empty');
            return;
          }
          if (newUsername === originalUsername) {
            clearFeedback();
            usernameField.classList.remove('border-red-500');
            usernameField.classList.add('border-[#EAE0D5]');
            return;
          }
          if (newUsername.length < 3) {
            showError('Username must be at least 3 characters');
            return;
          }
          showLoading();
          try {
            const response = await fetch('{{ route("user.username.check") }}', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              body: JSON.stringify({
                username: newUsername
              })
            });
            const data = await response.json();
            if (data.available === true) {
              showSuccess();
            } else {
              showError(data.message || 'Username already taken.');
            }
          } catch (err) {
            showError('Network error. Please try again.');
          }
        });
      }

      // Re-initialize Lucide icons
      if (typeof lucide !== 'undefined') {
        lucide.createIcons();
        const observer = new MutationObserver(function() {
          lucide.createIcons();
        });
        observer.observe(document.body, {
          childList: true,
          subtree: true
        });
      }

      // Initial avatar visibility fix
      const hasPicture = "{{ auth()->user()->pic ? 'true' : 'false' }}" === 'true';
      if (previewImg && initialsDiv) {
        if (hasPicture && previewImg.src && previewImg.src !== window.location.origin + '/') {
          previewImg.classList.remove('hidden');
          initialsDiv.classList.add('hidden');
        } else if (!hasPicture) {
          previewImg.classList.add('hidden');
          initialsDiv.classList.remove('hidden');
        }
      }
    })();
  </script>

  <script src="https://unpkg.com/lucide@latest"></script>

</body>

</html>