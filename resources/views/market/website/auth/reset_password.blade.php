<!DOCTYPE html>
<html lang="en">
<head>
@include('includes.header_links')
<title>Reset Password</title>
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
        <h3>Reset Password</h3>
        </div>
              <form method="get" action="/reset-password-change" class="login">
                @csrf
                <div class="col-md-12 col-sm-12 mb-3">
                                <label class="mb-1"><b>E-Mail</b> <code>*</code></label>
                                <input type="email" name="email" placeholder="E-Mail" class="input-text" required value="{{ $email }}" readonly>
                                <input type="hidden" name="token" value="{{$token}}">
                                @error('email')
                                <br>
                                <span style="color: #f00;">
                                  {{$message}}
                              </span>
                              @enderror
                          </div>

                           <div class="col-md-12 col-sm-12 mb-3">                            
                                <label>Password <code>*</code></label> 
                                <input name="password" type="password" class="input-text" required="" placeholder="Password" id="password" value="{{ old('password') }}">
                                @error('password')
                                <span style="color: #f00;">
                                  {{ $message }}
                              </span>
                              @enderror
                      </div>  


                      <div class="col-md-12 col-sm-12 mb-3">
                        <label>Confirm Password <code>*</code></label> 
                        <input name="password_confirmation" type="password" class="input-text" required="" placeholder="Password" id="password_confirmation" value="{{ old('password_confirmation') }}">

                         @error('password_confirmation')
                            <span style="color: #f00;">
                              {{ $message }}
                          </span>
                          @enderror
                  </div>  

                
                <div class="form-row">
                  <div class="checkbox margin-top-10 margin-bottom-10">
                    <a class="lost_password" href="/register">Register</a> 
                  </div>
                  <a class="lost_password" href="/login">Login</a> 
                </div>
                <input type="submit" class="button full-width border margin-top-10" name="login" value="Update Password" />
        
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