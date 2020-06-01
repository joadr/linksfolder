 <?php
// Configura los datos de tu cuenta
require_once('Connections/linksfolder.php');

// Preguntaremos si se han enviado ya las variables necesarias
if (isset($_POST["username"])) {
	$username = $_POST["username"];
	$password = $_POST["password"];
	$cpassword = $_POST["cpassword"];
	$email = $_POST["email"];
	// Hay campos en blanco
	if($username==NULL|$password==NULL|$cpassword==NULL|$email==NULL) {
		echo "Verifica que no haya campos vacíos.";
	}else{
		// ¿Coinciden las contraseñas?
		if($password!=$cpassword) {
			echo "Las contraseñas no coinciden";
		}else{
			// Comprobamos si el nombre de usuario ya existía
			mysql_select_db($database_linksfolder, $linksfolder);
			$query_checkuser = sprintf("SELECT name FROM usuarios WHERE name='%s'", mysql_real_escape_string($username));
			$checkuser = mysql_query($query_checkuser, $linksfolder) or die(mysql_error());
			$row_checkuser = mysql_fetch_assoc($checkuser);
			$totalRows_checkuser = mysql_num_rows($checkuser);
			
			// Comprobamos si el email ya existía
			mysql_select_db($database_linksfolder, $linksfolder);
			$query_checkemail = sprintf("SELECT email FROM usuarios WHERE email='%s'", mysql_real_escape_string($email));
			$checkemail = mysql_query($query_checkemail, $linksfolder) or die(mysql_error());
			$row_checkemail = mysql_fetch_assoc($checkemail);
			$totalRows_checkemail = mysql_num_rows($checkemail);
			
			if ($totalRows_checkemail>0|$totalRows_checkuser>0) {
				echo "EL nombre de usuario o la cuenta de correo estan ya en uso";
			}else{
			//Todo parece correcto procedemos con la inserccion
				$insertSQL = sprintf("INSERT INTO usuarios (name, password, email) VALUES ('%s', '%s', '%s')",
                       mysql_real_escape_string($username),
                       mysql_real_escape_string($password),
                       mysql_real_escape_string($email));
					   
				mysql_query($insertSQL) or die(mysql_error());
				echo "<div align='center'><span class='Estilo3'>El usuario $username ha sido registrado de forma satisfactoria.<br />Usted será redireccionado en unos segundos, has <a href='login.php'>Click Aquí</a> si no quieres esperar más.</span><META HTTP-EQUIV=\"Refresh\" CONTENT=\"5; URL=login.php\"></div>";
			}
			mysql_free_result($checkuser);
			mysql_free_result($checkemail);
		}
	}
}
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Register- LinksFolder</title>
</head>
<body>
  <form action="" method="post" class="Estilo1">
    <div align="center">
      <table width="293" border="1">
        <tr>
          <td>Username:</td>
          <td><input name="username" type="text" id="username" /></td>
        </tr>
        <tr>
          <td>Password:</td>
          <td><input type="password" name="password" /></td>
        </tr>
        <tr>
          <td>Confirmar Password:</td>
          <td><input type="password" name="cpassword" /></td>
        </tr>
        <tr>
          <td>E-mail*:</td>
          <td><input type="text" name="email" /></td>
        </tr>
        <tr>
          <td><input name="submit" type="submit" value="Registrar" /></td>
          <td><input name="reset" type="reset" value="Reset" /></td>
        </tr>
      </table>
    </div>
  </form>
  <br />
<br />
<br />

  * El Email Será la fuente de comunicación entre el sistema y usted, ahí se le enviará un email de confirmación y en caso de que los links estén malos se le será informado por medio de esa cuenta de email.
</body>
</html>