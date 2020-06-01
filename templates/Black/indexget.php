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
<?php
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
		echo '<p class="imAlign_left"><div class="formulario">Please, input folder\'s Password:<br /><form method="POST" action="" id="password"><input type="password" value="" name="password" /><input type="submit" value="Enter" /></form></div></p>';
	//password is working
	} else {
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
		echo '<p class="imAlign_left"><jd>'.$row_viewfolder['title'].'</jd><br />';
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
		}
		// Send email to Author if some link is broken.
		if($m != 0){
			mail($row_viewemail['email'], "LinksFolder: Some Links Broken in your folder", "Dear user, we have noticed that ".$m." links are broken your folder id:".$_GET['f'].". Please try to renew the links.");
		}
		echo "Total Elapsed: ".$stopwatch->elapsed()." seconds<br />";
		// Now, the program shows the links in "quote" format.
		$quote = implode("<br />", $start);
		echo "<blockquote>".$quote."</blockquote>";
		$content = "<blockquote>".$row_viewfolder['links']."</blockquote>";
	}
	mysql_free_result($viewfolder);
	?>
 </p>
 </div>
<!-- Page END -->
	</div>
	<div id="imFooter">
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
