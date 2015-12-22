<?php
	require_once __DIR__.'/../core/settings.php';
	require_once __DIR__.'/../core/maintenance.php';
	
	//si no estoy logado, te echo
	if(!isset($_SESSION['usuario']->id_usuario) && !in_array($_SERVER['SCRIPT_NAME'], $not_session_required)) {
		expulsion_seguridad();
	}
?>