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
if(isset($_SESSION["login"])){
	$login=$_SESSION["login"];
	list($usu,$pass)=explode("-",$login);
	$sql="	SELECT * 
		FROM user 
		WHERE email=\"$usu\"
		AND password=\"$pass\"";
	$result1 = mysqli_query($con, $sql);
	$user = mysqli_fetch_array($result1);
	
} else {	
	mysqli_close($con);	
	header("location:login.php");
}

// Base de la búsqueda
$sql="	SELECT * 
		FROM user 
		INNER JOIN friendship ON email_added=email
		WHERE email_adder='".$user['email']."'";

// Obtuvo los parámetros del form
if(isset($_GET["name"])){	

	$name = $_GET["name"];
	if(trim($name)!=""){
		$sql = $sql . " AND name LIKE '%" . $name . "%'	";
	}
	
} else { //Sino búsqueda todos 
	$name = "";
}

$sql = $sql . " ORDER BY name ASC";
	
	//echo $sql;
$result = mysqli_query($con, $sql);			
mysqli_close($con);

?>			
        	<div style="max-width:600px"> 
                <div class="blanco"> Buscar amigos
                	<img class="smallImage" src="img/lupa.png" onclick="submitForm('searchFriendForm')"/>
            	</div>
            </div>   
            <form action="friends.php" method="get" name="searchFriendForm" id="searchFriendForm">
            	<textarea name="name" id="name"><?php echo $name; ?></textarea>   
            </form>         
            <div style="max-width:600px"> 
                <div class="blanco" style="margin-top:3%"> Mis amigos	</div>              
            </div>     
            <?php                        
                            if(isset($_SESSION["friendship_error"])){ 
								$error = $_SESSION["friendship_error"];
                                echo('<br> <div style="color:red;"> '. $error.' </div> ');
                                unset($_SESSION["friendship_error"]);
                            }
			?>   
            <?php 
				for($i=0;$i<mysqli_num_rows($result);$i++){			
					$user = mysqli_fetch_array($result);
					echo '<div class="element-box">
								<img onclick="location.href=\'php/logica_delfriend.php?email='. $user['email'] . '\';" class="sendImage" src="img/delete.png"></img >
								<img class="userImage" src="' . $user['image'] . '"></img >
								<div class="heading">
									<a href="profile.php?email=' . $user['email'] . '"> 
										<div>' . $user['name'] . '</div>                  
									</a>  
									<div class="profession" style="margin-bottom:5px;"> ' . $user['position'] . ' </div>
								</div>
						 </div>';
				}
			?>    
       </center>
</body>
</html>
