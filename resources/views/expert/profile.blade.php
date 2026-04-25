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
    @include('user.includes.general_style')
    <title>Expert Profile</title>

    <style>
        * {
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background: #0A0A0F;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, sans-serif;
        }

        .gradient-primary {
            background: linear-gradient(105deg, #8b5cf6 0%, #6366f1 100%);
        }

        .glow {
            box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(139, 92, 246, 0.1);
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
            background: #1e293b;
            border-radius: 10px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #8b5cf6;
            border-radius: 10px;
        }

        .file-preview-img {
            transition: all 0.2s ease;
        }

        .card-hover {
            transition: transform 0.1s ease, border-color 0.2s;
        }
    </style>

    <style>
        /* === Select2 Dark Theme Overrides === */

        /* Dropdown container */
        .select2-dropdown {
            background-color: #1f1f2b;
            /* dark background for the dropdown */
            border: 1px solid #2d2d3a;
            /* subtle border */
            border-radius: 8px;
            /* smooth corners */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.6);
            /* floating effect */
        }

        /* Search field inside dropdown */
        .select2-search--dropdown {
            padding: 8px;
            background-color: #1f1f2b;
            /* same as dropdown */
        }

        .select2-search--dropdown .select2-search__field {
            background-color: #0f0f1a;
            /* darker field */
            border: 1px solid #3a3a4a;
            color: #e0e0e0;
            /* light text */
            border-radius: 6px;
            padding: 8px 10px;
        }

        .select2-search--dropdown .select2-search__field:focus {
            border-color: #22c55e;
            /* green accent on focus */
            outline: none;
        }

        /* Each result item */
        .select2-results__option {
            background-color: #1f1f2b;
            color: #ddd;
            padding: 8px 12px;
            font-size: 14px;
        }

        .select2-results__option--highlighted {
            background-color: #2a2a3a !important;
            /* hover color */
            color: white !important;
        }

        .select2-results__option[aria-selected="true"] {
            background-color: #22c55e !important;
            /* selected item */
            color: black !important;
        }

        /* Fix the "clear" button and other small elements */
        .select2-container--default .select2-selection--single {
            background-color: #0f0f1a;
            /* matches your input background */
            border: 1px solid #3a3a4a;
            border-radius: 8px;
            height: 46px;
            /* adjust to match your inputs */
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

        /* When dropdown is open, style the selected item in the closed box */
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #22c55e;
        }

        /* If you use "allowClear", style the "x" */
        .select2-container--default .select2-selection--single .select2-selection__clear {
            color: #aaa;
            right: 25px;
        }

        .select2-container--default .select2-dropdown {
            background: rgba(30, 30, 50, 0.55) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(100, 100, 255, 0.18);
            border-radius: 12px;
        }

        /* Force original select to be hidden after Select2 initialises */
        #serviceSelect.select2-hidden-accessible {
            position: absolute !important;
            left: -10000px !important;
            top: auto !important;
            width: 1px !important;
            height: 1px !important;
            overflow: hidden !important;
            clip: rect(0, 0, 0, 0) !important;
            white-space: nowrap !important;
        }
    </style>

</head>

<body class="min-h-screen bg-[#0A0A0F] antialiased">

    <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">
        <!-- top greeting (dynamic greeting area) -->
        @include('user.includes.top_greetings')

        <div class="px-4 pt-4 pb-28">
            @include('includes.success')
            <!-- ==================== EXPERT DETAILS SECTION ==================== -->
            <div class="mt-2 mb-6">
                <div class="flex items-center gap-2 mb-3 px-1">
                    <i data-lucide="briefcase" class="w-5 h-5 text-indigo-400"></i>
                    <h3 class="text-indigo-200 font-semibold text-sm tracking-wide">PROFESSIONAL VERIFICATION</h3>
                    <div class="flex-1 h-px bg-gradient-to-r from-indigo-500/40 to-transparent"></div>
                </div>

                <form action="{{ route('expert_profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- hidden user id -->
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                    <div class="space-y-6">



                        <div class="bg-slate-800/40 rounded-xl p-4 border border-white/5">
                            
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">Select Service *</label>

                                <select id="serviceSelect"
                                    name="service_id"
                                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-slate-200 select2">

                                    <option value="">Select a service</option>

                                    @foreach($services as $service)
                                    <option value="{{ $service->id }}"
                                        {{ old('service_id', $expertData->service_id ?? '') == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }}
                                    </option>
                                    @endforeach
                                </select>

                                @error('service_id')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- NIC Details Grid -->
                        <div class="bg-slate-800/40 rounded-xl p-4 border border-white/5">
                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="id-card" class="w-4 h-4 text-indigo-400"></i>
                                <h4 class="text-sm font-semibold text-indigo-300">NIC & Verification</h4>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs text-slate-400 mb-1">NIC Number *</label>
                                    <input type="text" name="nic_number" value="{{ old('nic_number', $expertData->nic_number ?? '') }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="CNIC / NIC number">
                                    @error('nic_number')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs text-slate-400 mb-1">Expiry Date</label>
                                    <input type="date" name="nic_expiry" value="{{ old('nic_expiry', $expertData->nic_expiry ?? '') }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-slate-200 focus:ring-2 focus:ring-indigo-500">
                                    @error('nic_expiry')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>

                                <!-- NIC Front with preview -->
                                <div>
                                    <label class="block text-xs text-slate-400 mb-1">NIC Front Image</label>
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <input type="file" name="nic_front" id="nic_front_input" class="text-slate-400 text-sm file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-600/20 file:text-indigo-300 hover:file:bg-indigo-600/30 cursor-pointer">
                                        <div id="nic_front_preview_container" class="relative w-12 h-12 rounded-lg border border-dashed border-gray-600 overflow-hidden bg-slate-900 flex items-center justify-center">
                                            @if(!empty($expertData->nic_front_image))
                                            <img src="/{{ $expertData->nic_front_image }}" class="w-full h-full object-cover" alt="Front NIC">
                                            @else
                                            <i data-lucide="image" class="w-5 h-5 text-gray-500"></i>
                                            @endif
                                        </div>
                                    </div>
                                    @if(!empty($expertData->nic_front_image))<p class="text-[11px] text-slate-500 mt-1">Current: {{ basename($expertData->nic_front_image) }}</p>@endif
                                    @error('nic_front')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>

                                <!-- NIC Back with preview -->
                                <div>
                                    <label class="block text-xs text-slate-400 mb-1">NIC Back Image</label>
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <input type="file" name="nic_back" id="nic_back_input" class="text-slate-400 text-sm file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-600/20 file:text-indigo-300">
                                        <div id="nic_back_preview_container" class="relative w-12 h-12 rounded-lg border border-dashed border-gray-600 overflow-hidden bg-slate-900 flex items-center justify-center">
                                            @if(!empty($expertData->nic_back_image))
                                            <img src="/{{ $expertData->nic_back_image }}" class="w-full h-full object-cover" alt="Back NIC">
                                            @else
                                            <i data-lucide="image" class="w-5 h-5 text-gray-500"></i>
                                            @endif
                                        </div>
                                    </div>
                                    @if(!empty($expertData->nic_back_image))<p class="text-[11px] text-slate-500 mt-1">Current: {{ basename($expertData->nic_back_image) }}</p>@endif
                                    @error('nic_back')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>

                                <!-- Selfie with NIC preview -->
                                <div>
                                    <label class="block text-xs text-slate-400 mb-1">Selfie with NIC</label>
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <input type="file" name="selfie" id="selfie_input" class="text-slate-400 text-sm file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-600/20 file:text-indigo-300">
                                        <div id="selfie_preview_container" class="relative w-12 h-12 rounded-lg border border-dashed border-gray-600 overflow-hidden bg-slate-900 flex items-center justify-center">
                                            @if(!empty($expertData->selfie_image))
                                            <img src="/{{ $expertData->selfie_image }}" class="w-full h-full object-cover" alt="Selfie">
                                            @else
                                            <i data-lucide="camera" class="w-5 h-5 text-gray-500"></i>
                                            @endif
                                        </div>
                                    </div>
                                    @if(!empty($expertData->selfie_image))<p class="text-[11px] text-slate-500 mt-1">Current: {{ basename($expertData->selfie_image) }}</p>@endif
                                    @error('selfie')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>

                        <!-- submit button for expert data -->
                        <button type="submit" class="w-full py-3.5 rounded-xl font-semibold text-white bg-indigo-700 hover:bg-indigo-600 shadow-lg active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                            <i data-lucide="shield-check" class="w-4 h-4"></i> Update Expert Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @include('user.includes.bottom_navigation')
    </div>

    <script>
        // Simple image preview for NIC front, back, and selfie uploads
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

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize image previews
            setupImagePreview('nic_front_input', 'nic_front_preview_container');
            setupImagePreview('nic_back_input', 'nic_back_preview_container');
            setupImagePreview('selfie_input', 'selfie_preview_container');

            // Initialize Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
    <!-- jQuery & Select2 -->


    <script>
        $(document).ready(function() {
            $('#serviceSelect').select2({
                placeholder: 'Search for a service...',
                allowClear: true,
                width: '100%'
            });

            $(document).on('select2:open', '#serviceSelect', function() {
                setTimeout(function() {
                    document.querySelector('.select2-container--open .select2-search__field').focus();
                }, 0);
            });
        });
    </script>
    <style>
        /* additional custom alignment */
        .file\:mr-3::file-selector-button {
            margin-right: 0.75rem;
            transition: all 0.2s;
        }

        input[type="file"]::file-selector-button {
            background-color: #4f46e5;
            color: white;
            border-radius: 0.5rem;
            border: none;
            padding: 0.4rem 1rem;
            cursor: pointer;
        }

        input[type="file"]::file-selector-button:hover {
            background-color: #6366f1;
        }
    </style>
</body>

</html>