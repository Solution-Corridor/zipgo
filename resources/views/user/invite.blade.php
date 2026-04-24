<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    @include('user.includes.general_style')
    <title>Invite</title>
</head>

<body class="min-h-screen bg-[#0A0A0F]">

    <!-- Mobile-like container -->
    <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

        <!-- Top Greeting + Add / Ref (updated: sharp top corners, rounded bottom) -->
        @include('user.includes.top_greetings')


        <!-- Invite / Referral Screen Content -->

        <div class="px-5 pt-5 pb-28"> <!-- pb-28 to prevent overlap with bottom nav -->


            <!-- Commission Levels -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-center mb-4">Commission Levels</h3>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="card rounded-xl p-4 text-center border border-purple-500/30 bg-gradient-to-b from-purple-950/40 to-transparent">
                        <p class="text-sm text-gray-300 mb-1">Level 1</p>
                        <p class="text-2xl font-bold text-cyan-400">Invest: {{ number_format($user_package->referral_bonus_level1 ?? 0) }} %</p>
                    </div>
                    <div class="card rounded-xl p-4 text-center border border-blue-500/30 bg-gradient-to-b from-blue-950/40 to-transparent">
                        <p class="text-sm text-gray-300 mb-1">Level 2</p>
                        <p class="text-2xl font-bold text-cyan-400">Invest: {{ number_format($user_package->referral_bonus_level2 ?? 0) }} %</p>
                    </div>
                </div>
            </div>

            <!-- Level Stats Cards -->
            <div class="space-y-5">

                <!-- Level 1 Stats -->
                <div class="card rounded-2xl p-5 overflow-hidden relative glow">
                    <div class="absolute -top-1 -left-1 w-14 h-14 bg-gradient-to-br from-purple-700 to-indigo-700 rounded-br-2xl flex items-center justify-center text-xl font-bold text-white shadow-lg">
                        1
                    </div>
                    <h4 class="text-base font-semibold mb-4 text-center">Level 1 Stats</h4>
                    <p class="text-xs text-gray-400 text-center mb-5">Direct Referrals Business</p>

                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div>
                            <p class="text-xl font-bold text-white">{{ $level1_count }}</p>
                            <p class="text-xs text-gray-400 mt-1">Team Members</p>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-emerald-400">{{ number_format($level1_business, 0) }} Rs</p>
                            <p class="text-xs text-gray-400 mt-1">Total Invested</p>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-purple-300">{{ number_format($level1_commission, 0) }} Rs</p>
                            <p class="text-xs text-gray-400 mt-1">Your Earnings</p>
                        </div>
                    </div>
                </div>

<!-- Level 1 Members List -->
@if($level1_count > 0)
<div class="mt-6 card rounded-2xl p-5">
    <h5 class="text-base font-semibold mb-4 flex items-center justify-between">
        <span>Level 1 Members ({{ $level1_count }})</span>
        <span class="text-xs text-gray-500">Newest first</span>
    </h5>

    <div class="space-y-4 text-sm divide-y divide-gray-800/60" id="level1-users-list">
        @include('user.partials.user_list_items', ['users' => $level1_users])
    </div>

    @if($level1_users->hasMorePages())
    <div class="text-center mt-4">
        <button type="button" id="load-more-level1" data-page="2" class="px-4 py-2 bg-purple-600/20 border border-purple-500/30 rounded-lg text-sm text-purple-300 hover:bg-purple-600/30 transition">
            Load More
        </button>
    </div>
    @endif
</div>
@else
<div class="mt-6 card rounded-2xl p-5 text-center text-gray-400 text-sm py-8">
    No Level 1 members yet
</div>
@endif

                <!-- Level 2 Stats -->
                <div class="card rounded-2xl p-5 overflow-hidden relative glow">
                    <div class="absolute -top-1 -left-1 w-14 h-14 bg-gradient-to-br from-cyan-600 to-teal-700 rounded-br-2xl flex items-center justify-center text-xl font-bold text-white shadow-lg">
                        2
                    </div>
                    <h4 class="text-base font-semibold mb-4 text-center">Level 2 Stats</h4>
                    <p class="text-xs text-gray-400 text-center mb-5">Indirect / Level 2 Business</p>

                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div>
                            <p class="text-xl font-bold text-white">{{ $level2_count }}</p>
                            <p class="text-xs text-gray-400 mt-1">Team Members</p>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-emerald-400">{{ number_format($level2_business, 0) }} Rs</p>
                            <p class="text-xs text-gray-400 mt-1">Total Invested</p>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-purple-300">{{ number_format($level2_commission, 0) }} Rs</p>
                            <p class="text-xs text-gray-400 mt-1">Your Earnings</p>
                        </div>
                    </div>
                </div>

<!-- Level 2 Members List -->
@if($level2_count > 0)
<div class="mt-6 card rounded-2xl p-5">
    <h5 class="text-base font-semibold mb-4 flex items-center justify-between">
        <span>Level 2 Members ({{ $level2_count }})</span>
        <span class="text-xs text-gray-500">Newest first</span>
    </h5>

    <div class="space-y-4 text-sm divide-y divide-gray-800/60" id="level2-users-list">
        @include('user.partials.user_list_items', ['users' => $level2_users])
    </div>

    @if($level2_users->hasMorePages())
    <div class="text-center mt-4">
        <button type="button" id="load-more-level2" data-page="2" class="px-4 py-2 bg-cyan-600/20 border border-cyan-500/30 rounded-lg text-sm text-cyan-300 hover:bg-cyan-600/30 transition">
            Load More
        </button>
    </div>
    @endif
</div>
@else
<div class="mt-6 card rounded-2xl p-5 text-center text-gray-400 text-sm py-8">
    No Level 2 members yet
</div>
@endif


                <div class="card rounded-xl p-4 mb-6 text-center bg-gradient-to-br from-indigo-950/40 to-purple-950/30 border border-indigo-500/20">
                    <p class="text-sm text-gray-300 mb-1">Total Team</p>
                    <p class="text-2xl font-bold text-white">{{ $level1_count + $level2_count }} members</p>
                    <p class="text-lg font-semibold text-emerald-400 mt-2">
                        {{ number_format($total_team_business, 0) }} Rs invested
                    </p>
                </div>


            </div>

        </div>


        <!-- Bottom Navigation -->
        @include('user.includes.bottom_navigation')

    </div> <!-- end mobile container -->
<script>
    function setupLoadMore(level) {
        const button = document.getElementById(`load-more-${level}`);
        if (!button) return;
        let page = parseInt(button.dataset.page || 2);
        const list = document.getElementById(`${level}-users-list`);

        button.addEventListener('click', function() {
            fetch(`/invite/${level}/load-more?page=${page}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.html) {
                    list.insertAdjacentHTML('beforeend', data.html);
                    if (data.hasMorePages) {
                        page++;
                        button.dataset.page = page;
                    } else {
                        button.remove(); // or hide
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    setupLoadMore('level1');
    setupLoadMore('level2');
</script>
    <script>
        lucide.createIcons();
    </script>

</body>

</html>