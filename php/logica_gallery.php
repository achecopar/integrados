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

$message = $_POST["message"];
if($message==''){
	mysqli_close($con);	
	$_SESSION["gallery_error"] = "No puede publicar una imagen sin nombre";
	header("location:../mygallery.php");
}

$image = "NULL";
$image_name = "NULL";
if(isset($_FILES["galleryImage"])){
	$image_name= $message;
	$image_type= $_FILES["galleryImage"]["type"];
	$image_size= $_FILES["galleryImage"]["size"];
	
	if($_FILES["galleryImage"]["size"]!=0){
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
			if (move_uploaded_file($_FILES['galleryImage']['tmp_name'],"../img/".$image.".jpg")){ 
				//redimensionar(imagen origen, destino, tamano , calidad)
				redimensionar("../img/".$image.".jpg","../img/".$image.".jpg",500, 100);
			}else{
				mysqli_close($con);	
				$_SESSION["gallery_error"] = "No se pudo guardar la imagen";
				header("location:../mygallery.php");
			}	
		}else{
			mysqli_close($con);	
			$_SESSION["gallery_error"] = "La imagen debe tener formato jpeg y no ser mayor a 2MB";
			header("location:../mygallery.php");
		}
	} else {
		// Do nothing as there is no image uploaded	
	}	
} 

	$sql="INSERT INTO `social_network`.`gallery` (`id_media`, `media_date`,`media_name`,`media_owner`,count) VALUES ('".$image."', NOW(), '".$image_name."', '".$user['email']."',".$count.");";
	echo $sql;
	mysqli_query($con, $sql);
	
	mysqli_close($con);
	header("location:../mygallery.php");

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
	watermark($img_nuevo, $nuevo_ancho, $nuevo_alto);

}

function watermark($img_original, $ancho, $alto)
{
	$src = imagecreatefromjpeg($img_original);
	$wat = imagecreatefrompng('../img/water.png');
	$watermark_with = imagesx($wat);
	$watermark_height = imagesy($wat);
	$dest_x = $ancho - $watermark_with;
	$dest_y = $alto - $watermark_height;
	imagecopymerge($src, $wat, $dest_x, $dest_y, 0,0, $watermark_with, $watermark_height, 20);
	ImageJPEG($src,$img_original,100);
}
?>
