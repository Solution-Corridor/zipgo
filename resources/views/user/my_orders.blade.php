<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    @include('user.includes.general_style')
    <title>My Orders</title>
</head>

<body class="min-h-screen text-gray-200 flex items-start justify-center bg-[#0B0B12]">

    <div class="w-full max-w-[420px] min-h-screen relative bg-[#0B0B12]">

        @include('user.includes.top_greetings')

        <div class="px-4 py-4">

            <!-- Page Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-white">My Orders</h1>
                <div class="text-sm text-gray-400">
                    {{ $orders->total() }} orders
                </div>
            </div>

            @if($orders->isEmpty())
                <!-- Empty State -->
                <div class="bg-[#151520] rounded-2xl p-8 text-center mt-10">
                    <div class="mx-auto w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mb-4">
                        📦
                    </div>
                    <p class="text-xl font-semibold text-gray-300">No orders yet</p>
                    <p class="text-gray-500 mt-2">When you place an order, it will appear here.</p>
                </div>
            @else
                <!-- Orders List -->
                <div class="space-y-4 pb-24">
                    @foreach($orders as $order)
                        <div class="bg-[#151520] rounded-2xl overflow-hidden border border-gray-800">
                            
                            <!-- Order Header -->
                            <div class="px-4 pt-4 pb-3 border-b border-gray-800 flex justify-between items-start">
                                <div>
                                    <p class="text-xs text-gray-400">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                                    <p class="text-sm font-medium text-white mt-1">
                                        {{ $order->product_name }}
                                    </p>
                                </div>
                                
                                <div class="text-right">
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full 
                                        @php
                                            $statusClass = match($order->status) {
                                                'Pending', 'Pending Payment' => 'bg-yellow-500 text-yellow-900',
                                                'Processing' => 'bg-blue-500 text-white',
                                                'On Hold' => 'bg-orange-500 text-white',
                                                'Shipped', 'Fulfilled' => 'bg-purple-500 text-white',
                                                'Partially Shipped' => 'bg-indigo-500 text-white',
                                                'Delivered', 'Completed' => 'bg-emerald-500 text-white',
                                                'Canceled' => 'bg-red-500 text-white',
                                                'Refunded' => 'bg-teal-500 text-white',
                                                default => 'bg-gray-600 text-gray-200'
                                            };
                                        @endphp
                                        {{ $statusClass }}
                                    ">
                                        {{ $order->status }}
                                    </span>
                                </div>
                            </div>

                            <!-- Product Image + Details -->
                            <div class="p-4 flex gap-4">
                                @if($order->product_image)
                                    <img src="/uploads/market/products/{{ $order->product_image }}" 
                                         alt="{{ $order->product_name }}"
                                         class="w-20 h-20 object-cover rounded-xl flex-shrink-0">
                                @else
                                    <div class="w-20 h-20 bg-gray-800 rounded-xl flex items-center justify-center text-3xl flex-shrink-0">
                                        📦
                                    </div>
                                @endif

                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between">
                                        <div>
                                            <p class="text-sm text-gray-400">Quantity</p>
                                            <p class="font-semibold text-lg">{{ $order->quantity }}x</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-gray-400">Total</p>
                                            <p class="font-bold text-emerald-400 text-lg">
                                                Rs {{ number_format($order->total_price) }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-3 pt-3 border-t border-gray-800">
                                        <p class="text-xs text-gray-400">Ordered on</p>
                                        <p class="text-sm text-gray-300">
                                            {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y • h:i A') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Info -->
                            <div class="bg-[#0F0F18] px-4 py-3 text-xs border-t border-gray-800">
                                <div class="flex justify-between text-gray-400">
                                    <span>Customer:</span>
                                    <span class="text-gray-300">{{ $order->name }}</span>
                                </div>
                                <div class="flex justify-between text-gray-400 mt-1">
                                    <span>Phone:</span>
                                    <span class="text-gray-300">{{ $order->phone }}</span>
                                </div>
                                <div class="mt-2 text-gray-400 text-[10px] leading-tight">
                                    {{ Str::limit($order->address, 80) }}
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-6">
                    {{ $orders->links('pagination::tailwind') }}
                </div>
            @endif

        </div>

        @include('user.includes.bottom_navigation')

    </div>

</body>
</html>