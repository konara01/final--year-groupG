<?php

require "studserver.php";
check_login();

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $errors = registercourse($_POST);

    if (count($errors) == 0) {
        header("Location: studdashboard.php");
        die;
    }
}
// Get the student ID from the session
$student_id = $_SESSION['USER']->student_id;
$student_query = "SELECT student_id, student_name FROM students WHERE student_id = ?";
$student = database_run($student_query, [$student_id])[0];


$lessons_query = "SELECT lecturer_id, lecturer_name, lesson_id, lesson_name FROM lessons";
$lessons = database_run($lessons_query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">


<title>create timetable</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../asset/css/style2.css" rel="stylesheet">
  <style>
  .container {
            padding-left: 400px;
        }
    </style>
</head>

<body>

  <!-- ======= Mobile nav toggle button ======= -->
  <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>

  <!-- ======= Header ======= -->
  <header id="header">
    <div class="d-flex flex-column">

      <div class="profile">

        <img src="img/<?php echo $student->image; ?>" width="40" height="100" alt="Passport Image">

        <h1>Hi <?=$_SESSION['USER']->student_name?></h1>

      </div>

      <nav id="navbar" class="nav-menu navbar">
        <ul>
          <li><a href= "studdashboard.php"><i class="bx bx-home"></i>Home</a></li>
          <li><a href="studtimetable.php"><i class="bx bx-user"></i> <span>My schedule</span></a></li>
          <li><a href="qrcds.php"><i class="bi bi-qr-code-scan"></i> <span>My scanners</span></a></li>
          <li><a href="logout.php"><i class="bi bi-qr-code-scan"></i> <span>Logout</span></a></li>

        <!--
          <li><a href="#"><i class="bi bi-file-text"></i> <span>Attendance</span></a></li>
        -->
        </ul>
      </nav>



    </div>
  </header><!-- End Header -->


<body>
    <div class="container">
        <div class="containerdivision">
            <div class="toplining">
                <div class="lowstrip"> </div>
                <h1>Choose courses</h1>
                <form action="" method="post">
                    <input class="inputboxone" type="hidden" name="student_id"
                        value="<?php echo $student->student_id; ?>" readonly><br>
                    <input class="inputboxone" type="hidden" name="student_name"
                        value="<?php echo $student->student_name; ?>" readonly><br>
                    <div class="field input" id="dropdown">
                        <input type="hidden" name="lecturer_id" id="lecturer_id" value="">
                        <input type="hidden" name="lecturer_name" id="lecturer_name" value="">
                        <label for="lesson_id">Lesson:</label>
                        <select id="lesson_id" name="lesson_id" required>
                            <!-- Options will be populated dynamically -->
                            <option></option>
                            <?php foreach ($lessons as $lesson) { ?>
                            <option value="<?php echo htmlspecialchars($lesson->lesson_id); ?>">
                                <?php echo htmlspecialchars($lesson->lesson_name); ?></option>
                            <?php } ?>
                        </select>
                        <input type="hidden" name="lesson_name" id="lesson_name" value="">
                    </div>
                    <input type="submit" name="registercourse" value="Register Courses">
                </form>
                <div>
                <h1>Your Registered Courses</h1>

                <?php
// Retrieve data from the database
    $studcourses = get_all_studco();

    // Loop through the data and display it as profile cards
    foreach ($studcourses as $studcourse) {
    ?>
    <div class="sugg-card">
        <div class="sugg-details">
            <p><strong>Course Name:</strong> <?php echo $studcourse->lesson_name; ?></p>
            <p class="sugg" ><strong>Lecturer:</strong> <?php echo $studcourse->lecturer_name; ?></p>


        </div>
    </div>
    
    <?php } ?>
            </div>
        </div>
    </div>
    <script>
        const form = document.querySelector('form');
        const lessonIdField = document.querySelector('#lesson_id');
        const lecturerIdField = document.querySelector('#lecturer_id');
        const lecturerNameField = document.querySelector('#lecturer_name');
        const lessonNameField = document.querySelector('#lesson_name');
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            form.submit();
        });
        lessonIdField.addEventListener('change', (event) => {
            const lessonId = lessonIdField.value;
            const selectedLesson = getLessonById(lessonId);
            if (selectedLesson) {
                lecturerIdField.value = selectedLesson.lecturer_id;
                lecturerNameField.value = selectedLesson.lecturer_name;
                lessonNameField.value = selectedLesson.lesson_name;
            } else {
                lecturerIdField.value = '';
                lecturerNameField.value = '';
                lessonNameField.value = '';
            }
        });
        function getLessonById(lessonId) {
            const lessons = <?php echo json_encode($lessons); ?>;
            return lessons.find(lesson => lesson.lesson_id === lessonId);
        }
    </script>
</body>

</html>
