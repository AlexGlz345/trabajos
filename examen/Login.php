<?php
session_start(); // Inicia la sesión para mantener al usuario autenticado entre páginas

include("Conexion.php"); //Conecta con el archivo donde está la función para enlazar con la base de datos

$mensaje = ""; // Variable que guarda mensajes para mostrar al usuario (error o éxito)

// Verifica si el formulario de login fue enviado
if (isset($_POST['btnLogin'])) {
    $usuario = $_POST['usuario']; // Captura el nombre de usuario ingresado
    $password = $_POST['password']; // Captura la contraseña ingresada

    $conn = conectarBD(); // 🔌 Establece conexión con la base de datos

    //  Prepara la consulta para verificar si el usuario existe
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $resultado = mysqli_query($conn, $sql);

    // Si encuentra exactamente un usuario con ese nombre
    if (mysqli_num_rows($resultado) == 1) {
        $fila = mysqli_fetch_assoc($resultado); // Obtiene los datos del usuario

        // ✅ Verifica la contraseña usando hash seguro
        if (password_verify($password, $fila['password'])) {
            $_SESSION['usuario'] = $usuario; // Guarda el usuario en sesión
            header("Location: Index.php"); // Redirige a la página principal del sistema
            exit(); // Sale del script
        } else {
            $mensaje = "⚠️ Contraseña incorrecta."; // Contraseña no coincide
        }
    } else {
        $mensaje = "⚠️ Usuario no encontrado."; // No existe ese usuario en la base de datos
    }

    mysqli_close($conn); // Cierra la conexión con la base de datos
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="Login.css"> <!-- Estilo visual del formulario -->
</head>
<body>

    <!--  Encabezado con imagen institucional -->
    <header class="encabezado">
        <img src="/Fotos/udm.png" alt="Logo UDM" class="logo">
        <h1>UNIVERSIDAD DE MATAMOROS</h1>
    </header>

    <!-- Contenedor del formulario de login -->
    <div class="form-container">
        <h2>Inicio de Sesión</h2>

        <!--  Formulario de autenticación -->
        <form method="POST" action="">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required> <!--  Campo de usuario -->

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required> <!-- Campo de contraseña -->

            <button type="submit" name="btnLogin">Iniciar Sesión</button> <!-- Botón para enviar el formulario -->
        </form>

        <!-- Mensaje para mostrar errores o bienvenida -->
        <p><?php echo $mensaje; ?></p>

        <!--Enlace para ir a la página de registro -->
        <p>¿Eres nuevo aquí? <a href="Registro.php">Crea una cuenta</a></p>
    </div>

</body>
</html>