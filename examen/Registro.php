<?php
// Importa el archivo que contiene la conexión a la base de datos
include("Conexion.php");

// Variable que se usa para mostrar mensajes al usuario (éxito o error)
$mensaje = "";

// Verifica si se ha enviado el formulario de registro
if (isset($_POST['btnRegistrar'])) {
    // Captura los datos ingresados por el usuario
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $confirmar = $_POST['confirmar'];

    // Verifica si las contraseñas coinciden
    if ($password === $confirmar) {
        $conn = conectarBD(); // Establece conexión con la base de datos

        // Genera un hash seguro de la contraseña para protegerla en la base de datos
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Construye consulta SQL para insertar el nuevo usuario en la tabla
        $sql = "INSERT INTO usuarios (usuario, password) VALUES ('$usuario', '$passwordHash')";

        // Ejecuta la consulta y valida si fue exitosa
        if (mysqli_query($conn, $sql)) {
            $mensaje = "<span class='exito'>✅ Usuario registrado correctamente.</span>";
        } else {
            $mensaje = "<span class='error'>❌ Error al registrar: " . mysqli_error($conn) . "</span>";
        }

        // Cierra la conexión a la base de datos
        mysqli_close($conn);
    } else {
        // Mensaje si las contraseñas no coinciden
        $mensaje = "<span class='advertencia'>⚠️ Las contraseñas no coinciden.</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <!-- Enlace al archivo de estilos personalizado -->
    <link rel="stylesheet" href="Registro.css"> 
</head>
<body>

    <!-- Encabezado institucional con logo -->
    <header class="encabezado">
        <img src="/Fotos/udm.png" class="logo" alt="Logo UDM">
        <h1>UNIVERSIDAD DE MATAMOROS</h1>
    </header>

    <!-- Contenedor del formulario de registro -->
    <div class="formulario">
        <h2 class="subtitulo">CREAR CUENTA NUEVA</h2>

        <!-- Formulario que envía los datos por método POST -->
        <form method="POST" action="">
            <!-- Campo de nombre de usuario -->
            <label for="usuario">USUARIO:</label>
            <input type="text" name="usuario" required>

            <!-- Campo de contraseña -->
            <label for="password">CONTRASEÑA:</label>
            <input type="password" name="password" required>

            <!-- Campo para confirmar la contraseña -->
            <label for="confirmar">CONFIRMAR CONTRASEÑA:</label>
            <input type="password" name="confirmar" required>

            <!-- Botón para enviar el formulario -->
            <button type="submit" name="btnRegistrar">REGISTRAR</button>

            <!-- Muestra el mensaje de resultado si existe -->
            <?php if ($mensaje != "") echo "<p class='mensaje'>$mensaje</p>"; ?>
        </form>

        <!-- Enlace para redirigir al login si ya tiene cuenta -->
        <p class="regresar">¿Ya tienes una cuenta? <a href="Login.php">Iniciar sesión</a></p>
    </div>

</body>
</html>