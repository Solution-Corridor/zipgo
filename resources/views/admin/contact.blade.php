<!DOCTYPE html>
<html lang="en">
@section('title')
Contact
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
       <h1 class="m-0"> Contact</h1>
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

      
  </div>
  <div class="card-body">
   <div class="tab-content" id="custom-tabs-four-tabContent">
     <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
      
      @include('admin.includes.success')
      <div class="card card-primary">
       <table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Sr#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
        </tr>
    </thead>
    <tbody>
       
        @foreach ($msgs as $msg)
        <tr>
            <td>{{ $msg->id }}</td>            
            <td>{{ $msg->name }}</td>
            <td>{{ $msg->email }}</td>
            <td>
                <strong>{{ $msg->subject }}</strong>
                <p>{{ $msg->message }}<br>
                    <i>{{ $msg->date }}</i>
                </p>
            </td>

            
        </tr>
        @endforeach
    </tbody>
</table>


    </div>
  </div>
  
</div>
</div>


<!-- /.card -->


</div>
<!--/.col (left) -->

</div>
<!-- /.row -->
</div>
</div>
<!-- /.container-fluid -->
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
