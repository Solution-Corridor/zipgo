<!DOCTYPE html>
<html lang="en">
@section('title')
Dashboard
@endsection

<!-- Start top links -->
@include('admin.includes.headlinks')
<!-- end top links -->

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Start navbar -->
        @include('admin.includes.navbar')
        <!-- end navbar -->

        <!-- Start Sidebar -->
        @include('admin.includes.sidebar')
        <!-- end Sidebar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h1 class="m-0 font-weight-bold text-dark">Dashboard</h1>                            
                        </div>
                    </div>
                </div>
            </section>

           
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- ==================== SERVICE FEES ==================== -->
                    <div class="row">
                        <div class="col-12 mb-4">
                            <h5 class="font-weight-bold text-muted mb-3">Service Fees</h5>
                            <div class="row">
                                <!-- Total Service Fee Collected -->
                                <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card shadow-sm border-0 h-100 hover-lift position-relative">
                                        <span class="badge badge-danger position-absolute"
                                            style="top: 10px; right: 10px; font-size: 12px; padding: 6px 10px;">
                                            {{ $total_users ?? 0 }}
                                        </span>
                                        
                                    </div>
                                </div>

                                
                            </div>
                        </div>
                    </div>

                   
                    

                    

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
             
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        @include('admin.includes.version')
        <!-- /.footer -->

    </div>
    <!-- ./wrapper -->

    <!-- Footer links / scripts -->
    @include('admin.includes.footer_links')

    

</body>

</html>