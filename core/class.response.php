<?php
// Esta es la clase estandar de respuesta
class Response {
	// Resultado de como ha ido la cosa (bool -> true/false)
	var $resultado 	= null;
	// Mensaje de que ha ido bien o mal
	var $mensaje 	= "";
	// Datos a tener en cuenta (para las querys)
	var $datos		= null;
    // Cuando insertemos en base de datos en este campo irá el id insertado
    var $id 		= null;
}
?>
