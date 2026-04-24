<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-DCZ5K9SKZ9"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-DCZ5K9SKZ9');
</script>


<?php
$username = auth()->user()?->username ?? 'Guest';
?>

<!-- Sticky Top Greeting Header - Full Top Touch -->
<div class="sticky top-0 z-50 bg-slate-950">
    
            
        <div class="flex items-center gap-4 
                    bg-gradient-to-r from-slate-950 via-slate-900 to-slate-950
                    backdrop-blur-md 
                    rounded-2xl
                    px-5 py-4 
                    shadow-xl shadow-black/50 
                    w-full max-w-md mx-auto">

            <!-- Avatar -->
            <a href="<?php echo e(route('user_profile')); ?>" class="inline-block">
                <div class="relative shrink-0">
                    <div class="w-14 h-14 rounded-full overflow-hidden ring-1 ring-indigo-400/30 shadow-md">
                        <?php if(auth()->check() && auth()->user()->pic): ?>
                            <img src="/<?php echo e(auth()->user()->pic); ?>" class="w-full h-full object-cover" alt="">
                        <?php else: ?>
                            <div class="w-full h-full bg-gradient-to-br from-slate-700 via-indigo-800 to-slate-800 flex items-center justify-center text-2xl font-bold text-indigo-200">
                                <?php echo e(strtoupper(substr($username, 0, 1))); ?>

                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Online dot -->
                    <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 rounded-full border-2 border-slate-950 z-10"></div>
                </div>
            </a>

            <!-- Username -->
            <div class="flex-1 min-w-0">
                <a href="<?php echo e(route('user_profile')); ?>" class="inline-block">
                    <h2 class="text-base font-semibold tracking-tight text-slate-100">
                        <?php echo e($username); ?>

                    </h2>
                </a>
            </div>





        <!-- Notification Bell with Dropdown -->
        <div x-data="{ open: false }" class="relative inline-flex items-center">
            <!-- Notification Button -->
            <button
                @click="open = !open"
                type="button"
                class="relative w-10 h-10 rounded-full bg-gradient-to-br from-slate-800 to-indigo-900/80 flex items-center justify-center shadow-md shadow-black/30 active:scale-95 transition-all duration-200 ring-1 ring-slate-700/50 hover:ring-indigo-500/40">
                <!-- Bell Icon -->
                <i class="fas fa-bell text-slate-200 text-lg"></i>

                <!-- Notification Badge -->
                <?php if($unreadCount = auth()->user()?->unreadNotifications()->count() ?? 0): ?>
                <span
                    class="absolute -top-1 -right-1 flex h-5 min-w-[1.25rem] items-center justify-center
                           rounded-full bg-rose-600 text-[0.625rem] font-bold text-white
                           ring-2 ring-slate-950 shadow-sm z-50">
                    <?php echo e($unreadCount > 9 ? '9+' : $unreadCount); ?>

                </span>
                <?php endif; ?>
            </button>

            <!-- Dropdown Teleport -->
            <template x-teleport="body">
                <div
                    x-show="open"
                    x-cloak
                    @keydown.escape.window="open = false"
                    x-transition
                    class="fixed inset-0 z-[9998]">
                    <!-- Backdrop -->
                    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
                        @click="open = false"></div>

                    <!-- Dropdown Panel -->
                    <div
                        x-ref="dropdown"
                        class="absolute right-4 top-20 w-[320px] max-w-[92vw]
                               bg-gradient-to-b from-slate-900 to-slate-950
                               border border-slate-800/70
                               rounded-2xl
                               shadow-2xl shadow-black/70
                               overflow-hidden
                               flex flex-col
                               max-h-[70vh]
                               z-[9999]">

                        <!-- HEADER -->
                        <div class="flex items-center justify-between px-5 py-3.5 
                                    border-b border-slate-800/70 
                                    bg-slate-950/60 backdrop-blur-sm">
                            <h3 class="text-sm font-semibold text-slate-100 tracking-wide">
                                Notifications
                            </h3>

                            <!-- Close Button -->
                            <button
                                @click="open = false"
                                class="w-8 h-8 flex items-center justify-center
                                       rounded-full hover:bg-slate-800/70
                                       transition text-slate-400 hover:text-slate-200">
                                ✕
                            </button>
                        </div>

                        <!-- NOTIFICATION LIST -->
                        <div class="overflow-y-auto divide-y divide-slate-800/60">

                            <?php $__empty_1 = true; $__currentLoopData = auth()->user()?->unreadNotifications ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <a href="<?php echo e(route('notification.read', $notification->id)); ?>"
                                class="block px-5 py-3.5 hover:bg-slate-800/40 transition group">

                                <p class="text-sm text-slate-200 leading-snug group-hover:text-white">
                                    <?php echo e($notification->data['message'] ?? 'New notification'); ?>

                                </p>

                                <p class="text-[11px] text-slate-500 mt-1">
                                    <?php echo e($notification->created_at->diffForHumans()); ?>

                                </p>
                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="px-5 py-10 text-center text-slate-500 text-sm">
                                🔔 No new notifications
                            </div>
                            <?php endif; ?>

                        </div>

                        <!-- FOOTER -->
                        <div class="px-5 py-3.5 border-t border-slate-800/70 bg-slate-950/60">
                            <a href="/notifications"
                                class="block text-center text-sm font-medium
                                      text-indigo-400 hover:text-indigo-300 transition">
                                View all notifications →
                            </a>
                        </div>

                    </div>
                </div>
            </template>
        </div>

        <!-- Plan / + Button -->
        <a href="/plan"
            class="relative w-10 h-10 rounded-full bg-gradient-to-br from-slate-800 to-indigo-900/80 flex items-center justify-center text-xl font-bold shadow-md shadow-black/30 active:scale-95 transition-all duration-200 ring-1 ring-slate-700/50 hover:ring-indigo-500/40">
            <span class="relative z-10 text-slate-200">+</span>
        </a>
    </div>

</div>
<div class="px-4 mt-2 mb-2">
    <!-- if user have not any active payment plan notify him permannetly -->
    <?php
    use App\Models\Payment;
    $hasActive = false;
    ?>

    <?php if(auth()->guard()->check()): ?>
    <?php
    $hasActive = Payment::where('user_id', auth()->id())
    ->where('status', 'approved')
    ->whereNotNull('approved_at')
    ->whereNotNull('expires_at')
    ->where('expires_at', '>', now())
    ->exists();
    ?>
    

    <?php if(!$hasActive): ?>
    <div class="flex items-center gap-3 px-4 py-3 bg-red-900/30 border border-red-700/40 rounded-lg text-red-200 text-sm mb-3">

        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>

        <p class="flex-1">
            Activate a plan.
        </p>

        <a href="/plan"
            class="ml-auto text-xs px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
            Activate
        </a>

    </div>
    <?php endif; ?>
    
    <!-- important notification by admin  -->
    <?php
    $importantNote = \App\Models\ImportantNote::first();
    ?>

    <!-- important note area  -->
    <?php if($importantNote?->message): ?>
    <div class="flex items-center gap-3 px-4 py-3 bg-amber-900/30 border border-amber-700/40 rounded-lg text-amber-200 text-sm mb-3">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p>
            <?php echo nl2br(e($importantNote->message)); ?>

        </p>
    </div>
    <?php endif; ?>

    <?php endif; ?>
    <!-- Header -->
</div>


<?php if(auth()->guard()->check()): ?>
<?php
$hasWhatsapp = auth()->user()->whatsapp ?? null; // ← Change if your column name is different
?>

<?php if(!$hasWhatsapp): ?>
<!-- WhatsApp Required Modal -->
<div id="whatsapp-modal"
    class="fixed inset-0 z-[99999] flex items-center justify-center bg-black/90 backdrop-blur-sm"
    style="display: none;">

    <div class="bg-slate-900 border border-slate-700 rounded-3xl w-full max-w-md mx-4 overflow-hidden shadow-2xl">

        <!-- Header -->
        <div class="px-6 py-5 border-b border-slate-700 bg-slate-950">
            <h3 class="text-xl font-semibold text-white flex items-center gap-3">
                <i class="fab fa-whatsapp text-green-500 text-2xl"></i>
                WhatsApp Number Required
            </h3>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-5">
            <p class="text-slate-300 text-sm leading-relaxed">
                Please add your WhatsApp number to continue.<br>
                This is mandatory for notifications and support.
            </p>

            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1.5">
                    WhatsApp Number <span class="text-green-500">(with country code)</span>
                </label>
                <div class="relative">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-green-500 text-xl">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <input
                        id="whatsapp-input"
                        type="tel"
                        placeholder="+923001234567"
                        class="w-full bg-slate-800 border border-slate-600 focus:border-green-500 rounded-2xl py-4 pl-12 pr-5 text-white placeholder-slate-500 outline-none transition-all text-base">
                </div>
                <p id="whatsapp-error" class="text-red-400 text-sm mt-2 min-h-[1.25rem]"></p>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-5 border-t border-slate-700 bg-slate-950 flex gap-3">
            <button
                onclick="saveWhatsappNumber()"
                id="save-btn"
                class="flex-1 bg-green-600 hover:bg-green-700 transition py-4 rounded-2xl font-semibold text-white flex items-center justify-center gap-2 disabled:opacity-70">
                <i class="fab fa-whatsapp"></i>
                <span id="btn-text">Save WhatsApp Number</span>
            </button>
        </div>
    </div>
</div>
<!-- <script>
document.addEventListener('alpine:init', () => {
    Alpine.data('notifyDropdown', () => ({
        open: false,
        init() {
            this.$watch('open', value => {
                if(value) this.reposition()
            })
        },
        reposition() {
            const btn = this.$el.querySelector('button');
            const dropdown = this.$refs.dropdown;
            if(!btn || !dropdown) return;
            const rect = btn.getBoundingClientRect();
            dropdown.style.top = `${rect.bottom + window.scrollY}px`;
            dropdown.style.left = `${rect.right - dropdown.offsetWidth + window.scrollX}px`;
        }
    }))
    
})
</script> -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('whatsapp-modal').style.display = 'flex';
});

async function saveWhatsappNumber() {
    const input     = document.getElementById('whatsapp-input');
    const errorEl   = document.getElementById('whatsapp-error');
    const btn       = document.getElementById('save-btn');
    const btnText   = document.getElementById('btn-text');

    const number = input.value.trim();

    errorEl.textContent = '';
    btn.disabled = true;
    btnText.textContent = 'Saving...';

    if (!number || !number.startsWith('+')) {
        errorEl.textContent = 'Please enter a valid number starting with +. Example: +923001234567';
        resetButton();
        return;
    }

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (!csrfToken) {
            errorEl.textContent = 'CSRF token missing. Please refresh the page.';
            resetButton();
            return;
        }

        const response = await fetch('/update-whatsapp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'          // ← Important addition
            },
            body: JSON.stringify({ whatsapp: number })
        });

        // Read the body safely even if it's not JSON
        let data = {};
        const contentType = response.headers.get('content-type') || '';

        if (contentType.includes('application/json')) {
            try {
                data = await response.json();
            } catch (e) {
                data = { message: 'Invalid JSON from server' };
            }
        } else {
            // Server returned HTML (common with 419 or exceptions)
            const text = await response.text();
            console.error('Server returned HTML instead of JSON:', text.substring(0, 300));
            data.message = 'Server error (possibly 419 Page Expired). Please refresh the page and try again.';
        }

        if (response.ok && data.success) {
            window.location.reload();
        } else {
            if (response.status === 419) {
                errorEl.textContent = 'Session expired (419). Please refresh the page and try again.';
            } else if (response.status === 422) {
                errorEl.textContent = data.message || 'Validation error. Check your WhatsApp number.';
            } else {
                errorEl.textContent = data.message || `Error ${response.status}: ${response.statusText || 'Unknown error'}`;
            }
        }
    } catch (err) {
        console.error('Fetch error details:', err);
        errorEl.textContent = 'Could not connect to the server. Please refresh the page and try again.';
    } finally {
        resetButton();
    }
}

function resetButton() {
    const btn = document.getElementById('save-btn');
    const btnText = document.getElementById('btn-text');
    btn.disabled = false;
    btnText.textContent = 'Save WhatsApp Number';
}
</script>
    <?php endif; ?>
<?php endif; ?><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/user/includes/top_greetings.blade.php ENDPATH**/ ?>