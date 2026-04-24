      <a href="<?php echo e(route('password.change')); ?>"
        class="flex items-center justify-between w-full mt-3 px-4 py-3.5 
          bg-gray-900/60 border border-gray-700/60 rounded-xl 
          text-sm text-gray-200 hover:text-white 
          hover:border-purple-500/70 transition">
        <div class="flex items-center gap-3">
          <i data-lucide="lock" class="w-4 h-4"></i>
          <span>Change Password</span>
        </div>
        <i data-lucide="chevron-right" class="w-4 h-4 opacity-70"></i>
      </a>

     

      <!-- Delete Account Button -->
<button type="button"
    onclick="openDeleteModal()"
    class="flex items-center justify-between w-full mt-3 px-4 py-3.5 
    bg-gradient-to-r from-amber-500 to-yellow-500
    border border-amber-600 
    rounded-xl 
    text-sm font-medium text-black
    hover:from-amber-400 hover:to-yellow-400
    hover:border-amber-500
    transition">

    <div class="flex items-center gap-3">
        <i data-lucide="alert-triangle" class="w-4 h-4"></i>
        <span>Delete Account</span>
    </div>

    <i data-lucide="chevron-right" class="w-4 h-4 opacity-70"></i>
</button>


      <!-- Logout -->
      <div class="mt-3">
        <a href="<?php echo e(route('logout')); ?>"
          class="flex items-center justify-between px-4 py-3.5 bg-gradient-to-r from-red-950/50 to-red-900/40 border border-red-800/50 rounded-xl text-red-200 text-sm hover:text-red-100 hover:border-red-700/60 transition">
          <div class="flex items-center gap-3">
            <i data-lucide="log-out" class="w-4 h-4"></i>
            <span>Logout</span>
          </div>
          <i data-lucide="chevron-right" class="w-4 h-4 opacity-70"></i>
        </a>
      </div>




      <!-- Delete Account Modal -->
      <div id="deleteModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50">

        <div class="bg-gray-900 border border-gray-700 rounded-2xl w-full max-w-md p-6">

          <h2 class="text-lg font-semibold text-white mb-2">
            Confirm Account Deletion
          </h2>

          <p class="text-sm text-gray-400 mb-4">
            This action is permanent and cannot be undone.
            Please enter your password to continue.
          </p>

          <form method="POST" action="<?php echo e(route('account.delete')); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>

            <div class="relative mt-2">

              <input type="password"
                name="password"
                id="deletePassword"
                required
                placeholder="Enter your password"
                class="w-full px-4 py-2 pr-12 bg-gray-800 border border-gray-700 rounded-lg text-sm text-gray-200 focus:border-red-500 focus:outline-none">

              <!-- Eye Toggle Button -->
              <button type="button"
                onclick="toggleDeletePassword()"
                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-200">
                <i id="deletePasswordIcon" data-lucide="eye" class="w-4 h-4"></i>
              </button>

            </div>

            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-400 text-xs mt-2"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <div class="flex justify-end gap-3 mt-6">

              <button type="button"
                onclick="closeDeleteModal()"
                class="px-4 py-2 text-sm bg-gray-800 border border-gray-700 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                Cancel
              </button>

              <button type="submit"
                class="px-4 py-2 text-sm bg-red-600 rounded-lg text-white hover:bg-red-700 transition">
                Delete Permanently
              </button>

            </div>
          </form>
        </div>
      </div>


      <script>
    function openDeleteModal() {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }

    // Auto-open modal if validation fails
    <?php if($errors->has('password')): ?>
        openDeleteModal();
    <?php endif; ?>

    function toggleDeletePassword() {
        const input = document.getElementById('deletePassword');
        const icon = document.getElementById('deletePasswordIcon');

        if (input.type === "password") {
            input.type = "text";
            icon.setAttribute("data-lucide", "eye-off");
        } else {
            input.type = "password";
            icon.setAttribute("data-lucide", "eye");
        }

        lucide.createIcons();
    }
</script><?php /**PATH E:\xampp\htdocs\zipGo\resources\views/user/includes/profile_bottom_nav.blade.php ENDPATH**/ ?>