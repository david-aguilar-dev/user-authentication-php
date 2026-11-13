<?php
session_start();

// Eliminar cookies pasando fecha en el pasado
setcookie("usuario",      "", time() - 3600, "/");
setcookie("nivel",        "", time() - 3600, "/");
setcookie("nombres",      "", time() - 3600, "/");
setcookie("ultimoAcceso", "", time() - 3600, "/");

// Destruir sesión también
session_destroy();

echo "<script> window.location='login.php' </script>";
?>