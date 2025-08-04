<?php
include("Conexion.php"); // Incluye el archivo de conexión a la base de datos

$mensaje = ""; // Variable para mostrar mensajes al usuario

// Si el usuario envía el formulario
if (isset($_POST['btnRegistrar'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $confirmar = $_POST['confirmar'];

    // Verifica si las contraseñas coinciden
    if ($password === $confirmar) {
        $conn = conectarBD(); // Conecta con la base de datos

        // Hashea la contraseña para mayor seguridad
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Inserta el nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (usuario, password) VALUES ('$usuario', '$passwordHash')";

        if (mysqli_query($conn, $sql)) {
            $mensaje = "<span class='exito'>✅ Usuario registrado correctamente.</span>";
        } else {
            $mensaje = "<span class='error'>❌ Error al registrar: " . mysqli_error($conn) . "</span>";
        }

        mysqli_close($conn); // Cierra conexión
    } else {
        $mensaje = "<span class='advertencia'>⚠️ Las contraseñas no coinciden.</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="Registro.css"> 
</head>
<body>

    <!-- ENCABEZADO CON LOGO Y TEXTO -->
    <header class="encabezado">
        <img src="/Fotos/udm.png" class="logo" alt="Logo UDM">
        <h1>UNIVERSIDAD DE MATAMOROS</h1>
    </header>

    <!-- CUADRO BLANCO CENTRADO CON EL FORMULARIO -->
    <div class="formulario">
        <h2 class="subtitulo">CREAR CUENTA NUEVA</h2>

        <form method="POST" action="">
            <label for="usuario">USUARIO:</label>
            <input type="text" name="usuario" required>

            <label for="password">CONTRASEÑA:</label>
            <input type="password" name="password" required>

            <label for="confirmar">CONFIRMAR CONTRASEÑA:</label>
            <input type="password" name="confirmar" required>

            <button type="submit" name="btnRegistrar">REGISTRAR</button>

            <!-- Mensaje de éxito o error -->
            <?php if ($mensaje != "") echo "<p class='mensaje'>$mensaje</p>"; ?>
        </form>

        <!-- ENLACE AL LOGIN -->
        <p class="regresar">¿Ya tienes una cuenta? <a href="Login.php">Iniciar sesión</a></p>
    </div>

</body>
</html>