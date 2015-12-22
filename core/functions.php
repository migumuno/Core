<?php
	/**
	 * Sube un archivo a la carpeta uploads
	 * @param unknown_type $arr_file_desc
	 * @param unknown_type $destino
	 * @param unknown_type $name
	 */
	function subirArchivo ($arr_file_desc, $destino=null, $name=null){
		$arr_file = array();
        $file_extension = file_extension ($arr_file_desc['name']);
         
        if($destino == null){
        	$dia = date("j");
        	$mes = date("n");
        	$anyo = date("Y");
        	$new_relative_path = $anyo.BARRA_SERVIDOR.$mes.BARRA_SERVIDOR.$dia;
        }else{
        	$new_relative_path = $destino;
        }
        
        if($name!=null){
        	$new_file_name = $name;
        }else{
        	$new_file_name = str_replace(".".$file_extension, "", $arr_file_desc['name']);
        }
         
        // Creamos la ruta de carpetas
        createPath ($new_relative_path);       
         
        // Si existe el archivo, con un contador cambio el nombre hasta que deje de existir
        $cont = 0;

        while ( file_exists(UPLOAD_DIR.BARRA_SERVIDOR.$new_relative_path.BARRA_SERVIDOR.$new_file_name.".".$file_extension) ){
            $cont++;
            $new_file_name .= $cont;
        }
         
        if (file_exists($arr_file_desc['tmp_name'])){
            if( !copy($arr_file_desc['tmp_name'], UPLOAD_DIR.BARRA_SERVIDOR.$new_relative_path.BARRA_SERVIDOR.$new_file_name.".".$file_extension) ){
                   print "Error, no ha sido posible la copia del archivo";
            } else {
            	//borro el archivo temporal
                unlink ($arr_file_desc['tmp_name']);
            }
        } else {
           header('Content-type: application/json');
	   
			//objeto json que devolverá la respuesta
			$jsondata = array();
		    $jsondata['error']	= true;
		    $jsondata['msg']	= "No se ha podido subir el archivo, intentelo de nuevo o contacte con su administrador.";
		 
		    echo json_encode($jsondata);
		    exit;
        }
         
        $new_file_path = $new_relative_path.BARRA_SERVIDOR.$new_file_name.".".$file_extension;
        $origen_dir = UPLOAD_DIR.BARRA_SERVIDOR.substr( $new_file_path, 0, strrpos($new_file_path, BARRA_SERVIDOR) ).BARRA_SERVIDOR;
        $nombre_archivo = substr( $new_file_path, (strrpos($new_file_path, BARRA_SERVIDOR)+1) );
        $nombre_sin_extension = substr( $nombre_archivo, 0, strrpos($nombre_archivo, ".") );
        $extension = substr( $new_file_path, strrpos($new_file_path, ".")+1 );
        
        //si es una imagen, creo una más pequeña para agilizar la carga con thumbnails
        if ($extension=="jpg"||$extension=="gif"||$extension=="png") {
            //$info = getimagesize ($new_file_path);
            img_resize( $origen_dir.$nombre_archivo, THUMBNAIL_WIDTH, $origen_dir, $nombre_sin_extension.".".$extension, THUMBNAIL_HEIGHT);
        }
         
        // Devuelvo la ruta sin la carpeta padre por si se cambia en la configuracion
        return $new_file_path;
    }
	
    /**
     * Crea una estructura de directorios
     * @param string $new_path
     */
    function createPath ($new_path){
        $arrCarpetas = explode (BARRA_SERVIDOR, $new_path);
        
        //recorro todas las carpetas que hay en la ruta que me pasan
        for( $i=0; $i<(sizeof($arrCarpetas)); $i++ ){
            
        	$path = "";
            
        	//voy creando el path
        	for( $j=0; $j<=$i; $j++ ){
                $path .= $arrCarpetas[$j].BARRA_SERVIDOR;
            }
            
            //si el path no existe, lo creo
            if( !is_dir(UPLOAD_DIR.BARRA_SERVIDOR.$path) ){
                mkdir ( UPLOAD_DIR.BARRA_SERVIDOR.$path, 0755 );
            }
        }
    }

    /**
     * Redimensiona una imagen
     * @param unknown_type $tmpname
     * @param unknown_type $width
     * @param unknown_type $save_dir
     * @param unknown_type $save_name
     * @param unknown_type $height
     */
	function img_resize( $tmpname, $width, $save_dir, $save_name, $height ){
	    $save_dir .= ( substr($save_dir,-1) != BARRA_SERVIDOR) ? BARRA_SERVIDOR :BARRA_SERVIDOR;
	    $gis       = getimagesize($tmpname);
	    $type      = $gis[2];
	
	    switch($type) {
	        case "1": $imorig = imagecreatefromgif($tmpname); break;
	        case "2": $imorig = imagecreatefromjpeg($tmpname);break;
	        case "3": $imorig = imagecreatefrompng($tmpname); break;
	        default:  $imorig = imagecreatefromjpeg($tmpname);
	    }

	    $x = imagesx($imorig);
        $y = imagesy($imorig);
        
        $aw = $height;
        $ah = $width;
        
        $im = imagecreatetruecolor($aw,$ah);
        if (imagecopyresampled($im,$imorig , 0,0,0,0,$aw,$ah,$x,$y)) {
	        if (imagejpeg($im, $save_dir.$save_name)) {
	            return true;
	        } else {
	            return false;
	        }
	    }
	}

	/**
	 * Genera una Url frindly
	 * @param unknown_type $string
	 */
	function text2url($string) {
        $string = unacent($string);
        $spacer = "-";
        $string = trim($string);
        $string = strtolower($string);
        $string = trim(preg_replace("[^ A-Za-z0-9_]", " ", $string)); 
        $string = preg_replace("/[ \t\n\r]+/", "-", $string);
        $string = str_replace(" ", $spacer, $string);             
        $string = str_replace(",", $spacer, $string);
        $string = preg_replace("/[ -]+/", $spacer, $string);
        return $string;
	}
	
	/**
	 * Limpia los acentos de una cadena
	 * @param string $text texto a limpiar
	 */
	function unacent($text){
		static $test = array();
		if (empty($test)){
			$html = // Obtenemos la tabla
			get_html_translation_table(HTML_ENTITIES);

			foreach ($html as $char => $ord){
				if (ord($char) >= 192){
					$test[$char] = $ord[1];
				}
			}
		} // Cambios de acentos...
		$text = strtr($text, $test);
		return $text;
	}
    
    /**
     * Transforma lo recibido a utf8
     * @param unknown_type $in
     */
      function to_utf8($in){
        if (is_array($in)) {
            foreach ($in as $key => $value) {
                $out[to_utf8($key)] = to_utf8($value);
            }
        } elseif(is_string($in)) {
            if(mb_detect_encoding($in) != "UTF-8")
                return utf8_encode($in);
            else
                return $in;
        } else {
            return $in;
        }
        return $out;
    } 
    
    /**
     * Compara 2 fechas y devuelve la diferencia de días
     * @param unknown_type $fecha_inicio
     * @param unknown_type $fecha_fin
     */
    function compare_dates ($fecha_inicio, $fecha_fin=null){
        if($fecha_fin==null ||
            $fecha_fin=="0000-00-00 00:00:00" ||
            $fecha_fin==""){
            $todays_date = date("Y-m-d H:i:s");
            $fecha_fin = $todays_date;
        }
        $numero_fecha_fin    = strtotime($fecha_fin);
        $numero_fecha_inicio = strtotime($fecha_inicio);
        $difference          = $numero_fecha_fin-$numero_fecha_inicio;
        // print "[$fecha_fin]-[$fecha_inicio]=$difference";
        // Lo pasamos a dias
        return ((($difference/60)/60)/24);
    }
    
    /**
     * Comprime un archivo (solo apto para servidores linux)
     * @param unknown_type $origen
     * @param unknown_type $destino
     */
    function zip_file ($origen, $destino){
		$cmd = "zip -j \"".$destino."\" ".
				"\"".$origen."\"";
		// print $cmd;
		$res = `$cmd`;
		return $res;
	}
	
	/**
	 * Descomprime un archivo (solo apto para servidores linux)
	 * @param unknown_type $origen
	 * @param unknown_type $destino
	 * @param unknown_type $cd_dir
	 */
	function zip_dir ($origen, $destino, $cd_dir=null){
	    $cmd = "";
	    if($cd_dir!=null){
	        $cmd .= "cd $cd_dir/\n";
	    }
		$cmd .= "zip -r \"".$destino."\" ".
				"\"".$origen."\"";
		// print $cmd;
		$res = `$cmd`;
		return $res;
	}
	
	/**
	 * Comprime un archivo con los métodos de php
	 * @param unknown_type $zip_file
	 * @param unknown_type $source_file
	 * @param unknown_type $new_name
	 */
	function zip_with_php ($zip_file, $source_file, $new_name=null){
	    
	    if(file_exists($source_file)){
            //Open zip archive.
            $zip = new ZipArchive();
    
            if(file_exists($zip_file)){
                $zip->open($zip_file);
            } else {
                $zip->open($zip_file, ZipArchive::CREATE) or die('Error: Unable to create zip file');
            }

            if($new_name!=null){
                //Add the same file with different name
                $zip->addFile($source_file, $new_name);
            } else {
                $zip->addFile($source_file);
            }
            //Close zip archive.
            $zip->close();
            return true;
        } else {
            return false;
        }
	}
	
	/**
	 * Descomprime un archivo (solo para servidores linux)
	 * @param unknown_type $origen
	 * @param unknown_type $destino
	 */
	function unzip_file ($origen, $destino=null){
	    
	    if($destino==null) $destino = TMP_DIR;
	    
		$cmd = "unzip \"".$origen."\" -d \"".$destino."/.\" ";
		$res = `$cmd`;
		// print $cmd;
		
		$files = array ();
		if ($handle = opendir($destino)) {
            while (false !== ($file = readdir($handle))) {
                $sfile = strtolower($file);
                if( (strpos($sfile, ".zip")===false)  &&
                   !is_dir($destino.BARRA_SERVIDOR.$file) ){
                    array_push($files, $file);
                }
            }
            closedir($handle);
        }
        unlink ($origen);
        
        return $files;
	}
	
	/**
	 * Elimina un directorio (solo servidores linux)
	 * @param unknown_type $dir
	 */
	function clear_dir ($dir){
	    if(strlen($dir)>10){
		    $cmd = "rm -R ".$dir."/* ";
    		// print $cmd;
    		$res = `$cmd`;
    		return $res;
		} else {
		    return "";
		}
	}
	
	/**
	 * Obtiene el thumbnail de una foto subida con nuestro método de subida de archivos
	 * @param unknown_type $source
	 * @param unknown_type $type
	 */
	function get_thumbnail ($source, $type="Foto"){
	    if($type=="Foto"){
	        $file_without_extension = strtolower(substr($source, 0, strrpos($source,".")));
    		$file_extension         = strtolower(substr(strrchr($source,"."),1));
    		return $file_without_extension."_z".".".$file_extension;
	    } else {
	        return "doc.jpg";
	    }
	}
	
	/**
	 * Devuelve la extensión de un archivo
	 * @param unknown_type $source
	 */
	function file_extension ($source){
	    return strtolower(substr(strrchr($source,"."),1));
	}	
	
	/**
	 * Encripta un string (análogo al método decrypt)
	 * @param unknown_type $text
	 */
	function encrypt($text){
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$enc = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, ENCRYPT_HASH, $text, MCRYPT_MODE_ECB, $iv));
		// print $enc."<br>";
		$enc = str_replace("%", "54SFD", $enc);
		$enc = str_replace("+", "5SDFC", $enc);
		$enc = str_replace("=", "72ZX1", $enc);
		$enc = str_replace("=", "42SD2", $enc);
		$enc = str_replace("/", "F4Z42", $enc);
		// print $enc."<br>\n";
		return $enc;
    }
    
    /**
     * desencripta un string encriptado por el método encrypt
     * @param unknown_type $text
     */
    function decrypt($text){
        // print $text."<br>\n";
        $text = str_replace("54SFD", "%", $text);
	    $text = str_replace("5SDFC", "+", $text);
	    $text = str_replace("72ZX1", "=", $text);
	    $text = str_replace("42SD2", "?", $text);
	    $text = str_replace("F4Z42", "/", $text);
	    // print $text."<br>\n";
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		//I used trim to remove trailing spaces
		return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, ENCRYPT_HASH, base64_decode($text), MCRYPT_MODE_ECB, $iv));
    }

    /**
     * Método que pasa un valor a float, si tiene coma lo cambia por punto y si no tiene decimales le pone el .00
     * @param unknown_type $valor
     */
	function to_float ($valor){
		if($valor==""){
			$valor = 0.00;
		} else {
		    // Obtengo las posiciones de los signos de puntuacion
		    $coma  = strpos($valor,",");
		    $punto = strpos($valor,".");
		    
		    // si tiene punto y está a la izquierda de la coma, eliminamos el punto porque es de miles
		    if($punto>-1){
		        // 22.000,00
		        if($punto < $coma){
		            $valor = str_replace(".", "", $valor); // replace '.' with ''
		        }
		    }
		    
			$valor = str_replace(",", ".", $valor); // replace ',' with '.'
		}
		return sprintf ('%.2f', $valor);
	}
	
	/**
	 * Método que pone la coma a los decimales
	 * @param unknown_type $valor
	 */
	function to_spanish_float ($valor){
	    // Obtengo las posiciones de los signos de puntuacion
	    $coma  = strpos($valor,",");
	    $punto = strpos($valor,".");
	    
	    // si tiene punto y está a la izquierda de la coma, eliminamos el punto porque es de miles
	    if($coma>-1){
	        // 22,000.00
	        if($coma < $punto){
	            $valor = str_replace(",", "", $valor); // replace '.' with ''
	        }
	    }
	    
	    $valor = to_float ($valor);
		$valor = str_replace(",", ".", $valor); // replace ',' with '.'
		
		$formato_americano = sprintf ('%.2f', $valor);
		return str_replace(".", ",", $formato_americano);
	}

	function convertir_fecha_espanol ($fecha){
        if(trim($fecha)=="" || $fecha=="0000-00-00 00:00:00" || $fecha=="0000-00-00"){
            return "";
        } else {
            $timestamp = strtotime($fecha);
            return date('d/m/Y', $timestamp);
        }
    }
    
    function convertir_fecha_espanol_completa ($fecha){
        if(trim($fecha)=="" || $fecha=="0000-00-00 00:00:00" || $fecha=="0000-00-00"){
            return "";
        } else {
            $timestamp = strtotime($fecha);
            return date('d/m/Y H:i', $timestamp);
        }
    }
    
     function convertir_fecha_ingles_completa ($fecha){
        if(trim($fecha)=="" || $fecha=="00:00:00 00/00/0000" || $fecha=="00/00/0000"){
            return "";
        } else {
            $timestamp = strtotime($fecha);
            return date('Y-d-m H:i:s', $timestamp);
        }
    }
    
    function convertir_fecha_ingles ($fecha, $hora_defecto=null){
        if($fecha==null || trim($fecha)=="" || $fecha=="00/00/0000"){
            return "";
        } else {
            $timestamp = strtotime($fecha);
            if($timestamp!=null){
            	return date('Y-d-m', $timestamp);
            }else{
            	$fecha_dividida = explode("/", $fecha);	
            	return $fecha_dividida[2]."-".$fecha_dividida[1]."-".$fecha_dividida[0];
            }
        }
    }

	/**
	 * Convierte un array en un string (método análogao a string_to_array)
	 * @param array $array
	 */
	function array_to_string($array) {
       $retval = '';
       $null_value = "^^^";
       foreach ($array as $index => $val) {
           if(gettype($val)=='array') $value='^^array^'.array_to_string($val);    else $value=$val;
           if (!$value)
               $value = $null_value;
           $retval .= urlencode(base64_encode($index)) . '|' . urlencode(base64_encode($value)) . '||';
       }
       return urlencode(substr($retval, 0, -2));
    }

    /**
     * Convierte un string en un array (método análogo a array_to_string)
     * @param unknown_type $string
     */
    function string_to_array($string) {
       $retval = array();
       $string = urldecode($string);
       $tmp_array = explode('||', $string);
       $null_value = urlencode(base64_encode("^^^"));
       foreach ($tmp_array as $tmp_val) {
           list($index, $value) = explode('|', $tmp_val);
           $decoded_index = base64_decode(urldecode($index));
           if($value != $null_value){
               $val= base64_decode(urldecode($value));
               if(substr($val,0,8)=='^^array^') $val=string_to_array(substr($val,8));
               $retval[$decoded_index]=$val;
             }
           else
               $retval[$decoded_index] = NULL;
       }
       return $retval;
    } 

	/**
	 * Devuelve el tamaño de un archivo en kb
	 * @param int $peso total del archivo
	 * @param int $decimales que quieres tener
	 */
	function tamano_archivo($peso , $decimales = 2 ) {
		return round($peso/pow(1024,($i = floor(log($peso, 1024)))),$decimales )." Kb";
	} 
	
	/**
	 * Método que convierte un xml en un array
	 * @param xml $xml que se quiere pasar a array
	 * @param string $main_heading key de la parte del xml que se quiere devolver
	 */
	function xml_to_array($xml,$main_heading = '') {
	    $deXml = simplexml_load_string($xml);
	    $deJson = json_encode($deXml);
	    $xml_array = json_decode($deJson,TRUE);
	    if (! empty($main_heading)) {
	        $returned = $xml_array[$main_heading];
	        return $returned;
	    } else {
	        return $xml_array;
	    }
	}

	/**
	 * El método add filter prepara los filtros que después se compondrán
	 * a la hora de ejecutar una query
	 * @param array $filters array donde estamos guardando los filtros
	 * @param string $field nombre del campo de la base de datos a filtrar
	 * @param $value valor del campo
	 * @param string $comparative tipo de comparativa a aplicar. Se aceptan 
	 * todas las que se usen en sql
	 * @param string $concatenation and / or. Cuando se usen or, todo debe
	 * llevar la concatenación or para que funcione de manera correcta
	 */
	function add_filter( &$filters, $field, $value, $comparative="=", $concatenation="and" ){
		if($comparative!='in' && $comparative!='not in'){
			$key_row 	= array("field"=>$field, "comparative"=>$comparative, "concatenation"=>$concatenation);
		}else{
			$key_row 	= array("field"=>$field, "comparative"=>$comparative, "concatenation"=>$concatenation, "value"=>$value);
		}
		$value_row 	= array("field"=>$field, "value"=>$value);
		
		if(!isset($filters['keys']) || !is_array($filters['keys'])){
			$filters['keys'] = array();
		}
		
		if(!isset($filters['values']) || !is_array($filters['values'])){
			$filters['values'] = array();
		}
		
		array_push($filters['keys'], $key_row);
		//el in y el not in van directamente por las keys
		if($comparative!='in' && $comparative!='not in'){
			$filters['values'][":".$field] = $value;
		}

        return $filters;
    }

    /**
     * Método que prepara los filtros para una query genérica
     * @param array $filters este array se prepara con el método
     * add_filter
     */
	function prepare_filters($filters){
		if ($filters==null) return "";

		//inicio_variables
		$filter_query	= "WHERE ( ";
       	$filter_pos		= 0;
       	$num_or	 		= 0;
       	$num_and 		= 0;
       	
       	// primero cuento los or que hay para que no me printe un "or (" al llegar al último or que haya.
        foreach($filters as $key=>$value ){
        	if(strtolower($value['concatenation'])=="or"){
        		$num_or++;
        	}
        }
        
        // ahora cuento los and
        foreach($filters as $key=>$value ){
        	if(strtolower($value['concatenation'])=="and"){
        		$num_and++;
        	}
        }
        
        //si no hay ors recorro los and
        if($num_or==0){
        	foreach($filters as $key1=>$value1 ){
        		if(strtolower($value1['concatenation'])=="and"){

        			//si es distinto de 0 ponemos un and despues de cada filtro para que el primero no lleve and
        			if($filter_pos!=0){$filter_query .= " and ";}
        			$filter_pos++;
        			if($value1['comparative'] == "like" || $value1['comparative'] == "not like") {
        				$filter_query .= " LOWER(".$value1['field'].") ".$value1['comparative']." LOWER(:".$value1['field'].") ";
        			} else if( $value1['comparative'] == "float" ){
        				$filter_query .= " cast(".$value1['field']." as DECIMAL(9,2)) ".$value1['comparative']." cast('".$value1['field']."' as DECIMAL(9,2) ) ";
        			} else if( $value1['comparative'] == "in" || $value1['comparative'] == "not in"){
        				$filter_query .= " ".$value1['field']." ".$value1['comparative']." (".$value1['value'].") ";
        			} else {
        				$filter_query .= " ".$value1['field']." ".$value1['comparative']." :".$value1['field']." ";
        			}

        		}
        	}
        }

        //primero recorro los or porque la estructura es ( and )or( ... and ...and ... )
        foreach($filters as $key=>$value ){
        	if(strtolower($value['concatenation'])=="or"){
        		//seguidamente recorro los and que van dentro de cada or
        		foreach($filters as $key1=>$value1 ){
        			if(strtolower($value1['concatenation'])=="and"){
	        			//si es distinto de 0 ponemos un and despues de cada filtro para que el primero no lleve and
	        			if($filter_pos!=0){$filter_query .= " and ";}
	        			$filter_pos++;
	        			
	        			if($value1['comparative'] == "like" || $value1['comparative'] == "not like") {
	        				$filter_query .= " LOWER(".$value1['field'].") ".$value1['comparative']." LOWER(:".$value1['field'].") ";
	        			} else if( $value1['comparative'] == "float" ){
	        				$filter_query .= " cast(".$value1['field']." as DECIMAL(9,2)) ".$value1['comparative']." cast('".$value1['field']."' as DECIMAL(9,2) ) ";
	        			} else if( $value1['comparative'] == "in" || $value1['comparative'] == "not in"){
	        				$filter_query .= " ".$value1['field']." ".$value1['comparative']." (".$value1['value'].") ";
	        			} else {
	        				$filter_query .= " ".$value1['field']." ".$value1['comparative']." :".$value1['field']." ";
	        			}

        			}
        		}
        		
        		$filter_pos = 0;
        		if($filter_pos!=0){$filter_query .= " and ";}
        		$filter_pos++;
        		if($value['comparative'] == "like" || $value['comparative'] == "not like") {
        			$filter_query .= " LOWER(".$value['field'].") ".$value['comparative']." LOWER(:".$value['field'].") ";
        		} else if( $value['comparative'] == "float" ){
        			$filter_query .= " cast(".$value['field']." as DECIMAL(9,2)) ".$value['comparative']." cast('".$value['field']."' as DECIMAL(9,2) ) ";
        		} else if( $value['comparative'] == "in" || $value['comparative'] == "not in"){
        			$filter_query .= " ".$value['field']." ".$value['comparative']." (".$value['value'].") ";
        		} else {
        			$filter_query .= " ".$value['field']." ".$value['comparative']." :".$value['field']." ";
        		}
        		//aqui solo pinto or si no es el último
        		
        		$num_or--;
        		if($num_or>0){$filter_query .= " ) or ( ";}
        		
        	}
        }

        //cierro todo
        if(sizeof($filters)>0) $filter_query .= " ) ";
        // print $filter_query;
         
        return $filter_query;
	}
	
	/**
	 * MÈtodo Para la aplicación de seguridad
	 * a bajo nivel, recibe un array de datos
	 * y limpia sus elementos de manera b·sica
	 * pero efectiva 
	 * @param array $data
	 * @param sanitiser $sanitiser: el sanitizador de html purify
	 * @param bool $is_cookie: identifica si el elemento a identificar es una cookie
	 */
	function sanitize($data, $sanitiser, $is_cookie=false){
		//recorro todos los datos que me pasan
		foreach($data as $key=>$data_element){
			//si es una cookie, sanitizo una cookie
			if($is_cookie){
				$data[$key] = filter_var($data_element, FILTER_SANITIZE_STRING); //caracteres que no gustan a php
			}else{
				//si el dato es un array, recursión
				if(is_array($data_element)){
					sanitize($data_element, $sanitiser);
				}else{//en caso contrario, sanitizo mínimamente
					//si contiene cualquier etiqueta html /javascript
					if(is_html($data[$key])){
						$data[$key] = $sanitiser->purify($data[$key]);//protección contra xss
					}else{//si es una variable "normal"
						$data[$key] = filter_var($data_element, FILTER_SANITIZE_STRING); //caracteres que no gustan a php
						$data[$key] = prevent_sqlinjection($data[$key]);//protección contra sql injection
					}
					
				}
			}
		}
		
		return $data;
	}
	
	/**
	 * MÈtodo que determina si un string es parte de un
	 * código html o no.
	 * @param string $str
	 * @param bool $count si quieres que te diga dónde empezarÌa
	 */
	function is_html($str, $count = FALSE){
	    $html = array('A','ABBR','ACRONYM','ADDRESS','APPLET','AREA','B','BASE','BASEFONT','BDO','BIG','BLOCKQUOTE','BODY','BR','BUTTON','CAPTION','CENTER','CITE','CODE','COL','COLGROUP','DD','DEL','DFN','DIR','DIV','DL','DT','EM','FIELDSET','FONT','FORM','FRAME','FRAMESET','H1','H2','H3','H4','H5','H6','HEAD','HR','HTML','I','IFRAME','IMG','INPUT','INS','ISINDEX','KBD','LABEL','LEGEND','LI','LINK','MAP','MENU','META','NOFRAMES','NOSCRIPT','OBJECT','OL','OPTGROUP','OPTION','P','PARAM','PRE','Q','S','SAMP','SCRIPT','SELECT','SMALL','SPAN','STRIKE','STRONG','STYLE','SUB','SUP','TABLE','TBODY','TD','TEXTAREA','TFOOT','TH','THEAD','TITLE','TR','TT','U','UL','VAR');
	    if(preg_match_all("~(<\/?)\b(".implode('|',$html).")\b([^>]*>)~i",$str,$c)){
	        if($count)
	            return array(TRUE, count($c[0]));
	        else
	            return TRUE;
	    }else{
	        return FALSE;
	    }
	} 
	
	/**
	 * MÈtodo que sirve como primerva barrera de limpieza
	 * para la prevención de sql injection
	 * @param string $data
	 */
	function prevent_sqlinjection ($data){
		return addslashes(limpiarCadena(preg_replace('/[^·ÈÌó¡\.Õ"/Ò-a-zA-Zá-úÁ-ÚÑñ0-9-_;:@.\s\n\r\/]/i', '', $data)));
	}
	
	/**
	 * MÈtodo asociado a prevent_sqlinjection
	 * limpia una cadenao con populares cadenas
	 * asociadas a lenguaje sql
	 * @param string $valor
	 */
	function limpiarCadena($valor){
		$search = array(
			 "SELECT"
			,"COPY"
			,"DELETE"
			,"DROP"
			,"1=1"
			,"UNION"
			,"DUMP"
			," OR "
			,"%"
			,"LIKE"
			,"--"
			,"^"
			,"["
			,"]"
			,"\\"
			,"!"
			,"°"
			,"?"
			,"="
			,"&"
		);
		
		$replace = array(
			 ""
			,""
			,""
			,""
			,""
			,""
			,""
			,""
			,""
			,""
			,""
			,""
			,""
			,""
			,""
			,""
			,""
			,""
			,""
			,""
		);
		$valor = str_ireplace($search,$replace,$valor);
		return $valor;
	}
	
	/**
	 * MÈtodo que hace una expulsión de seguridad del site
	 * borra sesión, elimina todas las variables de entorno y redirige a la home
	 * @param string $url_expulsion url a la que queremos expulsar, por defecto vamos a index
	 */
	function expulsion_seguridad($url_expulsion="/"){
		unset($_COOKIE);
		unset($_REQUEST);
		unset($_GET);
		unset($_POST);
		unset($_FILES);
		session_unset();
		session_destroy();
		session_start();
		session_regenerate_id(true);
		header("HTTP/1.1 302 Moved Temporarily");
		header('Location: '.$url_expulsion);
  		die(); 
	}
	
	/**
	 * MÈtodo que envÌa lo mails
	 * @param email $para
	 * @param string $asunto
	 * @param string $cuerpo
	 * @param email $email_desde // por si queremos cambiar el remitente
	 * @param string $nombre_desde // por si queremos cambiar el temitente
	 */
	function enviar_email($para, $asunto, $cuerpo, $email_desde=null, $nombre_desde=null) {
        require_once($_SERVER["DOCUMENT_ROOT"]."/classes/Mailing/class.mailer.php");
        
        $desarrollo 		= unserialize(DEVELOPMENT);
        $mail           	= new Mailer();
        $correo         	= new stdClass ();
        
        //preparo las variables del correo
		$correo->para		= ($desarrollo['enabled'])?$desarrollo['development_mail']:$para; //si desarrollo est· activo, todos los correos van a desarrollo
        $correo->asunto 	= $asunto;
        $correo->cuerpo 	= $cuerpo;
        $correo->From 		= $email_desde;
        $correo->FromName 	= $nombre_desde;
        
        return $mail->enviar($correo);
    }
    
    /**
     * Cambia un string de utf8 a sio
     * @param string $input
     */
    function utf2iso ($input){
        if(is_array  ($input)){
            $array_temp = array ();
            foreach($input as $name => $value) {
                if(is_array($value)) {
                    $array_temp[(mb_detect_encoding($name." ",'UTF-8,UTF-8') == 'UTF-8' ? utf8_decode($name) : $name )] = utf2iso($value);
                } else {
                    $array_temp[(mb_detect_encoding($name." ",'UTF-8,UTF-8') == 'UTF-8' ? utf8_decode($name) : $name )] = (mb_detect_encoding($value." ",'UTF-8,UTF-8') == 'UTF-8' ? utf8_decode($value) : $value );
                }
            }
            return $array_temp;
        } else {
            if(mb_detect_encoding($input." ",'UTF-8,UTF-8') == 'UTF-8'){
                return utf8_decode($input);
            } else {
                return $input;
            }
        }
    }
	
    /**
     * Devuelve quien ha llamado a la funciópn
     * Enter description here ...
     */
	function get_caller(){
		$callers=debug_backtrace();
		return ucfirst((($callers[3]['class']!=null)?$callers[3]['class']."->":"").$callers[3]['function']."()");
	}
	
	/**
	 * 
	 * Muestra una query de manera friendly
	 * @param unknown_type $query
	 * @param unknown_type $results
	 * @param unknown_type $params
	 */
	function show_query($query,$results=false,$params=false){
		?>
			<table cellpadding="5" style="border:3px solid #3E50B4;">
			  <tr style="background:#3E50B4;color:white;">
			    <th>Llamado desde</th>
			    <th>Query</th>
			  </tr>
			  <tr>
			    <td><?=get_caller()?></td>
			    <td><?=$query?></td>
			  </tr>
			 <?=(!$results && !$params)?"</table><hr>":""?>
		<?php 
	}
	
	/**
	 * Muestra los resultados de una query
	 * va asociado el mÈtodo show_query
	 * @param array $data
	 */
	function show_query_result($data){
		?>
			<tr>
			    <td style="background:#3E50B4;color:white;">Resultados</td>
				<td><?=show($data)?></td>
			</tr>
		<?php 
	}
	
	/**
	 * Muestra los par·metros utilizados en una query
	 * de manera friendly, va asociado al mÈtodo show_query
	 * @param array $data
	 */
	function show_query_params($data){
		?>
			<tr>
			    <td style="background:#3E50B4;color:white;">Parámetros</td>
				<td><?=show($data)?></td>
			</tr>
		<?php 
	}
	
	/**
    * Muestra algo de manera friendly
    * @param $datos
    * @param $titulo
    */
    function show($datos, $titulo = false){
        if($titulo){
            echo "<h3>" . $titulo . "</h3>";
        }
        echo "<pre>";
            print_r($datos);
        echo "</pre>";
    }
	
	/**
	 * Método que transforma un objeto en un array
	 * @param objeto $d
	 * @return Arra:|unknown
	 */
	function objectToArray($d) {
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}
	
		if (is_array($d)) {
			/*
				* Return array converted to object
				* Using __FUNCTION__ (Magic constant)
				* for recursive call
				*/
			return array_map(__FUNCTION__, $d);
		}else {
			// Return array
			return $d;
		}
	}
	
	/**
	 * Método que transforma un array en un objeto
	 * @param array $d
	 * @return StdClass|unknown
	 */
	function arrayToObject($d) {
		if (is_array($d)) {
			/*
				* Return array converted to object
				* Using __FUNCTION__ (Magic constant)
				* for recursive call
				*/
			return (object) array_map(__FUNCTION__, $d);
		}else {
			// Return object
			return $d;
		}
	}
?>