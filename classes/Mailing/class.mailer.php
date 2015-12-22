<?php
require_once("class.phpmailer.php");

class Mailer{
           
	function enviar ($Mail){

		//configuracion
		$mail= new PHPMailer();
		$mail ->IsSMTP();
		$mail ->Host       = "smtp.mandrillapp.com";
		$mail ->Port       = 587;
		$mail ->SMTPAuth   = true;
		$mail ->Username   = "administrador@icemd.com";
		$mail ->Password   = "FXKaNDsQFOQopVFtXUDeXA";
		//puede que queramos cambiar el remitente por defecto
		if(!is_null($Mail->From) && $Mail->From != ''){
			$mail->From    = $Mail->From;
		}else{
			$mail->From	   = "soporte@innovadsl.es";
		}
		if(!is_null($Mail->FromName) && $Mail->FromName != ''){
			$mail ->FromName   = $Mail->FromName;
		}else{
			$mail->FromName	   = "Soporte Innova";
		}
		$mail ->Mailer 	   = "smtp";		
		if($Mail->para!=""){
			$arr_paras = explode (";", $Mail->para);
			if(sizeof($arr_paras)>0){
				foreach ($arr_paras as $valor){
					if(trim($valor)!=""){
						$mail ->AddAddress (trim($valor));
					}
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
		
		$mail->IsHTML(true);
		$mail->Timeout = 120;
		$mail->Subject = utf2iso($Mail->asunto);
		$mail->Body    = utf2iso($Mail->cuerpo);
		$mail->AddReplyTo($mail ->From, $mail ->FromName);		
		
			
		//enviamos el mail. Si falla, lo intentamos enviar hasta 3 veces  
		$intentos=0;
		do{
			$ok = $mail ->Send();
			$intentos = $intentos+1;
		}while ( !$ok && $intentos < 3 );
		
		return $ok;
	}
}
?>
