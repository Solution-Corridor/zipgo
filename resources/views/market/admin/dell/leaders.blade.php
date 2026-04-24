<!DOCTYPE html>
<html lang="en">
@section('title')
Leaders
@endsection
<!-- Start top links -->
@include('admin.includes.headlinks')
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
   <div class="content-header">
    <div class="container-fluid">
     <div class="row mb-2">
      <div class="col-sm-6">
       <h1 class="m-0"> Leaders</h1>
   </div><!-- /.col -->
   <div class="col-sm-6"></div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<section class="content">
 <div class="container-fluid">
  <div class="row">
   <!-- left column -->
   <div class="col-md-12">

    <div class="card card-primary card-outline card-outline-tabs">
     <div class="card-header p-0 border-bottom-0">
      <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
       <li class="nav-item">
        <a class="nav-link active" id="verified-tab" data-toggle="pill" href="#verified" role="tab" aria-controls="verified" aria-selected="true"><i class="fa fa-check-circle"></i>&nbsp;&nbsp;Active</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="non-verified-tab" data-toggle="pill" href="#non-verified" role="tab" aria-controls="non-verified" aria-selected="false"><i class="fa fa-book"></i>&nbsp;&nbsp;InActive</a>
    </li>

</ul>
</div>

@include('includes.success')

<div class="card-body">
    <div class="tab-content" id="custom-tabs-four-tabContent">
     <div class="tab-pane fade show active" id="verified" role="tabpanel" aria-labelledby="verified-tab">
         <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ref</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Since</th>
                </tr>
            </thead>
            <tbody>
                @foreach($active as $u)
                <tr>
                    <td>{{ $u->id }}</td>
                    <td>{{ $u->ref_code }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->phone }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ \Carbon\Carbon::parse($u->created_at)->format('d M y') }}</td>


                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="tab-pane fade" id="non-verified" role="tabpanel" aria-labelledby="non-verified-tab">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Ref</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Since</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inactive as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->ref_code }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->phone }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ \Carbon\Carbon::parse($u->created_at)->format('d M y') }}</td>


                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</div>
</div>
</div>
</div>
</section>

<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!------ Start Footer -->
@include('admin.includes.version')
<!------ end Footer -->

</div>
<!-- ./wrapper -->
<!------ Start Footer links-->
@include('admin.includes.footer_links')
<!------ end Footer links -->

</body>
</html>
