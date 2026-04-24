<!DOCTYPE html>
<html lang="en">
@section('title')
Rank Rewards
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
                     <h1 class="m-0"> Rank Rewards</h1>
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
                @include('includes.success')

                <div class="card card-primary">
                    <div class="card-header">Rank Rewards</div>

                    <div class="row">
                        <div class="col-md-12">
                            <form action="/save_rank_reward" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="container-fluid">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <label>Receiver Id<code>*</code></label>
                                            <input type="text" name="ref_code" id="ref_code" class="form-control" required="" placeholder="Receiver ID">
                                        </div>

                                        <div class="col-md-4">
                                            <label>Receiver Name<code>*</code></label>
                                            <input type="text" name="receiver_name" id="ref_name" class="form-control" required="" placeholder="Receiver Name" readonly>
                                            <input type="hidden" name="receiver_id" id="receiver_id">
                                        </div>

                                        <div class="col-md-2">
                                            <label>Amount<code>*</code></label>
                                            <input type="number" name="amount" id="amount" class="form-control" required="" placeholder="1000">
                                        </div>

                                        <div class="col-md-2">
                                            <label>Rank<code>*</code></label>
                                            <select class="form-control select2" name="rank">
                                                <option value="">Select New Rank</option>
                                                <option value="Silver">Silver</option>
                                                <option value="Gold">Gold</option>
                                                <option value="Ambassador">Ambassador</option>
                                                <option value="Crown A">Crown A</option>
                                                <option value="Sale Manager">Sale Manager</option>
                                                <option value="SS.M">SS.M</option>
                                                <option value="S.Director">S.Director</option>
                                            </select>
                                        </div>


                                    </div>
                                </div>

                                <div class="card-footer text-center">
                                    <a href="/dashboard" class="btn btn-danger">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Grant Reward</button>
                                </div>
                            </form>
                        </div>
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

<!------ Start Footer -->
@include('admin.includes.version')
<!------ end Footer -->

</div>
<!-- ./wrapper -->
<!------ Start Footer links-->
@include('admin.includes.footer_links')
<!------ end Footer links -->

<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI/tZ1XaT84vJ0WN1FouJpiM4+QxuJ49YpFhF0E=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
        function updateRefName() {
            var ref_code = $('#ref_code').val().trim();

            if (ref_code !== '') {
                // Make an AJAX request to retrieve the user's name
                $.ajax({
                    url: '/getUserName', // Replace with your route URL
                    method: 'GET',
                    data: { ref_code: ref_code },
                    dataType: 'json',
                    success: function (response) {
                        try {
                            if (response.success) {
                                $('#ref_name').val(response.data.name);
                                $('#receiver_id').val(response.data.id);
                            } else {
                                // Handle the case when the ref_id is not found
                                $('#ref_name').val('Incorrect #');
                            }
                        } catch (error) {
                            // Handle unexpected JSON response format
                            console.error(error);
                            $('#ref_name').val('Error parsing response');
                        }
                    },
                    error: function () {
                        // Handle AJAX errors
                        $('#ref_name').val('Error');
                    }
                });
            } else {
                // Handle the case when ref_id is empty
                $('#ref_name').val('Ref ID is empty');
                $('#ref_by').val('');
            }
        }

        $('#ref_code').on('blur', updateRefName);

        // If you want to run the code initially as well, you can call the function here:
        // updateRefName();
    });
</script>


</body>
</html>
