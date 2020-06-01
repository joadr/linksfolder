<?php require_once('Connections/linksfolder.php'); 
include('lang/main.php');
if (!isset($_SESSION)) {
  session_start();
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
		include('templates/black/indexget.php');
} else {
		include('templates/black/index.php');
}
?>