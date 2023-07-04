<?php 

session_start();

function database_run($query, $vars = array(), $fetch = true)
{
    $string = "mysql:host=localhost;dbname=attendancesystem";
    $con = new PDO($string, 'root', '');
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!$con) {
        echo "Database connection failed.";
        return false;
    }

    $stm = $con->prepare($query);

    try {
        $check = $stm->execute($vars);

        if ($check) {
            // For SELECT queries, fetch and return the result set
            if ($fetch) {
                $data = $stm->fetchAll(PDO::FETCH_OBJ);

                if (count($data) > 0) {
                    return $data;
                }
            }
            // For INSERT queries, return the success status
            else {
                return true;
            }
        } else {
            // Display the error message if execution fails
            $error_info = $stm->errorInfo();
            echo "Database error: " . $error_info[2];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    return false;
}








function signup($data)
{
	$errors = array();
 
	//validate 

	if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
		$errors[] = "Please enter a valid email";
	}

	if(strlen(trim($data['password'])) < 6){
		$errors[] = "Password must be atleast 6 chars long";
	}


	// if($data['password'] != $data['password2']){
	// 	$errors[] = "Passwords must match";
	// }
    
	$check = database_run("select * from students where email = :email limit 1",['email'=>$data['email']]);
	if(is_array($check)){
		$errors[] = "That email already exists";
	}

	//save
	if(count($errors) == 0){
		$arr['student_name'] = $data['student_name'];
		$arr['address'] = $data['address'];
		$arr['email'] = $data['email'];
		$arr['phone'] = $data['phone'];
		$arr['password'] = $data['password'];

     // Process the uploaded image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = 'img/' . $image_name;

        if (move_uploaded_file($image_tmp, $image_path)) {
            $arr['image'] = $image_name;
        } else {
            $errors[] = "Failed to move the uploaded image.";
        }
    } else {
        $arr['image'] = ""; // Set a default value if no image is uploaded
    }

		$query = "insert into students (student_name,address,email,phone,password,image) values 
		(:student_name,:address,:email,:phone,:password,:image)";

		database_run($query,$arr);
	}
	return $errors;
}



function login($data)
{
    $errors = array();
 
    // Validate

    if (strlen(trim($data['password'])) < 6) {
        $errors[] = "Password must be at least 6 characters long";
    }
 
    // Check
    if (count($errors) == 0) {

		$arr['email'] = $data['email'];
		$password =  $data['password'];

		$query = "select * from students where email = :email limit 1";

		$row = database_run($query,$arr);

        if (is_array($row)) {
            $row = $row[0];

            if ($password === $row->password) {
                $_SESSION['USER'] = $row;
                $_SESSION['LOGGED_IN'] = true;
            } else {
                $errors[] = "Wrong email or password";
            }
        } else {
            $errors[] = "Wrong email or password";
        }
    }
    return $errors;
}





function check_login($redirect = true){

	if(isset($_SESSION['USER']) && isset($_SESSION['LOGGED_IN'])){

		return true;
	}

	if($redirect){
		header("Location: indexx.php");
		die;
	}else{
		return false;
	}
}

function registercourse($data)
{
    $errors = array();

    // validate

    // Check if the required fields are present
    if (empty($data['student_id']) || empty($data['student_name']) || empty($data['lecturer_id']) || empty($data['lecturer_name']) || empty($data['lesson_id']) || empty($data['lesson_name'])) {
        $errors[] = "All fields are required.";
    }

    // Save
    if (count($errors) == 0) {
        $arr['student_id'] = $data['student_id'];
        $arr['student_name'] = $data['student_name'];
        $arr['lecturer_id'] = $data['lecturer_id'];
        $arr['lecturer_name'] = $data['lecturer_name'];
        $arr['lesson_id'] = $data['lesson_id'];
        $arr['lesson_name'] = $data['lesson_name'];

        $query = "INSERT INTO students_course (student_id, student_name, lecturer_id, lecturer_name, lesson_id, lesson_name) VALUES (:student_id, :student_name, :lecturer_id, :lecturer_name, :lesson_id, :lesson_name)";

        database_run($query, $arr);
    }

    return $errors;
}






// function to retrieve all qrcodes from the database
// function get_all_qrcodes()
// {
// 	$query = "select * from qrcode";
// 	return database_run($query);
// }

function get_all_qrcodes($student_id)
{
    $query = "SELECT q.*
              FROM qrcode q
              JOIN students_course sc ON q.lesson_id = sc.lesson_id
                                      AND q.lesson_name = sc.lesson_name
              WHERE sc.student_id = :student_id;
            ORDER BY q.date DESC";

    return database_run($query, ['student_id' => $student_id]);
}


function get_total_scanned_codes() {
    // Get the student ID from the session
    $student_id = $_SESSION['USER']->student_id;
    $query = "SELECT COUNT(*) AS total_codes FROM attended_students WHERE student_id = :student_id";
    $result = database_run($query, array('student_id' => $student_id));
    return isset($result[0]->total_codes) ? $result[0]->total_codes : 0;
  }
  
  function get_total_submitted_attendance() {
    // Get the student ID from the session
    $student_id = $_SESSION['USER']->student_id;
    
    $query = "SELECT COUNT(*) AS total_attendance FROM attended_students WHERE student_id = :student_id";
    $result = database_run($query, array('student_id' => $student_id));
    return isset($result[0]->total_attendance) ? $result[0]->total_attendance : 0;
  }
  
  


  function get_student_timetables($student_id)
  {
      $query = "SELECT t.*, sc.lecturer_name, sc.lesson_name
                FROM timetables t
                JOIN students_course sc ON t.lecturer_id = sc.lecturer_id
                                      AND t.lesson_id = sc.lesson_id
                                      AND t.lesson_name = sc.lesson_name
                WHERE sc.student_id = :student_id";
  
      return database_run($query, ['student_id' => $student_id]);
  }
  



// function to retrieve all students from the database
function get_all_students()
{
	$query = "select * from students";
	return database_run($query);
}

// function to retrieve a single student by ID from the database
function get_students_by_id($student_id)
{
	$query = "select * from students where student_id = :student_id limit 1";
	$result = database_run($query, array('student_id' => $student_id));
	return isset($result[0]) ? $result[0] : null;
}

// function to delete a students from the database
function delete_students($student_id)
{
	$query = "delete from students where student_id= :student_id";
	return database_run($query, array('student_id' => $student_id));
}

// function to update a students
function update_student($student)
{
    $query = "UPDATE students SET fullname = :fullname, phone_number = :phone_number, email = :email  WHERE student_id = :student_id";
    return database_run($query, array(
        'student_id' => $student['student_id'],
        'fullname' => $student['fullname'],
        'email' => $student['email'],
        'mobile' => $student['phone_number'],
    ));
}



function get_all_studco() {
    $student_id = $_SESSION['USER']->student_id;
    $query = "SELECT * FROM students_course WHERE student_id = ?";
    return database_run($query, [$student_id]);
}

function get_total_studcourse() {
    $query = "SELECT COUNT(*) AS total_courses FROM students_course WHERE student_id = ?";
    $student_id = $_SESSION['USER']->student_id;
    $result = database_run($query, [$student_id]);
    return isset($result[0]->total_courses) ? $result[0]->total_courses : 0;
}
?>