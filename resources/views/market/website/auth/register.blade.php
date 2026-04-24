<!doctype html>
	<html lang="zxx">
	<head>
		@include('includes.header_links')

		<title>Register</title>
	</head>
	<body>
		<!-- Navbar Start -->
		@include('includes.navbar')
		<!-- Navbar End -->

		<div class="inner-banner">
			<div class="container">
				<div class="inner-title text-center">

					<h3>Register</h3>
					@include('includes.success')


					<ul>
						<li>
							<a href="/">Home</a>
						</li>
						<li>
							<i class="bx bx-chevrons-right"></i>
						</li>
						<li>Register</li>
					</ul>
				</div>
			</div>
			<div class="inner-shape">
				<img src="/assets/images/shape/inner-shape.png" alt="Images">
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
		</style>


		<div class="user-area pt-100 pb-70">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-6">
						<div class="user-img">
							<img src="/assets/images/user-img.jpg" alt="Images">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="user-form">
							<div class="contact-form">

								<h2>Register Now</h2>
								<div>

									@include('includes.success')

								</div>

								<form method="post" action="/saveRegister">
									@csrf
									<div class="row">


										<div class="col-lg-6 ">
											<div class="form-group">
												<input    name="ref_code"
												id="ref_code"  type="text" class="form-control" value="{{$ref->ref_code??''}}{{ old('ref_code') }}" placeholder="Enter Referal Code " >
												@error('ref_code')
												<div class="invalid-feedback">{{ $message }}</div>
												@enderror

											</div>
										</div>

										<div class="col-lg-6 ">
											<div class="form-group">
												<input name="ref_name" id="ref_name" type="text" class="form-control" value="{{$ref->name??''}}{{ old('ref_name') }}"
												placeholder="Referal Name " >
												@error('ref_name')
												<div class="invalid-feedback">{{ $message }}</div>
												@enderror
												<input name="ref_by" id="ref_by" type="hidden" value="{{$ref->id??''}}">
												@error('ref_name')
												<div class="invalid-feedback">{{ $message }}</div>
												@enderror

											</div>
										</div>


										<div class="col-lg-12 ">
											<div class="form-group">
												<input name="name" type="text" class="form-control" required data-error="Please enter your Username"   value="{{ old('name') }}"  placeholder="Enter Your Username " >
												@error('name')
												<div class="invalid-feedback">{{ $message }}</div>
												@enderror

											</div>
										</div>



										<div class="col-lg-6">
											<div class="form-group">
												<input type="email" name="email" class="form-control" required data-error="Please enter your Email" value="{{ old('email') }}" placeholder="Enter Your Email">
												@error('email')
												<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>

										<div class="col-6">
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

										<div class="col-lg-12 ">
											<button type="submit" class="default-btn btn-bg-two">
												Register Now
											</button>
										</div>
										<div class="col-12">
											<p class="account-desc">
												Already have an account?
												<a href="/login">Log In</a>
											</p>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		@include('includes.footer')

		@include('includes.footer_links')


		<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI/tZ1XaT84vJ0WN1FouJpiM4+QxuJ49YpFhF0E=" crossorigin="anonymous"></script>

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-nXX6Zw6Zv1HdT2owmPyPMy9OvWtq8l+2H5L1XWSi3ZBtTRlKC2QrCDVVUBAcSSlYF6hbKjfA6YpNZqLqMgn/Ig==" crossorigin="anonymous" />


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
                    			$('#ref_by').val(response.data.id);
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


<script>
	function togglePasswordVisibility() {
		var passwordInput = document.getElementById("password");
		var toggleIcon = document.querySelector(".toggle-password i");

		if (passwordInput.type === "password") {
			passwordInput.type = "text";
			toggleIcon.className = "fas fa-eye-slash";
		} else {
			passwordInput.type = "password";
			toggleIcon.className = "fas fa-eye";
		}
	}
</script>


</body>

</html>
