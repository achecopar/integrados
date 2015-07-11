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

// Selecciona todos los posts de mis amigos
$sql = "SELECT id_wall_entry,date,message,visibility,wall_entry.image AS imagen,image_name,video,email_owner,name FROM wall_entry 
	INNER JOIN friendship ON email_owner = email_added 
	INNER JOIN user ON email_owner = email
	WHERE email_adder ='".$usu."'
	ORDER BY date DESC;"; 

//echo $sql;
$entries = mysqli_query($con, $sql);
?>

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
    	<center>
        	  <?php 
			  	$havePosts = false;
				for($i=0;$i<mysqli_num_rows($entries);$i++){			
					$havePosts = true;
											
					$entry = mysqli_fetch_array($entries);					
					
					$origin = 'wall.php?anchor=post_'.$entry['id_wall_entry'];
										
					// Para cada uno veo si me agregó o no
					$sql = "SELECT * FROM friendship WHERE email_adder='".$entry['email_owner']."' AND email_added='".$usu."' LIMIT 1";
					$result = mysqli_query($con, $sql);
					
					// Si no me agregó y el post es privado, no lo muestro 
					if($entry['visibility']=='FRIENDS' & mysqli_num_rows($result)==0 & $user['admin']==0){
						//echo "Hidden post " . $entry['id_wall_entry'];
					} else {
															
						if($entry['visibility']=='ALL'){
							$class = "element-box";
						}else {
							$class = "element-red-box";
						}
											
						// Obtiene imagen 
						$image = "";
						$overlay = "";
						if($entry['imagen']!=NULL){
							$image = '<div class="media"> <img style="width:300px;" src="img/'.$entry['imagen'].'.jpg" rel="#image'.$entry['imagen'].'"/> </div>'; 							$overlay = '<div class="simple_overlay" id="image'.$entry['imagen'].'">
								  <!-- large image -->
								  <img src="img/'.$entry['imagen'].'.jpg" class="overlayed"  style="float:right;"/>
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
							
							// Arma divs para borrar comentarios si es admin
							$delete_comment = "";							
							if(isset($_SESSION['login_admin']) or $user['email']==$comment['user_email']){					
								$delete_comment = '<img class="sendImage" src="img/delete.png" onclick="submitForm(\'com_'.$comment['id_comment'].'\')"/>  									
												<form action="php/logica_delcomment.php" method="post" name="com_'.$comment['id_comment'].'" id="com_'.$comment['id_comment'].'">                       
													<textarea name="origin" style="display:none;">'.$origin.'</textarea>
													<textarea name="id_comment" style="display:none;">'. $comment['id_comment'] .'</textarea>          		
												</form>';
							}	
							
							// Arma comentario
							$comments = $comments . 
										'<div class="message">                  
											<a href="profile.php?email=' . $comment['user_email'] . '"> 
												<span> '.$comment['name'].'</span>                  
											</a>  
											 comentó: 
											'. $comment['message'] .$delete_comment.' 
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
								
						echo $overlay.'<div class="'. $class .'">'.
							// La siguiente línea es para poner un anchor
							'.<a name="post_'.$entry['id_wall_entry'].'"> </a> '.$delete_post .'
								<div class="heading">  
									<div class="date"> 
											<a href="profile.php?email=' . $entry['email_owner'] . '"> 
												<span> '.$entry['name'].'</span>                  
											</a>   publicó en la fecha </br>' . $entry['date'] . '</div>
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
									<img href="#" class="smallImage" src="img/like.png"></img> <a href="php/logica_like.php?type='.$like.'&origin='.$origin.'&id_wall_entry='.$entry['id_wall_entry'].'">' .$like. '</a> <br>
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
				}
				if(!$havePosts){
					echo '<div class="element-box">
								<div class="heading">  
									<div class="date"> Info </div>
								</div>
								<div class="message"> Sus amigos no han publicado nada. </div>								
						  </div>'; 
				} 
				mysqli_close($con);
			?>            	
        </center>
        
        <script>
			$(document).ready(function() {		 
				<?php
					if(isset($_GET['anchor'])){
						echo 'location.hash = "#'.$_GET['anchor'].'";';
					}
				?>
			});
		</script>
</body>
</html>
