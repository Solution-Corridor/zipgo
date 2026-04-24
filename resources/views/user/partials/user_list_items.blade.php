@foreach($users as $u)
<div class="pt-3 first:pt-0 flex justify-between items-start gap-3">
    <div class="flex-1 min-w-0">
        <p class="font-medium truncate">
            {{ $u->name ?? $u->username }}
        </p>
        <p class="text-xs text-gray-500 mt-0.5">
            {{ $u->created_at->diffForHumans() }}
        </p>
    </div>
    <div class="text-right shrink-0">
        <span class="flex flex-col items-start text-emerald-400 font-medium leading-tight">
            <span class="text-base">
                {{ number_format($u->total_invested, 0) }} Rs
            </span>
            <span class="text-xs text-gray-500">
                Invested
            </span>
        </span>
    </div>
</div>
@endforeach