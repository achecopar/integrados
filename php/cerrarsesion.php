<?php
session_start(); //necesario para que no de error
unset($_SESSION["login"]); // PARA BORRAR LA VARIABLE $_SESSION
unset($_SESSION["login_admin"]);

setcookie("log", $esUsuario, time()-3600,"/","");//PARA BORRAR LA VARIABLE DE LA COOKIE - recordarme en inicio automático
setcookie("log_admin", $esUsuario, time()-3600,"/","");

header("location:../index.php");


?>