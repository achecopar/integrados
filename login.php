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
    
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet" media="screen"/>     
    
	<script src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js" type="text/javascript" ></script>
    <script src="js/slideshow.js" type="text/javascript" ></script>
</head>

<body>

<div id="contenedor">
	<div id="header">
    	<img id="logo" src="img/logo.png"/> 
        <span id="title">Integrados</span>
    </div>	
	<div id="loginArea"> 
    	<center>
        	<div id="spaceLogin"> </div>
            Login 
            <form action="php/logica_login.php" method="post" id="loginForm" name="loginForm" class="must-center">
              <div class="element-box formBox heading container">
                <div class="col-xs-4 col-md-4">	
                       <label for="userr" class="form-control">E-mail:</label>
                       <label for="password" class="form-control">Clave:</label>
                </div> 
                <div class="col-xs-8 col-md-8">
                      <input type="email" class="form-control" name="username" value="" required/>
                      <input type="password" class="form-control" name="pass" value="" required/> 
                </div>
			 	 <input type="checkbox" name="recordarme" value="true" /> Recordarme <br/>
                 <?php
					session_start();
                 	if(isset($_SESSION["login_error"])){ 
						echo('<div style="color:red;"> Usuario y/o contraseña inválidos </div>');
						unset($_SESSION["login_error"]);
					}
				 ?>
              </div>              
              <input type="submit" value="Entrar">
              <input type="button" value="Registrarse" onclick="javascript:location.href='register.php'">
            </form>  
        </center>
     </div>
	<div id="pie"> 
    </div>
</div>
</body>
</html>

