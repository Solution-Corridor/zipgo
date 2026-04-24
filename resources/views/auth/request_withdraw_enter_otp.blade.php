<!DOCTYPE html>
<html lang="en">
@section('title')
Deposit Funds
@endsection
<!-- Start top links -->
@include('customer.includes.headlinks')
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
 <div class="wrapper">
  <!-- Start navbar -->
  @include('customer.includes.navbar')
  <!-- end navbar -->

  <!-- Start Sidebar -->
  @include('customer.includes.sidebar')
  <!-- end Sidebar -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
    <div class="container-fluid">
     <div class="row mb-2">
      <div class="col-sm-6">
       <h1 class="m-0"> Enter OTP</h1>
               @include('includes.success')

     </div><!-- /.col -->
     <div class="col-sm-6">
       <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">OTP</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<section class="content">
 <div class="container-fluid">
  <div class="row">
   <!-- left column -->
   <div class="col-md-12">
    <div class="card">
      <div class="card-header bg-info">OTP</div>
      

      <div class="card-body">
        @include('includes.success')
        <form method="post" action="/request_withdraw_verify_otp">
                @csrf
          <div class="row">

          


              <div class="form-row form-row-wide">
                    <input type="text" class="form-control @error('otp') is-invalid @enderror" name="otp" id="otp" placeholder="OTP" value="" required />
                    @error('otp')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>   

                <input type="submit" class="button full-width border margin-top-10" name="verify" value="Verify OTP" />
            
            


          </div>

        </div>

        <div class="modal-footer justify-content-between">
          <a href="/dashboard2" class="btn btn-danger">Close</a>
          <button type="submit" class="btn btn-primary">Proceed</button>
        </div>

      </form>

    </div>
  </div>
  <!--/.col (left) -->

  
<!-- /.row -->
</div>
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!------ Start Footer -->
@include('customer.includes.version')
<!------ end Footer -->

</div>
<!-- ./wrapper -->
<!------ Start Footer links-->
@include('customer.includes.footer_links')
<!------ end Footer links -->

<script>
  function copyToClipboard() {
    /* Create a temporary input element */
    var input = document.createElement("input");

    /* Set the input's value to the text you want to copy */
    input.value = document.getElementById("copyText").textContent;

    /* Append the input element to the document */
    document.body.appendChild(input);

    /* Select the text in the input field */
    input.select();
    input.setSelectionRange(0, 99999); /* For mobile devices */

    /* Copy the text to the clipboard */
    document.execCommand("copy");

    /* Remove the temporary input element */
    document.body.removeChild(input);

    /* Alert the user that the text has been copied */
    alert("Link Copied");
  }
</script>

<script>
  function calculateCoins(amount) {
  // Multiply the entered amount by 100 to calculate coins
  const coinsInput = document.querySelector('input[name="coins"]');
  if (coinsInput) {
    coinsInput.value = amount * 100;
  }
}
</script>

</body>
</html>
