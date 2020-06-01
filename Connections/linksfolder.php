<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_linksfolder = "localhost";
$database_linksfolder = "linksfolder";
$username_linksfolder = "root";
$password_linksfolder = "runescape";
$linksfolder = mysql_pconnect($hostname_linksfolder, $username_linksfolder, $password_linksfolder) or trigger_error(mysql_error(),E_USER_ERROR); 
?>