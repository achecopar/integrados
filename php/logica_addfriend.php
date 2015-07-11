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
	$sql="	SELECT * 
		FROM user 
		WHERE email=\"$mail\"
		AND password=\"$pass\"";
	$result = mysqli_query($con, $sql);
	$user = mysqli_fetch_array($result);
}
 
$friend = $_GET["friend"];
$friend_name = $_GET["friend_name"];

if($mail!=$friend){
	// Mira si la amistad ya existe
	$sql = "SELECT * FROM friendship
			WHERE email_adder = '". $mail."' 
			AND email_added = '". $friend."'";
	$friendship = mysqli_query($con,$sql);

	if(mysqli_num_rows($friendship)==0){	
		//Inserts the friendship
		$sql="INSERT INTO `social_network`.`friendship` (`email_adder`, `email_added`) VALUES ('" .$mail. "', '". $friend ."');";
	
		mysqli_query($con, $sql);

		$from = "noreply@integrados.com";
		$headers = "From: Contacto Web <".$from.">\r\n";
		mail ("<".$friend.">", 'Integrados Friendship notice' , $friend_name . ', '.$user['name'].' te ha agregado a sus amigos.',$headers);
	} else {
		$_SESSION["friendship_error"] = "Ya tenías a esta persona entre tus amigos";	
	}
} else {
	$_SESSION["friendship_error"] = "No puedes agregarte a tí mismo";
}

mysqli_close($con);

header("location:../friends.php?name=".$friend_name);

?>
