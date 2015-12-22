<?php
	require_once ($_SERVER["DOCUMENT_ROOT"].'/core/functions.php');
	
	//la ruta del archivo tiene que venir "ruta del archivo.extension@@nombre que quieras darle" todo eso encriptado
	if($_REQUEST['key']!=null){
		$ruta_basta 	= decrypt($_REQUEST['key']);  //primero desencrypto la key
		$ruta_depurada 	= explode("@@", $ruta_basta); //separo la url del nombre
		
		$archivo = $ruta_depurada[0];
		$nombre  = $ruta_depurada[1];
		
		//si el archivo existe lo descargo
		if(file_exists($archivo) || file_exists($_SERVER['DOCUMENT_ROOT'].$archivo)){
			if(strpos($archivo, $_SERVER['DOCUMENT_ROOT']) === false){
				$archivo = $_SERVER['DOCUMENT_ROOT'].$archivo;
			}
			
			header("HTTP/1.1 200 OK");//modificamos  cabecera
			header("Status: 200 OK"); //modificamos   cabecera
			switch (file_extension($archivo)) {
				case 'css':
					$contenType = "text/css";
				break;
				case 'js':
					$contenType = "text/javascript";
				break;
				default:
					$contenType = "text/php";
				break;
			}
			header('Content-Type: '.$contenType);//modificamos   cabecera
			header('Content-Disposition: attachment; filename="'.$nombre.".".file_extension($archivo).'"'); //modificamos  cabecera
			header('Content-Length: '.filesize($archivo));//modificamos  cabecera
			readfile($archivo);
		}else{
			header("HTTP/1.0 404 Not Found");
			die();
		}
			
	}else{
		die("Debes enviar la key del archivo a descargar");
	}
?>