<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    @include('user.includes.general_style')
    <title>Awards</title>
</head>

<body class="min-h-screen text-gray-200 flex items-start justify-center">

    <div class="w-full max-w-[420px] min-h-screen relative" style="background: #0B0B12;">

        @include('user.includes.top_greetings')

        <div class="px-4 py-1 mb-4">

            <div class="flex items-center justify-between bg-gray-800 rounded-lg px-4 py-3 shadow-sm mb-2">
    
    <!-- Investment Info -->
    <div>
        <div class="text-xs text-gray-400 uppercase tracking-wide">
            Team Investment {{ now()->format('F Y') }}
        </div>
        <div id="balanceAmount" class="text-xl font-bold text-emerald-400">
            Rs {{ number_format($team_invest ?? 0) }}
        </div>
    </div>

    <!-- Level Counts -->
    <div class="flex items-center gap-4 text-sm font-semibold">
        <span class="bg-gray-700 px-3 py-1 rounded text-blue-400">
            L1: {{ $level1_count ?? 0 }}
        </span>
        <span class="bg-gray-700 px-3 py-1 rounded text-purple-400">
            L2: {{ $level2_count ?? 0 }}
        </span>
    </div>

</div>

            <div class="flex items-center justify-between mb-4">

                <h2 class="text-xl font-bold">Team Salary Rewards</h2>

                <button class="bg-gray-500 text-white px-4 py-2 rounded-lg" disabled>
                    Apply Now
                </button>
            </div>

            <div class="space-y-4 mb-14">

            <!-- 100k -->
                <div class="bg-[#151520] p-4 rounded-xl flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-400">Team Investment</p>
                        <p class="text-lg font-semibold">100,000</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-400">Bonus</p>
                        <p class="text-lg font-bold text-green-400">7,500</p>
                    </div>
                </div>


                <!-- 200k -->
                <div class="bg-[#151520] p-4 rounded-xl flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-400">Team Investment</p>
                        <p class="text-lg font-semibold">200,000</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-400">Bonus</p>
                        <p class="text-lg font-bold text-green-400">18,000</p>
                    </div>
                </div>

                <!-- 300k -->
                <div class="bg-[#151520] p-4 rounded-xl flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-400">Team Investment</p>
                        <p class="text-lg font-semibold">300,000</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-400">Bonus</p>
                        <p class="text-lg font-bold text-green-400">27,000</p>
                    </div>
                </div>

                <!-- 500k -->
                <div class="bg-[#151520] p-4 rounded-xl flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-400">Team Investment</p>
                        <p class="text-lg font-semibold">500,000</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-400">Bonus</p>
                        <p class="text-lg font-bold text-green-400">45,000</p>
                    </div>
                </div>

                <!-- 800k -->
                <div class="bg-[#151520] p-4 rounded-xl flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-400">Team Investment</p>
                        <p class="text-lg font-semibold">800,000</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-400">Bonus</p>
                        <p class="text-lg font-bold text-green-400">72,000</p>
                    </div>
                </div>

                <!-- 1M -->
                <div class="bg-[#151520] p-4 rounded-xl flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-400">Team Investment</p>
                        <p class="text-lg font-semibold">1,000,000</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-400">Bonus</p>
                        <p class="text-lg font-bold text-green-400">90,000</p>
                    </div>
                </div>

                <div class="bg-[#151520] p-4 rounded-xl flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-400">Team Investment</p>
                        <p class="text-lg font-semibold">1,500,000</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-400">Bonus</p>
                        <p class="text-lg font-bold text-green-400">135,000</p>
                    </div>
                </div>

                <div class="bg-[#151520] p-4 rounded-xl flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-400">Team Investment</p>
                        <p class="text-lg font-semibold">2,000,000</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-400">Bonus</p>
                        <p class="text-lg font-bold text-green-400">180,000</p>
                    </div>
                </div>

            </div>

        </div>

        @include('user.includes.bottom_navigation')

    </div>

</body>

</html>