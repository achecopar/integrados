<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link href="css/elements-style.css" type="text/css" rel="stylesheet" media="screen">      
	<link href="css/classes.css" type="text/css" rel="stylesheet" media="screen"> 
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet" media="screen"/>
    
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

if(isset($_SESSION["login"])){
	$login=$_SESSION["login"];
	list($usu,$pass)=explode("-",$login);
	$sql="	SELECT * 
		FROM user 
		WHERE email=\"$usu\"
		AND password=\"$pass\"";
	$result = mysqli_query($con, $sql);
	$user = mysqli_fetch_array($result);
	
	if(!isset($_GET["email"]) or !isset($_GET['owner'])){	
		mysqli_close($con);
		header("location:myprofile.php");
	} else {
		$email = $_GET['email'];
		$owner = $_GET['owner'];
	}
	
	$sql2= " SELECT image,image_name,date FROM `wall_entry`
			WHERE email_owner = '".$email."'
			AND image IS NOT NULL
			UNION
			SELECT id_media,media_name,media_date FROM gallery
			WHERE media_owner = '".$email."'
			ORDER BY date DESC";
	$entries = mysqli_query($con, $sql2);
			
} else {	
	header("location:login.php");
}

?>		       
    	<center>
        	<div style="max-width:600px">               
                    <div class="blanco" style="margin-top:3%;"> Galería de 
					<?php 
						echo '<a class="blanco" href="profile.php?email=' . $email . '"> '.$owner.'</a>'; 
					?>
                    </div>
            </div>
            <?php 
				$haveImages = false;
				for($i=0;$i<mysqli_num_rows($entries);$i++){	
					$haveImages = true;		
					$entry = mysqli_fetch_array($entries);	
					
					$delete = "";
					if(isset($_SESSION['login_admin'])){
						$delete = '<img class="sendImage" src="img/delete.png" onclick="submitForm(\'delgallery_'.$entry['image'].'\')"/>  									
										<form action="php/logica_delgallery.php" method="post" name="delgallery_'.$entry['image'].'" id="delgallery_'.$entry['image'].'">                       
											<textarea name="origin" style="display:none;">gallery.php?email='.$email.'&owner='.$owner.'</textarea>
											<textarea name="image" style="display:none;">'. $entry['image'] .'</textarea>          		
										</form>';
					}				
									
					// Obtiene imagen 
					if($entry['image']!=NULL){
						echo '<div class="simple_overlay" id="image'.$entry['image'].'">
								  <!-- large image -->
								  <img src="img/'.$entry['image'].'.jpg" class="overlayed"  style="float:right;"/>
								  <div class="blanco" style="float:left;"> '.$entry['image_name'].'</div>
							</div> 
							<div class="element-box">
								'.$delete.'
								<div class="heading"> 
									<div> '.$entry['image_name'].' </div>  
									<div class="date"> '.$entry['date'].' </div> 
								</div>
								<div class="media">
									<img style="width:300px;" src="img/'.$entry['image'].'.jpg" rel="#image'.$entry['image'].'"/>
								</div>
							</div>';
					}
				}
						
				if(!$haveImages){
					echo '<div class="element-box">
								<div class="heading">  
									<div class="date"> Info </div>
								</div>
								<div class="message"> Este usuario aún no ha subido imágenes. </div>								
						  </div>'; 
				} 
				mysqli_close($con);
			?>
        </center>     
</body>
</html>
