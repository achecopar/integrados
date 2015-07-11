<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link href="../css/elements-style.css" type="text/css" rel="stylesheet" media="screen">      
	<link href="../css/classes.css" type="text/css" rel="stylesheet" media="screen"> 
    <link href="../css/bootstrap.css" type="text/css" rel="stylesheet" media="screen"/>    
</head>

<body>
<center>
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

$delete= $_POST["image"];
$origin = $_POST["origin"];

// Si es solo de la galeria
if(strpos($delete,'g') !== false){		
	$sql="DELETE FROM `social_network`.`gallery` WHERE `id_media`='" .$delete ."'";
	mysqli_query($con, $sql);
	mysqli_close($con);
	echo $origin;
	header("location:../".$origin);
	
} else {
	// Obtiene post asociado y crea formulario confirmación
	$sql="SELECT * FROM `social_network`.`wall_entry` WHERE `image`='" .$delete ."'";
	$result = mysqli_query($con, $sql);
	$entry = mysqli_fetch_array($result);
	echo '<form action="logica_delpost.php" method="post" name="delpost_'.$entry['id_wall_entry'].'" id="delpost_'.$entry['id_wall_entry'].'">                       
		<textarea name="origin" style="display:none;">'.$origin.'</textarea>
		<textarea name="id_wall_entry" style="display:none;">'. $entry['id_wall_entry'] .'</textarea> 
		<input type="submit" value="Eliminar post asociado">
        <input type="button" value="Cancelar acción" onclick="javascript:location.href=\'../'.$origin.'\'">        		
	  </form>';
}

mysqli_close($con);

?></center>     
</body>
</html>