<?php  


require "lecserver.php";

$errors = array();

if($_SERVER['REQUEST_METHOD'] == "POST")
{

	$errors = generate_qrcode($_POST);

	if(count($errors) == 0)
	{
		header("Location: lectdashboard.php");
		die;
	}
}
// Get the lecturer ID from the session
$lecturer_id = $_SESSION['USER']->lecturer_id;
$lecturer_query = "SELECT lecturer_id, lecturer_name FROM lecturers WHERE lecturer_id = ?";
$lecturer = database_run($lecturer_query, [$lecturer_id])[0];

$lessons_query = "SELECT lesson_id, lesson_name FROM lessons WHERE lecturer_id = ?";
$lessons = database_run($lessons_query, [$lecturer_id]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="tect/css" href="../asset/css/style2.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/form2.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet"> -->

  <!-- Template Main CSS File -->
<title>Qr code generation Form</title>

</head>

<body>

  <!-- ======= Mobile nav toggle button ======= -->
  <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>

  <!-- ======= Header ======= -->
  <header id="header">
    <div class="d-flex flex-column">

      <div class="profile">

        <img src="../assets/img/profile-img.jpg" alt="" class="img-fluid rounded-circle">

        <h1 class="text-light"><a href="index.html">prof.</a></h1>
        <div class="social-links mt-3 text-center">
         <!--
          <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
          <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
          <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
          <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
          <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
        -->
        </div>
      </div>

      <nav id="navbar" class="nav-menu navbar">
        <ul>
          <li><a href= "lectdashboard.php"><i class="bx bx-home"></i>Home</a></li>
          <li><a href="timetable.php"><i class="bx bx-user"></i> <span>My schedule</span></a></li>
          <li><a href="qrcodes.php"><i class="bi bi-qr-code-scan"></i> <span>My scanners</span></a></li>
          <li><a href="attend.php"><i class="bi bi-file-text"></i> <span>Attendance</span></a></li>
          <li><a href="logout.php"><i class="bi bi-file-text"></i> <span>Logout</span></a></li>

        </ul>
      </nav>

    </div>
  </header><!-- End Header -->

<h2>Qrcode generation</h2>
<form class="conteiner" method="post" action="">

<div>
						<?php if(count($errors) > 0):?>
							<?php foreach ($errors as $error):?>
								<?= $error?> <br>	
							<?php endforeach;?>
						<?php endif;?>
					</div>
<div class="content">
        <input class="inputboxone" type="hidden" name="lecturer_id" value="<?php echo $lecturer->lecturer_id; ?>" readonly><br>
        <input class="inputboxone" type="hidden" name="lecturer_name" value="<?php echo $lecturer->lecturer_name; ?>" readonly><br>
            <div class="field input" id="dropdown">
            <label for="lesson_id">Lesson:</label>
            <select id="lesson_id" name="lesson_id" required>
                <!-- Options will be populated dynamically -->
                <?php foreach ($lessons as $lesson) { ?>
                <option value="<?php echo htmlspecialchars($lesson->lesson_id); ?>"><?php echo htmlspecialchars($lesson->lesson_name); ?></option>
                <?php } ?>
            </select>
            <input type="hidden" name="lesson_name" id="lesson_name" value="">

            </div>
</div>

<div class="content2">

<input type="date" id="pwd" name="date" size="40" >
<input type="time" id="pwd" name="time" size="40" >

</div>
<button type="submit" value="Submit" class="">Generate QR</button>

</form>

    

</div>
        <script>
    const form = document.querySelector('form');
    const lessonNameField = document.querySelector('#lesson_name');
    const lessonIdField = document.querySelector('#lesson_id');
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const lessonId = lessonIdField.value;
        const lessonName = getLessonName(lessonId);
        lessonNameField.value = lessonName;
        form.submit();
    });
    function getLessonName(lessonId) {
        <?php
        // Generate a JavaScript object that maps lesson IDs to lesson names
        $lessonMap = [];
        foreach ($lessons as $lesson) {
            $lessonMap[$lesson->lesson_id] = $lesson->lesson_name;
        }
        echo 'const lessonMap = ' . json_encode($lessonMap) . ';';
        ?>
        return lessonMap[lessonId] || '';
    }
</script>
</body>
</html>