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

$type= $_GET["type"];
$origin = $_GET["origin"];
$id_wall_entry = $_GET["id_wall_entry"];
if(isset($_GET["anchor"])){
	$addAnchor=true;
} else {
	$addAnchor=false;
}

if($type=='Me gusta'){	
	//Inserts the like
	$sql="INSERT INTO `social_network`.`like_wall` (`id_wall_entry`,`user_email`) VALUES ('".$id_wall_entry."','".$mail."')";	
} else {
	//Deletes the like
	$sql="DELETE FROM `social_network`.`like_wall` WHERE `id_wall_entry`='" .$id_wall_entry. "' AND user_email='".$mail."'";
}
	
mysqli_query($con, $sql);
	
mysqli_close($con);

//echo $sql;
if($addAnchor){
	header("location:../".$origin."&anchor=".$_GET['anchor']);
} else {
	header("location:../".$origin);
}
?>
