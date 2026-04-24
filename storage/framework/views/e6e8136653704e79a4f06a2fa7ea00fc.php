<!-- Footer -->
        <footer class="mt-10 text-center text-white text-sm">
            © 2026 All Rights Reserved.
        </footer>
        <script src="/assets_new/global/js/jquery.min.js"></script>
        <script src="/assets_new/global/js/bootstrap.min.js"></script>
        <script src="/assets_new/global/js/notiflix-aio-2.7.0.min.js"></script>
        <script src="/assets_new/global/js/pusher.min.js"></script>
        <script src="/assets_new/global/js/vue.min.js"></script>
        <script src="/assets_new/global/js/axios.min.js"></script>
        <script src="/assets_new/themes/assets/frontend/js/cookie.js"></script>
        <script src="/assets_new/themes/assets/global/js/custom.js"></script>



        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const menuBtn = document.getElementById('menu-btn');
                const closeMenuBtn = document.getElementById('close-menu-btn');
                const mobileMenu = document.getElementById('mobile-menu');
                const mobileMenuContent = document.getElementById('mobile-menu-content');

                function openMenu() {
                    mobileMenu.classList.remove('hidden');
                    setTimeout(() => {
                        mobileMenuContent.classList.remove('translate-x-full');
                    }, 50);
                }

                function closeMenu() {
                    mobileMenuContent.classList.add('translate-x-full');
                    setTimeout(() => {
                        mobileMenu.classList.add('hidden');
                    }, 300);
                }

                menuBtn.addEventListener('click', openMenu);
                closeMenuBtn.addEventListener('click', closeMenu);
                mobileMenu.addEventListener('click', function(event) {
                    if (event.target === mobileMenu) {
                        closeMenu();
                    }
                });
            });
        </script><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/includes/footer_links.blade.php ENDPATH**/ ?>