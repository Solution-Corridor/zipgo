<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-green elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('market.dashboard') }}" class="brand-link">
    <img src="/assets/images/admin.png" class="logo-one" alt="Logo" height="30">
    <span class="brand-text font-weight-light"> <strong>Solution Market</strong></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
          <a href="{{ route('market.dashboard') }}" class="nav-link {{request()->segment(1)=='dashboard' ? 'active' : ''}}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>


        <li class="nav-item">
          <a href="{{ route('market.add_blogs') }}" class="nav-link {{request()->segment(1)=='add_blogs' ||request()->segment(1)=='edit_blogs' ? 'active' : ''}}">
            <i class="nav-icon fab fa-blogger"></i>
            <p>Blogs</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('market.add_products') }}" class="nav-link {{request()->segment(1)=='add_product' ||request()->segment(1)=='edit_product' ? 'active' : ''}}">
            <i class="nav-icon fas fa-shopping-cart"></i>
            <p>Products</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('market.add_category') }}" class="nav-link {{request()->segment(1)=='add_category' ||request()->segment(1)=='edit_category' ? 'active' : ''}}">
            <i class="nav-icon fa fa-layer-group"></i>
            <p>Categories</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('market.add_sub_category') }}" class="nav-link {{request()->segment(1)=='add_sub_category' ||request()->segment(1)=='edit_sub_category' ? 'active' : ''}}">
            <i class="nav-icon fa fa-stream"></i>
            <p>Sub Categories</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('market.add_quality') }}" class="nav-link {{request()->segment(1)=='add_quality' ||request()->segment(1)=='edit_quality' ? 'active' : ''}}">
            <i class="nav-icon fa fa-star"></i>
            <p>Varities</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('market.orders') }}" class="nav-link {{request()->segment(2)=='orders' ? 'active' : ''}}">
            <i class="nav-icon fa fa-envelope"></i>
            <p>Orders</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('market.contact_us') }}" class="nav-link {{request()->segment(2)=='contact-us' ? 'active' : ''}}">
            <i class="nav-icon fa fa-envelope"></i>
            <p>Contact Us</p>
          </a>
        </li>



</aside>