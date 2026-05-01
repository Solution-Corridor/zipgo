<style>
  .nav-sidebar .nav-link.active {
    background: linear-gradient(to right, #015694, #349242) !important;
    color: #ffffff !important;
    /* border-left: 4px solid #349242;  */
  }

  .nav-sidebar .nav-treeview .nav-link.active {
    background: silver !important;
    color: #000 !important;
    /* border-left: 4px solid #015694; */
  }
</style>
<aside class="main-sidebar sidebar-dark-green elevation-4">
  <a href="{{ route('admin.dashboard') }}" class="brand-link">
    <img src="/assets/images/favicon.png" class="logo-one" alt="Logo" height="30">
    <span class="brand-text font-weight-light"><strong>ZipGo</strong></span>
  </a>

  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        

        <li class="nav-item">
          <a href="{{ route('admin.experts') }}" class="nav-link {{ request()->segment(2) == 'experts' ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-tie"></i>
            <p>Experts
              <span class="badge badge-warning right mr-3">{{ \App\Models\ExpertDetail::where('profile_status', 0)->count() }}</span>
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('services.index') }}" class="nav-link {{ request()->segment(2) == 'services' ? 'active' : '' }}">
            <i class="nav-icon fas fa-cogs"></i>
            <p>Services</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('cities.index') }}" class="nav-link {{ request()->segment(2) == 'cities' ? 'active' : '' }}">
            <i class="nav-icon fas fa-city"></i>
            <p>Cities</p>
          </a>
        </li>

        <li class="nav-item {{ in_array(request()->segment(2), ['add_blogs','blogs_list','edit_blog']) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ in_array(request()->segment(2), ['add_blogs','blogs_list','edit_blog']) ? 'active' : '' }}">
            <i class="nav-icon fa fa-blog"></i>
            <p>
              Blogs
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right mr-3">
                {{ \App\Models\Blog::count() }}
              </span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('blogs.add') }}" class="nav-link {{ request()->segment(2) == 'add_blogs' ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Blog</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('blogs.list') }}" class="nav-link {{ request()->segment(2) == 'blogs_list' ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Blogs Listing</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="{{ route('all_complaints') }}" class="nav-link {{ request()->segment(1) == 'all-complaints' ? 'active' : '' }}">
            <i class="nav-icon fas fa-exclamation-triangle"></i>
            <p>
              Complaints
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.users') }}" class="nav-link {{ in_array(request()->segment(2), ['users', 'user-details', 'edit_user']) ? 'active' : '' }}">
            <i class="nav-icon fa fa-user"></i>
            <p>Users</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="" class="nav-link {{ request()->segment(1) == 'payment-methods' ? 'active' : '' }}">
            <i class="nav-icon fas fa-credit-card"></i>
            <p>Payment Methods</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('important_note') }}" class="nav-link {{ request()->segment(1) == 'important-note' ? 'active' : '' }}">
            <i class="nav-icon fas fa-cogs"></i>
            <p>Important Note</p>
          </a>
        </li>

        <li class="nav-item" style="height: 60px;"></li>
      </ul>
    </nav>
  </div>
</aside>