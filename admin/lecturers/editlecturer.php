<?php

include('../adminserver.php');


// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();

    // Sanitize input fields
    $lecturer_id = filter_var($_POST['lecturer_id'], FILTER_SANITIZE_NUMBER_INT);
    $lecturer_name = filter_var($_POST['lecturer_name'], FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    // $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    // Validate input fields
    if (empty($lecturer_name)) {
        $errors[] = 'full name is required';
    }
    if (empty($phone)) {
        $errors[] = 'mobilenumber is required';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address';
    }
    
    

    // If no errors, update the $staff in the database
    if (empty($errors)) {
        $staff = array(
            'lecturer_id' => $lecturer_id ,
            'lecturer_name' => $lecturer_name,
            'phone' => $phone,
            'email' => $email,
        );
        update_lecturer($staff);
        header('Location: lecturers.php');
        die();
    }}
    // Fetch staff data from the database
    $lecturer_id = $_GET['lecturer_id']; // Assuming you're passing staff_id in the URL parameter
    $staff = get_lecturer_by_id($lecturer_id);
    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit students</title>
    <link rel="stylesheet" href="style.css">

    <style>
.styled-table {
    border-collapse: separate;
    border-spacing: 0;
    width: 50%;
    margin: 0 auto; /* Center the table */
    background-color: #f2f2f2; /* Light gray background */
    box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3); /* Increased shadow */
    border-radius: 5px;
}

.styled-table td,
.styled-table th {
    padding: 10px;
    text-align: left;
}

.styled-table th {
    background-color: #e0e0e0; /* Slightly darker gray for table header */
    font-weight: bold;
}

.errors {
    color: red;
    margin-bottom: 10px;
}

.btn {
    background-color: #3498db;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
}

.btn:hover {
    background-color: #2980b9;
}
h2{
    text-align: center;
    color: firebrick;
}

    </style>
</head>
<body>
<div class="content">
    <h2>Edit stuffs</h2>
    <?php if (!empty($errors)) { ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="hidden" name="lecturer_id" value="<?php echo $staff->lecturer_id; ?>">
        <table class="styled-table">
            <tr>
                <td><label for="fullname">Full Name:</label></td>
                <td><input type="text" name="lecturer_name" value="<?php echo htmlspecialchars($staff->lecturer_name); ?>"></td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td>
                <td><input type="email" name="email" value="<?php echo htmlspecialchars($staff->email); ?>"></td>
            </tr>
            <tr>
                <td><label for="mobilenumber">mobilenumber:</label></td>
                <td><input type="text" name="phone" value="<?php echo htmlspecialchars($staff->phone); ?>"></td>
            </tr>
   
          
                <td><input class="btn" type="submit" name="update_lecturer" value="Update Staff" required></td>
            </tr>
        </table>
    </form>
</div>
