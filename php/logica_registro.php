<?php
session_start();

$con=mysqli_connect("127.0.0.1","root","","social_network");

if (mysqli_connect_errno($con)) { 
	echo "Failed to connect to MySQL: " . mysqli_connect_error(); 
}

$username= $_POST["username"]; 
$position= $_POST["position"];
$sector=$_POST["sector"];
$mail= $_POST["mail"];
$phone= $_POST["phone"];
$country= $_POST["country"];
$lat= $_POST["lat"];
$long= $_POST["long"];
$pass1= $_POST["pass1"];

$sql=" SELECT * FROM user WHERE email='".$mail."'";
$result = mysqli_query($con, $sql);

$usersFound=mysqli_num_rows($result);
if($usersFound==0){
	//Inserts the user
	$sql="INSERT INTO `social_network`.`user` (`email`, `name`, `position`, `sector`, `country`, `phone`, `job_place_x`, `job_place_y`, `admin`, `deleted`, `password`,`image`) VALUES ('".$mail."', '".$username."', '".$position."', '".$sector."', '".$country."', '".$phone."', '".$lat."', '".$long."', 0, 0, '".$pass1."','img/user.jpg')";
	mysqli_query($con, $sql);
		
	//Does the login
	$_SESSION["login"] = "$mail-$pass1";
	mysqli_close($con);
	header("location:../index.php");
}else{	
	// Back to register with error
	mysqli_close($con);
	header("location:../register.php");
	$_SESSION["register_error"] = "true";
}

?>
