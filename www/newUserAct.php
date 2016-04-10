<?php
$servername = "localhost";
$dbusername = "root";
$username = $_POST["userName"];
$password = $_POST["passWord"];
$email = $_POST["userEmail"];
$dbpassword = "";
$dbName = "myGeckoArmy";
$options = ['cost' => 12,];
$hashedPassWord = password_hash($password, PASSWORD_BCRYPT, $options);



function checkUserName($username, $servername, $dbusername, $dbpassword, $dbName) {
	$conn = new mysqli($servername, $dbusername, $dbpassword, $dbName); 
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
		} 
	$newSqlQuery = "SELECT * FROM users WHERE userName='".$username."'";
	$result = $conn->query($newSqlQuery);
	if($result->num_rows>0){
		return TRUE;
	}
	else{
		return FALSE;
	}
	$conn->close();
	
}



if (   (checkUserName($username, $servername, $dbusername, $dbpassword, $dbName)) === TRUE ){
	header("Location: newUserNameError.html"); 
	exit;
	//echo "User Already Exist";	
}
else{
	$conn = new mysqli($servername, $dbusername, $dbpassword, $dbName);
	$sql = "INSERT INTO users (userName,hashedPassWord,userEmail) VALUES ('".$username."','".$hashedPassWord."','".$email."')";
	if ($conn->query($sql) === TRUE) {
	header("Location: index.html");
    //echo "New record created successfully";
	} 
	else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

$conn->close();
}






?>