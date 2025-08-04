<?php
function conectarBD() {
    $servidor = "localhost";
    $usuario = "root";
    $password = "";
    $basededatos = "control_escolar";  // Nombre correcto de la base de datos

    $conexion = mysqli_connect($servidor, $usuario, $password, $basededatos);

    if (!$conexion) {
        die("❌ Error de conexión: " . mysqli_connect_error());
    }

    return $conexion;
}
?>