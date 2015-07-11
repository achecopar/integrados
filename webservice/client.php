<?php
	//echo "hi";
	// Creamos el objeto controlador (el cliente)
	$soap_client = new SoapClient(null,array(
    "uri"                => "http://test-uri/",
    "location"        => "http://localhost/proyecto/webservice/server.php"));
 
// Nos conectamos a un método remoto, con dos parámetros de entrada. Si todo va bien, en $demo tenemos la respuesta
try {
	$postOK = $soap_client->post('user@integraccs.com','User1234',"De webservice");
	
	$postWRONG = $soap_client->post('usuario inexistente','User1234',"De webservice CON ERROR");
    
	print(utf8_decode("El post OK retornó = ".$postOK));
	print('<br>');
	print("El post WRONG = ".utf8_decode($postWRONG));
	

} catch (SoapFault $exception) {
    print_r($exception);
}

?>