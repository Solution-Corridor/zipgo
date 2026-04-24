<!doctype html>
<html lang="zxx">

<head>
  @include('includes.header_links')
  <title>Login</title>
</head>

<body>

  <!-- Navbar Start -->
  @include('includes.navbar')
  <!-- Navbar End -->



  <div class="inner-banner">
    <div class="container">
      <div class="inner-title text-center">
        <h3>Log In</h3>
        <ul>
          <li>
            <a href="/">Home</a>
          </li>
          <li>
            <i class="bx bx-chevrons-right"></i>
          </li>
          <li>Log In</li>
        </ul>
      </div>
    </div>
    <div class="inner-shape">
      <img src="assets/images/shape/inner-shape.png" alt="Images">
    </div>
  </div>


  <div class="user-area pt-10 pb-10">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="user-img">
            <img src="assets/images/user-img.jpg" alt="Images">
          </div>
        </div>
        <div class="col-lg-6">

          <div class="contact-form" style="background: #f9f9f9; padding: 20px; border-radius: 10px;">
            <h2>Log In</h2>
            @include('includes.success')

            <form method="POST" action="/postlogin">
              @csrf
              <div class="row">
                <div class="col-lg-12 ">
                  <div class="form-group">
                    <input type="text" class="form-control" name="email" required data-error="Please enter your Username or Email" placeholder="Username or Email">
                  </div>
                </div>
                <div class="col-12">
                  <!-- Include jQuery -->
                  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

                  <div class="form-group">
                    <input class="form-control" type="password" name="password" id="password" placeholder="Password">
                    <span class="toggle-password" onclick="togglePassword()">Show Password</span>
                  </div>

                  <script>
                    function togglePassword() {
                      var passwordField = document.getElementById("password");

                      if (passwordField.type === "password") {
                        passwordField.type = "text";
                      } else {
                        passwordField.type = "password";
                      }
                    }
                  </script>


                </div>

                <div class="col-lg-12">
                  <button type="submit" class="default-btn btn-bg-two w-100">
                    Log In Now
                  </button>
                </div>

              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
  <style>
    .password-wrapper {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
    }

    .form-control {
      padding-right: 30px;
      /* Adjust based on your design */
    }

    @media screen and (max-width: 768px) {
      .user-img {
        display: none;
      }
    }

    }
  </style>

  <script>
    function togglePasswordVisibility(inputId) {
      var passwordInput = document.getElementsByName(inputId)[0];
      var toggleIcon = passwordInput.parentElement.querySelector(".toggle-password i");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.className = "fas fa-eye-slash";
      } else {
        passwordInput.type = "password";
        toggleIcon.className = "fas fa-eye";
      }
    }
  </script>




  @include('includes.footer')

  @include('includes.footer_links')

</body>

</html>