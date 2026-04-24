<!DOCTYPE html>
<html lang="en">
@section('title')
Kyc List
@endsection
<!-- Start top links -->
@include('admin.includes.headlinks')
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
 <div class="wrapper">

  <style>
  .enlarge-image {
    transition: transform 0.2s;
  }

  .enlarge-image:hover {
    transform: scale(10.2);
  }
</style>

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
       <h1 class="m-0"> Kyc List</h1>
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

   @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        @include('includes.success') 

   <div class="col-md-12">
    <div class="card card-primary card-outline card-outline-tabs">
     <div class="card-header p-0 border-bottom-0">

      <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
       <li class="nav-item">
        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#pending" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true"><i class="fa fa-list"></i>&nbsp;&nbsp;Pending</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#approved" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false"><i class="fa fa-plus"></i>&nbsp;&nbsp;Approved</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#rejected" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false"><i class="fa fa-plus"></i>&nbsp;&nbsp;Rejected</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
   <div class="tab-content" id="custom-tabs-four-tabContent">
     <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
      <table class="example1 table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Country</th>
              <th>Type</th>
              <th>Front</th>
              <th>Back</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pending_kyc as $cd)
            <tr>
              <td>{{ $cd->kyc_id }}</td>
              <td>{{ $cd->full_name }}<br>{{ $cd->dob }}</td>
              <td>{{ $cd->country }}</td>
              <td>{{ $cd->doc_type }}<br>{{ $cd->doc_number }}</td>
              <td>
    <img src="/uploads/kyc/{{ $cd->pic_front}}" style="height: 50px;" class="enlarge-image" onclick="enlargeImage(this);">
  </td>
  <td>
    <img src="/uploads/kyc/{{ $cd->pic_back}}" style="height: 50px;" class="enlarge-image" onclick="enlargeImage(this);">
  </td>
              <td>
                <a onclick="return confirm('Are you sure to Accept?');" href="/accept_kyc/{{ $cd->kyc_id}}" class="btn btn-success btn-xs" title="Accept KYC"><i class="fa fa-check"></i></a>

                <a onclick="return confirm('Are you sure to Reject?');" href="/reject_kyc/{{ $cd->kyc_id}}" class="btn btn-danger btn-xs" title="Reject KYC"><i class="fa fa-ban"></i></a>

              </td>
            </tr>

            @endforeach

          </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
<table class="example1 table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Country</th>
              <th>Type</th>
              <th>Front</th>
              <th>Back</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($approved_kyc as $cd)
            <tr>
              <td>{{ $cd->kyc_id }}</td>
              <td>{{ $cd->full_name }} <br>{{ $cd->dob }}</td>
              <td>{{ $cd->country }}</td>
              <td>{{ $cd->doc_type }}<br>{{ $cd->doc_number }}</td>
              <td>
    <img src="/uploads/kyc/{{ $cd->pic_front}}" style="height: 50px;" class="enlarge-image" onclick="enlargeImage(this);">
  </td>
  <td>
    <img src="/uploads/kyc/{{ $cd->pic_back}}" style="height: 50px;" class="enlarge-image" onclick="enlargeImage(this);">
  </td>
              <td>
                <a onclick="return confirm('Are you sure to Accept?');" href="/accept_kyc/{{ $cd->kyc_id}}" class="btn btn-success btn-xs" title="Accept KYC"><i class="fa fa-check"></i></a>

                <a onclick="return confirm('Are you sure to Reject?');" href="/reject_kyc/{{ $cd->kyc_id}}" class="btn btn-danger btn-xs" title="Reject KYC"><i class="fa fa-ban"></i></a>

              </td>
            </tr>

            @endforeach

          </tbody>
        </table>
  </div>
  <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
<table class="example1 table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Country</th>
              <th>Type</th>
              <th>Front</th>
              <th>Back</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($rejected_kyc as $cd)
            <tr>
              <td>{{ $cd->kyc_id }}</td>
              <td>{{ $cd->full_name }}<br>{{ $cd->dob }}</td>
              <td>{{ $cd->country }}</td>
              <td>{{ $cd->doc_type }}<br>{{ $cd->doc_number }}</td>
              <td>
    <img src="/uploads/kyc/{{ $cd->pic_front}}" style="height: 50px;" class="enlarge-image" onclick="enlargeImage(this);">
  </td>
  <td>
    <img src="/uploads/kyc/{{ $cd->pic_back}}" style="height: 50px;" class="enlarge-image" onclick="enlargeImage(this);">
  </td>
              <td>
                <a onclick="return confirm('Are you sure to Accept?');" href="/accept_kyc/{{ $cd->kyc_id}}" class="btn btn-success btn-xs" title="Accept KYC"><i class="fa fa-check"></i></a>

                <a onclick="return confirm('Are you sure to Reject?');" href="/reject_kyc/{{ $cd->kyc_id}}" class="btn btn-danger btn-xs" title="Reject KYC"><i class="fa fa-ban"></i></a>

              </td>
            </tr>

            @endforeach

          </tbody>
        </table>
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

<script>
    function enlargeImage(image) {
      image.classList.toggle("enlarge-image");
    }
  </script>
</body>
</html>
