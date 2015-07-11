<?php
session_start();

$con=mysqli_connect("127.0.0.1","root","","social_network");

if (mysqli_connect_errno($con)) { 
	echo "Failed to connect to MySQL: " . mysqli_connect_error(); 
}

if(isset($_SESSION["login_admin"])){
	$login=$_SESSION["login_admin"];
	list($usu,$pass)=explode("-",$login);
	$sql="SELECT * 
		FROM user 
		WHERE email=\"$usu\"
		AND password=\"$pass\"";
	$result = mysqli_query($con, $sql);
	$user = mysqli_fetch_array($result);
		
} else {	
	mysqli_close($con);
	header("location:login.php");
}

$message = $_POST["message"];

	$sql="INSERT INTO `social_network`.`adv` (`id`, `date`, `message`) VALUES (NULL, NOW(), '".$message."');";
	
	mysqli_query($con, $sql);
	
	mysqli_close($con);
	header("location:../adv.php?recargar=1");

?>
