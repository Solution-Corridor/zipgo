{{-- resources/views/user/includes/mobile_navbar.blade.php --}}
<style>
  /* Fixed Navbar – dark gradient */
  .zipgo-navbar {
    background: linear-gradient(135deg, #1f2937, #111827);
    height: 60px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 16px;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
  }
  .navbar-logo img {
    height: 32px;
    width: auto;
    display: block;
  }
  .hamburger {
    display: flex;
    flex-direction: column;
    gap: 5px;
    cursor: pointer;
  }
  .hamburger span {
    width: 24px;
    height: 3px;
    background: white;
    border-radius: 2px;
    transition: 0.3s;
  }
  /* Mobile slide-down menu */
  .mobile-menu {
    position: fixed;
    top: 60px;
    left: 0;
    right: 0;
    background: linear-gradient(135deg, #1f2937 0%, #1a2433 25%, #141c2b 50%, #0f172a 75%, #020617 100%);
    padding: 20px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    transform: translateY(-100%);
    transition: transform 0.35s ease;
    z-index: 999;
  }
  .mobile-menu.active {
    transform: translateY(0);
  }
  .mobile-menu a {
    display: block;
    padding: 14px 0;
    color: white;
    font-size: 16px;
    text-decoration: none;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    transition: opacity 0.2s;
  }
  .mobile-menu a i {
    width: 24px;
    margin-right: 10px;
    text-align: center;
  }
  .mobile-menu a:hover {
    opacity: 0.8;
  }
  /* Ensure body has top padding if navbar is fixed – but this depends on parent layout.
     We'll not force a global style here; instead document that the parent container
     should have padding-top: 60px. For safety, we add a small note. */
</style>

<nav class="zipgo-navbar">
  <div class="navbar-logo">
    <img src="/assets/images/logo.png" alt="ZipGo Logo" title="ZipGo Logo">
  </div>
  <div class="hamburger" id="hamburgerBtn">
    <span></span><span></span><span></span>
  </div>
</nav>

<div class="mobile-menu" id="mobileMenu">
  @guest
  <a href="/login"><i class="fas fa-sign-in-alt"></i> Login</a>
  <a href="/register"><i class="fas fa-user-plus"></i> Register</a>
  @endguest

  @auth
  @if(auth()->user()->type == 0)
  <a href="{{ route('admin.dashboard') }}" style="color: #fc0;"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
  @elseif(auth()->user()->type == 2)
  <a href="{{ route('expert.dashboard') }}" style="color: #fc0;"><i class="fas fa-user-circle"></i> Dashboard</a>
  @else
  <a href="{{ route('user.dashboard') }}" style="color: #fc0;"><i class="fas fa-user-circle"></i> Dashboard</a>
  @endif
  @endauth

  <a href="/areas"><i class="fas fa-map-marker-alt"></i> Areas</a>
  <a href="/services"><i class="fas fa-th-large"></i> Services</a>
  <a href="/blogs"><i class="fas fa-blog"></i> Blogs</a>

  @auth
  <a href="/logout" style="color: #f00;"><i class="fas fa-sign-out-alt"></i> Logout</a>
  @endauth

</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.getElementById('hamburgerBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    if (hamburger && mobileMenu) {
      hamburger.addEventListener('click', (e) => {
        e.stopPropagation();
        mobileMenu.classList.toggle('active');
      });
      document.addEventListener('click', (event) => {
        if (!hamburger.contains(event.target) && !mobileMenu.contains(event.target)) {
          mobileMenu.classList.remove('active');
        }
      });
    }
  });
</script>