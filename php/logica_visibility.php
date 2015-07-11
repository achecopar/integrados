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
} 

$type= $_GET["type"];
$entry = $_GET["entry"];
$anchor = $_GET["anchor"];

if($type=='ALL'){
	$change='FRIENDS';
} else {
	$change='ALL';
}

//Inserts the friendship
$sql="UPDATE `social_network`.`wall_entry` SET `visibility`='".$change."' WHERE `id_wall_entry`='" .$entry. "'";
	
mysqli_query($con, $sql);
	
mysqli_close($con);

//echo $sql;
header("location:../myprofile.php?anchor=".$anchor);

?>
