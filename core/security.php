<?php
	
	/*****************************/
	/*							 */
	/*			NIVEL1			 */
	/*							 */
	/*****************************/

	//obtengo la ip actual de manera segura
	$actual_ip = filter_var(getenv ( "REMOTE_ADDR" ), FILTER_VALIDATE_IP);

	//si no tengo guardada la ip desde la que se conectan
	if(!isset($_SESSION['ORIGIN_IP'])){
		$_SESSION['ORIGIN_IP'] 					= $actual_ip;
		$_SESSION['ORIGIN_IP_CHANGED_TIMES']	= 0;
		$_SESSION['LAST_IP_CHANGED_TIME']		= date("Y-m-d h:i:s");
		$_SESSION['PREVIOUS_ORIGIN_IP']			= array();
	}else{
		//calculo el tiempo entre ahora mismo y la última vez que cambié de IP
		$to_time 				= strtotime(date("Y-m-d h:i:s"));
		$from_time 				= strtotime($_SESSION['LAST_IP_CHANGED_TIME']);
		$time_between_changes 	= round(abs($to_time - $from_time) / 60,2);

		//comparo la Ip original con la actual, si no es la misma y no es la primera que la cambio en menos de un tiempo, expulsión de seguridad
		if (strcmp($_SESSION['ORIGIN_IP'] , $actual_ip) !== 0 && $_SESSION['ORIGIN_IP_CHANGED_TIMES'] >= MAX_IP_CHANGED_TIMES && $time_between_changes > MAX_TIME_BETWEEN_IP_CHANGES) {
			//enviamos un email de aviso a soporte
			$asunto = "Violación de seguridad nivel 1 en site:".$_SERVER['SERVER_NAME'];
			include $_SERVER['DOCUMENT_ROOT'].'/common/mailing/security/not_equal_ip.php'; //aquí tenemos el cuerpo del mensaje
			enviar_email(security_mail, $asunto, $cuerpo);
			//realizamos la expulsión de seguridad
			expulsion_seguridad();

		//admito un cambio de IP cada 15 minutos
		}else if(strcmp($_SESSION['ORIGIN_IP'] , $actual_ip) !== 0){
			//meto la ip en el array de ips previas (por un posible traceo)
			array_push($_SESSION['PREVIOUS_ORIGIN_IP'], $_SESSION['ORIGIN_IP']);
			$_SESSION['ORIGIN_IP'] 					= $actual_ip;
			$_SESSION['LAST_IP_CHANGED_TIME']		= date("Y-m-d h:i:s");
			$_SESSION['ORIGIN_IP_CHANGED_TIMES']++;
		}
	}
	
	//libero memoria
	unset($actual_ip);
	
	/*****************************/
	/*							 */
	/*			NIVEL2			 */
	/*							 */
	/*****************************/
	
	//como medida de seguridad básica, vamos a limpiar todas las variables por defecto
	
	//con esto prevenimos el XSS
	require_once $_SERVER['DOCUMENT_ROOT'].'/lib/htmlpurifier/HTMLPurifier.auto.php';
	// Configuración básica
	$config = HTMLPurifier_Config::createDefault();
	$config->set('Core.Encoding', CODIFICACION);
	$config->set('HTML.Doctype', 'HTML 4.01 Transitional');
	// Creamos la whitelist
	$config->set('HTML.Allowed', ALLOWED_HTML_TAGS); // configuramos las etiquetas que permitimos
	$sanitiser = new HTMLPurifier($config);
	
	//aquí limpiamos todas las variables y combatimos de manera superficial el sql inject
	$_REQUEST = sanitize($_REQUEST, $sanitiser);
	$_POST 	  = sanitize($_POST, 	$sanitiser);
	$_GET 	  = sanitize($_GET, 	$sanitiser);
	$_COOKIE  = sanitize($_COOKIE, 	$sanitiser, true);
	
	//libero memoria
	unset($sanitiser);
?>