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
                } else {
                    echo "No rows found in the result set.";
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


	$check = database_run("select * from admin where email = :email limit 1",['email'=>$data['email']]);
	if(is_array($check)){
		$errors[] = "That email already exists";
	}

	//save
	if(count($errors) == 0){
		$arr['admin_name'] = $data['admin_name'];
		$arr['username'] = $data['username'];
		$arr['email'] = $data['email'];
		$arr['password'] = $data['password'];


		$query = "insert into admin (admin_name,username,email,password) values 
		(:admin_name,:username,:email,:password)";

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

		$arr['username'] = $data['username'];
		$password =  $data['password'];

		$query = "select * from admin where username = :username limit 1";

		$row = database_run($query,$arr);

        if (is_array($row)) {
            $row = $row[0];

            if ($password === $row->password) {
                $_SESSION['USER'] = $row;
                $_SESSION['LOGGED_IN'] = true;
            } else {
                $errors[] = "Wrong username or password";
            }
        } else {
            $errors[] = "Wrong username or password";
        }
    }
    return $errors;
}





function check_login($redirect = true){

	if(isset($_SESSION['USER']) && isset($_SESSION['LOGGED_IN'])){

		return true;
	}
	$stuff_id = $_SESSION['USER']->stuff_id;


	if($redirect){
		header("Location: index.php");
		die;
	}else{
		return false;
	}
}




// function to retrieve all lecturer from the database
function get_all_lecturers()
{
	$query = "select * from lecturers";
	return database_run($query);
}

// function to retrieve a single lecturer by ID from the database
function get_lecturer_by_id($lecturer_id)
{
	$query = "select * from lecturers where lecturer_id = :lecturer_id limit 1";
	$result = database_run($query, array('lecturer_id' => $lecturer_id));
	return isset($result[0]) ? $result[0] : null;
}

// function to delete a lecturer from the database
function delete_lecturers($lecturer_id)
{
	$query = "delete from lecturers where lecturer_id= :lecturer_id";
	return database_run($query, array('lecturer_id' => $lecturer_id));
}

// function to update a lecturer
function update_lecturer($lecturer)
{
    $query = "UPDATE lecturers SET lecturer_name = :lecturer_name, email = :email, phone = :phone WHERE lecturer_id = :lecturer_id";
    return database_run($query, array(
        'lecturer_id' => $lecturer['lecturer_id'],
        'lecturer_name' => $lecturer['lecturer_name'],
        'email' => $lecturer['email'],
        'phone' => $lecturer['phone']
    ));
}




function get_total_submitted_attendance() {
    $query = "SELECT * FROM attended_students";
	return database_run($query);
}


function get_all_qrcodes()
{
	$query = "select * from qrcode";
	return database_run($query);
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
    $query = "UPDATE students SET student_id = :student_id, student_name = :student_name, email = :email, phone = :phone WHERE student_id = :student_id";
    return database_run($query, array(
        'student_id' => $student['student_id'],
        'student_name' => $student['student_name'],
        'email' => $student['email'],
        'phone' => $student['phone'],
    ));
}
function delete_qr($qrid)
{
	$query = "delete from qrcode where qrid= :qrid";
	return database_run($query, array('qrid' => $qrid));
}
?>