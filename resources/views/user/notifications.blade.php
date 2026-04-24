<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    @include('user.includes.general_style')
    <title>Notifications</title>
</head>

<body class="min-h-screen bg-[#0A0A0F] text-white font-sans">

    <!-- Mobile-like container -->
    <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative overflow-hidden">

        <!-- Top bar: Greeting + Notification bell + Add button -->
        @include('user.includes.top_greetings')

        <div class="p-4 space-y-4">

            <h2 class="text-xl font-semibold mb-4">Notifications</h2>

            <form method="POST" action="{{ route('readAll') }}">
                @csrf
                <button type="submit" class="text-xs text-blue-400 mb-3 hover:text-blue-300 transition-colors">
                    Mark all as read
                </button>
            </form>

            @forelse($notifications as $notification)

                @php
                    $data = json_decode($notification->data, true);
                @endphp

                <a href="{{ route('notification.read', $notification->id) }}" class="block w-full">
                    <div class="p-4 rounded-xl border {{ $notification->read_at ? 'bg-[#111118] border-gray-800' : 'bg-[#141422] border-blue-500' }}">

                        <div class="flex justify-between items-start gap-3">

                            <div class="flex-1">
                                <p class="text-sm leading-relaxed">
                                    {{ $data['message'] ?? 'Notification' }}
                                </p>

                                @if(isset($data['amount']))
                                    <p class="text-xs text-green-400 mt-1 font-medium">
                                        Amount: Rs {{ number_format((float) $data['amount'], 2) }}
                                    </p>
                                @endif

                                <p class="text-xs text-gray-400 mt-2">
                                    {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                </p>
                            </div>

                            @if(!$notification->read_at)
                                <span class="text-[10px] px-2 py-1 bg-blue-600 rounded-full font-medium">
                                    New
                                </span>
                            @endif

                        </div>

                    </div>
                </a>

            @empty

                <div class="text-center text-gray-400 mt-10 py-8">
                    No notifications found.
                </div>

            @endforelse

            <div class="mt-6">
                {{ $notifications->links() }}
            </div>

        </div>

        <!-- Bottom Navigation -->
        @include('user.includes.bottom_navigation')

    </div> <!-- end mobile container -->
     <script>
    lucide.createIcons();
    </script>

</body>

</html>