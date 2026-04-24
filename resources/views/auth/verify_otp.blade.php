<!doctype html>
	<html lang="zxx">
	<head>

		@include('includes.mob_header_links')

		<title>Verify Otp</title>
	</head>
	<body>
		<!-- Navbar Start -->
		@include('includes.mob_navbar')
		<!-- Navbar End -->



		


		<div class="user-area pt-100 pb-70">
			<div class="container">
				<div class="user-form">
					<div class="contact-form">
						<h2>Verify OTP</h2>
						@include('includes.success')

						<form method="post" action="/verify_email">
							@csrf
							
							<div class="row">
								<input type="hidden" name="v_token" required value="{{ $v_token }}">
								<div class="col-lg-8">
									<div class="form-group">
										<input type="number" name="otp" class="form-control" required placeholder="OTP" required value="">
										@error('otp')
										<p style="color: red;">{{ $message }}</p>
										@enderror
									</div>
								</div>
								<div class="col-lg-4">
									<button type="submit" class="default-btn btn-bg-two"   name="verify" value="Verify">
										Verify Account
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>





        @include('includes.footer')

        @include('includes.mob_footer_links')

			</body>
	</html>
