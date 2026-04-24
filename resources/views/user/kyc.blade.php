<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    @include('user.includes.general_style')
    <title>KYC Verification</title>
</head>

<body class="min-h-screen bg-[#0A0A0F]">

    <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

        @include('user.includes.top_greetings')

        <div class="px-4 pt-4 pb-20 space-y-6">

            <h2 class="text-xl font-bold text-white text-center">KYC Verification</h2>

            <!-- ── Current status card (unchanged) ──────────────────────── -->
            @if(!$kyc)
                <div class="bg-gray-900/60 rounded-xl p-5 text-center border border-gray-700">
                    <p class="text-gray-300 text-sm mb-4">Verify identity to unlock full features</p>
                    <a href="{{ route('kyc.create') }}"
                       class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-10 py-3.5 rounded-xl text-sm transition">
                        Start Verification
                    </a>
                </div>

            @elseif($kyc->isApproved())
                <div class="bg-green-900/40 border border-green-700/50 rounded-xl p-5 text-center">
                    <div class="text-4xl mb-3">✅</div>
                    <h3 class="text-lg font-semibold text-green-400 mb-1.5">Verified</h3>
                    <p class="text-gray-300 text-sm">Your identity is verified.</p>
                </div>

            @elseif($kyc->isSubmitted())
                <div class="bg-blue-900/40 border border-blue-700/50 rounded-xl p-5 text-center">
                    <div class="text-4xl mb-3">⏳</div>
                    <h3 class="text-lg font-semibold text-blue-400 mb-1.5">Under Review</h3>
                    <p class="text-gray-300 text-sm">Review usually takes 24–72 hours.</p>
                </div>

            @else
                <div class="bg-yellow-900/40 border border-yellow-700/50 rounded-xl p-5 text-center">
                    <div class="text-4xl mb-3">⚠️</div>
                    <h3 class="text-lg font-semibold text-yellow-400 mb-2">Action Required</h3>
                    <p class="text-gray-300 text-sm mb-4">Please complete KYC verification.</p>
                    <a href="{{ route('kyc.create') }}"
                       class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white font-medium px-10 py-3.5 rounded-xl text-sm transition">
                        Complete Now
                    </a>
                </div>
            @endif

            <!-- ── KYC History ───────────────────────────────────────────── -->
@if($kycHistory->isNotEmpty())
    <div class="space-y-4 mt-8">
        <h3 class="text-lg font-semibold text-gray-200 text-center sm:text-left">
            Previous KYC Submissions
        </h3>

        <div class="space-y-3">
            @foreach($kycHistory as $record)
                <div class="bg-gray-900/70 rounded-xl p-4 border">

                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <div class="text-sm font-medium text-gray-300">
                                {{ ucfirst($record->status) }}
                            </div>
                            <div class="text-xs text-gray-500 mt-0.5">
                                {{ $record->created_at->format('d M Y • H:i') }}
                            </div>
                        </div>

                        @if($record->status === 'approved')
                            <span class="text-xs bg-green-900/70 text-green-400 px-2.5 py-1 rounded-full">Verified</span>
                        @elseif($record->status === 'rejected')
                            <span class="text-xs bg-red-900/70 text-red-400 px-2.5 py-1 rounded-full">Rejected</span>
                        @else
                            <span class="text-xs bg-blue-900/70 text-blue-400 px-2.5 py-1 rounded-full">In Progress</span>
                        @endif
                    </div>

                    @if($record->status === 'rejected' && $record->admin_note)
                        <div class="mt-2 text-xs text-red-300/90 border-t border-red-800/30 pt-2">
                            {{ $record->admin_note }}
                        </div>
                    @endif

                </div>
            @endforeach
        </div>
    </div>
@endif

            @include('user.includes.profile_bottom_nav')

        </div>

        @include('user.includes.bottom_navigation')

    </div>

</body>
</html>