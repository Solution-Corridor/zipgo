<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-green elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
        <img src="/assets/images/favicon.png" class="logo-one" alt="Logo" height="30">
        <span class="brand-text font-weight-light"><strong>ZipGo</strong></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/user-dashboard" class="nav-link {{ request()->segment(1) == 'user-dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>User Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/expert-dashboard" class="nav-link {{ request()->segment(1) == 'expert-dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Expert Dashboard</p>
                    </a>
                </li>

                
                <li class="nav-item">
                    <a href="{{ route('services.index') }}" class="nav-link {{ request()->segment(1) == 'services' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Services</p>
                    </a>
                </li>
               
                <li class="nav-item">
                    <a href="{{ route('cities.index') }}" class="nav-link {{ request()->segment(1) == 'cities' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-city"></i>
                        <p>Cities</p>
                    </a>
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
                    <a href="/users" class="nav-link {{ in_array(request()->segment(1), ['users', 'user-details', 'edit_user']) ? 'active' : '' }}">
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
               
                <!-- Blogs Menu (Fixed Structure) -->
                <li class="nav-item {{ in_array(request()->segment(2), ['add_blogs','blogs_list','edit_blog','upload_images']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ in_array(request()->segment(1), ['add_blog','blogs_list','edit_blog','upload_images']) ? 'active' : '' }}">
                        <i class="nav-icon fa fa-blog"></i>
                        <p>
                            Blogs
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right mr-3">0</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="" class="nav-link {{ request()->segment(2) == 'add_blogs' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Blog</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link {{ in_array(request()->segment(2), ['blogs_list','edit_blog']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Blogs Listing</p>
                            </a>
                        </li>
                    </ul>

                    

                <li class="nav-item">
                    <a href="" class="nav-link {{ in_array(request()->segment(2), ['add_category','edit_category']) ? 'active' : '' }}">
                        <i class="nav-icon fa fa-layer-group"></i>
                        <p>Categories
                            <span class="badge badge-info right"></span>
                        </p>
                    </a>
                </li>

                
                
                <li class="nav-item" style="height: 60px;"></li>

            </ul>
            </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>