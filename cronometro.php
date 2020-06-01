<?php 
Class cronometro { 
    var $comienzo; 
    // me devuelve un tiempo en segundos y milisegundos 
    function _getmicrotime() { 
 
        list($_milisegundos, $_segundos) = explode(" ", microtime()); 
 
        return ((float)$_milisegundos + (float)$_segundos); 
    } 
 
    // constructor cronometro 
    function cronometro() { 
 
        $this->comienzo = $this->_getmicrotime(); 
 
        return true; 
    } 
 
    // para el cronometro y devuelve el tiempo 
    // se puede dar una salida formateada a traves de los parametros. 
    //  
    // Si $formatear esta a verdadero entonces devolvera cuantos segundos 
    // se demoro con $nroDecimales decimales (milisegundos). 
    function stop($formatear = false, $nroDecimales = 0) { 
 
        $_tiempo = $this->_getmicrotime() - $this->comienzo; 
 
        return ($formatear) ? number_format($_tiempo, $nroDecimales, ',', '.') : $_tiempo; 
    } 
} 
?> 