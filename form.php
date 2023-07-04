<?php

require "lecserver.php";

$errors = array();

if($_SERVER['REQUEST_METHOD'] == "POST")
{

	$errors = signup($_POST);

	if(count($errors) == 0)
	{
		header("Location: indexx.php");
		die;
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/form2.css">


     <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">


<title>Registration form</title>

</head>


<body>

     <header id="header" class="fixed-top d-flex align-items-center  header-transparent ">
    <div class="container d-flex align-items-center justify-content-between">

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="homepage.html">Home</a></li>
          <li><a class="nav-link scrollto" href="http://localhost:3000/Login.html" target="blank">Login</a></li>
         <!--
          <li><a class="nav-link scrollto " href="#portfolio">About us</a></li>
          <li><a class="nav-link scrollto" href="#team">Team</a></li>
                  --> 
            </ul>
          </li>
        </ul>
      </nav>

    </div>
  </header>



<h2>Lecturer Registration form</h2>
<form class="conteiner" method="post" action="">

<h5>1.  Personal Info</h5>
<div>
						<?php if(count($errors) > 0):?>
							<?php foreach ($errors as $error):?>
								<?= $error?> <br>	
							<?php endforeach;?>
						<?php endif;?>
					</div>
<div class="content">


<input type="text" name="lecturer_name" size="40" class="name" aria-required="true" aria-invalid="false" placeholder="Name*">

<input type="text" name="address" size="40" class="address" aria-required="true" aria-invalid="false" placeholder="Address*">

<input type="email" name="email" size="40" class="email" aria-required="true" aria-invalid="false" placeholder="Email*">

<input type="tel" name="phone" size="40" class="phone" aria-required="true" aria-invalid="false" placeholder="Phone*">


</div>

<h5></h5>

<div class="content2">


<input type="password" id="pwd" name="password" size="40" placeholder=" create password*">
<input type="password" id="pwd" name="password2" size="40" placeholder="confirm password*">



</div>
<button type="submit" value="Submit" class="">Submit</button>
<div class="text-center p-t-136">
						<span class="txt1">Already have an account?</span>
						<a class="txt2" href="form.php">
							Login
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
</form>

    

</div>
    
</body>
</html>