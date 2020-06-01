<?php require_once('Connections/linksfolder.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
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

// Get User ID
$uid = $_SESSION['MM_uid'];

mysql_select_db($database_linksfolder, $linksfolder);
$query_Folders = sprintf("SELECT * FROM folders  WHERE folders.`uid` = %s ORDER by id ASC", GetSQLValueString($uid, "text"));
$Folders = mysql_query($query_Folders, $linksfolder) or die(mysql_error());
$row_Folders = mysql_fetch_assoc($Folders);
$totalRows_Folders = mysql_num_rows($Folders);

  //numerador
  $i=1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Folders - Links Folders</title>
</head>

<body>
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
  	<td>#</td>
    <td>Code</td>
    <td>Title</td>
    <td>Links</td>
    <td>Password</td>
    <td>Alert</td>
    <td>Edit</td>
    <td>Delete</td>
  </tr>
  </tr>
  <?php do { ?>
  <?php
  switch($row_Folders['alert']){
	  case 0:
	  	$alert = "Normal";
		break;
	  case 1:
	  	$alert = '<font color="#FF0000">ALERT</font>';
		break;
  }
  
  // mostrar sólo 30 caracteres de los links.
  $texto1 = strip_tags($row_Folders['links']);

  $texto2 = substr($texto1,0,70);
  
  $texto = $texto2."...";
  

  ?>
    <tr>
      <td><?php echo $i++;?></td>
      <td><?php echo $row_Folders['cid']; ?></td>
      <td><?php echo $row_Folders['title']; ?></td>
      <td><?php echo $texto; ?></td>
      <td><?php echo $row_Folders['password']; ?></td>
      <td><?php echo $alert; ?></td>
      <td><a href="edit.php?id=<?php echo $row_Folders['cid']; ?>">Edit</a></td>
      <td><a href="delete.php?id=<?php echo $row_Folders['cid']; ?>"><font color="#FF0000">[Delete]</font></a></td>
    </tr>
    <?php } while ($row_Folders = mysql_fetch_assoc($Folders)); ?>
</table>
<?php
$mifecha = '2010-09-03 23:28:55';
echo 'Hora actual: '.$mifecha;
$fecha_proxima = strtotime("$mifecha +1 months");
echo '<br />Mañana: '.date("Y-m-d H:i:s", $fecha_proxima);  
?>
</body>
</html>
<?php
mysql_free_result($Folders);
?>
