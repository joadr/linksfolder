<?php require_once('Connections/linksfolder.php'); 
include('lang/main.php');
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
//we start the clock
class StopWatch {
    public $total;
    public $time;
   
    public function __construct() {
        $this->total = $this->time = microtime(true);
    }
   
    public function clock() {
        return -$this->time + ($this->time = microtime(true));
    }
   
    public function elapsed() {
        return microtime(true) - $this->total;
    }
   
    public function reset() {
        $this->total=$this->time=microtime(true);
    }
} 
$stopwatch = new StopWatch();
usleep(1000000);

// we check if there's a folder trying to be checked
if($_GET['f']){
	// We Obtain The Folders
	mysql_select_db($database_linksfolder, $linksfolder);
	$query_viewfolder = sprintf("SELECT * FROM folders WHERE cid = %s", GetSQLValueString($_GET['f'], "text"));
	$viewfolder = mysql_query($query_viewfolder, $linksfolder) or die(mysql_error());
	$row_viewfolder = mysql_fetch_assoc($viewfolder);
	$totalRows_viewfolder = mysql_num_rows($viewfolder);
	
	// We obtain the author of the folder and he's email
	mysql_select_db($database_linksfolder, $linksfolder);
	$query_viewemail = sprintf("SELECT id, email FROM usuarios WHERE id = %s", GetSQLValueString($row_viewfolder['uid'], "text"));
	$viewemail = mysql_query($query_viewemail, $linksfolder) or die(mysql_error());
	$row_viewemail = mysql_fetch_assoc($viewemail);
	$totalRows_viewemail = mysql_num_rows($viewemail);
	// check folder's passsword
	if($_POST['password'] != $row_viewfolder['password']){
		echo 'Please, input folder\'s Password:<br /><form method="POST" action="" id="password"><input type="text" value="" name="password" /><input type="submit" value="Enter" /></form>';
	//password is wordking
	} else {
		echo '<h1>'.$row_viewfolder['title'].'</h1>';
		// Separate links
		$start = explode(" - ", $row_viewfolder['links']);
		// Start Checking them
		// Crear Contador de Links
		$i = 1;
		// Crear contador de Links malos.
		$m = 0;
		// if count($array) > 100 then cut the array.
		if(count($start) > 100){
		$start = array_slice($start, 0, 100);
		}
		echo count($start);
		// Checkea si el link está correcto e imprime los links clickeables, con puerto cambiado y checkeados. Ahora verifica si es rapidshare, mediafire, o megaupload.
		foreach($start as $mina){
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
					++$m;
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
					++$m;
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
					++$m;
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
					++$m;
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
					++$m;
				} else {
					echo '<font color="#006600"><b>Parte '.$i++.':</b></font> <a href="'.$mina.'">'.$mina.'</a> <img src="http://megauploadlinks.donkiehost.com/check.png"><br />';
				}
			}
			
			// Megaupload
			else{
				// Cambio de puertos:
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
				//obtener contenido de la web
				$file = file_get_contents($mina);
				$encontrar = strpos($file, 'Invalid');
				if ($encontrar) {
					echo '<font color="#FF0000"><b>Parte '.$i++.':</b></font> <a href="'.$lol.'">'.$lol.'</a> <img src="http://megauploadlinks.donkiehost.com/cross.png"><br />';
					++$m;
				} else {
					echo '<font color="#006600"><b>Parte '.$i++.':</b></font> <a href="'.$lol.'">'.$lol.'</a> <img src="http://megauploadlinks.donkiehost.com/check.png"><br />';
				}
			}
			echo "Total Elapsed: ".$stopwatch->elapsed()." seconds<br />"; 
		}
		// Send email to Author if some link is broken.
		if($m != 0){
			mail($row_viewemail['email'], "LinksFolder: Some Links Broken in your folder", "Dear user, we have noticed that ".$m." links are broken your folder id:".$_GET['f'].". Please try to renew the links.");
		}
		// Now, the program shows the links in "quote" format.
		$quote = implode("<br />", $start);
		echo "<blockquote>".$quote."</blockquote>";
		$content = "<blockquote>".$row_viewfolder['links']."</blockquote>";
	}
} else {
	$content ='
	<!-- Formulario -->
<form method="post" action="">
    <b>Cambio de puertos Megaupload:</b><br />
      <input name="port" type="radio" value="80" checked="checked" /> 80 (normal)   
      <input type="radio" name="port" value="800" /> 800  
      <input type="radio" name="port" value="1723" /> 1723<br />
      <textarea name="texto" cols="60" rows="10" id="texto"></textarea>
      <input type="submit" value="ingresar" />
</form>';

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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home - Links Folder</title>
<link rel="shortcut icon" href="folder2.png" />
</head>
<body>
<?php
echo $content;
?>
</body>
</html>
<?php
}
if($_GET['f']){
mysql_free_result($viewfolder);
}
?>
