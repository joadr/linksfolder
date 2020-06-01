<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home - Links Folder</title>
</head>
<body>
<!-- Formulario -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <b>Cambio de puertos:</b><br />
      <input name="port" type="radio" value="80" checked="checked" /> 80 (normal)   
      <input type="radio" name="port" value="800" /> 800  
      <input type="radio" name="port" value="1723" /> 1723<br />
      <textarea name="texto" cols="60" rows="10" id="texto"></textarea>
      <input type="submit" value="ingresar" />
</form>
<?php
// Obtener Texto del formulario.
$cadena = $_POST['texto'];

// Revisar si el formulario estaba vacío o no; Cambiar Puerto si no está vacío.
if($cadena != ''){
	if($_POST['port'] != ''){
		switch($_POST['port']) {
			case "80":
				$lol = $cadena;
				break;
			case "800":
				$lol = str_replace("m/", "m:800/", $cadena);
				break;
			case "1723":
				$lol = str_replace("m/", "m:1723/", $cadena);
				break;
		}
	}else{
			$lol = $cadena;
		}
	
// $lol = str_replace("m/", "m:". $puerto ."/", $cadena);

// Crear Contador de Links
$i = 1;

// Extraer los links del formulario (deja de lado HTML y cualquier otro texto.
function extraer_links($str){
    $regexp = '#http://([A-z0-9.?=:/-]+)#';
    preg_match_all($regexp, $str, $m);
 
    return isset($m[0]) ? $m[0] : array();   
}

$fleta = extraer_links($lol);
$fleto = array_unique($fleta);

// Checkea si el link está correcto e imprime los links clickeables, con puerto cambiado y checkeados
foreach($fleto as $mina){
	//obtener contenido de la web
	$file = file_get_contents($mina);
	$encontrar = strpos($file, 'Invalid');
	if ($encontrar !== false) {
			echo '<font color="#FF0000"><b>Parte '.$i++.':</b></font> <a href="'.$mina.'">'.$mina.'</a> <img src="http://megauploadlinks.donkiehost.com/cross.png"><br />';
	} else {
			echo '<font color="#006600"><b>Parte '.$i++.':</b></font> <a href="'.$mina.'">'.$mina.'</a> <img src="http://megauploadlinks.donkiehost.com/check.png"><br />';
	}
}
}
?>
</body>
</html>