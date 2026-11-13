<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <?php
        if(isset($_GET['estado'])){
            $estado = $_GET['estado'];
            if($estado == "error"){
                echo "Error, usuario y/o contraseña incorrecta";
            }
        }
    ?>
    <form action="procesar.php" method="post">
        <table border="1">
            <tr>
                <td>Usuario: </td>
                <td><input type="email" name="usuario"></td>
            </tr>
            <tr>
                <td>Clave:</td>
                <td><input type="password" name="clave"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Procesar" name="procesar"></td>
            </tr>
        </table>
    </form>
</body>

</html>