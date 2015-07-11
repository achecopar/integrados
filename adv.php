<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link href="css/elements-style.css" type="text/css" rel="stylesheet" media="screen">      
	<link href="css/classes.css" type="text/css" rel="stylesheet" media="screen"> 
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet" media="screen"/>
	<title>Untitled Document</title>
    
    <script src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js" type="text/javascript" ></script>
    <script src="js/slideshow.js" type="text/javascript" ></script>
</head>

<body>
<?php
session_start();

$con=mysqli_connect("127.0.0.1","root","","social_network");

if (mysqli_connect_errno($con)) { 
	echo "Failed to connect to MySQL: " . mysqli_connect_error(); 
}

if(isset($_GET['recargar'])){
	$_SESSION['recargar']='adv.php';
	echo '<script> parent.location.reload(); </script>';
}

if(isset($_SESSION["login_admin"])){
	$login=$_SESSION["login_admin"];
	list($usu,$pass)=explode("-",$login);
	$sql="SELECT * 
		FROM user 
		WHERE email=\"$usu\"
		AND password=\"$pass\"";
	$result = mysqli_query($con, $sql);
	$user = mysqli_fetch_array($result);
		
} else {	
	mysqli_close($con);
	header("location:login.php");
}

if(isset($_GET['delete'])){
	$sql = "DELETE FROM adv WHERE id=".$_GET['delete'];
	mysqli_query($con,$sql);
	header("location:adv.php?recargar=1");
}
?>
			
    	<center>
        	
           			 <form action="php/logica_anuncio.php" method="post" name="advForm" id="advForm" >           	
                        <div class="blanco" style="margin-top:3%;"> Agregar anuncio
                            <img class="smallImage" src="img/send.png" onclick="submitForm('advForm')"/>
                        </div>                        
                		<textarea id="message" name="message" required></textarea> 
                     </form>
            <?php 
				$sql= " SELECT * FROM adv ORDER BY date DESC";				
				$entries = mysqli_query($con, $sql);
				
				for($i=0;$i<mysqli_num_rows($entries);$i++){					
					$entry = mysqli_fetch_array($entries);

					echo '<div class="element-box">
							<img onclick="location.href=\'adv.php?delete='. $entry['id'] . '\';" class="sendImage" src="img/delete.png"></img >
							<div class="heading">
								<img class="userImage" src="img/logo.png"></img >
								<div class="date"> La Empresa publicó en la fecha ' . $entry['date'] . '</div> 
							</div>                 
							<div class="message"> '. $entry['message'] .' </div>
						</div>';
				}
			?>      
            
        </center>
</body>
</html>
