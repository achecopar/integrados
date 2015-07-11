<?php
session_start();

$con=mysqli_connect("127.0.0.1","root","","social_network");

if (mysqli_connect_errno($con)) { 
	echo "Failed to connect to MySQL: " . mysqli_connect_error(); 
}

// Verifica que el usuario esté logueado
if(!isset($_SESSION["login"])){	
	mysqli_close($con);
	header("location:login.php");
} else {
	$login=$_SESSION["login"];
	list($mail,$pass)=explode("-",$login);	
	
}

$delete= $_POST["id_comment"];
$origin = $_POST["origin"];

//Deletes the comment
$sql="DELETE FROM `social_network`.`comment` WHERE `id_comment`='" .$delete ."'";
	
mysqli_query($con, $sql);
	
mysqli_close($con);

//echo $sql;
header("location:../".$origin);

?>
