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
	list($usu,$pass)=explode("-",$login);
	$sql="	SELECT * 
		FROM user 
		WHERE email=\"$usu\"
		AND password=\"$pass\"";
	$result = mysqli_query($con, $sql);
	$user = mysqli_fetch_array($result);
}

if(!isset($_GET["email"])){	
	mysqli_close($con);
	header("location:myprofile.php");
}


// Obtiene usuario del profile
$usu=$_GET["email"];
$sql="	SELECT * 
	FROM user 
	WHERE email=\"$usu\"";
$result = mysqli_query($con, $sql);
$profile = mysqli_fetch_array($result);

// Revisa si el profile ha agregado al que está mirando
$sql = "SELECT * FROM friendship 
		WHERE email_adder='". $profile['email']. "'
		AND email_added='".$user['email']."' LIMIT 1";
$result = mysqli_query($con, $sql);

// Arma el SQL de búsqueda de posts según si es amigo o no

$sql= " SELECT * FROM wall_entry 
		WHERE email_owner='".$profile['email']."'";
if(mysqli_num_rows($result)==0 & $user['admin']==0){
	$sql = $sql . " AND visibility='ALL'";
} 
$sql = $sql . " ORDER BY date DESC";

$entries = mysqli_query($con, $sql);

// Quedan $user con el usuario logueado y $profile con el usuario del perfil que se está mirando

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link href="css/elements-style.css" type="text/css" rel="stylesheet" media="screen">      
	<link href="css/classes.css" type="text/css" rel="stylesheet" media="screen">
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet" media="screen"/>    
	<link href="css/media.css" type="text/css" rel="stylesheet" media="screen">      
    	
	<script src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js" type="text/javascript" ></script>
    <script src="js/slideshow.js" type="text/javascript" ></script>
    
	<link href="tipr/tipr.css" rel="stylesheet">
	<script src="tipr/tipr.js"></script>   
    
	<title>Untitled Document</title>
    
</head>

<body>		
		<div class="simple_overlay" id="profile">
              <!-- large image -->
              <img src="<?php echo $profile['image'];?>" class="overlayed"/>
        </div>
        
    	<center>
        	<div style="max-width:600px"> 
                <div class="blanco"> Información Personal de Usuario &nbsp;&nbsp;&nbsp; 
                	<img class="smallImage" src="img/add.png" onclick="location.href='<?php echo "php/logica_addfriend.php?friend=" . $profile['email']."&friend_name=".$profile['name']; ?>';" /> 
                </div>
                <img class="bigUserImage" id="profile" style="margin-top:3%;" src="<?php echo $profile['image'];?>" rel="#profile"></img > 
                <?php
                	echo '<div> <a class="blanco" href="gallery.php?email='.$profile['email'].'&owner='.$profile['name'].'"> Ver galería </a> </div>';
				?>     
                <div style="max-width:600px"> 
                    <div class="blanco" style="margin-top:3%;">&nbsp; Enviar mensaje de correo
                        <img class="smallImage" src="img/enviar.png" onclick="submitForm('sendMailForm')"/>
                    </div>
                </div>
                <form action="php/logica_sendmail.php" method="post" id="sendMailForm">
                	<textarea name="mail"></textarea> 
                    <input type="text" name="to" style="display:none" value="<?php echo $profile['email'] ?>"/>
                </form>          
                 
                <div class="element-box formBox heading container">
                    <div class="col-xs-4 col-md-4 form-labels" style="float:left;"">	
                           <label for="UserName" class="form-control">E-mail:</label>
                           <label for="UserName" class="form-control">Usuario:</label>
                           <label for="UserName" class="form-control">Cargo:</label>
                           <label for="UserName" class="form-control">Sector:</label>
                           <label for="UserName" class="form-control">Teléfono:</label>
                       		<label for="UserName" class="form-control">País:</label>
                       		<label for="UserName" class="form-control">Latitud:</label>
                       		<label for="UserName" class="form-control">Longitud:</label>
                    </div> 
                    <div class="col-xs-8 col-md-8 pull-right form-values"> 
                     	<div class="form-control form-entry tip" data-tip="E-mail"> <?php echo $profile['email']?> </div> <br/>
                     	<div class="form-control form-entry tip" data-tip="Usuario"> <?php echo $profile['name']?> </div> <br/>
                     	<div class="form-control form-entry tip" data-tip="Cargo"> <?php echo $profile['position']?> </div><br/>
                     	<div class="form-control form-entry tip" data-tip="Sector"> <?php echo $profile['sector']?> </div><br/>
                     	<div class="form-control form-entry tip" data-tip="Teléfono"> <?php echo $profile['phone']?> </div><br/>
                     	<div class="form-control form-entry tip" data-tip="País"> <?php echo $profile['country']?> </div><br/>
                     	<div class="form-control form-entry tip" data-tip="Latitud"> <?php echo $profile['job_place_x']?> </div><br/>
                     	<div class="form-control form-entry tip" data-tip="Longitud"> <?php echo $profile['job_place_y']?> </div><br/>
                    </div>
                </div>       
                <b>Lugar de trabajo:</b> <br/>          
                <span id="location"> 
                	<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d209663.94494326797!2d<?php echo $profile['job_place_x']?>!3d<?php echo $profile['job_place_y']?>!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2suy!4v1411507904761" width="600" height="450" frameborder="0" style="border:0"></iframe>
                </span>            
            </div>      
             <?php 
				$havePosts = false;
				for($i=0;$i<mysqli_num_rows($entries);$i++){	
					$havePosts = true;					
					$entry = mysqli_fetch_array($entries);
					
					$origin = 'profile.php?email='.$profile['email'].'&anchor=post_'.$entry['id_wall_entry'];
					
					if($entry['visibility']=='ALL'){
						$class = "element-box";
					}else {
						$class = "element-red-box";
					}
										
					// Obtiene imagen 
					$image = "";
					$overlay = "";
					if($entry['image']!=NULL){
						$image = '<div class="media"> <img style="width:300px;" src="img/'.$entry['image'].'.jpg" rel="#image'.$entry['image'].'"/> </div>';
						$overlay = '<div class="simple_overlay" id="image'.$entry['image'].'">
								  <!-- large image -->
								  <img src="img/'.$entry['image'].'.jpg" class="overlayed"  style="float:right;"/>
								  <div class="blanco" style="float:left;"> '.$entry['image_name'].'</div>
							</div>'; 
					}
					
					// Obtiene video
					$video = "";
					if($entry['video']!=NULL){
						$video = '<div class="media"><iframe width="560" height="315" src="http://www.youtube.com/embed/'.$entry['video'].'" frameborder="0" allowfullscreen></iframe></div>';
					}
										
					// Obtiene comentarios					
					$sql = "SELECT * FROM comment 
							INNER JOIN user ON email=user_email
							WHERE id_wall_entry='".$entry['id_wall_entry']."'";
					$result2 = mysqli_query($con, $sql);
					$comments = " ";
					for($j=0;$j<mysqli_num_rows($result2);$j++){			
						$comment = mysqli_fetch_array($result2);
						
						// Arma divs para borrar comentarios en caso de ser admin					
						$delete_comment = "";
						if(isset($_SESSION['login_admin']) or $user['email']==$comment['user_email']){
							$delete_comment = '<img class="sendImage" src="img/delete.png" onclick="submitForm(\'com_'.$comment['id_comment'].'\')"/>  									
												<form action="php/logica_delcomment.php" method="post" name="com_'.$comment['id_comment'].'" id="com_'.$comment['id_comment'].'">                       
													<textarea name="origin" style="display:none;">'.$origin.'</textarea>
													<textarea name="id_comment" style="display:none;">'. $comment['id_comment'] .'</textarea>          		
												</form>';
						}
						
						// Arma comentarios	
						$comments = $comments . 
									'<div class="message">                  
										<a href="profile.php?email=' . $comment['user_email'] . '"> 
											<span> '.$comment['name'].'</span>                  
										</a>  
										 comentó: 
										'. $comment['message'] . $delete_comment .'
									</div> ';
					}
					
					// Obtiene si hay like
					$sql = "SELECT * FROM like_wall 
							WHERE id_wall_entry='".$entry['id_wall_entry']."' 
							AND user_email='".$user['email']."'";
					$result3 = mysqli_query($con,$sql);
					if(mysqli_num_rows($result3)==0){
						$like = "Me gusta";
					} else {
						$like = "Ya no me gusta";	
					}
					
					// Obtiene like count del post
						$sql = "SELECT COUNT(*) AS like_count
								FROM wall_entry
								INNER JOIN like_wall ON wall_entry.id_wall_entry = like_wall.id_wall_entry
								WHERE like_wall.id_wall_entry = '". $entry['id_wall_entry']."'";
						$likeresult = mysqli_query($con,$sql);
						$likes = mysqli_fetch_array($likeresult);
						$like_count = $likes['like_count'];
					
					// Arma delete post					
					$delete_post = "";
					if(isset($_SESSION['login_admin'])){
						$delete_post = '<img class="sendImage" src="img/delete.png" onclick="submitForm(\'delpost_'.$entry['id_wall_entry'].'\')"/>  									
										<form action="php/logica_delpost.php" method="post" name="delpost_'.$entry['id_wall_entry'].'" id="delpost_'.$entry['id_wall_entry'].'">                       
											<textarea name="origin" style="display:none;">'.$origin.'</textarea>
											<textarea name="id_wall_entry" style="display:none;">'. $entry['id_wall_entry'] .'</textarea>          		
										</form>';
					}
						
					// Arma los div a mostrar
					echo $overlay.'<div class="'. $class .'">'. 
							// La siguiente línea es para poner un anchor
							'.<a name="post_'.$entry['id_wall_entry'].'"> </a>'.$delete_post.'
							<div class="heading">  
								<div class="date"> Publicó en la fecha </br>' . $entry['date'] . '</div>
							</div>
								<img href="#" class="sendImage" src="img/like.png"></img >
							<span class="sendImage"> ' . $like_count . ' </span>
							<div class="message"> '. $entry['message'] .' </div>'
							.$image.$video
							//<div class="media">		
                    //<iframe width="560" height="315" src="http://www.youtube.com/embed/HxOvL3MwI7w" frameborder="0" allowfullscreen></iframe>
						//	</div>
						// Para imágenes con <img /> 
							.'<div class="footer">
								<img href="#" class="smallImage" src="img/like.png"></img > 
								<a href="php/logica_like.php?type='.$like.'&origin='.$origin.'&id_wall_entry='.$entry['id_wall_entry'].'">' .$like. '</a><br>
									'.$comments.'									   
									<span style="margin-top:3%;"> Enviar comentario </spain>
									<img class="smallImage" src="img/comment.png" onclick="submitForm(\''.$entry['id_wall_entry'].'\')"/>  									
            						<form action="php/logica_comment.php" method="post" name="'.$entry['id_wall_entry'].'" id="'.$entry['id_wall_entry'].'">                       
										<textarea name="origin" style="display:none;">'.$origin.'</textarea>
										<textarea name="id_wall_entry" style="display:none;">'. $entry['id_wall_entry'] .'</textarea>          		
										<textarea name="comment"></textarea>  
									</form>
							</div>
						</div>';
				}				
				if(!$havePosts){
					echo '<div class="element-box">
								<div class="heading">  
									<div class="date"> Info </div>
								</div>
								<div class="message"> Este usuario aún no ha publicado nada. </div>								
						  </div>'; 
				} 
				mysqli_close($con);
			?>               
        </center>
        
        <script>
			$(document).ready(function() {
				 $('.tip').tipr();
				 $("img[rel]").overlay();			 
				<?php
					if(isset($_GET['anchor'])){
						echo 'location.hash = "#'.$_GET['anchor'].'";';
					}
				?>
			});
		</script>
</body>
</html>
