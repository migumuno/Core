<?php
	require_once __DIR__.'/functions.php';
	require_once __DIR__.'/../config/presets.php';
	require_once __DIR__.'/class.response.php';
	require_once __DIR__.'/class.database.php';

	//si no hay sesion, la creo
	if(!isset($_SESSION)){
		session_start();
	}
	
	//por recomendaciones de seguridad, regnero el id de la sesion
	session_regenerate_id();
	
	//medidas de seguridad (de todos los niveles)
	require_once __DIR__.'/security.php';
	
    // fuerzo la desviación horaria
    date_default_timezone_set('Europe/Madrid');
   
    // Fuerzo las cabeceras con la codificación y que no haya caché
	header('Content-Type: text/html; charset='.CODIFICACION);
	header("Cache-Control: no-store, no-cache, must-revalidate"); 
    header("Pragma: no-cache");
	
	//creo la conexión a base de datos
	$db = new db();
?>