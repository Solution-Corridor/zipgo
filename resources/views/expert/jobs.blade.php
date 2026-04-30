<!DOCTYPE html>
<html lang="en">
<head>
    @include('expert.includes.general_style')
    <title>My Jobs | Expert Dashboard</title>
</head>
<body class="min-h-screen bg-[#121826]">

<div class="mx-auto max-w-[420px] min-h-screen bg-[#121826] shadow-2xl shadow-black/50 relative">

    @include('expert.includes.top_greetings')

    <div class="px-4 pt-4 pb-20">
        <!-- Header with filter tabs -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-white">My Jobs</h1>
            <div class="flex gap-2">
                <a href="{{ route('expert.jobs') }}" class="text-xs px-3 py-1 rounded-full {{ !$statusFilter ? 'bg-[#F4A261] text-white' : 'bg-[#1A2636] text-gray-400' }}">All</a>
                <a href="{{ route('expert.jobs', ['status' => 'pending']) }}" class="text-xs px-3 py-1 rounded-full {{ $statusFilter == 'pending' ? 'bg-[#F4A261] text-white' : 'bg-[#1A2636] text-gray-400' }}">Pending</a>
                <a href="{{ route('expert.jobs', ['status' => 'confirmed']) }}" class="text-xs px-3 py-1 rounded-full {{ $statusFilter == 'confirmed' ? 'bg-[#F4A261] text-white' : 'bg-[#1A2636] text-gray-400' }}">Confirmed</a>
                <a href="{{ route('expert.jobs', ['status' => 'completed']) }}" class="text-xs px-3 py-1 rounded-full {{ $statusFilter == 'completed' ? 'bg-[#F4A261] text-white' : 'bg-[#1A2636] text-gray-400' }}">Completed</a>
            </div>
        </div>

        <!-- Jobs list -->
        <div class="space-y-3">
            @forelse($jobs as $job)
            <div class="bg-[#1A2636] rounded-xl p-3 border border-[#2A3A5A] shadow-md">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-semibold text-white">{{ $job->customer }}</p>
                        <p class="text-xs text-gray-400">{{ $job->service }} • {{ $job->date }} at {{ $job->time }}</p>
                        <p class="text-xs text-gray-500 mt-1 truncate max-w-[200px]">{{ $job->address }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-xs px-2 py-1 rounded-full 
                            @if($job->status == 'completed') bg-green-900/40 text-green-400
                            @elseif($job->status == 'confirmed') bg-[#2A5C8C]/40 text-[#8AB3D3]
                            @elseif($job->status == 'pending') bg-[#F4A261]/20 text-[#F4A261]
                            @else bg-red-900/40 text-red-400 @endif">
                            {{ ucfirst($job->status) }}
                        </span>
                        @if($job->earnings)
                            <p class="text-xs text-[#F4A261] mt-1">Rs. {{ number_format($job->earnings) }}</p>
                        @endif
                    </div>
                </div>
                <div class="mt-2 flex justify-end">
                    <a href="{{ route('expert.jobs.show', $job->id) }}" class="text-xs text-[#F4A261] hover:text-[#E08E3E]">View Details →</a>
                </div>
            </div>
            @empty
            <div class="bg-[#1A2636]/60 rounded-xl p-8 text-center border border-dashed border-[#2A3A5A]">
                <i data-lucide="briefcase" class="w-12 h-12 text-gray-600 mx-auto mb-2"></i>
                <p class="text-gray-400">No jobs found.</p>
            </div>
            @endforelse
        </div>
    </div>

    @include('expert.includes.bottom_navigation')
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
</body>
</html>