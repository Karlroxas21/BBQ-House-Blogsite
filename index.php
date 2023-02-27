<?php
session_start();
include('./anti-csrf-tokens/tokens.php');
if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) {

?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>BBQ Blog</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="./style.css">
		<link rel="shortcut icon" type="image/jpg" href="images/iconlogo.png" />
	</head>

	<body>

		<header>
			<div class="collapse bg-dark bg-gradient" id="navbarHeader">
				<div class="container">
					<div class="row">
						<div class="col-sm-8 col-md-7 py-4">
							<h4 class="text-white">About BBQHOUSE</h4>
							<p class="text-muted">BBQ HOUSE is located Montalban, Rizal. We are famous for our month-watering pork and chicken barbecue. We also offer unlimited rice and a variety of homemade sauces for you to enjoy. Our side dishes will also please your taste buds. Our staff are all friendly, making sure we will offer you the best dining experience. We offer outdoor seating and our indoor seating are suitable for small or big groups. Our restaurant is budget friendly. We can't wait to serve you our authentic barbecue meal. Come dine with us.</p>
						</div>
						<div class="col-sm-4 offset-md-1 py-4">
							<h4 class="text-white">Sites</h4>
							<ul class="list-unstyled">
								<li><a href="https://national-u.edu.ph/" class="text-white">Visit Official Website</a></li>
								<li><a href="https://www.facebook.com/NationalUniversityPhilippines" class="text-white">Follow on Facebook - BBQHOUSE</a></li>
								<li><a href="https://www.facebook.com/groups/ccitofficial/" class="text-white">Follow on Instagram - BBQHOUSE</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="navbar navbar-dark bg-dark shadow-sm">
				<div id="style1" class="container">
					<a href="#" class="navbar-brand d-flex align-items-center">
						<img src="images/logo.png" alt="Logo" width="130" height="125" />
					</a>

					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
				</div>
			</div>
		</header>

		<main>
			<section class="py-5 text-center container">
				<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
					<div class="carousel-inner">
						<div class="carousel-item active">
							<img src="images/bbq.png" class="d-block w-100" alt="...">
						</div>
						<div class="carousel-item">
							<img src="images/bbq2.png" class="d-block w-100" alt="...">
						</div>
					</div>
					<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					</button>
				</div>
			</section>

			<section class="py-2 bg-light">
				<div class="container">
					<div class="row">

						<div class="col-md-8">
							<div class="card shadow-sm">
								<img src="images/bbq4.png" class="card-img-top" alt="...">
								<div class="card-body">
									<h1 class="display-8 fw-bold text-dark">What is BBQ HOUSE?</h1>
									<figure>
										<blockquote class="blockquote">
											<p id="style2">
												A food blog called BBQ HOUSE promotes quick, easy cooking with uncomplicated materials and minimal tools. Additionally, the website offers a wide selection of recipes.
											</p>
										</blockquote>
									</figure>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="row">
								<form action="login.php" method="POST" class="form-control needs-validation" id="frmLogin" enctype="multipart/form-data" autocomplete="off" novalidate>
									<input type="hidden" name="anticsrf" value="<?php echo $_SESSION['login_token']; ?>">
									<h1 class="h3 mb-3 fw-normal">Please sign in</h1>

									<div class="mb-3">
										<label for="email" class="form-label">Email</label>
										<input type="email" class="form-control" id="Email" name="Email" required>
										<div class="invalid-feedback">
											Invalid Email Address
										</div>
									</div>

									<div class="mb-3">
										<label for="Password" class="form-label">Password</label>
										<input type="Password" class="form-control" id="Password" name="Password" required>
										<div class="invalid-feedback">
											Invalid Password
										</div>
										<label for="toggle"><input type="checkbox" name="togglepw" id="togglepw">Show Password</label>
									</div>

									<div class="d-grid gap-2">
										<button class="btn btn-lg btn-primary" type="submit" name="login">Sign in</button>
										<a type='button' class='btn btn-lg btn-info' data-bs-toggle="modal" data-bs-target="#exampleModal">Register Here</a>
									</div>
								</form>
							</div>

							<!-- Modal  -->
							<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Account Registration</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<form action="register.php" method="POST" class="row g-3 needs-validation" novalidate>
												<input type="hidden" name="anticsrf" value="<?php echo $_SESSION['register_token']; ?>">

												<div class="mb-3">
													<label for="Name" class="form-label">Name</label>
													<input type="text" class="form-control" id="Name" name="Name" placeholder="Name" required>
												</div>
												<div class="valid-feedback">
													Looks good!
												</div>
												<div class="invalid-feedback">
													Please choose a name.
												</div>
												<div class="mb-3">
													<label for="Email" class="form-label">Email Address</label>
													<input type="email" class="form-control" id="Email" name="Email" placeholder="name@example.com" required>
													<div class="valid-feedback">
														Looks good!
													</div>
													<div class="invalid-feedback">
														Please choose a Email Address.
													</div>
												</div>
												<div class="mb-3">
													<label for="Password" class="form-label">Password</label>
													<input type="password" class="form-control" id="Password" name="Password" placeholder="Password" required required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
													<div class="valid-feedback">
														Looks good!
													</div>
													<div class="invalid-feedback">
														Password must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters
													</div>
												</div>
												<div class="mb-3">
													<label for="psw-repeat" class="form-label">Repeat Password</label>
													<input type="password" class="form-control" placeholder="Repeat Password" name="cpassword" id="cpassword" required>
													<div class="invalid-feedback">
														Passwords don't match
													</div>
												</div>
												<div class="modal-footer">
													<button type="submit" name="Submit" class="btn btn-primary">Submit</button>
													<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>

							<!-- MODAL ENDS HERE -->

							<div class="row" id="style3">
								<form action="comment.php" method="POST">
									<input type="hidden" name="anticsrf" value="<?php echo $_SESSION['comment_token']; ?>">

									<h1 class="h3 mb-3 fw-normal">Post Comments</h1>

									<div class="mb-3">
										<textarea name="Message" id="style4"></textarea>
									</div>

									<button class="btn btn-lg btn-primary" name="comment_submit" type="submit">Submit Post</button>

								</form>
							</div>
						</div>
					</div>
				</div>
			</section>

			<section class="py-5">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h1 class="h3 mb-3 fw-normal">Comments</h1>
							<table class="table table-striped table-responsive">
								<?php
								$connection = mysqli_connect("localhost", "root", "");
								$db = mysqli_select_db($connection, 'blogsite');

								$query = "SELECT * FROM tblcomments";
								$query_run = mysqli_query($connection, $query);
								?>

								<thead>
									<tr>
										<th scope="col">Message</th>
										<th scope="col">Post Date</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if ($query_run) {
										while ($row = mysqli_fetch_array($query_run)) {
									?>
											<tr>
												<th><?php echo $row['Message']; ?> </th>
												<th><?php echo $row['PostDate']; ?> </th>
											</tr>
								</tbody>
						<?php
										}
									}
						?>
							</table>
						</div>
					</div>
				</div>
			</section>
		</main>
		<script nonce="bootstrapminjs" src="js/bootstrap.min.js"></script>

		<!-- Registration Validation -->
		<script nonce="regvalidation">
			(function() {
				'use strict'

				// Fetch all the forms we want to apply custom Bootstrap validation styles to
				var forms = document.querySelectorAll('.needs-validation')

				// Loop over them and prevent submission
				Array.prototype.slice.call(forms)
					.forEach(function(form) {
						form.addEventListener('submit', function(event) {
							if (!form.checkValidity()) {
								event.preventDefault()
								event.stopPropagation()
							}

							form.classList.add('was-validated')
						}, false)
					})
			})()
		</script>
		<script nonce="checkpw">
			// Check if passwords match
			$(document).ready(function() {
				$("form").submit(function(event) {
					var password = $("#Password").val();
					var cpassword = $("#cpassword").val();
					if (password != cpassword) {
						$(".invalid-feedback").text("Passwords don't match");
						event.preventDefault();
					}
				});
			});
		</script>
		<script src="./togglepw.js"></script>

	</body>

	</html>

<?php
} else {
	header("Location: ui_admin_dashboard.php");
}
?>