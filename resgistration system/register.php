<?php 
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'student';
$DATABASE_NAME = 'userlogin';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	// Could not get the data that should have been sent.
	exit('Please complete the registration form!');
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	// One or more values are empty.
	exit('Please complete the registration form');
}

if (isset($_FILES['image'])) {
	// Get the image file name.
	$image_name = $_FILES['image']['name'];
	// Save the image file to a directory on the server.
	$image_path = '../upload/' . $image_name;
	move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
}
//  //if (isset($_FILES['image']['name']) AND !empty($_FILES['image']['name'])) {
         
         
// 	$img_name = $_FILES['image']['name'];
// 	$tmp_name = $_FILES['image']['tmp_name'];
// 	$error = $_FILES['image']['error'];
	
// 	if($error === 0){
// 		$img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
// 		$img_ex_to_lc = strtolower($img_ex);

// 		$allowed_exs = array('jpg', 'jpeg', 'png');

// 		if(in_array($img_ex_to_lc, $allowed_exs)){
// 			$new_img_name = uniqid($uname, true).'.'.$img_ex_to_lc;
			// $img_upload_path = '../upload/'.$new_img_name;
			// move_uploaded_file($tmp_name, $img_upload_path);
// 		}
// 	}
//}


// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.
	if ($stmt->num_rows > 0) {
		// Username already exists
		echo 'Username exists, please choose another!';
	} else {
		// Insert new account
        // Username doesn't exists, insert new account
        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, profilePicture) VALUES (?, ?, ?, ?)')) {
        // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
        $password = $_POST['password'];
        $stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $image_name);
        $stmt->execute();
		header("Location: /loginsystem/login.html");
        } else {
        // Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
        echo 'Could not prepare statement!';
        }
	}
	$stmt->close();
} else {
	// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
	echo 'Could not prepare statement!';
}
$con->close(); 
?>
