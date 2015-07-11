<?php
session_start();

// Verifica que el usuario esté logueado
if(!isset($_SESSION["login"])){	
	mysqli_close($con);
	header("location:login.php");
} else {
	$login=$_SESSION["login"];
	list($from,$pass)=explode("-",$login);	
}
 
$to = $_POST["to"];
$mail = $_POST["mail"];

$headers = "From: <".$from.">\r\n";
mail ("<".$to.">", 'Message sent through Integrados' , $mail,$headers);
	
header("location:../profile.php?email=".$to);

?>
