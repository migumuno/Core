<?php 
	$cuerpo = "Se ha detectado una violación de seguridad. 
	La Ip original desde la que se ha recibido la conexión ha cambiado durante la navegación.
	<br><br>
	La ip nueva desde la que se realizó la conexión ha sido: ".$actual_ip."<br><br>
	Aquí tienes los datos que se han podido recopilar:<br><br>
	SESSION:<br>
	<pre>
	".print_r($_SESSION,1)."
	</pre>
	<br>
	REQUEST:<br>
	<pre>
	".print_r($_REQUEST,1)."
	</pre>
	SERVER:<br>
	<pre>
	".print_r($_SERVER,1)."
	</pre>
	<br>
	Si el problema persiste, recomendamos incluir las IPS implicadas en una lista negra para denegar el acceso.
	<br><br>
	Pasa un buen día.";
?>