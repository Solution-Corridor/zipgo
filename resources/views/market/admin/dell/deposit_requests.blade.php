@php
use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="en">
@section('title')
Deposit Requests
@endsection
<!-- Start top links -->
@include('admin.includes.headlinks')
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <style>
        .zoomable-image {
            transition: transform 0.3s ease-in-out;
        }

        .zoomable-image:hover {
            transform: scale(3.2);
            z-index: 999;
        }
    </style>

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
           <h1 class="m-0"> Deposit Requests</h1>
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
                                <a class="nav-link active" id="pending-tab" data-toggle="pill" href="#pending" role="tab" aria-controls="pending" aria-selected="true"><i class="fa fa-check-circle"></i>&nbsp;&nbsp;Pending</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="approved-tab" data-toggle="pill" href="#approved" role="tab" aria-controls="approved" aria-selected="false"><i class="fa fa-book"></i>&nbsp;&nbsp;Approved</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="rejected-tab" data-toggle="pill" href="#rejected" role="tab" aria-controls="rejected" aria-selected="false"><i class="fa fa-ban"></i>&nbsp;&nbsp;Rejected</a>
                            </li>      
                        </ul>
                    </div>

                    @include('includes.success')
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                                <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Receipt</th>
                    <th>TRX ID</th>
                    <th>Amount</th>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>User Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pending as $p)
                <tr>
                    <td>{{ $p->type }}</td>
                    <td>{{ Carbon::parse($p->created_at)->format('d M y') }}</td>
                    <td>
                        <img src="/uploads/receipts/{{ $p->receipt }}" class="zoomable-image" style="width:100px; height: 50px;">
                    </td>

                    <td>{{ $p->id }}</td>
                    <td>{{ $p->amount }}</td>
                    <td>{{ $p->user_name }}</td>
                    <td>{{ $p->user_email }}</td>
                    <td>{{ $p->user_phone }}</td>
                    <td>
                        <a href="{{ route('activate.deposit', ['id' => $p->id]) }}" class="btn btn-xs btn-success" title="Activate" onclick="alert('Are You Sure to Activate?')">
                            <i class="fa fa-check-circle"></i>
                        </a>
                         <a href="{{  route('reject.deposit', ['id' => $p->id]) }}" class="btn btn-xs btn-danger" title="Activate" onclick="alert('Are You Sure to Reject?')">
                            <i class="fa fa-check-circle"></i>
                        </a>

                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
                            </div>

                            <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                                <table id="example1" class="example3 table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Receipt</th>
                    <th>TRX ID</th>
                    <th>Amount</th>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>User Phone</th>
                </tr>
            </thead>
            <tbody>
                @foreach($approved as $p)
                <tr>
                    <td>{{ $p->type }}</td>
                    <td>{{ Carbon::parse($p->created_at)->format('d M y') }}</td>
                    <td>
                        <img src="/uploads/receipts/{{ $p->receipt }}" class="zoomable-image" style="width:150px; height: 100px;">
                    </td>

                    <td>{{ $p->id }}</td>
                    <td>{{ $p->amount }}</td>
                    <td>{{ $p->user_name }}</td>
                    <td>{{ $p->user_email }}</td>
                    <td>{{ $p->user_phone }}</td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
                            </div>

                            <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                                <table id="example1" class="example3 table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Receipt</th>
                    <th>TRX ID</th>
                    <th>Amount</th>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>User Phone</th>
                    <th>Reason</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rejected as $p)
                <tr>
                    <td>{{ $p->type }}</td>
                    <td>{{ Carbon::parse($p->created_at)->format('d M y') }}</td>
                    <td>
                        <img src="/uploads/receipts/{{ $p->receipt }}" class="zoomable-image" style="width:150px; height: 100px;">
                    </td>

                    <td>{{ $p->id }}</td>
                    <td>{{ $p->amount }}</td>
                    <td>{{ $p->user_name }}</td>
                    <td>{{ $p->user_email }}</td>
                    <td>{{ $p->user_phone }}</td>
                    <td class="text-danger">{{ $p->reject_reason }}</td>
                    <td>
                        <a href="{{ route('activate.package', ['id' => $p->id]) }}" class="btn btn-xs btn-success" title="Activate" onclick="alert('Are You Sure to Activate?')">
                            <i class="fa fa-check-circle"></i>
                        </a>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!--/.col (left) -->

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>

<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal for Reject Reason -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="reject-package" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="pkgId">
                    <label for="rejectReason">Please provide a reason for rejection:</label>
                    <textarea class="form-control" id="rejectReason" name="rejectReason" rows="3" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // When the modal is shown
        $('#rejectModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var packageId = button.data('package-id'); 
            $('#pkgId').val(packageId);       
        });

        
    });
</script>


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
