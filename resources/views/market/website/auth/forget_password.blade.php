<!doctype html>
	<html lang="zxx">
	<head>

		@include('includes.header_links')

		<title>Forget Password</title>
	</head>
	<body>
		<!-- Navbar Start -->
		@include('includes.navbar')
		<!-- Navbar End -->



		<div class="inner-banner">
			<div class="container">
				<div class="inner-title text-center">
					<h3>Forget Password</h3>
					<ul>
						<li>
							<a href="/">Home</a>
						</li>
						<li>
							<i class="bx bx-chevrons-right"></i>
						</li>
						<li>Forget Password</li>
					</ul>
				</div>
			</div>
			<div class="inner-shape">
				<img src="assets/images/shape/inner-shape.png" alt="Images">
			</div>
		</div>


		<div class="user-area pt-100 pb-70">
			<div class="container">
				<div class="user-form">
					<div class="contact-form">
						<h2>Forget Password</h2>
						@include('includes.success')

						<form method="post" action="{{ url('/forgot_password') }}" class="login">
							@csrf
							<div class="row">
								<div class="col-lg-12 ">
									<div class="form-group">
										<input type="text" name="email" class="form-control" required data-error="Please enter username or email" placeholder="Username or Email">
									</div>
								</div>
								<div class="col-lg-12 ">
									<button type="submit" class="default-btn btn-bg-two">
										Reset Now
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

			@include('includes.footer')

		@include('includes.footer_links')


		
	</body>
	</html>