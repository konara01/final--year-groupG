<?php

require "adminserver.php";

$errors = array();

if($_SERVER['REQUEST_METHOD'] == "POST")
{

	$errors = signup($_POST);

	if(count($errors) == 0)
	{
		header("Location: index.php");
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


<input type="text" name="admin_name" size="40" class="name" aria-required="true" aria-invalid="false" placeholder="Full Name*">

<input type="text" name="username" size="40" class="address" aria-required="true" aria-invalid="false" placeholder="Username*">

<input type="email" name="email" size="40" class="email" aria-required="true" aria-invalid="false" placeholder="Email*">



</div>

<h5></h5>

<div class="content2">


<input type="password" id="pwd" name="password" size="40" placeholder=" create password*">



</div>
<button type="submit" value="Submit" class="">Submit</button>
<div class="text-center p-t-136">
						<span class="txt1">Already have an account?</span>
						<a class="txt2" href="index.php">
							Login
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
</form>

    

</div>
    
</body>
</html>