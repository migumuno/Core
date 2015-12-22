<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?=CODIFICACION?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="">
        <meta name="keywords" content="">	
        <title></title>
        <?php 
    		foreach($header_includes as $type=>$routes){
	    		switch ($type){
	    			case 'js':
	    				foreach($routes as $route){
		    				if(!is_null($route) && $route !=''){
				    		?>
				    			<script src="<?=DWFS.$route?>"></script>
				    		<?php 
		    				}
	    				}
	    			break;
					case 'css':
						foreach($routes as $route){
							if(!is_null($route) && $route !=''){
							?>
				    			<link rel="stylesheet" type="text/css" href="<?=DWFS.$route?>" />
				    		<?php 
							}
						}
	    			break;
					case 'script':
						foreach($routes as $route){
							if(!is_null($route) && $route !=''){
							?>
		    					<?=$route?>
		    				<?php 
							}
						}
	    			break; 
	    		}
	    	}
	    ?>
    </head>
    <body>        
		<?php 
			include("cabecera.php");  //html de la cabecera
		?>