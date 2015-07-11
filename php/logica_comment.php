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

$message = $_POST["comment"];
$origin = $_POST["origin"];
$id_wall_entry = $_POST["id_wall_entry"];

if($message!=""){
	$sql="INSERT INTO `social_network`.`comment` (`id_comment`, `id_wall_entry`,`date`, `message`, `deleted`, `user_email`) VALUES (NULL, '".$id_wall_entry."', NOW(), '".$message."', '0', '".$user['email']."');";
		
	mysqli_query($con, $sql);
}
	
mysqli_close($con);
header("location:../".$origin);

?>
