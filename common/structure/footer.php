	    <?php 
	    	include $_SERVER['DOCUMENT_ROOT'].'/common/structure/pie.php'; //html del pie
	    	
    		foreach($footer_includes as $type=>$routes){
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
    </body>
</html>
<?php 
	//corto la conexión a base de datos si está abierta
	if(isset($db)){
		$db->disconnect();
	}
?>