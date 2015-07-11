<?php
session_start();

$con=mysqli_connect("127.0.0.1","root","","social_network");

if (mysqli_connect_errno($con)) { 
	echo "Failed to connect to MySQL: " . mysqli_connect_error(); 
}

if(isset($_SESSION["login"])){
	$login=$_SESSION["login"];
	list($usu,$pass)=explode("-",$login);
	$sql="	SELECT * 
		FROM user 
		WHERE email=\"$usu\"
		AND password=\"$pass\"";
	$result = mysqli_query($con, $sql);
	$user = mysqli_fetch_array($result);
		
} else {	
	mysqli_close($con);
	header("location:login.php");
}

$username= $_POST["username"]; 
$position= $_POST["position"];
$sector=$_POST["sector"];
$phone= $_POST["phone"];
$country= $_POST["country"];
$lat= $_POST["lat"];
$long= $_POST["long"];

if(isset($_POST["pass4"])){
	$pass4= $_POST["pass4"];
} else {
	$pass4 = NULL;
}


if($pass4 == NULL){
	//Updates the user without pass
	$sql="UPDATE `social_network`.`user` SET `name`='".$username."', `position`='".$position."', `sector`='".$sector."', `country`='".$country."', `phone`='".$phone."', `job_place_x`='".$lat."', `job_place_y`='".$long."', `admin`=0, `deleted`=0 WHERE `email` = '".$user['email']."';";
} else {
	//Updates the user with new pass
	$sql="UPDATE `social_network`.`user` SET `name`='".$username."', `position`='".$position."', `sector`='".$sector."', `country`='".$country."', `phone`='".$phone."', `job_place_x`='".$lat."', `job_place_y`='".$long."', `admin`=0, `deleted`=0, `password`='".$pass4."' WHERE `email` = '".$user['email']."';";
	//Updates session and cookies
	$_SESSION["login"] = $user['email']."-".$pass4;
	
	if (isset($_COOKIE["log"])){ 
		setcookie("log",$user['email']."-".$pass4, time()+6000);
	}
	
}
	//echo $sql;
	mysqli_query($con, $sql);
	
	mysqli_close($con);
	header("location:../myprofile.php?recargar=1");

?>
