<?php  

require "studserver.php";

$errors = array();

if($_SERVER['REQUEST_METHOD'] == "POST")
{

	$errors = login($_POST);

	if(count($errors) == 0)
	{
		header("Location: studdashboard.php");
		die;
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<!-- <link rel="stylesheet" type="text/css" href="css/util.css"> -->
	<link rel="stylesheet" type="text/css" href="../css/main.css">
<!--===============================================================================================-->
<!-- <link href="assets/css/style.css" rel="stylesheet"> -->
<!-- <link rel="stylesheet" type="text/css" href="form2.css"> -->


</head>
<body>

	<header id="header" class="fixed-top d-flex align-items-center  header-transparent ">
        <div class="container d-flex align-items-center justify-content-between">
    
        </div>
      </header> 


	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="../css/avatar.png" alt="IMG">
				</div>

				<form method="post" class="login100-form validate-form">
					<span class="login100-form-title">
						Member Login
					</span>
					<div>
						<?php if(count($errors) > 0):?>
							<?php foreach ($errors as $error):?>
								<?= $error?> <br>	
							<?php endforeach;?>
						<?php endif;?>
					</div>
						<!-- <p>select user Roles</p> -->

					<!-- <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
					<select class="drop" type="text" id="country" name="">
						<span class="focus-input100"></span>
					  <option name value="lecturer">lecturer</option>
					  <option value="student">Student</option>
					</select>
					</div> -->

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="text" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button type="submit"  value="Login" class="login100-form-btn">
							Login
						</button>
					</div>

<p>  </p>
					<div class="text-center p-t-136">
						<span class="txt1">don't have an account?</span>
						<a class="txt2" href="form.php">
							sign up
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

</body>
</html>