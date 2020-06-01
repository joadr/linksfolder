<?php require_once('Connections/linksfolder.php'); ?>
<?php
  session_start();
include('lang/main.php');

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

// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['user'])) {
  $loginUsername=$_POST['user'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "panel.php";
  $MM_redirectLoginFailed = "panel.php?error=failed";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_linksfolder, $linksfolder);
  
  $LoginRS__query=sprintf("SELECT name, password FROM usuarios WHERE name=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $linksfolder) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      
    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
	// asd
mysql_select_db($database_linksfolder, $linksfolder);
$query_usuarios = sprintf("SELECT * FROM usuarios WHERE name = %s", GetSQLValueString($loginUsername, "text"));
$usuarios = mysql_query($query_usuarios, $linksfolder) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);
$uid = $row_usuarios['id'];
$_SESSION['MM_uid'] = $uid;	

// Get ip:
$ip = getenv("REMOTE_ADDR");
  $updateSQL = sprintf("UPDATE usuarios SET lastaccessip=%s WHERE id=%s",
                       GetSQLValueString($ip, "text"),
                       GetSQLValueString($uid, "int"));

  $Result1 = mysql_query($updateSQL, $linksfolder) or die(mysql_error());

// asdf
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Log in - Links Folder</title>
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
<p class="imAlign_left"><span class="ff2 fc0 fs10"><jd>Log in</jd><br /><br />
<div id="formu" class="formulario">
<form action="<?php echo $loginFormAction; ?>" method="POST" id="login">
<table width="200" cellspacing="3" bordercolor="#666666" style="text-align:center;">
  <tr>
    <td><?php echo USER;?>:</td>
    <td><input type="text" value="" name="user" /></td>
  </tr>
  <tr>
    <td><?php echo PASSWORD;?>:</td>
    <td><input type="password" value="" name="password" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="<?php echo LOGIN;?>" /></td>
  </tr>
</table>
</form>
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