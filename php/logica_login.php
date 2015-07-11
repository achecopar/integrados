<?php
session_start();

$con=mysqli_connect("127.0.0.1","root","","social_network");

if (mysqli_connect_errno($con)) { 
	echo "Failed to connect to MySQL: " . mysqli_connect_error(); 
}

$username= $_POST["username"]; 
$pass= $_POST["pass"];
$recordarme=$_POST["recordarme"];

$sql="	SELECT * 
		FROM user 
		WHERE email=\"$username\"
		AND password=\"$pass\"
		AND deleted=0";
		
$result = mysqli_query($con, $sql);
$esUsuario=mysqli_num_rows($result);
$user=mysqli_fetch_array($result);
if($esUsuario==1){
	$_SESSION["login"] = "$username-$pass";
	if($user['admin']==true){		
		$_SESSION["login_admin"] = "$username-$pass";
		if ($recordarme=="true")setcookie("log_admin","$username-$pass", time()+6000);
	}	
	
	if ($recordarme=="true")setcookie("log","$username-$pass", time()+6000);
	mysqli_close($con);
	
	header("location:../index.php");
}else{	
	mysqli_close($con);
	header("location:../login.php");
	$_SESSION["login_error"] = "true";
}
?>
