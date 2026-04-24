<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <?php echo $__env->make('user.includes.general_style', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <title>Profile</title>
</head>

<body class="min-h-screen bg-[#0A0A0F]">

    <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

        <?php echo $__env->make('user.includes.top_greetings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="px-4 pt-4 pb-24"> <!-- reduced padding -->
            <!-- Profile Card -->
            <!-- Wrap only the editable profile card in a form -->
            <form method="POST" action="<?php echo e(route('user_profile.update')); ?>" enctype="multipart/form-data" class="mb-5">
                <?php echo csrf_field(); ?>

<!-- Profile Card -->
<div class="card rounded-xl overflow-hidden glow bg-gray-900/70 border border-gray-700/50">
    <div class="p-6">
        <?php echo $__env->make('includes.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Avatar + User Info Section -->
        <div class="flex items-start gap-5 mb-8">

            <!-- Avatar -->
            <div class="relative group flex-shrink-0">
                <input type="file" name="pic" id="avatar" accept="image/*" class="hidden">

                <?php if(auth()->user()->pic): ?>
                    <img id="avatar-preview"
                         src="/<?php echo e(auth()->user()->pic); ?>"
                         class="w-28 h-28 rounded-2xl object-cover shadow-xl ring-2 ring-purple-500/30"
                         alt="Profile photo">
                    <div id="avatar-initials" class="hidden w-28 h-28 rounded-2xl bg-gradient-to-br from-purple-700 to-indigo-800 flex items-center justify-center text-4xl font-bold shadow-xl">
                        <?php echo e(strtoupper(substr(auth()->user()->username ?? 'U', 0, 1))); ?>

                    </div>
                <?php else: ?>
                    <div id="avatar-initials" class="w-28 h-28 rounded-2xl bg-gradient-to-br from-purple-700 to-indigo-800 flex items-center justify-center text-4xl font-bold shadow-xl">
                        <?php echo e(strtoupper(substr(auth()->user()->username ?? 'U', 0, 1))); ?>

                    </div>
                    <img id="avatar-preview" src="" class="hidden w-28 h-28 rounded-2xl object-cover shadow-xl" alt="Profile preview">
                <?php endif; ?>

                <!-- Camera Overlay -->
                <label for="avatar" class="absolute inset-0 cursor-pointer rounded-2xl opacity-0 group-hover:opacity-100 bg-black/60 flex items-center justify-center transition-all duration-300">
                    <i data-lucide="camera" class="w-10 h-10 text-white"></i>
                </label>
            </div>

            <!-- User Details -->
            <div class="flex-1 min-w-0 pt-1">
                <h2 class="text-2xl font-bold text-white tracking-tight">
                    <?php echo e(auth()->user()->username ?? 'User'); ?>

                </h2>

                <!-- Reference -->
                <?php if(auth()->user()?->referrer?->id): ?>
                <p class="text-xs text-slate-400 mt-1 flex items-center gap-1">
                    <span class="text-purple-400">Ref By:</span> 
                    FI26<?php echo e(auth()->user()->referrer->id); ?>

                </p>
                <?php endif; ?>

                <!-- KYC Status -->
                <a href="<?php echo e(route('kyc.index')); ?>" class="inline-block mt-3">
                    <div class="text-xs px-4 py-1.5 rounded-2xl font-semibold text-white w-max
                        <?php echo e(auth()->user()->kyc_status === 'approved' ? 'bg-emerald-600' : 
                           (auth()->user()->kyc_status === 'submitted' ? 'bg-blue-600' : 'bg-red-600')); ?> 
                        hover:scale-105 transition-all duration-200">
                        KYC • 
                        <?php echo e(auth()->user()->kyc_status === 'submitted' 
                                ? 'Under Process' 
                                : ucfirst(str_replace('_', ' ', auth()->user()->kyc_status ?? 'Not Submitted'))); ?>

                    </div>
                </a>

                <!-- Member Since -->
                <p class="text-xs text-gray-400 mt-4">
                    Since <?php echo e(auth()->user()->created_at->format('d M Y')); ?>

                </p>

                <!-- Tap to change hint -->
                <p class="text-[10px] text-cyan-400 mt-1 flex items-center gap-1">
                    <i data-lucide="info" class="w-3 h-3"></i>
                    Tap to change photo
                </p>
            </div>
        </div>

                        <!-- Form Fields -->
                        <div class="space-y-5">
                            <!-- Username (readonly) -->
                            <div class="space-y-1.5">
                                <label class="block text-[10px] text-gray-400 mb-1 uppercase tracking-wide">USERNAME</label>
                                <div class="relative">
                                    <input
                                        type="text"
                                        name="username"
                                        id="username"
                                        value="<?php echo e(old('username', auth()->user()->username ?? '')); ?>"
                                        placeholder="Your username"
                                        pattern="[A-Za-z0-9_.-]+"
                                        title="Username can only contain letters, numbers, underscores, dots and hyphens (no spaces)"
                                        class="w-full bg-gray-900/60 border border-gray-700/60 rounded-lg px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-purple-500/70 transition pr-10" />

                                    <!-- Inline feedback (check / cross / spinner) -->
                                    <div id="username-feedback"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-sm pointer-events-none">
                                    </div>
                                </div>

                                <!-- Error message below -->
                                <div id="username-error" class="text-red-400 text-xs mt-1 px-1">
    <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <?php echo e($message); ?>

    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
                            </div>

                            <!-- Phone -->
<div>
    <label class="block text-[10px] text-gray-400 mb-1 uppercase tracking-wide">PHONE</label>
    <input type="tel" name="phone" value="<?php echo e(old('phone', auth()->user()->phone ?? '')); ?>"
        placeholder="03001234567"
        class="w-full bg-gray-900/60 border border-gray-700/60 rounded-lg px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-purple-500/70 transition">
    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <p class="text-red-400 text-xs mt-1"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<!-- WhatsApp -->
<div>
    <label class="block text-[10px] text-gray-400 mb-1 uppercase tracking-wide">WHATSAPP</label>
    <input type="tel" name="whatsapp" value="<?php echo e(old('whatsapp', auth()->user()->whatsapp ?? '')); ?>"
        placeholder="03001234567"
        class="w-full bg-gray-900/60 border border-gray-700/60 rounded-lg px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-purple-500/70 transition">
    <?php $__errorArgs = ['whatsapp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <p class="text-red-400 text-xs mt-1"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

                            <!-- Email -->
                            <div>
                                <label class="block text-[10px] text-gray-400 mb-1 uppercase tracking-wide">EMAIL</label>
                                <input type="email" name="email" value="<?php echo e(old('email', auth()->user()->email ?? '')); ?>"
                                    placeholder="Enter your email address"
                                    class="w-full bg-gray-900/60 border border-gray-700/60 rounded-lg px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-purple-500/70 transition">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-400 text-xs mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <!-- Address -->

                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full mt-7 py-3.5 rounded-xl font-semibold text-white gradient-primary shadow-lg active:scale-[0.98] transition">
                            Save Changes
                        </button>

                    </div>
                </div>
            </form>

            <?php echo $__env->make('user.includes.profile_bottom_nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        </div>

        <?php echo $__env->make('user.includes.bottom_navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    </div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const usernameInput = document.getElementById('username');
    const feedback     = document.getElementById('username-feedback');
    const errorDiv     = document.getElementById('username-error');

    if (!usernameInput) return;

    // Clean input (no spaces)
    usernameInput.addEventListener('input', function() {
        this.value = this.value.replace(/\s+/g, '');
        clearFeedback();
    });

    // Check availability when user leaves the field
    usernameInput.addEventListener('blur', async function() {
        const username = this.value.trim();
        const original  = "<?php echo e(auth()->user()->username ?? ''); ?>";

        // Skip if empty or unchanged
        if (!username || username === original) {
            clearFeedback();
            return;
        }

        if (username.length < 3) {
            showError('Username must be at least 3 characters');
            return;
        }

        // Show loading
        feedback.innerHTML = '<i class="fas fa-circle-notch fa-spin text-yellow-400"></i>';
        errorDiv.textContent = '';

        try {
            const response = await fetch('<?php echo e(route("user.username.check")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({ username: username })
            });

            const data = await response.json();

            if (data.available) {
                feedback.innerHTML = '<i class="fas fa-check-circle text-green-400"></i>';
                errorDiv.textContent = '';
                usernameInput.classList.remove('border-red-500');
                usernameInput.classList.add('border-green-500/50');
            } else {
                feedback.innerHTML = '<i class="fas fa-times-circle text-red-400"></i>';
                errorDiv.textContent = data.message || 'This username is already taken';
                usernameInput.classList.remove('border-green-500/50');
                usernameInput.classList.add('border-red-500');
            }
        } catch (err) {
            feedback.innerHTML = '<i class="fas fa-exclamation-triangle text-orange-400"></i>';
            errorDiv.textContent = 'Could not check availability';
        }
    });

    function clearFeedback() {
        feedback.innerHTML = '';
        errorDiv.textContent = '';
        usernameInput.classList.remove('border-red-500', 'border-green-500/50');
    }

    function showError(msg) {
        feedback.innerHTML = '<i class="fas fa-times-circle text-red-400"></i>';
        errorDiv.textContent = msg;
        usernameInput.classList.add('border-red-500');
    }
});
</script>

<script>
    lucide.createIcons();

    const avatarInput = document.getElementById('avatar');
    const preview = document.getElementById('avatar-preview');
    const initials = document.getElementById('avatar-initials');

    avatarInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                preview.src = ev.target.result;
                preview.classList.remove('hidden');
                initials.classList.add('hidden');
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
  <script>
    lucide.createIcons();
  </script>

</body>

</html><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/user/profile.blade.php ENDPATH**/ ?>