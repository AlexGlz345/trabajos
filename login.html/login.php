<?php
// Datos de usuario "duros" para ejemplo
$usuario_valido = "admin";
$contrasena_valida = "admin";

// Obtener datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Verificar credenciales
if ($username === $usuario_valido && $password === $contrasena_valida) {
    // Redirigir a la página de éxito
    header("Location: bienvenidos.php");
    exit();
} else {
    echo "<p style='color:red;'>Usuario o contraseña incorrectos.</p>";
    echo "<a href='index.html'>Volver</a>";
}
?>
