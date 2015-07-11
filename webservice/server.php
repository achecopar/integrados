<?php

$soap = new SoapServer(null, array('uri' => "http://test-uri/"));
$soap->setClass('WebPost');
$soap->handle();
		
class WebPost
    {		
		public function post(String $mail, String $pass, String $message){
			
			$con=mysqli_connect("127.0.0.1","root","","social_network");
			
			if (mysqli_connect_errno($con)) { 
				echo "Failed to connect to MySQL: " . mysqli_connect_error(); 
			}
			
			$sql="	SELECT * 
				FROM user 
				WHERE email=\"$mail\"
				AND password=\"$pass\"";
			$result = mysqli_query($con, $sql);
			$user = mysqli_fetch_array($result);
			
			if(mysqli_num_rows($result)!=0){
				
				$sql="INSERT INTO `social_network`.`wall_entry` (`id_wall_entry`, `date`, `message`, `visibility`, `image`, `image_name`, `video`, `email_owner`) VALUES (NULL, NOW(), '".$message."', 'ALL', NULL, NULL, NULL, '".$user['email']."');";
				mysqli_query($con, $sql);
	
				mysqli_close($con);
				
				return "Post OK";
				
			} else {
				
				return "Usuario y/o contraseña inválidos";
				
			}	
			
								
		}
		
    }		

?>