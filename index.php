<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title></title>
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css" href="assets/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="assets/css/feathericon.min.css">
	<link rel="stylesheet" href="assets/plugins/morris/morris.css">
	<link rel="stylesheet" href="assets/css/style.css"> </head>

<body>
	<div class="main-wrapper login-body">
		<div class="login-wrapper">
			<div class="container">
				<div class="loginbox">
					<div class="login-left"> <img class="img-fluid" src="assets\img\logo\jayga-01.png" alt="Logo"> </div>
					<div class="login-right">
						<div class="login-right-wrap">
							<h1>Login</h1>
							<p class="account-subtitle">Welcome, Admin</p>
							<form action="crud/login_backend.php" method ="post">
								<div class="form-group">
									<input class="form-control" type="text" placeholder="Username" name="name"> </div>
								<div class="form-group">
									<input class="form-control" type="password" placeholder="Password" name="password"> </div>
								<div class="form-group">
									<button class="btn btn-primary btn-block" type="submit">Login</button>
								</div>
										<?php 
											//If User Failed To log in then show error message.
											if(isset($_SESSION['loginError'])) {
											?>
											<div>
												<p class="text-center">Invalid Email/Password! Try Again!</p>
											</div>
											<?php
											unset($_SESSION['loginError']); }
										?>

							</form>
							<div class="text-center forgotpass"><a href="forgot-password.php">Forgot Password?</a> </div>
							<!-- <div class="login-or"> <span class="or-line"></span> <span class="span-or">or</span> </div> -->
							<!-- <div class="social-login"> <span>Login with</span> <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a><a href="#" class="google"><i class="fab fa-google"></i></a> </div> -->
							<!-- <div class="text-center dont-have">Don’t have an account? <a href="register.php">Register</a></div> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="assets/js/jquery-3.5.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/js/script.js"></script>
</body>

</html>