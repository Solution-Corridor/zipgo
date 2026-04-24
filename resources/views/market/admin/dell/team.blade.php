<!DOCTYPE html>
<html lang="en">
@section('title')
Add Team
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
       <h1 class="m-0"> Add Team</h1>
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
        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true"><i class="fa fa-list"></i>&nbsp;&nbsp;List Team</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Team</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
   <div class="tab-content" id="custom-tabs-four-tabContent">
     <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      @include('admin.includes.success') 
      <div class="card card-primary">
       <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
           <th>Sr#</th>
           <th>Name</th>
           <th>Picture</th>
           <th>Designation</th>
           <th>Detail</th>
           <th>Action</th>
         </tr>
       </thead>
       <tbody>
         @foreach ($team as $cd)
         <tr>
          <td>{{ $cd->team_id }}</td>
          <td>{{ $cd->name }}</td>
          <td><img src="/uploads/team/{{ $cd->pic }}" width="100" height="80"></td>
         <td>{{ $cd->desigination }}</td>
            <td>{!! $cd->detail !!}</td>
            
            <td>
             <!--  <a href="#" class="btn btn-success btn-xs" title="View"><i class="fa fa-eye"></i></a> -->
              <a href="/edit_team/{{ $cd->team_id }}" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
              <a onclick="return confirm('Are you sure to Delete?');" href="/delete_team/{{ $cd->team_id }}" class="btn btn-danger btn-xs" title="Delete" ><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

    </div>
  </div>
  <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">

    <div class="card card-primary">

      <!-- form start -->
      <form action="/save_team" method="POST" enctype="multipart/form-data">
       <div class="card-body">
        <div class="row"> 

          @csrf
          <div class="col-md-6">
            <label><b>Name </b><span class="strdngr">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="Add Title">
          </div>      

          <div class="col-md-6">
           <label><b>Picture </b><span class="strdngr">*</span></label>
           <input type="file" name="pic" class="form-control">
         </div> 

            <div class="col-md-12">
           <label><b>Designation </b><span class="strdngr">*</span></label>
           <input type="text" name="desigination" class="form-control">
         </div>                 
         <div class="col-md-12">
          <div class="form-group">
            <label><b>Detail</b><code>*</code></label>
            <textarea name="detail" class="form-control textarea" placeholder="Detail" required>{{ old('detail') }}</textarea>
          </div>
          @error('detail')
          <p class="help-block text-danger">{{ $message }}</p>
          @enderror
        </div>

      </div>                        

    </div>
    <div class="card-footer text-center">
      <a href="/dashboard" class="btn btn-danger">Cancel</a>
      <button type="submit" name="btnClass" class="btn btn-primary">Add Blog</button>
    </div>
  </form>
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
