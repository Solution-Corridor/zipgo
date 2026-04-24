<!DOCTYPE html>
<html lang="en">

<head>
	@include('includes.header_links')
	<title>Change Password</title>
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
		<!-- Header Container -->
		@include('includes.navbar')
		<div class="clearfix"></div>
		<!-- Header Container / End --> 

		<!-- Content -->
		<div class="container">
			<div class="row"> 
				<!-- Widget -->
				
				<div class="col-md-12">
					@include('includes.success')
									<form action="/change_password" method="POST" class="password-form">
    @csrf
    <div class="col-md-12">
        <label>Current Password <code>*</code></label>
        <div class="form-group">
            <input type="password" name="old_password" class="form-control" placeholder="Current Password" required>
            <span class="toggle-password" onclick="togglePasswordVisibility('old_password')">
                <i class="fas fa-eye"></i>
            </span>
        </div>
    </div>

    <div class="col-md-12">
        <label>New Password <code>*</code></label>
        <div class="password-wrapper">
            <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
            <span class="toggle-password" onclick="togglePasswordVisibility('new_password')">
                <i class="fas fa-eye"></i>
            </span>
        </div>
    </div>

    <div class="col-md-12">
        <label>Confirm New Password <code>*</code></label>
        <div class="password-wrapper">
            <input type="password" name="new_password_confirmation" class="form-control" placeholder="Re-enter New Password" required>
            <span class="toggle-password" onclick="togglePasswordVisibility('new_password_confirmation')">
                <i class="fas fa-eye"></i>
            </span>
        </div>
    </div>
    <div class="col-md-12 text-center" style="padding: 15px;">
        <button type="submit" class="default-btn btn-bg-two border-radius-50">Change Password</button>
    </div>
</form>

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
        padding-right: 30px; /* Adjust based on your design */
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


					</div>


				</div>
			</div>
		</div>
		@include('includes.footer')

		@include('includes.footer_links')
	</body>
	</html>