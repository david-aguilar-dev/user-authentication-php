<?php
    function getConexion(){

        $servidor = 'localhost';        
        $usuario = 'root';
        $clave = '';
        $base = 'sistema';
    
        $conexion = mysqli_init();
        mysqli_real_connect($conexion, $servidor, $usuario, $clave, $base, 3306);

        return $conexion;
    }
?>