<!DOCTYPE html>
<?php

session_start();

// Leer cookies
if(isset($_COOKIE['usuario'])){
    echo "Bienvenido: " . $_COOKIE['usuario'] . "<br>";
    echo "Nivel: " . $_COOKIE['nivel'] . "<br>";
    echo "Nombre: " . $_COOKIE['nombres'] . "<br>";
    echo "Último acceso: " . $_COOKIE['ultimoAcceso'] . "<br>";
    echo "<hr>";
}
if( !isset($_SESSION['estadoLogin']) ){
    //echo "<script> window.location='index.php?estado=permiso' </script>";

    echo "Acceso restringido <br>";
    echo "<a href='login.php'>Ingresar desde Login</a>";
    exit();
}



include 'conexion.php';
 
$conexion = getConexion();
 
if ($conexion) {
    echo "";
} else {
    echo "No conectado a la base de datos";
    exit;
}
?>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
 
<body>
 
    <?php
    //dibuja en la pagina las variables de SESSION
    //foreach($_SESSION as $clave => $valor){
    //    echo $clave . "=>" . $valor . "<br>";
    //}
    <a href="logout.php">Cerrar Sesión</a>
    <hr>

    $guardar = isset($_POST['guardar']);
    $buscar = isset($_POST['buscar']);
    $seleccionar = isset($_POST['seleccionar']);
    $editar = isset($_POST['editar']);
    $actualizar = isset($_POST['actualizar']);
    $eliminar = isset($_POST['eliminar']);
    $confirmar = isset($_POST['confirmar']);
 
    $elCodigo = "";
    $elCorreo = "";
    $losNombres = "";
    $losApellidos = "";
    $laClave = "";
    $elNivel = "";
 
    if ($guardar) {
        $elCorreo = $_POST['correo'];
        $losNombres = $_POST['nombres'];
        $losApellidos = $_POST['apellidos'];
        $laClave = $_POST['clave'];
        $elNivel = $_POST['nivel'];
        $depto = $_POST['departamento'];
 
        $consultaSql = "SELECT * FROM usuarios WHERE correos = '$elCorreo'";
        $resultado = mysqli_query($conexion, $consultaSql);
        $cantidadRegistros = mysqli_num_rows($resultado);
 
        if ($cantidadRegistros > 0) {
            echo "No se puede almacenar el nuevo usuario, correo ya existe en la base de datos";
        } else {
            $consulta = "INSERT INTO usuarios(correos, claves, nombres, apellidos, niveles, departamento) ";
            $consulta .= "VALUES('$elCorreo','$laClave','$losNombres','$losApellidos',$elNivel,$depto)";
 
            mysqli_query($conexion, $consulta);
        }
    } else if ($buscar || $seleccionar || $editar || $eliminar) {
        $elCorreo = $_POST['correo'];
        $consulta = "SELECT * FROM usuarios WHERE correos = '$elCorreo'";
        $resultadoSql = mysqli_query($conexion, $consulta);
        $fila = mysqli_fetch_assoc($resultadoSql);
 
        $elCorreo = $fila['correos'];
        $losNombres = $fila['nombres'];
        $losApellidos = $fila['apellidos'];
        $laClave = $fila['claves'];
        $elNivel = $fila['niveles'];
    } else if($actualizar){
        $elCorreo = $_POST['correo'];
        $losNombres = $_POST['nombres'];
        $losApellidos = $_POST['apellidos'];
        $laClave = $_POST['clave'];
        $elNivel = $_POST['nivel'];
 
        $consulta = "UPDATE usuarios SET nombres = '$losNombres', apellidos = '$losApellidos', ";
        $consulta .= "claves = '$laClave', niveles = $elNivel ";
        $consulta .= "WHERE correos = '$elCorreo'";
 
        mysqli_query($conexion, $consulta);
       
    } else if($confirmar){
        $elCorreo = $_POST['correo'];
 
        $consulta = "DELETE FROM usuarios WHERE correos = '$elCorreo'";
 
        mysqli_query($conexion, $consulta);
    }
 
    ?>
 
 
    <form action="" method="post">
        <table border="1">
            <tr>
                <td>
                    Correo:
                </td>
                <td>
                    <input type="email" name="correo" value="<?php echo $elCorreo; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    Nombres:
                </td>
                <td>
                    <input type="text" name="nombres" value="<?php echo $losNombres; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    Apellidos:
                </td>
                <td>
                    <input type="text" name="apellidos" value="<?php echo $losApellidos; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    Clave:
                </td>
                <td>
                    <input type="password" name="clave" value="<?php echo $laClave; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    Departamento:
                </td>
                <td>
                    <select name="departamento">
                        <?php
                            $sql = "SELECT * FROM departamentos";
                            $resultado = mysqli_query($conexion, $sql);
                            while($fila = mysqli_fetch_assoc($resultado)){
                                $codigoDpto = $fila['codigos'];
                                $nombreDpto = $fila['nombres'];
                                echo "<option value='$codigoDpto'>$nombreDpto</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="radio" name="nivel" value="1" <?php if ($elNivel == 1) echo "checked"; ?>>Usuario<br>
                    <input type="radio" name="nivel" value="2" <?php if ($elNivel == 2) echo "checked"; ?>>Asistente<br>
                    <input type="radio" name="nivel" value="3" <?php if ($elNivel == 3) echo "checked"; ?>>Administrador
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php
                        if($editar){
                            echo "<input type='submit' value='Guardar' name='actualizar'>";
                            echo "<input type='submit' value='Cancelar' name='cancelar'>";
                        }
                        else if($eliminar){
                            echo "<input type='submit' value='Confirmar' name='confirmar'>";
                            echo "<input type='submit' value='Cancelar' name='cancelar'>";
                        }
                        else{
                            echo "<input type='submit' value='Guardar' name='guardar'>";
                            echo "<input type='submit' value='Buscar' name='buscar'>";
                            echo "<input type='submit' value='Actualizar' name='actualizar'>";
                            echo "<input type='submit' value='Eliminar' name='eliminar'>";
                        }
                    ?>
                </td>
            </tr>
        </table>
    </form>
    <br>
    <br>
 
    <table border="1">
        <tr>
            <td>Codigos</td>
            <td>Correos</td>
            <td>Nombres</td>
            <td>Apellidos</td>
            <td>Claves</td>
            <td>Niveles</td>
            <td>Acciones</td>
        </tr>
 
        <?php
        $consulta = "SELECT * FROM usuarios";
 
        if($editar){
            //$consulta = $consulta . " WHERE correos = '$elCorreo'";
            $consulta .= " WHERE correos = '$elCorreo'";
        }
 
        $resultadoSql = mysqli_query($conexion, $consulta);
 
        //print_r( $resultadoSql);
 
        while ($registro = mysqli_fetch_assoc($resultadoSql)) {
            //if($registro['correos'] == $elCorreo){
        ?>

        <?php
            // Timestamps de Unix
            $ahora        = time();                    // momento actual
            $unaHora      = time() + 3600;            // 1 hora
            $unDia        = time() + 86400;           // 1 día
            $unaSemana    = time() + (7 * 24 * 60 * 60); // 7 días

            echo "Timestamp actual: "     . $ahora     . " = " . date("Y-m-d H:i:s", $ahora)     . "<br>";
            echo "Expira en 1 hora: "     . $unaHora   . " = " . date("Y-m-d H:i:s", $unaHora)   . "<br>";
            echo "Expira en 1 día: "      . $unDia     . " = " . date("Y-m-d H:i:s", $unDia)     . "<br>";
            echo "Expira en 1 semana: "   . $unaSemana . " = " . date("Y-m-d H:i:s", $unaSemana) . "<br>";
        ?>
            <form action="" method="post">
                <tr>
 
                    <?php
                        if($editar){
 
                    ?>
                            <td><?php echo $registro['codigos']; ?></td>
                            <td><?php echo $registro['correos']; ?></td>
                            <td><input type="text" name="nombres" value="<?php echo $registro['nombres']; ?>"></td>
                            <td><input type="text" name="apellidos" value="<?php echo $registro['apellidos']; ?>"></td>
                            <td><input type="password" name="clave" value="<?php echo $registro['claves']; ?>"></td>
                            <td>
                                <input type="radio" name="nivel" value="1" <?php if ($registro['niveles'] == 1) echo "checked"; ?>>Usuario<br>
                                <input type="radio" name="nivel" value="2" <?php if ($registro['niveles'] == 2) echo "checked"; ?>>Asistente<br>
                                <input type="radio" name="nivel" value="3" <?php if ($registro['niveles'] == 3) echo "checked"; ?>>Administrador
                            </td>
 
                    <?php
                        }
                        else{
                    ?>
                            <td><?php echo $registro['codigos']; ?></td>
                            <td><?php echo $registro['correos']; ?></td>
                            <td><?php echo $registro['nombres']; ?></td>
                            <td><?php echo $registro['apellidos']; ?></td>
                            <td><?php echo $registro['claves']; ?></td>
                            <td><?php echo $registro['niveles']; ?></td>
                    <?php
                        }
                    ?>
                   
 
 
                    <td>
                        <input type="hidden" name="correo" value="<?php echo $registro['correos']; ?>">
 
                        <?php
                            if($editar){
                        ?>
                                <input type="submit" value="Guardar" name="actualizar">
                                <input type="submit" value="Cancelar" name="cancelar">
                        <?php
                            }
                            else{
                        ?>
                                <input type="submit" value="Seleccionar" name="seleccionar">
                                <input type="submit" value="Editar" name="editar">
                                <input type="submit" value="Eliminar" name="eliminar">
                        <?php
                            }
                        ?>
 
                       
                    </td>
                </tr>
            </form>
        <?php
            //}
        }
        ?>
 
 
    </table>
 
 
 
 
 
</body>
 
</html>