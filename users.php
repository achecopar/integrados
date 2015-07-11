
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link href="css/elements-style.css" type="text/css" rel="stylesheet" media="screen">      
	<link href="css/classes.css" type="text/css" rel="stylesheet" media="screen"> 
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet" media="screen"/>
	<title>Untitled Document</title>
    
    <script src="js/slideshow.js" type="text/javascript" ></script>
    
</head>

<body>		
    	<center>
       
        <?php 
// Pongo el PHP luego del encabezado del HTML para poder hacer echos y que se vean en pantalla, por debugging
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

// Base de la búsqueda
$sql="	SELECT * 
		FROM user 
		WHERE deleted=0";

// Agrega los demás parámetros. 

// Obtuvo los parámetros del form
if(isset($_POST["busqueda"])){	

	$type = $_POST["busqueda"];
	$sector = $_POST["sector"];
	$country = $_POST["country"];
	$term = $_POST["userSearch"];	
		
} else { //Sino búsqueda todos por defecto

	$sector = "all";
	$country = "all";
	$type = "nombre";
	$term = "";	
	
}

$term = trim($term);

//echo "sector:".$sector.", country:".$country.", type:".$type.", term:".$term;

	// Realiza la búsqueda
	if($term != ""){
		if($type == "nombre"){
			$sql = $sql." AND name LIKE '%".$term."%'";
		} else { //mail, son 2 radio buttons		
			$sql = $sql." AND email LIKE '%".$term."%'";
		}		
	}
	
	if($country != "all"){
			$sql = $sql." AND country=\"$country\"";
	}
		
	if($sector != "all"){
			$sql = $sql." AND sector=\"$sector\"";
	}	
	
	// Resultado de búsqueda por orden alfabético
	$sql = $sql . " ORDER BY name ASC";
	
//	echo $sql;	
	$result = mysqli_query($con, $sql);			
	mysqli_close($con);

?>

        	<div class="blanco" style="max-width:600px"> 
                <div> Buscar usuarios
                	<img class="smallImage" src="img/lupa.png" onclick="submitForm('searchUserForm')"/>
            	</div>
            </div>   
            <form action="users.php" method="post" name="searchUserForm" id="searchUserForm">        
                <textarea id="userSearch" name="userSearch"> <?php echo $term ?></textarea>                       
                <div class="blanco" style="max-width:600px">
                    <input type="radio" name="busqueda" value="nombre" <?= $type == 'nombre' ? ' checked="checked"' : '';?>>Nombre
                    <input type="radio" name="busqueda" value="mail" <?= $type == 'mail' ? ' checked="checked"' : '';?>>Dirección de correo
                    País
                    <select name="country" class="negro">
                      <option value="Uruguay" <?= $country == 'Uruguay' ? ' selected="selected"' : '';?>>Uruguay</option>
                      <option value="Brasil" <?= $country == 'Brasil' ? ' selected="selected"' : '';?>>Brasil</option>country
                      <option value="Argentina" <?= $country == 'Argentina' ? ' selected="selected"' : '';?>>Argentina</option>
                      <option value="Chile" <?= $country == 'Chile' ? ' selected="selected"' : '';?>>Chile</option>
                      <option value="all" <?= $country == 'all' ? ' selected="selected"' : '';?>>Todos</option>
                    </select>
                    Sector
                    <select name="sector" class="negro">
                      <option value="Recursos Humanos" <?= $sector == 'Recursos Humanos' ? ' selected="selected"' : '';?>>RRHH</option>
                      <option value="Ventas" <?= $sector == 'Ventas' ? ' selected="selected"' : '';?>>Ventas</option>
                      <option value="Soporte" <?= $sector == 'Soporte' ? ' selected="selected"' : '';?>>Soporte</option>
                      <option value="Gerencia" <?= $sector == 'Gerencia' ? ' selected="selected"' : '';?>>Gerencia</option>
                      <option value="Informática" <?= $sector == 'Informática' ? ' selected="selected"' : '';?>>Informática</option>
                      <option value="all" <?= $sector == 'all' ? ' selected="selected"' : '';?>>Todos</option>
                    </select>
                </div>   
            </form>               
            <div class="blanco" style="margin-top:3%"> Resultados </div>  
            <?php 
				for($i=0;$i<mysqli_num_rows($result);$i++){			
					$user = mysqli_fetch_array($result);
					
					$delete = "";
					if(isset($_SESSION['login_admin'])){
						$delete = '<img onclick="location.href=\'php/logica_deluser.php?email='. $user['email'] . '\';" class="sendImage" src="img/delete.png"></img >';
					}
					
					echo '<div class="element-box">'.$delete.'
									<img class="userImage" src="' . $user['image'] . '"></img >
									<a href="profile.php?email=' . $user['email'] . '"> 
										<div>' . $user['name'] . '</div>                  
									</a>  									
									<div class="profession"> ' . $user['email'] . ', ' . $user['position']. ' </div>
						 </div>';
				}
			?>
       </center>
</body>
</html>
