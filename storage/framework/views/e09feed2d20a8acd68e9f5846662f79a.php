<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <?php echo $__env->make('includes.mob_header_links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <title>Verify OTP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="body body5 bg-[#0A0A0F] text-white">
<main class="mx-auto max-w-md p-4 min-h-screen">

    <?php echo $__env->make('includes.mob_navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
            <!-- Heading -->
            <div class="text-center mb-8">
                <h1 class="text-[28px] font-bold text-white mb-2">Enter OTP</h1>
                <p class="text-white/50 text-sm">
                    <?php echo e($message ?? 'Check your email for the 6-digit OTP code'); ?>

                </p>
            </div>

            <?php echo $__env->make('includes.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Form -->
            <form action="<?php echo e(route('password.update.otp')); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>

                <!-- OTP -->
                <div class="space-y-2">
                    <label class="text-xs font-medium text-white/60 block px-1">
                        OTP (6 digits)
                    </label>

                    <input 
                        type="text" 
                        name="otp"
                        maxlength="6"
                        inputmode="numeric"
                        pattern="\d{6}"
                        placeholder="••••••"
                        class="w-full bg-white/[0.06] border border-white/[0.08] rounded-2xl px-4 py-4 text-center text-[20px] tracking-[8px] text-white placeholder:text-white/30 focus:outline-none focus:border-primary/50 focus:bg-white/[0.08] transition-all"
                        required
                    />
                </div>

                <div class="space-y-2">
    <label class="text-xs font-medium text-white/60 block px-1">
        New Password
    </label>

    <div class="relative">
        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Enter new password"
            class="w-full bg-white/[0.06] border border-white/[0.08] rounded-2xl pl-12 pr-12 py-4 text-[15px] text-white placeholder:text-white/30 focus:outline-none focus:border-primary/50 focus:bg-white/[0.08] transition-all"
            required
        />

        <button type="button"
            onclick="togglePassword('password', this)"
            class="absolute right-4 top-1/2 -translate-y-1/2 text-white/40 hover:text-white transition">
            <i class="fas fa-eye"></i>
        </button>
    </div>
</div>

                <div class="space-y-2">
    <label class="text-xs font-medium text-white/60 block px-1">
        Confirm Password
    </label>

    <div class="relative">
        <input 
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            placeholder="Confirm password"
                        class="w-full bg-white/[0.06] border border-white/[0.08] rounded-2xl pl-12 pr-12 py-4 text-[15px] text-white placeholder:text-white/30 focus:outline-none focus:border-primary/50 focus:bg-white/[0.08] transition-all"

            required
        />

        <button type="button"
            onclick="togglePassword('password_confirmation', this)"
            class="absolute right-4 top-1/2 -translate-y-1/2 text-white/40 hover:text-white transition">
            <i class="fas fa-eye"></i>
        </button>
    </div>
</div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-gradient-primary text-white font-semibold py-4 rounded-2xl shadow-[0_8px_30px_rgba(124,58,237,0.3)] hover:shadow-[0_8px_40px_rgba(124,58,237,0.4)] transition-all">
                    Reset Password
                </button>
            </form>

            <!-- Back -->
            <div class="mt-6 text-center">
                <a href="<?php echo e(route('login')); ?>" class="text-primary hover:text-accent transition-colors text-sm">
                    Back to Login
                </a>
            </div>


    <?php echo $__env->make('includes.mob_footer_links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
function togglePassword(fieldId, button) {
    const input = document.getElementById(fieldId);
    const icon = button.querySelector("i");

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>
</main>
</body>
</html><?php /**PATH E:\xampp\htdocs\zipGo\resources\views/auth/forgot-password-verify.blade.php ENDPATH**/ ?>