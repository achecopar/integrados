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
	
<?php 
session_start();

$con=mysqli_connect("127.0.0.1","root","","social_network");

if (mysqli_connect_errno($con)) { 
	echo "Failed to connect to MySQL: " . mysqli_connect_error(); 
}

if(isset($_GET['recargar'])){
	$_SESSION['recargar']='myprofile.php';
	echo '<script> parent.location.reload(); </script>';
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
	
	$sql2= " SELECT * FROM wall_entry 
		WHERE email_owner='".$usu."' ORDER BY date DESC";
	$entries = mysqli_query($con, $sql2);
			
} else {	
	header("location:login.php");
}

?>
		<div class="simple_overlay" id="myprofile">
              <!-- large image -->
              <img src="<?php echo $user['image'];?>" class="overlayed"/>
        </div>
        
    	<center>
        	<div style="max-width:600px"> 
                <div class="blanco"> Mi Perfil </div>
                <img class="bigUserImage" id="profile" style="margin-top:3%;" src="<?php echo $user['image'];?>" rel="#myprofile"></img > 
                <?php
					echo '<form action="php/logica_cambiarfoto.php" method="post" name="fotoForm" id="fotoForm" enctype="multipart/form-data">						
                <div style="max-width:600px"> 
						<label for="fotoImage">
                            <img src="img/image.png" />
                        </label>
                        <input class="image-upload" name="fotoImage" id="fotoImage" type="file" accept="image/*"/> 
                        <span class="blanco"> Cambiar foto
                            <img class="smallImage" src="img/send.png" onclick="submitForm(\'fotoForm\')"/>
                        </span>     						                                                             	
                </div>
                </form>
					';
					
				?>
                <form action="php/logica_mediaform.php" method="post" name="mediaForm" id="mediaForm" enctype="multipart/form-data">
                <div style="max-width:600px">  
                        <div class="blanco" style="margin-top:3%;"> Publicar nuevo estado
                            <img class="smallImage" src="img/send.png" onclick="submitForm('mediaForm')"/>
                        </div>                                                                        
                		<textarea id="message" name="message" required></textarea>              	
                        <label for="profileImage" class="attachImage">
                            <img class="attachImage" src="img/image.png" />
                        </label>
                        <input class="image-upload" name="profileImage" id="profileImage" type="file" accept="image/*"/> 
                        <span> Nombre de imagen: </span>
                        <input style="float:left;margin-bottom:2%;" class="form-control" name="image_name" id="image_name" type="text"/>       	
                        <img class="attachImage" style="margin-top:1%;" src="img/video.gif" />
                        <div> Código de video de youtube: </div>
                        <input style="float:left;margin-bottom:2%;" class="form-control" name="profileVideo" id="profileVideo" type="text"/>
                </div>
                </form>
                <?php                        
                            if(isset($_SESSION["post_error"])){ 
                                echo('<div style="color:red;"> '.$_SESSION["post_error"].' </div>');
                                unset($_SESSION["post_error"]);
                          	}
				?>
                
                <div class="blanco"> Información Personal </div>
                <form action="php/logica_profile.php" method="post" id="profileForm" name="profileForm" class="must-center">
                  <div class="element-box formBox heading container">
                    <div class="col-xs-4 col-md-4 form-labels">	
                           <label for="UserName" class="form-control">E-mail:</label>
                           <label for="UserName" class="form-control">Usuario:</label>
                           <label for="UserName" class="form-control">Cargo:</label>
                           <label for="UserName" class="form-control">Sector:</label>
                           <label for="UserName" class="form-control">Teléfono:</label>
                       		<label for="UserName" class="form-control">País:</label>
                       		<label for="UserName" class="form-control">Latitud:</label>
                       		<label for="UserName" class="form-control">Longitud:</label>
                           <label for="UserName" class="form-control">Nueva clave:</label>
                    </div> 
                    <div class="col-xs-8 col-md-8 form-values">
                    	                        
                     		<div class="form-control form-entry tip" data-tip="E-mail"> <?php echo $user['email']?> </div><br/>
                    	 	<div class="tip" data-tip="Usuario">
                          <input class="form-control" type="text" name="username" value="<?php echo $user['name']?>" required/>                          
                    	</div><div class="tip" data-tip="Cargo"> 
                          <input class="form-control" type="text" name="position" value="<?php echo $user['position']?>" required/>
                    	</div><div class="tip" data-tip="Sector">
                          <select name="sector" class="negro form-control">
                              <option value="Recursos Humanos" <?= $user['sector'] == 'Recursos Humanos' ? ' selected="selected"' : '';?>>Recursos Humanos</option>
                              <option value="Ventas" <?= $user['sector'] == 'Ventas' ? ' selected="selected"' : '';?>>Ventas</option>
                              <option value="Soporte" <?= $user['sector'] == 'Soporte' ? ' selected="selected"' : '';?>>Soporte</option>
                              <option value="Gerencia" <?= $user['sector'] == 'Gerencia' ? ' selected="selected"' : '';?>>Gerencia</option>
                              <option value="Informatica" <?= $user['sector'] == 'Informatica' ? ' selected="selected"' : '';?>>Informática</option>
                        </select required> 
                    	</div><div class="tip" data-tip="Teléfono">
                          <input class="form-control" type="tel" name="phone" value="<?php echo $user['phone']?>" required/>
                    	</div><div class="tip" data-tip="País">
                         <select name="country" class="negro form-control">
                          <option value="Uruguay" <?= $user['country'] == 'Uruguay' ? ' selected="selected"' : '';?>>Uruguay</option>
                          <option value="Brasil" <?= $user['country'] == 'Brasil' ? ' selected="selected"' : '';?>>Brasil</option>
                          <option value="Argentina" <?= $user['country'] == 'Argentina' ? ' selected="selected"' : '';?>>Argentina</option>
                          <option value="Chile" <?= $user['country'] == 'Chile' ? ' selected="selected"' : '';?>>Chile</option>  
                     	 </select required>  
                         </div> <div class="tip" data-tip="Latitud">
                      		<input type="tel" class="form-control" name="lat" value="<?php echo $user['job_place_x']?>" required/> 
                      	</div> <div class="tip" data-tip="Longitud">  
                     		 <input type="tel" class="form-control" name="long" value="<?php echo $user['job_place_y']?>" required/>  
                    	</div>  <div class="tip" data-tip="Nueva clave">
                           <input type="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" name="pass4"> 
                    
                		<div>                       
                    </div>
                  </div>
                  
                        </div>La clave debe tener 6 caracteres, mayúsculas, minúsculas y números. </div>
                  <input type="submit" value="Guardar">
                </form>        
                <br/>
                <b>Lugar de trabajo:</b> <br/>          
                <span id="location"> 
                	<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d209663.94494326797!2d<?php echo $user['job_place_x']?>!3d<?php echo $user['job_place_y']?>!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2suy!4v1411507904761" width="600" height="450" frameborder="0" style="border:0"></iframe>
                </span>            
            </div>   
            <?php 
				$havePosts = false;
				for($i=0;$i<mysqli_num_rows($entries);$i++){	
					$havePosts = true;		
					$entry = mysqli_fetch_array($entries);
					
					$anchor = 'post_'.$entry['id_wall_entry'];
					$origin = 'myprofile.php?anchor='.$anchor;
					
					if($entry['visibility']=='ALL'){
						$class = "element-box";
						$visibility = "img/world.png";
					}else {
						$class = "element-red-box";
						$visibility = "img/friends.png";
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
							</div> ';
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
						$comments = $comments . 
									'<div class="message">                  
										<a href="profile.php?email=' . $comment['user_email'] . '"> 
											<span> '.$comment['name'].'</span>                  
										</a>  
										 comentó: 
										'. $comment['message'].'                         
										<img class="sendImage" src="img/delete.png" onclick="submitForm(\'com_'.$comment['id_comment'].'\')"/>  									
											<form action="php/logica_delcomment.php" method="post" name="com_'.$comment['id_comment'].'" id="com_'.$comment['id_comment'].'">                       
												<textarea name="origin" style="display:none;">'.$origin.'</textarea>
												<textarea name="id_comment" style="display:none;">'. $comment['id_comment'] .'</textarea>          		
											</form>
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
					
					// Arma el div a mostrar
					echo $overlay.'<div class="'. $class .'">'.
							// La siguiente línea es para poner un anchor
							'.<a name="post_'.$entry['id_wall_entry'].'"> </a>
							<img class="sendImage" src="img/delete.png" onclick="submitForm(\'delpost_'.$entry['id_wall_entry'].'\')"/>  									
										<form action="php/logica_delpost.php" method="post" name="delpost_'.$entry['id_wall_entry'].'" id="delpost_'.$entry['id_wall_entry'].'">                       
											<textarea name="origin" style="display:none;">'.$origin.'</textarea>
											<textarea name="id_wall_entry" style="display:none;">'. $entry['id_wall_entry'] .'</textarea>          		
										</form>
							<div class="heading">  
								<div class="date"> Publiqué en la fecha </br>' . $entry['date'] . '</div>
							</div>
								<img href="#" class="sendImage" src="img/like.png"></img >
							<span class="sendImage"> ' . $like_count . ' </span>
							<div class="message"> '. $entry['message'] .' </div> '
							.$image.$video.
							//<div class="media">		
                    //<iframe width="560" height="315" src="http://www.youtube.com/embed/HxOvL3MwI7w" frameborder="0" allowfullscreen></iframe>
						//	</div>
						// Para imágenes con <img /> 
							'<div class="footer">
								<img onclick="location.href=\'php/logica_visibility.php?type='.$entry['visibility'].'&entry='.$entry['id_wall_entry'].'&anchor='.$anchor.'\';" class="smallImage" src="'. $visibility.'"></img >  
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
								<div class="message"> Usted no han publicado nada aún. </div>								
						  </div>'; 
				} 
				mysqli_close($con);	
			?>       
        </center>
        
        <script>
		$(document).ready(function() {
			 $('.tip').tipr({
				  'mode': 'top'
			 });			 		 
				<?php
					if(isset($_GET['anchor'])){
						echo 'location.hash = "#'.$_GET['anchor'].'";';
					}					
				?>
		});
		</script>
</body>
</html>
