<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  @include('includes.mob_header_links')
  <title>Register</title>

  <style>
    /* Custom dropdown styles for dark theme */
    .custom-dropdown {
      position: relative;
      width: 100%;
    }

    .custom-dropdown-input {
      width: 100%;
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 1rem;
      padding: 1rem;
      padding-left: 1rem;
      color: white;
      font-size: 15px;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .custom-dropdown-input:hover {
      background: rgba(255, 255, 255, 0.1);
    }

    .custom-dropdown-menu {
      position: absolute;
      top: calc(100% + 0.5rem);
      left: 0;
      right: 0;
      background: #1e1e2a;
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 1rem;
      max-height: 250px;
      overflow-y: auto;
      z-index: 50;
      display: none;
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
    }

    .custom-dropdown-menu.show {
      display: block;
    }

    .custom-dropdown-search {
      padding: 0.75rem;
      position: sticky;
      top: 0;
      background: #1e1e2a;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .custom-dropdown-search input {
      width: 100%;
      padding: 0.6rem 0.75rem;
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 0.75rem;
      color: white;
      font-size: 14px;
    }

    .custom-dropdown-search input:focus {
      outline: none;
      border-color: #8b5cf6;
    }

    .custom-dropdown-item {
      padding: 0.75rem 1rem;
      cursor: pointer;
      color: white;
      font-size: 14px;
      transition: background 0.15s;
    }

    .custom-dropdown-item:hover {
      background: rgba(139, 92, 246, 0.3);
    }

    .custom-dropdown-item.selected {
      background: rgba(139, 92, 246, 0.5);
      font-weight: 500;
    }
  </style>
</head>

<body class="body body5 bg-[#0A0A0F] text-white">
  <main class="mx-auto max-w-md p-4 min-h-screen">
    <!--=====progress END=======-->
    <div class="paginacontainer"></div>
    @include('includes.mob_navbar')


    <div class="min-h-screen bg-[#0A0A0F] flex flex-col">

      <div class="flex-1 justify-center px-6 relative z-10">
        <div class="w-full max-w-[360px] mx-auto py-2">

          <div class="text-center mb-8">
            <h1 class="text-[28px] font-bold text-white mb-2">Create Account</h1>
            <p class="text-white/50 text-sm">Join and start earning today</p>
          </div>
          <!-- Form -->
          @include('includes.success')
          <div class="mt-4 text-center">
            @if (session('attempts_left') !== null)
            <p class="text-yellow-400 text-sm font-medium">
              Attempts left: <strong>{{ session('attempts_left') }}</strong>
            </p>
            @endif


          </div>
          <form action="{{ route('saveRegister') }}" method="POST" class="space-y-5">
            @csrf

            @if(isset($ref) && $ref)
            <input type="hidden" name="referred_by" value="{{ $ref->id ?? '' }}">
            <div class="text-xs text-white/50">Referral code: {{ request()->code ?? $code ?? '' }}</div>

            @endif

            <div class="space-y-1.5">
              <label class="text-xs font-medium text-white/60 block px-1">Username</label>
              <div class="relative">
                <div class="absolute left-4 top-1/2 -translate-y-1/2">
                  <i class="fas fa-user text-white/40"></i>
                </div>
                <input
                  type="text"
                  name="username"
                  id="username"
                  value="{{ old('username') }}"
                  placeholder="JohnSmith"
                  pattern="[A-Za-z0-9_.-]+"
                  title="Username can only contain letters, numbers, underscores, dots and hyphens (no spaces)"
                  class="w-full bg-white/[0.06] border rounded-2xl pl-12 pr-10 py-4 text-[15px] text-white placeholder:text-white/30 focus:outline-none focus:border-primary/50 focus:bg-white/[0.08] transition-all border-white/[0.08]" />

                <!-- Feedback area -->
                <div id="username-feedback" class="absolute right-4 top-1/2 -translate-y-1/2 text-sm pointer-events-none">
                  <!-- Will be filled by JS: spinner / check / cross / message -->
                </div>
              </div>

              <!-- Error message below input -->
              <div id="username-error" class="text-red-400 text-xs mt-1.5 px-1 min-h-[1.25rem]"></div>
            </div>

            <div class="space-y-1.5">
              <label class="text-xs font-medium text-white/60 block px-1">
                Phone Number
              </label>

              <div class="relative">
                <div class="absolute left-4 top-1/2 -translate-y-1/2">
                  <i class="fas fa-phone text-white/40"></i>
                </div>

                <input
                  type="text"
                  name="phone"
                  id="phone"
                  value="{{ old('phone') }}"
                  placeholder="03001234567"
                  inputmode="numeric"
                  pattern="[0-9]+"
                  minlength="11"
                  maxlength="11"
                  oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                  class="w-full bg-white/[0.06] border rounded-2xl pl-12 pr-4 py-4 text-[15px] text-white placeholder:text-white/30 focus:outline-none focus:border-primary/50 focus:bg-white/[0.08] transition-all border-white/[0.08]" />
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
                  placeholder="Enter any password"
                  class="w-full bg-white/[0.06] border border-white/[0.08] rounded-2xl pl-12 pr-12 py-4 text-[15px] text-white placeholder:text-white/30 focus:outline-none focus:border-primary/50 focus:bg-white/[0.08] transition-all" />
                <button
                  type="button"
                  id="togglePassword"
                  class="absolute right-4 top-1/2 -translate-y-1/2 p-1 text-orange-600 hover:text-orange-800 transition-colors">
                  <!-- We'll change this icon with JS -->
                  <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye">
                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                  </svg>
                </button>
              </div>
            </div>

            <div class="space-y-2">
              <div class="flex justify-between items-center px-1">
                <label class="text-xs font-medium text-white/60">City</label>
              </div>
              <div class="custom-dropdown" id="cityDropdown">
                <div class="custom-dropdown-input" id="cityDropdownInput">
                  <span id="citySelectedText">Select a city</span>
                  <svg class="w-4 h-4 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </div>
                <div class="custom-dropdown-menu" id="cityDropdownMenu">
                  <div class="custom-dropdown-search">
                    <input type="text" id="citySearch" placeholder="Search city..." autocomplete="off">
                  </div>
                  <div id="cityOptionsList">
                    @foreach($cities as $city)
                    <div class="custom-dropdown-item" data-value="{{ $city->id }}">
                      {{ $city->name }}
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
              <input type="hidden" name="city_id" id="city_id" value="{{ old('city_id') }}">
            </div>

            <div class="space-y-2">
              <div class="flex justify-between items-center px-1">
                <label class="text-xs font-medium text-white/60">Register As</label>
              </div>
              <div class="custom-dropdown" id="userTypeDropdown">
                <div class="custom-dropdown-input" id="userTypeDropdownInput">
                  <span id="userTypeSelectedText">Select user type</span>
                  <svg class="w-4 h-4 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </div>
                <div class="custom-dropdown-menu" id="userTypeDropdownMenu">
                  <div class="custom-dropdown-item" data-value="customer">Customer</div>
                  <div class="custom-dropdown-item" data-value="expert">Expert</div>
                </div>
              </div>
              <input type="hidden" name="user_type" id="user_type" value="{{ old('user_type') }}">
            </div>

            <button
              type="submit"
              id="submitBtn"
              class="w-full bg-gradient-primary text-white font-semibold py-4 rounded-2xl
           flex items-center justify-center gap-2 mt-4
           shadow-[0_8px_30px_rgba(124,58,237,0.3)]
           hover:shadow-[0_8px_40px_rgba(124,58,237,0.4)]
           active:scale-[0.98] transition-all
           disabled:opacity-60 disabled:cursor-not-allowed">

              <span id="btnText">Register</span>
            </button>


          </form>
          <div class="mt-8 text-center">
            <p class="text-white/40 text-sm">
              Already have an account? <a href="/login" class="text-primary font-semibold hover:text-accent transition-colors">Login Now</a>
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
      document.addEventListener('DOMContentLoaded', () => {
        const usernameInput = document.getElementById('username');
        const feedback = document.getElementById('username-feedback');
        const errorDiv = document.getElementById('username-error');

        if (!usernameInput) return;

        // Optional: live space removal (you already have this)
        usernameInput.addEventListener('input', function() {
          this.value = this.value.replace(/\s+/g, '');
          // this.value = this.value.toLowerCase(); // ← uncomment if you want usernames always lowercase
          clearFeedback();
        });

        // Main check – when user leaves the field
        usernameInput.addEventListener('blur', async function() {
          const username = this.value.trim();

          // Skip check if empty or too short
          if (username.length < 3) {
            clearFeedback();
            return;
          }

          // Show loading
          feedback.innerHTML = '<i class="fas fa-circle-notch fa-spin text-yellow-400"></i>';
          errorDiv.textContent = '';

          try {
            const response = await fetch('{{ route("check.username") }}', {
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

            if (data.available === true) {
              feedback.innerHTML = '<i class="fas fa-check-circle text-emerald-400"></i>';
              errorDiv.textContent = '';
              usernameInput.classList.remove('border-red-500');
              usernameInput.classList.add('border-emerald-500/50');
            } else {
              feedback.innerHTML = '<i class="fas fa-times-circle text-red-400"></i>';
              errorDiv.textContent = data.message || 'Username is already taken';
              usernameInput.classList.remove('border-emerald-500/50');
              usernameInput.classList.add('border-red-500');
            }
          } catch (err) {
            feedback.innerHTML = '<i class="fas fa-exclamation-circle text-amber-400"></i>';
            errorDiv.textContent = 'Could not check username. Try again.';
          }
        });

        function clearFeedback() {
          feedback.innerHTML = '';
          errorDiv.textContent = '';
          usernameInput.classList.remove('border-red-500', 'border-emerald-500/50');
        }
      });
    </script>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('id_password');
        const toggleButton = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eyeIcon');

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
      document.addEventListener('DOMContentLoaded', function() {
        // Generic dropdown controller
        function initDropdown(dropdownId, hiddenInputId, searchable = false) {
          const dropdown = document.getElementById(dropdownId);
          const inputDiv = dropdown.querySelector('.custom-dropdown-input');
          const menu = dropdown.querySelector('.custom-dropdown-menu');
          const selectedSpan = inputDiv.querySelector('span:first-child');
          const hiddenInput = document.getElementById(hiddenInputId);
          let items = dropdown.querySelectorAll('.custom-dropdown-item');

          // Toggle menu
          inputDiv.addEventListener('click', (e) => {
            e.stopPropagation();
            menu.classList.toggle('show');
          });

          // Close when clicking outside
          document.addEventListener('click', function(e) {
            if (!dropdown.contains(e.target)) {
              menu.classList.remove('show');
            }
          });

          // Handle item selection
          items.forEach(item => {
            item.addEventListener('click', () => {
              const value = item.getAttribute('data-value');
              const text = item.innerText;
              selectedSpan.innerText = text;
              hiddenInput.value = value;
              menu.classList.remove('show');
              // Remove selected class from all items
              items.forEach(i => i.classList.remove('selected'));
              item.classList.add('selected');
            });
          });

          // Search functionality (if searchable)
          if (searchable) {
            const searchInput = dropdown.querySelector('.custom-dropdown-search input');
            const optionsContainer = dropdown.querySelector('#cityOptionsList');
            const originalItems = Array.from(optionsContainer.querySelectorAll('.custom-dropdown-item'));

            searchInput.addEventListener('input', function() {
              const query = this.value.toLowerCase();
              originalItems.forEach(item => {
                const text = item.innerText.toLowerCase();
                if (text.includes(query)) {
                  item.style.display = '';
                } else {
                  item.style.display = 'none';
                }
              });
            });
          }

          // Pre-select from old value
          if (hiddenInput.value) {
            const selectedItem = Array.from(items).find(item => item.getAttribute('data-value') === hiddenInput.value);
            if (selectedItem) {
              selectedSpan.innerText = selectedItem.innerText;
              selectedItem.classList.add('selected');
            }
          }
        }

        // Initialize city dropdown (searchable)
        initDropdown('cityDropdown', 'city_id', true);
        // Initialize user type dropdown (not searchable)
        initDropdown('userTypeDropdown', 'user_type', false);
      });
    </script>


    @include('includes.mob_footer_links')

  </main>
</body>

</html>