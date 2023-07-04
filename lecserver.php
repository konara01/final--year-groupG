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


	if($data['password'] != $data['password2']){
		$errors[] = "Passwords must match";
	}
    
	$check = database_run("select * from lecturers where email = :email limit 1",['email'=>$data['email']]);
	if(is_array($check)){
		$errors[] = "That email already exists";
	}

	//save
	if(count($errors) == 0){
		$arr['lecturer_name'] = $data['lecturer_name'];
		$arr['address'] = $data['address'];
		$arr['email'] = $data['email'];
		$arr['phone'] = $data['phone'];
		$arr['password'] = $data['password'];


		$query = "insert into lecturers (lecturer_name,address,email,phone,password) values 
		(:lecturer_name,:address,:email,:phone,:password)";

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
        $password = $data['password'];

        $query = "SELECT * FROM lecturers WHERE email = :email LIMIT 1";
        $row = database_run($query, $arr);

        if (is_array($row)) {
            $row = $row[0];

            if ($password === $row->password) {
                $_SESSION['USER'] = $row;
                $_SESSION['LOGGED_IN'] = true;
                $_SESSION['lecturer_id'] = $row->lecturer_id; // Store lecturer_id in the session
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




// function to retrieve all staff from the database
function get_all_attended_students() {
    $lecturer_id = $_SESSION['USER']->lecturer_id;
    $query = "SELECT * FROM attended_students WHERE lecturer_id = ?";
    return database_run($query, [$lecturer_id]);
}

function get_total_students() {
    $query = "SELECT COUNT(*) AS total_students FROM students_course WHERE lecturer_id = ?";
    $lecturer_id = $_SESSION['USER']->lecturer_id;
    $result = database_run($query, [$lecturer_id]);
    return isset($result[0]->total_students) ? $result[0]->total_students : 0;
}


function get_total_submitted_attendance() {
    $query = "SELECT COUNT(*) AS total_attendance FROM attended_students WHERE lecturer_id = ?";
    $lecturer_id = $_SESSION['USER']->lecturer_id;
    $result = database_run($query, [$lecturer_id]);
    return isset($result[0]->total_attendance) ? $result[0]->total_attendance : 0;
}

function get_total_lessons() {
    $query = "SELECT COUNT(*) AS total_lessons FROM lessons WHERE lecturer_id = ?";
    $lecturer_id = $_SESSION['USER']->lecturer_id;
    $result = database_run($query, [$lecturer_id]);
    return isset($result[0]->total_lessons) ? $result[0]->total_lessons : 0;
}

    function get_total_generated_codes() {
      $lecturer_id = $_SESSION['USER']->lecturer_id;
      $query = "SELECT COUNT(*) AS total_codes FROM qrcode WHERE lecturer_id = ?";
      $result = database_run($query, [$lecturer_id]);
      return isset($result[0]->total_codes) ? $result[0]->total_codes : 0;
  }



// function to update a staff
function update_staff($staff)
{
    $query = "UPDATE staffs SET fullname = :fullname, email = :email, phone_number = :phone_number WHERE staff_id = :staff_id";
    return database_run($query, array(
        'staff_id' => $staff['staff_id'],
        'fullname' => $staff['fullname'],
        'email' => $staff['email'],
        'phone_number' => $staff['phone_number']
    ));
}




// function to retrieve all qrcodes from the database
function get_all_qrcodes()
{
	$query = "select * from qrcode";
	return database_run($query);
}
function get_all_qrs($lecturer_id)
{
    $query = "SELECT * FROM qrcode WHERE lecturer_id = :lecturer_id";
    $params = array('lecturer_id' => $lecturer_id);
    return database_run($query, $params);
}
function get_qrcode_by_id($qrid)
{
	$query = "select * from qrcode where qrid = :qrid limit 1";
	$result = database_run($query, array('qrid' => $qrid));
	return isset($result[0]) ? $result[0] : null;
}

// function to retrieve all students from the database
function get_all_students()
{
	$query = "select * from students";
	return database_run($query);
}

function get_total_studentsreg() {
    $query = "SELECT * FROM students_course WHERE lecturer_id = ?";
    $lecturer_id = $_SESSION['USER']->lecturer_id;
    return database_run($query, [$lecturer_id]);
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


function generate_qrcode($data)
{
    $errors = array();

    // Validate the form inputs
    if (empty($data['lesson_name'])) {
        $errors[] = "Lesson name is required";
    }
    if (empty($data['date'])) {
        $errors[] = "Date is required";
    }
    if (empty($data['time'])) {
        $errors[] = "Time is required";
    }

    // Add more validation rules if needed

    // If no errors, generate the QR code and save to the database
    if (count($errors) == 0) {
        // Generate QR code
        generateQRCodeAndSaveToDatabase($data);
    }

    return $errors;
}
require_once 'vendor/autoload.php';
use Endroid\QrCode\QrCode;


function generateQRCodeAndSaveToDatabase($data)
{
    require_once 'vendor/autoload.php';

    // Create a new QR code instance
    $qrCode = new QrCode($data['lesson_name'] . ' ' . $data['date'] . ' ' . $data['time']);

    // Set the desired size of the QR code
    $qrCode->setSize(300);

    // Save the QR code as an image file
    $imagePath = 'images/' . uniqid() . '.png';
    $qrCode->writeFile($imagePath);

    // Save the QR code image path and other details to the database
    $conn = database_run(
        "INSERT INTO qrcode (lecturer_id, lecturer_name, lesson_id, lesson_name, date, time, image_name) VALUES (?, ?, ?, ?, ?, ?, ?)",
        array($data['lecturer_id'], $data['lecturer_name'], $data['lesson_id'], $data['lesson_name'], $data['date'], $data['time'], $imagePath),
        false
    );

    if ($conn) {
        echo "QR code saved successfully!";
    }
}



function createTimetable($data)
{
    $errors = array();

    // Validate inputs
    if (empty($data['day'])) {
        $errors[] = "Please enter a day";
    }

    if (empty($data['time'])) {
        $errors[] = "Please enter a time";
    }

    // Save timetable
    if (count($errors) == 0) {
        $arr['lecturer_id'] = $data['lecturer_id'];
        $arr['lecturer_name'] = $data['lecturer_name'];
        $arr['lesson_id'] = $data['lesson_id'];       
        $arr['lesson_name'] = $data['lesson_name'];
        $arr['day'] = $data['day'];
        $arr['time'] = $_POST['time'];

        $query = "INSERT INTO timetables (lecturer_id,lecturer_name,lesson_id,lesson_name,day,time) VALUES 
        (:lecturer_id,:lecturer_name,:lesson_id,:lesson_name,:day,:time)";

        database_run($query,$arr);
    }
    return $errors;
}

// Helper function to get the service name based on the ID
function get_lesson_name($lesson_id)
{
    global $lessons;
    foreach ($lessons as $lesson) {
        if ($lesson->lesson_id == $lesson_id) {
            return $lesson->lesson_name;
        }
    }
    return "";
}
function get_all_timetables($lecturer_id)
{
    $query = "SELECT * FROM timetables WHERE lecturer_id = :lecturer_id";
    $params = array('lecturer_id' => $lecturer_id);
    return database_run($query, $params);
}



?>
