<!-- Navbar -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<nav class="main-header navbar navbar-expand navbar-dark mynav">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="/market" class="nav-link btn btn-link"> <i class="fa fa-home"></i> Home</a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="/market/about" class="nav-link btn btn-link"> <i class="fa fa-info"></i> About</a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="/market/blogs" class="nav-link btn btn-link"> <i class="fab fa-blogger"></i> Blogs</a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="/market/products" class="nav-link btn btn-link"> <i class="fas fa-shopping-cart"></i> Products</a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="/market/contact" class="nav-link btn btn-link"> <i class="fa fa-question"></i> Contact</a>
    </li>

  </ul>
  <ul class="navbar-nav ml-auto">

    <!-- User Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <img src="{{ auth()->user()->pic ? '/profile/' . auth()->user()->pic : '/admin_assets/img/avatar.png' }}" style="height: 30px; width: 30px;" class="img-circle" alt="Avatar" />
        &nbsp;&nbsp;
        <strong class="text-light">{{ auth()->user()->name }}</strong>&nbsp;&nbsp;
        <i class="fa fa-angle-down"></i>&nbsp;&nbsp;
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="/user_profile" class="dropdown-item">
          <i class="fa fa-user mr-2"></i> My Profile
        </a>
        <div class="dropdown-divider"></div>
        <a href="/logout" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i> Sign Out
        </a>
      </div>
    </li>

  </ul>
</nav>
<!-- /.navbar -->