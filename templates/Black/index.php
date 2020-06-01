<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
	<title>Links Folder</title>
<?php
include('header.html');
?>
</head>
<body>
<div id="imSite">
<div id="imHeader">
	<h1>Links Folder</h1>
</div>
<div class="imInvisible">
<hr />
<a href="#imGoToCont" title="Skip the main menu">Go to content</a>
</div>
<div id="imBody">
	<div id="imMenuMain">

<!-- Menu START -->
<a name="imGoToMenu"></a><p class="imInvisible">Main menu:</p>
<div id="imMnMn">
<?php
include('menu.php');
?>
</div>
<!-- Menu END -->

	</div>
<hr class="imInvisible" />
<a name="imGoToCont"></a>
	<div id="imContent">

<!-- Page START -->
<div id="imPage">

<div id="imCel0_00">
<div id="imCel0_00_Cont" style="float: left;">
	<div id="imObj0_00">

</div>
</div>
<div style="clear:both;"></div>
</div>
<p class="imAlign_left"><span class="ff2 fc0 fs10">Bienvenido!<br /><br />
Si desea, puede comprobar sus links en el siguiente cuadro de texto.<br />
Soportamos los siguientes Host!:<br />
* Megaupload.com, *rapidshare.com, * hotfile.com, * DepositFiles.com, * Fileserve.com, * Mediafire.com.
<HR width=60% align="center">
<div id="formu" class="formulario">
<form method="post" action="">
    <b>Cambio de puertos Megaupload:</b><br />
      <input name="port" type="radio" value="80" checked="checked" /> 80 (normal)   
      <input type="radio" name="port" value="800" /> 800  
      <input type="radio" name="port" value="1723" /> 1723<br />
      <textarea name="texto" cols="60" rows="10" id="texto" class="textarea"></textarea>
      <input type="submit" value="ingresar" />
</form>
<?php
if($_POST['texto']){
// Obtener Texto del formulario.
$cadena = $_POST['texto'];

// Revisar si el formulario estaba vacío o no; Cambiar Puerto si no está vacío.
if($cadena != ''){

// Extraer los links del formulario (deja de lado HTML y cualquier otro texto.
function extraer_links($str){
    $regexp = '#http://([A-z0-9.?=:/-]+)#';
    preg_match_all($regexp, $str, $m);
 
    return isset($m[0]) ? $m[0] : array();   
}

$fleta = extraer_links($cadena);
$fleto = array_unique($fleta);

// Crear Contador de Links
$i = 1;
// Checkea si el link está correcto e imprime los links clickeables, con puerto cambiado y checkeados. Ahora verifica si es rapidshare, mediafire, o megaupload.
foreach($fleto as $mina){
	$existe_en_rapidshare = strpos($mina, 'rapidshare.com');
	$existe_en_mediafire = strpos($mina, 'mediafire.com');
	$existe_en_hotfile = strpos($mina, 'hotfile.com');
	$existe_en_depositfiles = strpos($mina, 'depositfiles.com');
	$existe_en_fileserve = strpos($mina, 'fileserve.com');
	
	// Rapidshare
	if($existe_en_rapidshare){
		//obtener contenido de la web
		$file = file_get_contents($mina);
		$encontrar = strpos($file, '<h1>Error</h1>');
		if ($encontrar) {
			echo '<font color="#FF0000"><b>Parte '.$i++.':</b></font> <a href="'.$mina.'">'.$mina.'</a> <img src="http://megauploadlinks.donkiehost.com/cross.png"><br />';
		} else {
			echo '<font color="#006600"><b>Parte '.$i++.':</b></font> <a href="'.$mina.'">'.$mina.'</a> <img src="http://megauploadlinks.donkiehost.com/check.png"><br />';
		}
	} 
	
	// MediaFire
	elseif($existe_en_mediafire){ 
		//obtener contenido de la web
		$file = file_get_contents($mina);
		$encontrar = strpos($file, 'Invalid or Deleted File');
		if ($encontrar) {
			echo '<font color="#FF0000"><b>Parte '.$i++.':</b></font> <a href="'.$mina.'">'.$mina.'</a> <img src="http://megauploadlinks.donkiehost.com/cross.png"><br />';
		} else {
			echo '<font color="#006600"><b>Parte '.$i++.':</b></font> <a href="'.$mina.'">'.$mina.'</a> <img src="http://megauploadlinks.donkiehost.com/check.png"><br />';
		}
	}
	
	// HotFile
	elseif($existe_en_hotfile){ 
		//obtener contenido de la web
		$file = file_get_contents($mina);
		$encontrar = strpos($file, 'deleted');
		if ($encontrar) {
			echo '<font color="#FF0000"><b>Parte '.$i++.':</b></font> <a href="'.$mina.'">'.$mina.'</a> <img src="http://megauploadlinks.donkiehost.com/cross.png"><br />';
		} else {
			echo '<font color="#006600"><b>Parte '.$i++.':</b></font> <a href="'.$mina.'">'.$mina.'</a> <img src="http://megauploadlinks.donkiehost.com/check.png"><br />';
		}
	}
		
	// Deposit Files
	elseif($existe_en_depositfiles){ 
		//obtener contenido de la web
		$file = file_get_contents($mina);
		$encontrar = strpos($file, 'removed');
		if ($encontrar) {
			echo '<font color="#FF0000"><b>Parte '.$i++.':</b></font> <a href="'.$mina.'">'.$mina.'</a> <img src="http://megauploadlinks.donkiehost.com/cross.png"><br />';
		} else {
			echo '<font color="#006600"><b>Parte '.$i++.':</b></font> <a href="'.$mina.'">'.$mina.'</a> <img src="http://megauploadlinks.donkiehost.com/check.png"><br />';
		}
	}
	// FileServe
	elseif($existe_en_fileserve){ 
		//obtener contenido de la web
		$file = file_get_contents($mina);
		$encontrar = strpos($file, 'File not available');
		if ($encontrar) {
			echo '<font color="#FF0000"><b>Parte '.$i++.':</b></font> <a href="'.$mina.'">'.$mina.'</a> <img src="http://megauploadlinks.donkiehost.com/cross.png"><br />';
		} else {
			echo '<font color="#006600"><b>Parte '.$i++.':</b></font> <a href="'.$mina.'">'.$mina.'</a> <img src="http://megauploadlinks.donkiehost.com/check.png"><br />';
		}
	}
	
	// Megaupload
	else{
		//obtener contenido de la web
		$file = file_get_contents($mina);
		$encontrar = strpos($file, 'Invalid');
		if ($encontrar) {
			echo '<font color="#FF0000"><b>Parte '.$i++.':</b></font> <a href="'.$mina.'">'.$mina.'</a> <img src="http://megauploadlinks.donkiehost.com/cross.png"><br />';
		} else {
				if($_POST['port'] != ''){
		switch($_POST['port']) {
			case "80":
				$lol = $mina;
				break;
			case "800":
				$lol = str_replace("m/", "m:800/", $mina);
				break;
			case "1723":
				$lol = str_replace("m/", "m:1723/", $mina);
				break;
		}
	}else{
			$lol = $mina;
		}
			echo '<font color="#006600"><b>Parte '.$i++.':</b></font> <a href="'.$lol.'">'.$lol.'</a> <img src="http://megauploadlinks.donkiehost.com/check.png"><br />';
		}
	}
}
echo "Total Elapsed: ".$stopwatch->elapsed()." seconds<br />"; 
}
}
?>
</div>
<br />
</span></p>
</div>
<!-- Page END -->

	</div>
	<div id="imFooter" style="clear: both;">
	</div>
</div>
</div>
<div class="imInvisible">
<hr />
<a href="#imGoToCont" title="Read this page again">Back to content</a> | <a href="#imGoToMenu" title="Read this site again">Back to main menu</a>
</div>


<div id="imShowBoxBG" style="display: none;" onclick="imShowBoxHide()"></div>
<div id="imShowBoxContainer" style="display: none;" onclick="imShowBoxHide()"><div id="imShowBox" style="height: 200px; width: 200px;"></div></div>
<div id="imBGSound"></div>
<div id="imToolTip"><script type="text/javascript">var imt = new IMTip;</script></div>
</body>
</html>
