<!DOCTYPE html>
<html lang="en">
@section('title')
Promotions
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
       <h1 class="m-0"> Promotions</h1>
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
        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true"><i class="fa fa-list"></i>&nbsp;&nbsp;List</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</a>
    </li>
</ul>
</div>
<div class="card-body">
   <div class="tab-content" id="custom-tabs-four-tabContent">
     <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
      @include('includes.success')
      <div class="card card-primary">
        
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ad</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($promotions as $promotion)
                <tr>
                    <td>{{ $promotion->id }}</td>
                    <td>
                        <img src="/uploads/promotions/{{ $promotion->ad }}" alt="Promotion Ad" style="max-width: 100px;">
                    </td>
                    <td>{{ \Carbon\Carbon::parse($promotion->created_at)->format('d M y') }}</td>
                    <td>
                        <form action="{{ route('deletePromotion', ['id' => $promotion->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-xs" title="Delete" onclick="return confirm('Are you sure to delete?')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        

    </div>
</div>
<div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">

  <div class="card card-primary">

    <form action="{{ route('savePromotion') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <label>Promotion Ad<code>*</code></label>
                    <input type="file" name="ad" class="form-control" required="" value="{{ old('ad') }}">
                </div>

                <div class="col-md-12">
                    <div class="card-footer text-center">
                        <a href="/dashboard" class="btn btn-danger">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Promotion</button>
                    </div>
                </div>
            </div>
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
