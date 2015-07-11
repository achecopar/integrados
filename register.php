<?php session_start();?>
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
        	<div id="spaceRegister"> </div>
            Registro
            <form action="php/logica_registro.php" method="post" id="registerForm" name="registerForm" class="must-center">
              <div class="element-box heading formBox container">
                <div class="col-xs-4 col-md-4">	
                       <label for="UserName" class="form-control">Nombre:</label>
                       <label for="UserName" class="form-control">Cargo:</label>
                       <label for="UserName" class="form-control">Sector:</label>
                       <label for="UserName" class="form-control">E-mail:</label>
                       <label for="UserName" class="form-control">Teléfono:</label>
                       <label for="UserName" class="form-control">País:</label>
                       <label for="UserName" class="form-control">Latitud:</label>
                       <label for="UserName" class="form-control">Longitud:</label>
                       <label for="UserName" class="form-control">Clave:</label>
                       <label for="UserName" class="form-control">Repetir Clave:</label>
                </div> 
                <div class="col-xs-8 col-md-8">
                      <input type="text" class="form-control" name="username" value="" required/>
                      <input type="text" class="form-control" name="position" value="" required/> 
                      <select name="sector" class="negro form-control">
                          <option value="Recursos Humanos">Recursos Humanos</option>
                          <option value="Ventas">Ventas</option>
                          <option value="Soporte">Soporte</option>
                          <option value="Gerencia">Gerencia</option>
                          <option value="Informatica">Informática</option>
                        </select required> 
                      <input type="email" class="form-control" name="mail" value="" required/> 
                      <input type="tel" class="form-control" name="phone" value="" required/> 
                      <select name="country" class="negro form-control">
                          <option value="Uruguay">Uruguay</option>
                          <option value="Brasil">Brasil</option>
                          <option value="Argentina">Argentina</option>
                          <option value="Chile">Chile</option>  
                      </select required>   
                      <input type="tel" class="form-control" name="lat" value="" required/>   
                      <input type="tel" class="form-control" name="long" value="" required/>                                    
                      <input type="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" name="pass1" 
                      	  onchange="form.pass2.pattern = this.value;">          			  
					  <input type="password" class="form-control" name="pass2" required>                       
                </div>
                		<div>La clave debe tener 6 caracteres, mayúsculas, minúsculas y números. </div>
                        <?php                        
                            if(isset($_SESSION["register_error"])){ 
                                echo('<div style="color:red;"> Este correo electrónico ya existe </div>');
                                unset($_SESSION["register_error"]);
                            }?>
              </div>
              <input type="submit" value="Registrarse">
              <input type="button" value="Volver" onclick="javascript:location.href='index.php'">
            </form>               
        </center>
    </div>
	<div id="pie"> 
    </div>
</div>
</body>
</html>

