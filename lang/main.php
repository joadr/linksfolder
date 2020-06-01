<?php
/* Spanish
Comienza todo lo que tiene que ver con los leguajes
Define los archivos de cada lenguajes y los incluye según corresponda.

   English
linkss all about languajes
Define all files about every languaje and includes in each case.
*/
switch($_SESSION['lang']) {
	case "english":
		include('lang/english.lang.php');
		break;
	case "spanish":
		include('lang/spanish.lang.php');
		break;
	case "portuguese":
		include('lang/portuguese.lang.php');
		break;
}
?>