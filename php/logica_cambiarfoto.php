<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link href="../css/elements-style.css" type="text/css" rel="stylesheet" media="screen">      
	<link href="../css/classes.css" type="text/css" rel="stylesheet" media="screen"> 
    <link href="../css/bootstrap.css" type="text/css" rel="stylesheet" media="screen"/>
    
	<script src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js" type="text/javascript" ></script>
    <script src="../js/slideshow.js" type="text/javascript" ></script>
    
</head>

<body>
<center>

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
	header("location:../login.php");
}

$image = "NULL";
if(isset($_FILES["fotoImage"])){
	$image_type= $_FILES["fotoImage"]["type"];
	$image_size= $_FILES["fotoImage"]["size"];
	
	if($_FILES["fotoImage"]["size"]!=0){
		//controlo el tipo y el tamano del archivo
		if(strpos($image_type, "jpeg") and $image_size=2000000){
			//Controlo que exista el directorio donde voy a subir el archivo, sino existe lo creo
			if (!file_exists ("../img")){
				mkdir("../img");
			}
						
			//Obtiene el número de imagen siguiente y lo guarda en $image
			$sql = "SELECT MAX(count) AS max,1 FROM social_network.gallery";
			$result = mysqli_query($con, $sql);
			$image = mysqli_fetch_array($result);
			echo $image['max'];
			if($image['max']==NULL){
				$count=1;
				$image = "g".$count;
			} else {
				$count = $image['max'] + 1;
				$image = "g".$count;
			}
			
			//Subo el archivo
			if (move_uploaded_file($_FILES['fotoImage']['tmp_name'],"../img/".$image.".jpg")){ 
				//redimensionar(imagen origen, destino, tamano , calidad)
				redimensionar("../img/".$image.".jpg","../img/".$image.".jpg",500, 100);
				$sql="INSERT INTO `social_network`.`gallery` (`id_media`, `media_date`,`media_name`,`media_owner`,count) VALUES ('".$image."', NOW(), 'Foto de perfil', '".$user['email']."',".$count.");";
				echo $sql;
				mysqli_query($con, $sql);
				
				$sql="UPDATE `social_network`.`user` SET `image`='img/".$image.".jpg' WHERE email='".$user['email']."';";
				echo $sql;
				mysqli_query($con, $sql);
				
				mysqli_close($con);
				header("location:../myprofile.php?recargar=1");
			}else{
				mysqli_close($con);	
				$_SESSION["post_error"] = "No se pudo guardar la imagen";
				header("location:../myprofile.php");
			}	
		}else{
			mysqli_close($con);	
			$_SESSION["post_error"] = "La imagen debe tener formato jpeg y no ser mayor a 2MB";
			header("location:../myprofile.php");
		}
	} else {
		mysqli_close($con);	
		$_SESSION["post_error"] = "Agregue una imagen de perfil con el icono a la izquierda de cambiar foto";
		header("location:../myprofile.php");
	}	
} 	

function redimensionar($img_original, $img_nuevo, $img_tam, $imagen_nueva_calidad){
	$datos = getimagesize($img_original);
	$ancho=$datos[0];
	$alto=$datos[1];
	
	if($ancho > $alto){
		$nuevo_ancho = $img_tam;
		$radio = $ancho/$img_tam;
		$nuevo_alto = $alto/$radio;
	}else{
		$nuevo_alto = $img_tam;
		$radio = $alto/$img_tam;
		$nuevo_ancho = $ancho/$radio;		
	}
	
	$img = imagecreatefromjpeg($img_original);
	$tapiz = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
	imagecopyresized($tapiz, $img,0,0,0,0,$nuevo_ancho,$nuevo_alto,imagesx($img),imagesy($img));
	imagejpeg($tapiz,$img_nuevo,$imagen_nueva_calidad);
}
?></center>     
</body>
</html>

