<?php

// PARA EVITAR ABRIR Y CERRAR TODAS LAS CONEXIONES PASARLAS COMO PARAMETRO

// LAS SESIONES SE USAN TAMBIEN PARA SABER SI MOSTRAR LOS MENSAJES DE ERROR O NO. SI HAY DE ERROR LOGIN MOSTRAR TEXTO

session_start();

$con=mysqli_connect("127.0.0.1","root","","social_network");

if (mysqli_connect_errno($con)) { 
	echo "Failed to connect to MySQL: " . mysqli_connect_error(); 
}

if(!isset($_SESSION["login"])){
	if (isset($_COOKIE["log"])){ 
		$c = $_COOKIE["log"];
		list($usu,$pass)=explode("-",$c);
		$sql="	SELECT * 
				FROM user 
				WHERE email=\"$usu\"
				AND password=\"$pass\"";
		$result = mysqli_query($con, $sql);		
		$user = mysqli_fetch_array($result);
		$esUsuario=mysqli_num_rows($result);
		
		//Si el resultado es 1 va  a ser usuario, cualquier otra cosa no.
		// En este caso prosigue en esta página
		if($esUsuario==1){
			$_SESSION["login"] = "$usu-$pass";
		}else{
			mysqli_close($con);
			header("location:login.php");
		}
	} else {
		mysqli_close($con);
		header("location:login.php");
	}
}else{
	$login=$_SESSION["login"];
	list($usu,$pass)=explode("-",$login);
	//list($usu,$pass)=split("-",$login);
	$sql="	SELECT * 
		FROM user 
		WHERE email=\"$usu\"
		AND password=\"$pass\"";
	$result = mysqli_query($con, $sql);
	$user = mysqli_fetch_array($result);
	$esUsuario=mysqli_num_rows($result);	
	
	if($esUsuario!=1)header("location:login.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="height=height, width=width, initial-scale=1"> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
	<title>Integrados</title>
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico"/>
	
    <link href="css/general-style.css" type="text/css" rel="stylesheet" media="screen">
	<link href="css/elements-style.css" type="text/css" rel="stylesheet" media="screen">      
	<link href="css/classes.css" type="text/css" rel="stylesheet" media="screen">   
	<link href="css/media.css" type="text/css" rel="stylesheet" media="screen">  
    
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet" media="screen"/>
    
    <script src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js" type="text/javascript" ></script>
    <script src="js/slideshow.js" type="text/javascript" ></script>
</head>

<body>

<div id="contenedor">
	<div id="header">
    	<img id="logo" src="img/logo.png"/> 
        <span id="title">Integrados</span>
        <div id="container_usuario">
			<img id="img_usuario" class="bigUserImage" src="<?php echo $user['image'];?>"/>
            <div id="usuario"> Bienvenido/a, <?php echo $user['name'] ?> </div> 
            <a href="php/cerrarsesion.php" style="color:#CCC">Salir</a>      
        </div>
    </div>
	<div id="menuH">
         <ul id="menu">
            <li><a href="javascript:loadPage('wall.php')">Inicio</a>
                <ul class="submenu">
                    <li><a href="javascript:loadPage('myprofile.php')">Perfil</a></li>
                    <li><a href="javascript:loadPage('mygallery.php')">Galería</a></li>
                </ul>
            </li>
            <li><a href="javascript:loadPage('friends.php')">Amigos</a>
            <li><a href="javascript:loadPage('users.php')">Usuarios</a>
            </li>
            <li> <?php 
				if(isset($_SESSION["login_admin"]) or isset($_COOKIE["log_admin"])){
					echo "<a href=\"javascript:loadPage('adv.php')\">Anuncios</a>";
				} else {
					echo "<a href=\"#\"><img src=\"img/transparence.png\"></a>";
				}
				 ?>
            </li>
        </ul>
    </div>	
	<div id="menuV">
    	<div id="cartel-anuncio">Anuncios</div>
        <div id="slideshow">
         	<?php 
				$sql= " SELECT * FROM adv ORDER BY date DESC";				
				$entries = mysqli_query($con, $sql);
				
				for($i=0;$i<mysqli_num_rows($entries);$i++){					
					$entry = mysqli_fetch_array($entries);

					echo '<div class="anuncio">
            	    		<div class="blanco">'. $entry['date'] . '</div> 
                			<div class="mensaje"> '. $entry['message'] .' </div>
            			</div>';
				}
				mysqli_close($con);	
			?>            
        </div>
    </div>
	<div id="areaDeTrabajo"> 
    	<?php
			if(isset($_SESSION["recargar"])){ 
                $source = $_SESSION["recargar"];
				unset($_SESSION["recargar"]);
            } else {
				$source = "wall.php";
			}
			echo '<iframe id="paginas" width="100%" height="100%" src="'.$source.'" frameborder="0" allowfullscreen></iframe>';
		?>
    </div>
	<div id="pie"> 
    </div>
</div>

	<script>
		$(document).ready(function() {
			 $("img[rel]").overlay();
		});
	</script>
</body>
</html>

