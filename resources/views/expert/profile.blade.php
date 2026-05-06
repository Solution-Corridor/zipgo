@php
$canEdit = true; // default: new submission
if ($expertData) {
// status 0 (pending) or 1 (approved) → disable editing
// status 2 (rejected) → allow editing
$canEdit = ($expertData->profile_status == 2);
}
@endphp
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <!-- jQuery (required by Select2) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Select2 CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

  <!-- Select2 JS (after jQuery) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  @include('expert.includes.general_style')
  <title>Expert Profile</title>

  <style>
    * {
      -webkit-tap-highlight-color: transparent;
    }

    body {
      background: #121826;
      font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, sans-serif;
    }

    .gradient-primary {
      background: linear-gradient(105deg, #F4A261 0%, #E08E3E 100%);
    }

    .glow {
      box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(244, 162, 97, 0.2);
    }

    [x-cloak] {
      display: none !important;
    }

    .animate-pulse-slow {
      animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse {

      0%,
      100% {
        opacity: 1;
      }

      50% {
        opacity: 0.6;
      }
    }

    .custom-scroll::-webkit-scrollbar {
      width: 4px;
    }

    .custom-scroll::-webkit-scrollbar-track {
      background: #1A2636;
      border-radius: 10px;
    }

    .custom-scroll::-webkit-scrollbar-thumb {
      background: #F4A261;
      border-radius: 10px;
    }

    .file-preview-img {
      transition: all 0.2s ease;
    }

    .card-hover {
      transition: transform 0.1s ease, border-color 0.2s;
    }

    /* Select2 dark overrides (navy/gold) */
    .select2-dropdown {
      background-color: #1A2636;
      border: 1px solid #2A3A5A;
      border-radius: 8px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.6);
    }

    .select2-search--dropdown {
      padding: 8px;
      background-color: #1A2636;
    }

    .select2-search--dropdown .select2-search__field {
      background-color: #121826;
      border: 1px solid #2A3A5A;
      color: #e0e0e0;
      border-radius: 6px;
      padding: 8px 10px;
    }

    .select2-search--dropdown .select2-search__field:focus {
      border-color: #F4A261;
      outline: none;
    }

    .select2-results__option {
      background-color: #1A2636;
      color: #ddd;
      padding: 8px 12px;
      font-size: 14px;
    }

    .select2-results__option--highlighted {
      background-color: #2A3A5A !important;
      color: white !important;
    }

    .select2-results__option[aria-selected="true"] {
      background-color: #F4A261 !important;
      color: #121826 !important;
    }

    .select2-container--default .select2-selection--single {
      background-color: #121826;
      border: 1px solid #2A3A5A;
      border-radius: 8px;
      height: 46px;
      line-height: 46px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: #e0e0e0;
      line-height: 46px;
      padding-left: 15px;
    }

    .select2-container--default .select2-selection--single .select2-selection__placeholder {
      color: #aaa;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 44px;
      right: 10px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
      border-color: #aaa transparent transparent transparent;
    }

    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
      border-color: transparent transparent #aaa transparent;
    }

    .select2-container--default.select2-container--open .select2-selection--single {
      border-color: #F4A261;
    }

    .select2-container--default .select2-selection--single .select2-selection__clear {
      color: #aaa;
      right: 25px;
    }

    .select2-container--default .select2-dropdown {
      background: rgba(26, 38, 54, 0.95) !important;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(244, 162, 97, 0.3);
      border-radius: 12px;
    }

    .select2-container--default .select2-selection--single[aria-disabled="true"] {
      background-color: #1A2636 !important;
      color: #cbd5f5 !important;
      border-color: #2A3A5A !important;
      cursor: not-allowed;
    }

    #serviceSelect.select2-hidden-accessible,
    #subServiceSelect.select2-hidden-accessible {
      position: absolute !important;
      left: -10000px !important;
      top: auto !important;
      width: 1px !important;
      height: 1px !important;
      overflow: hidden !important;
      clip: rect(0, 0, 0, 0) !important;
      white-space: nowrap !important;
    }

    input[type="file"]::file-selector-button {
      background-color: #F4A261;
      color: #121826;
      border-radius: 0.5rem;
      border: none;
      padding: 0.4rem 1rem;
      cursor: pointer;
      font-weight: 500;
    }

    input[type="file"]::file-selector-button:hover {
      background-color: #E08E3E;
    }
  </style>
</head>

<body class="min-h-screen bg-[#121826] antialiased">

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#121826] shadow-2xl shadow-black/50 relative">
    @include('expert.includes.top_greetings')

    <div class="px-4 pt-4 pb-28">
      @include('includes.success')
      <!-- ==================== EXPERT DETAILS SECTION ==================== -->
      <div class="mt-2 mb-6">
        <div class="flex items-center gap-2 mb-3 px-1">
          <i data-lucide="briefcase" class="w-5 h-5 text-[#F4A261]"></i>
          <h3 class="text-[#F4A261] font-semibold text-sm tracking-wide">PROFESSIONAL VERIFICATION</h3>
          <div class="flex-1 h-px bg-gradient-to-r from-[#F4A261]/40 to-transparent"></div>
        </div>

        @if($expertData)
        <div class="mb-4 p-3 rounded-lg {{ 
        $expertData->profile_status == 0 ? 'bg-yellow-500/10 border border-yellow-500/30' : 
        ($expertData->profile_status == 1 ? 'bg-green-500/10 border border-green-500/30' : 
        'bg-red-500/10 border border-red-500/30') 
    }}">
          <div class="flex items-center gap-2">
            <i data-lucide="{{ 
                $expertData->profile_status == 0 ? 'clock' : 
                ($expertData->profile_status == 1 ? 'badge-check' : 'x-circle') 
            }}" class="w-4 h-4 {{ 
                $expertData->profile_status == 0 ? 'text-yellow-400' : 
                ($expertData->profile_status == 1 ? 'text-green-400' : 'text-red-400') 
            }}"></i>
            <span class="text-sm font-medium {{ 
                $expertData->profile_status == 0 ? 'text-yellow-300' : 
                ($expertData->profile_status == 1 ? 'text-green-300' : 'text-red-300') 
            }}">
              Profile Status:
              @if($expertData->profile_status == 0) Pending
              @elseif($expertData->profile_status == 1) Approved
              @else Rejected
              @endif
            </span>
          </div>
          @if($expertData->profile_status == 0)
          <p class="text-xs text-yellow-400/70 mt-1">Your profile is under review. Editing is disabled until approval.</p>
          @elseif($expertData->profile_status == 1)
          <p class="text-xs text-green-400/70 mt-1">Your profile has been approved. You cannot edit it.</p>
          @else
          <p class="text-xs text-red-400/70 mt-1">Your profile was rejected. Please update and resubmit.</p>
          @endif
        </div>
        @endif

        <form action="{{ route('expert.profile.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="user_id" value="{{ auth()->id() }}">

          <div class="space-y-6">

            <!-- Service & Sub-service Card -->
            <div class="bg-[#1A2636] rounded-xl p-4 border border-[#2A3A5A]">
              <div class="flex items-center gap-2 mb-4">
                <i data-lucide="layers" class="w-4 h-4 text-[#F4A261]"></i>
                <h4 class="text-sm font-semibold text-[#F4A261]">Service Selection</h4>
              </div>

              <!-- Main Service Dropdown -->
              <div>
                <label class="block text-xs text-slate-400 mb-1">Select Service *</label>
                <select id="serviceSelect" name="service_id" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-slate-200 select2" {{ $canEdit ? '' : 'disabled' }}>
                  <option value="">Select a service</option>
                  @foreach($services as $service)
                  <option value="{{ $service->id }}" {{ old('service_id', $expertData->service_id ?? '') == $service->id ? 'selected' : '' }}>
                    {{ $service->name }}
                  </option>
                  @endforeach
                </select>
                @error('service_id')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
              </div>

              <!-- Sub-service Dropdown (dynamic) -->
              <div id="subServiceContainer" style="{{ old('service_id', $expertData->service_id ?? '') ? '' : 'display: none;' }}" class="mt-4">
                <label class="block text-xs text-slate-400 mb-1">Select Sub-Service *</label>
                <select id="subServiceSelect" name="sub_service_id" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-slate-200 select2" {{ $canEdit ? '' : 'disabled' }} required>
                  <option value="">-- First select a service --</option>
                </select>
                @error('sub_service_id')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <!-- NIC Details Grid -->
            <div class="bg-[#1A2636] rounded-xl p-4 border border-[#2A3A5A]">
              <div class="flex items-center gap-2 mb-4">
                <i data-lucide="id-card" class="w-4 h-4 text-[#F4A261]"></i>
                <h4 class="text-sm font-semibold text-[#F4A261]">NIC & Verification</h4>
              </div>
              <div class="space-y-4">

                <div>
                  <label class="block text-xs text-slate-400 mb-1">Full Name *</label>
                  <input type="text" name="full_name" value="{{ old('full_name', $expertData->full_name ?? '') }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-slate-200 focus:ring-2 focus:ring-[#F4A261] focus:border-transparent" placeholder="Full Name" {{ $canEdit ? '' : 'disabled' }} required>
                  @error('full_name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                  <label class="block text-xs text-slate-400 mb-1">NIC Number *</label>
                  <input type="text" name="nic_number" value="{{ old('nic_number', $expertData->nic_number ?? '') }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-slate-200 focus:ring-2 focus:ring-[#F4A261] focus:border-transparent" placeholder="CNIC / NIC number" {{ $canEdit ? '' : 'disabled' }} required>
                  @error('nic_number')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                  <label class="block text-xs text-slate-400 mb-1">Expiry Date</label>
                  <input type="date" name="nic_expiry" value="{{ old('nic_expiry', $expertData->nic_expiry ?? '') }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-slate-200 focus:ring-2 focus:ring-[#F4A261]" {{ $canEdit ? '' : 'disabled' }}>
                  @error('nic_expiry')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- NIC Front with preview -->
                <div>
                  <label class="block text-xs text-slate-400 mb-1">NIC Front Image</label>
                  <div class="flex items-center gap-3 flex-nowrap">
                    <input type="file" name="nic_front" id="nic_front_input" class="flex-1 min-w-0 text-slate-400 text-sm file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-[#F4A261]/20 file:text-[#F4A261] hover:file:bg-[#F4A261]/30 cursor-pointer" {{ $canEdit ? '' : 'disabled' }}>
                    <div id="nic_front_preview_container" class="relative w-12 h-12 rounded-lg border border-dashed border-gray-600 overflow-hidden bg-slate-900 flex-shrink-0 flex items-center justify-center">
                      @if(!empty($expertData->nic_front_image))
                      <img src="/{{ $expertData->nic_front_image }}" class="w-full h-full object-cover" alt="Front NIC">
                      @else
                      <i data-lucide="image" class="w-5 h-5 text-gray-500"></i>
                      @endif
                    </div>
                  </div>
                  @error('nic_front')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- NIC Back with preview -->
                <div>
                  <label class="block text-xs text-slate-400 mb-1">NIC Back Image</label>
                  <div class="flex items-center gap-3 flex-nowrap">
                    <input type="file" name="nic_back" id="nic_back_input" class="flex-1 min-w-0 text-slate-400 text-sm file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-[#F4A261]/20 file:text-[#F4A261] hover:file:bg-[#F4A261]/30 cursor-pointer" {{ $canEdit ? '' : 'disabled' }}>
                    <div id="nic_back_preview_container" class="relative w-12 h-12 rounded-lg border border-dashed border-gray-600 overflow-hidden bg-slate-900 flex-shrink-0 flex items-center justify-center">
                      @if(!empty($expertData->nic_back_image))
                      <img src="/{{ $expertData->nic_back_image }}" class="w-full h-full object-cover" alt="Back NIC">
                      @else
                      <i data-lucide="image" class="w-5 h-5 text-gray-500"></i>
                      @endif
                    </div>
                  </div>
                  @error('nic_back')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Selfie with NIC preview -->
                <div>
                  <label class="block text-xs text-slate-400 mb-1">Selfie with NIC</label>
                  <div class="flex items-center gap-3 flex-nowrap">
                    <input type="file" name="selfie" id="selfie_input" class="flex-1 min-w-0 text-slate-400 text-sm file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-[#F4A261]/20 file:text-[#F4A261] hover:file:bg-[#F4A261]/30 cursor-pointer" {{ $canEdit ? '' : 'disabled' }}>
                    <div id="selfie_preview_container" class="relative w-12 h-12 rounded-lg border border-dashed border-gray-600 overflow-hidden bg-slate-900 flex-shrink-0 flex items-center justify-center">
                      @if(!empty($expertData->selfie_image))
                      <img src="/{{ $expertData->selfie_image }}" class="w-full h-full object-cover" alt="Selfie">
                      @else
                      <i data-lucide="camera" class="w-5 h-5 text-gray-500"></i>
                      @endif
                    </div>
                  </div>
                  @error('selfie')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
              </div>
            </div>

            <!-- Submit button -->
            <button type="submit" {{ $canEdit ? '' : 'disabled' }} class="w-full py-3.5 rounded-xl font-semibold text-white bg-gradient-to-r from-[#F4A261] to-[#E08E3E] shadow-lg shadow-[#F4A261]/20 transition-all hover:from-[#E08E3E] hover:to-[#D97706] {{ $canEdit ? '' : 'opacity-60 cursor-not-allowed' }}">
              {{ $canEdit ? 'Update Expert Profile' : 'Profile Locked' }}
            </button>
          </div>
        </form>

        <!-- Logout Button -->
        <div class="mt-6">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-2.5 rounded-xl font-medium bg-transparent border border-[#F4A261] text-[#F4A261] hover:bg-[#F4A261]/10 transition active:scale-[0.98]">
              <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
          </form>
        </div>
      </div>
    </div>

    @include('expert.includes.bottom_navigation')
  </div>

  <!-- Dynamic JavaScript for sub-services and image preview -->
  <script>
    $(document).ready(function() {
      // Image preview function (keep as is)
      function setupImagePreview(inputId, previewContainerId) {
        const input = document.getElementById(inputId);
        const container = document.getElementById(previewContainerId);
        if (!input || !container) return;
        input.addEventListener('change', function(e) {
          if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(ev) {
              container.innerHTML = `<img src="${ev.target.result}" class="w-full h-full object-cover rounded-lg">`;
            }
            reader.readAsDataURL(e.target.files[0]);
          }
        });
      }

      // Initialize service Select2
      $('#serviceSelect').select2({
        placeholder: 'Search for a service...',
        allowClear: true,
        width: '100%'
      });

      // Function to load sub-services
      function loadSubServices(serviceId, selectedSubServiceId = null) {
        const subContainer = $('#subServiceContainer');
        const subSelect = $('#subServiceSelect');

        if (!serviceId) {
          subContainer.hide();
          subSelect.empty().append('<option value="">-- First select a service --</option>');
          if (subSelect.hasClass('select2-hidden-accessible')) {
            subSelect.select2('destroy');
            subSelect.select2({
              placeholder: 'Select a sub-service',
              allowClear: true,
              width: '100%'
            });
          }
          return;
        }

        subContainer.show();
        subSelect.empty().append('<option value="">Loading...</option>').prop('disabled', true);
        if (subSelect.hasClass('select2-hidden-accessible')) {
          subSelect.select2('destroy');
        }

        // FIXED URL
        const url = "{{ url('/expert/sub-services') }}/" + serviceId;
        // console.log('AJAX URL:', url);

        $.ajax({
          url: url,
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            console.log('Sub-services received:', data);
            subSelect.empty().append('<option value="">Select a sub-service</option>');
            if (data.length === 0) {
              subSelect.append('<option value="" disabled>No sub-services available</option>');
            } else {
              $.each(data, function(key, sub) {
                subSelect.append('<option value="' + sub.id + '">' + escapeHtml(sub.name) + '</option>');
              });
            }
            subSelect.select2({
              placeholder: 'Select a sub-service',
              allowClear: true,
              width: '100%'
            });
            const canEdit = @json($canEdit);
            subSelect.prop('disabled', !canEdit);
            if (selectedSubServiceId) {
              subSelect.val(selectedSubServiceId).trigger('change');
            }
          },
          error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            console.error('Response text:', xhr.responseText);
            subSelect.empty().append('<option value="">Error loading sub-services</option>');
            subSelect.select2({
              placeholder: 'o hooo',
              width: '100%'
            });
          }
        });
      }

      function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
          if (m === '&') return '&amp;';
          if (m === '<') return '&lt;';
          if (m === '>') return '&gt;';
          return m;
        });
      }

      // Event: service change
      $('#serviceSelect').on('change', function() {
        loadSubServices($(this).val(), null);
      });

      // On load
      const initialServiceId = $('#serviceSelect').val();
      const initialSubServiceId = @json(old('sub_service_id', $expertData -> sub_service_id ?? null));
      if (initialServiceId) {
        loadSubServices(initialServiceId, initialSubServiceId);
      } else {
        $('#subServiceContainer').hide();
      }

      // Select2 focus
      $(document).on('select2:open', function() {
        setTimeout(function() {
          document.querySelector('.select2-container--open .select2-search__field')?.focus();
        }, 0);
      });

      if (typeof lucide !== 'undefined') lucide.createIcons();
      setupImagePreview('nic_front_input', 'nic_front_preview_container');
      setupImagePreview('nic_back_input', 'nic_back_preview_container');
      setupImagePreview('selfie_input', 'selfie_preview_container');
    });
  </script>

  <style>
    /* Additional file input styling */
    .file\:mr-3::file-selector-button {
      margin-right: 0.75rem;
      transition: all 0.2s;
    }
  </style>
</body>

</html>