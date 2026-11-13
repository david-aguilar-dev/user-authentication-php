<?php
    include('conexion.php');
    session_start();
    if(isset($_POST['usuario']) && isset($_POST['clave'])){
        echo "SI EXISTEN LAS VARIABLES EN POST";
        echo "<br>";
        
        $elUsuario = $_POST['usuario'];
        $laClave = $_POST['clave'];

        if($elUsuario == ""){
            echo "Falta el correo";
        }
        else if($laClave == ""){
            echo "Falta la clave";
        }
        else{
            $conexion = getConexion();
            $sql = "SELECT * FROM usuarios WHERE correos = '$elUsuario' ";
            $sql .= "AND claves = '$laClave'";

            $resultado = mysqli_query($conexion, $sql);

            $cantidaRegistros = mysqli_num_rows($resultado);

            if($cantidaRegistros > 0){
                //leer el registro en encontrado en la base de datos
                $fila = mysqli_fetch_assoc($resultado);

                $_SESSION['estadoLogin'] = "activo";
                $_SESSION['nombres'] = $fila['nombres'];
                $_SESSION['apellidos'] = $fila['apellidos'];
                $_SESSION['nivel'] = $fila['niveles'];
                
                echo "<script> window.location='index.php' </script>";

                //Mustar el array del registro del objeto resutaldo
                //print_r($fila);
            }
            else{
                echo "<script> window.location='login.php?estado=error' </script>";
            }
            //echo "<br>";
            //Mustrar el array del objeto resutado
            //print_r($resultado);
            //echo "<br>";
            //Muestra la cantidad de registros encontrados en el objeto Resutlado
            //echo $cantidaRegistros;

        }
        echo "<br>";
        //Muestra el array $_POST
        //print_r($_POST);
    }
    else{
        echo "FALTAN DATOS";
    }
?>