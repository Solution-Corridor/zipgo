<!DOCTYPE html>
<html lang="en">
<head>
  @include('includes.header_links')
  <title>Enter OTP</title>
</head>

<body>
  <!-- Preloader Start -->
  <div class="preloader">
    <div class="utf-preloader">
      <span></span>
      <span></span>
      <span></span>
  </div>
</div>
<!-- Preloader End -->

<!-- Wrapper -->
<div id="wrapper"> 

    @include('includes.header')
    <div class="clearfix"></div>
    <!-- Header Container / End --> 
    
    <!-- Contact --> 
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="my-account">
            <div class="tabs-container"> 
              <!-- Login -->
              @include('includes.success')
              <div class="utf-welcome-text-item">
                <h3>Enter OTP</h3>                
            </div>
            <form method="post" action="/funds_transfer_verify_otp">
                @csrf
                <div class="form-row form-row-wide">
                    <input type="text" class="input-text @error('otp') is-invalid @enderror" name="otp" id="otp" placeholder="OTP" value="" required />
                    @error('otp')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>                

                <input type="submit" class="button full-width border margin-top-10" name="verify" value="Verify OTP" />
            </form>

        </div>
    </div>
</div>
</div>
</div>
<!-- Container / End --> 

<!-- Footer -->
@include('includes.footer')
<!-- Sign In Popup / End -->

<!-- Scripts --> 
@include('includes.footer_links')
</body>

</html>