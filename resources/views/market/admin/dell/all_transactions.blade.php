<!DOCTYPE html>
<html lang="en">
@section('title')
Transactions
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
       <h1 class="m-0"> Transactions</h1>
     </div><!-- /.col -->
     <div class="col-sm-6"></div><!-- /.col -->
   </div><!-- /.row -->
 </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<section class="content">
 <div class="container-fluid">
  <div class="row">

    <div class="col-md-12">
      @include('includes.success')
      <div class="card card-primary">
        <div class="card-header">
          Transaction History
        </div>
        <table id="example1" class="example1 table table-bordered table-striped">
          <thead>
            <tr>
              <th>Trx ID</th>
              <th>Date</th>
              <th>Amount</th>
              <th>Type</th>
              <th>Detail</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody> 
            @foreach($transactions as $trx)         
            <tr>
              <td>{{$trx->name}} ({{$trx->ref_code}})</td>
              <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d M y') }}</td>
              <td>{{$trx->amount}}</td>
              <td>{{$trx->trx_type}}</td>
              <td>{{$trx->detail}}</td>
              <td>
                <form method="POST" action="{{ route('delete.transaction', ['id' => $trx->transaction_id]) }}">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this transaction?')" title="Delete">
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
