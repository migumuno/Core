<?php
	//obtengo la ip de manera segura
	$actual_ip = getenv ( "REMOTE_ADDR" );
	
	//cargo mantenimiento
	$maintenance = unserialize(MAINTENANCE);

	//si estamos en mantenimiento y no estamos en la white list, allá que vamos
	if($maintenance['enabled'] && !in_array($actual_ip, $maintenance['allowed_ips']) && strpos($_SERVER['SCRIPT_NAME'], "mantenimiento") === false ){
  		header("HTTP/1.1 302 Moved Temporarily");
		header('Location: /mantenimiento/');
  		die();
  	//si no estamos en mantenimiento e intentamos entrar en mantenimiento, redirigimos a la home
	}else if(!$maintenance['enabled'] && strpos($_SERVER['SCRIPT_NAME'], "mantenimiento") !== false){
		header("HTTP/1.1 302 Moved Temporarily");
		header('Location: /');
  		die(); 
	}
?>