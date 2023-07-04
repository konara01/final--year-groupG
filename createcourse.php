<?php
require "lecserver.php";
check_login();

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $errors = createLessons($_POST);

    if (count($errors) == 0) {
        header("Location: lectdashboard.php");
        die;
    }
}

// Get the lecturer ID from the session
$lecturer_id = $_SESSION['USER']->lecturer_id;
$lecturer_query = "SELECT lecturer_id, lecturer_name FROM lecturers WHERE lecturer_id = ?";
$lecturer = database_run($lecturer_query, [$lecturer_id])[0];

// Function to create lessons
// Function to create lessons
function createLessons($data)
{
    $errors = array();

    // Validate input
    if (empty($data['number']) || !is_numeric($data['number']) || $data['number'] < 1) {
        $errors[] = "Please enter a valid number of subjects";
    }

    // Check if the number of subjects is provided
    if (count($errors) == 0) {
        $numOfSubjects = intval($data['number']);

        // Get the lecturer details
        $lecturer_id = $data['lecturer_id'];
        $lecturer_name = $data['lecturer_name'];

        // Prepare the SQL statement
        $query = "INSERT INTO lessons (lecturer_id, lecturer_name, lesson_name) VALUES (?, ?, ?)";

        // Loop through the number of subjects and insert them into the database
        for ($i = 1; $i <= $numOfSubjects; $i++) {
            $lesson_name = $data['lesson_name' . $i];

            // Execute the SQL statement with the corresponding values
            database_run($query, [$lecturer_id, $lecturer_name, $lesson_name]);
        }
    }

    return $errors;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="tect/css" href="../asset/css/style2.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/form2.css">

    <title>lecturer_indexpageuosb</title>
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
    </div>

    <nav id="navbar" class="nav-menu navbar">
      <ul>
        <li><a href= "lectdashboard.php"><i class="bx bx-home"></i>Home</a></li>
        <li><a href="#"><i class="bx bx-file-blank"></i> <span>My Report</span></a></li>
        <li><a href="timetable.php"><i class="bx bx-user"></i> <span>My schedule</span></a></li>
        <li><a href="qrcodes.php"><i class="bi bi-qr-code-scan"></i> <span>My scanners</span></a></li>
        <li><a href="attend.php"><i class="bi bi-file-text"></i> <span>Attendance</span></a></li>
        <li><a href="logout.php"><i class="bi bi-file-text"></i> <span>Logout</span></a></li>

      </ul>
    </nav>



  </div>
</header><!-- End Header -->
    <div class="container">
        <div class="toplining">
            <div class="lowstrip"> </div>
            <h1>List courses you will engage in</h1>
            <form action="" method="post">
                <input class="inputboxone" type="hidden" name="lecturer_id" value="<?php echo $lecturer->lecturer_id; ?>">
                <input class="inputboxone" type="hidden" name="lecturer_name" value="<?php echo $lecturer->lecturer_name; ?>">

                <label for="number">Number of Subjects:</label>
                <input type="number" name="number" id="number" required onchange="generateInputFields()"><br><br>

                <div id="subjectFieldsContainer"></div>

                <input type="submit" name="createLessons" value="Submit Lessons">
            </form>
        </div>
    </div>
    
    <script>
        function generateInputFields() {
            var numOfSubjects = document.getElementById("number").value;
            var container = document.getElementById("subjectFieldsContainer");
            container.innerHTML = ""; // Clear existing fields

            for (var i = 1; i <= numOfSubjects; i++) {
                var label = document.createElement("label");
                label.innerHTML = "Subject " + i + ":";
                container.appendChild(label);

                var input = document.createElement("input");
                input.type = "text";
                input.name = "lesson_name" + i;
                input.required = true;
                container.appendChild(input);

                container.appendChild(document.createElement("br"));
                container.appendChild(document.createElement("br"));
            }
        }
    </script>
</body>

</html>
