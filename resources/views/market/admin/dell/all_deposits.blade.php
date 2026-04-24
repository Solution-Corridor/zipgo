<!DOCTYPE html>
<html lang="en">
@section('title')
Deposists
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
       <h1 class="m-0"> Deposists</h1>
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

      <div class="card card-primary card-outline card-outline-tabs">
       <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
         <li class="nav-item">
          <a class="nav-link active" id="easypaisa-tab" data-toggle="pill" href="#easypaisa" role="tab" aria-controls="easypaisa" aria-selected="true"><i class="fa fa-list"></i>&nbsp;&nbsp;Easypaisa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="jazcash-tab" data-toggle="pill" href="#jazcash" role="tab" aria-controls="jazcash" aria-selected="false"><i class="fa fa-check-circle"></i>&nbsp;&nbsp;Jazz Cash</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="internal-tab" data-toggle="pill" href="#internal" role="tab" aria-controls="internal" aria-selected="false"><i class="fa fa-ban"></i>&nbsp;&nbsp;Internal Funds</a>
        </li>      
      </ul>
    </div>

    @include('includes.success')
    <div class="card-body">
      <div class="tab-content" id="custom-tabs-four-tabContent">
       <div class="tab-pane fade show active" id="easypaisa" role="tabpanel" aria-labelledby="easypaisa-tab">
        <table id="example1" class="example1 table table-bordered table-striped">
          <thead>
            <tr>
              <th>Leader</th>
              <th>Date</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody> 
            @foreach($easypaisa as $trx)         
            <tr>
              <td>{{$trx->name}} ({{$trx->ref_code}})</td>
              <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d M y') }}</td>
              <td>{{number_format($trx->amount)}}</td>
              <td>
                @if($trx->pkg_status==0)
                <span style="color:blue;">Pending</span>
                @endif
                @if($trx->pkg_status==1)
                <span style="color:green;">Active</span>
                @endif
                @if($trx->pkg_status==2)
                <span style="color:red;">Rejected</span>
                @endif
              </td>
              <td>
                <form method="POST" action="{{ route('delete.deposit', ['id' => $trx->pkg_id]) }}">
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

      <div class="tab-pane" id="jazcash" role="tabpanel" aria-labelledby="jazcash-tab">
        <table id="example1" class="example1 table table-bordered table-striped">
          <thead>
            <tr>
              <th>Leader</th>
              <th>Date</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody> 
            @foreach($jazzcash as $trx)         
            <tr>
              <td>{{$trx->name}} ({{$trx->ref_code}})</td>
              <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d M y') }}</td>
              <td>{{number_format($trx->amount)}}</td>
              <td>
                @if($trx->pkg_status==0)
                <span style="color:blue;">Pending</span>
                @endif
                @if($trx->pkg_status==1)
                <span style="color:green;">Active</span>
                @endif
                @if($trx->pkg_status==2)
                <span style="color:red;">Rejected</span>
                @endif
              </td>
              <td>
                <form method="POST" action="{{ route('delete.deposit', ['id' => $trx->pkg_id]) }}">
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

      <div class="tab-pane" id="internal" role="tabpanel" aria-labelledby="internal-tab">
        <table id="example1" class="example1 table table-bordered table-striped">
          <thead>
            <tr>
              <th>Leader</th>
              <th>Date</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody> 
            @foreach($internal_funds as $trx)         
            <tr>
              <td>{{$trx->name}} ({{$trx->ref_code}})</td>
              <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d M y') }}</td>
              <td>{{number_format($trx->amount)}}</td>
              <td>
                @if($trx->pkg_status==0)
                <span style="color:blue;">Pending</span>
                @endif
                @if($trx->pkg_status==1)
                <span style="color:green;">Active</span>
                @endif
                @if($trx->pkg_status==2)
                <span style="color:red;">Rejected</span>
                @endif
              </td>
              <td>
                <form method="POST" action="{{ route('delete.deposit', ['id' => $trx->pkg_id]) }}">
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
