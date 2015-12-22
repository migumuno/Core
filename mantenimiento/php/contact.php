<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/config/config.php');

	//definimos constantes
	define('SUBJECT','Contacto por web en mantenimiento');
	define('TEMPLATE_PATH','template/default.php');
	define('MSG_INVALID_NAME','Por favor introduce tu nombre.');
	define('MSG_INVALID_EMAIL','Por favor, introduce tu email.');
	define('MSG_INVALID_MESSAGE','Por favor, rellena algo en le mensaje.');
	define('MSG_SEND_ERROR','Lo siento, no se ha podido enviar el mensaje.');	

	// limpiamos
	$name 		= filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$email 		= filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$message 	= filter_var($_POST['message'], FILTER_SANITIZE_STRING);
	$err = "";
	
	//Checkeamos en servidor
	$pattern = "^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$^";
	if(!preg_match_all($pattern, $email, $out)) {
		$err = MSG_INVALID_EMAIL; // Invalid email
	}
	if(!$email) {
		$err = MSG_INVALID_EMAIL; // No Email
	}	
	if(!$message) {
		$err = MSG_INVALID_MESSAGE; // No Message
	}
	if (!$name) {
		$err = MSG_INVALID_NAME; // No name 
	}
	
	//creamos el cuerpo del mensaje, se puede cambiar el html 
	$body=include(TEMPLATE_PATH);
	
	if (!$err){
		//enviamos el mail
		if (enviar_email($maintenance['maintenance_email'], SUBJECT, $body, $email, $name)) {
				//si todo va correcto avisamos
				echo "SEND"; 
		}else{
			//si no, decimos que no hemos podido enviar el mail
			echo MSG_SEND_ERROR; 
		}
	} else {
		echo($err); // Algo no ha sido correctamente completado
	}
?>