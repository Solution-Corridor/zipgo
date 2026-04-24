@php
use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="en">
@section('title')
Withdraw Requests
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
                     <h1 class="m-0"> Withdraw Requests</h1>
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
                        <a class="nav-link active" id="pending-tab" data-toggle="pill" href="#pending" role="tab" aria-controls="pending" aria-selected="true"><i class="fa fa-list"></i>&nbsp;&nbsp;Pending</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="approved-tab" data-toggle="pill" href="#approved" role="tab" aria-controls="approved" aria-selected="false"><i class="fa fa-check-circle"></i>&nbsp;&nbsp;Approved</a>
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
                    <th>#</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Number</th>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>User Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $rq)
                <tr>
                    <td>{{ $rq->withdraw_id }}</td>
                    <td>{{ Carbon::parse($rq->created_at)->format('d M y') }}</td>
                    <td>{{ $rq->amount }}</td>
                    <td>{{ $rq->account_type }}</td>
                    <td>{{ $rq->title }}</td>
                    <td>{{ $rq->number }}</td>
                    <td>{{ $rq->name }}</td>
                    <td>{{ $rq->email }}</td>
                    <td>{{ $rq->phone }}</td>
                    <td>
                        <a href="{{ route('accept.withdraw', ['id' => $rq->withdraw_id, 'amount' => $rq->amount]) }}" class="btn btn-xs btn-success" title="Approve" onclick="alert('Are You Sure to Approve?')">
                            <i class="fa fa-check-circle"></i>
                        </a>

                        <a href="#" class="btn btn-xs btn-danger" title="Reject" data-toggle="modal" data-target="#rejectModal" data-request-id="{{ $rq->withdraw_id }}">
                            <i class="fa fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

                </div>

                <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                    <table id="example3" class="example3 table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Number</th>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>User Phone</th>
                </tr>
            </thead>
            <tbody>
                @foreach($approved as $rq)
                <tr>
                    <td>{{ $rq->withdraw_id }}</td>
                    <td>{{ Carbon::parse($rq->created_at)->format('d M y') }}</td>
                    <td>{{ $rq->amount }}</td>
                    <td>{{ $rq->account_type }}</td>
                    <td>{{ $rq->title }}</td>
                    <td>{{ $rq->number }}</td>
                    <td>{{ $rq->name }}</td>
                    <td>{{ $rq->email }}</td>
                    <td>{{ $rq->phone }}</td>
                    
                </tr>
                @endforeach

            </tbody>
        </table>
                </div>

                <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                    <table id="example4" class="example4 table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Number</th>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>User Phone</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rejected as $rq)
                <tr>
                    <td>{{ $rq->withdraw_id }}</td>
                    <td>{{ Carbon::parse($rq->created_at)->format('d M y') }}</td>
                    <td>{{ $rq->amount }}</td>
                    <td>{{ $rq->account_type }}</td>
                    <td>{{ $rq->title }}</td>
                    <td>{{ $rq->number }}</td>
                    <td>{{ $rq->name }}</td>
                    <td>{{ $rq->email }}</td>
                    <td>{{ $rq->phone }}</td>
                    
                </tr>
                @endforeach

            </tbody>
        </table>
                </div>

            </div>

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
            <form action="reject-withdraw" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="rqId">
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
            var requestId = button.data('request-id'); 
            $('#rqId').val(requestId);       
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
