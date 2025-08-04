<?php
session_start(); // Inicia la sesión 

include("Conexion.php"); // Incluye el archivo de conexión a la base de datos

$mensaje = ""; // Variable para mostrar mensajes al usuario

// Si el usuario envía el formulario
if (isset($_POST['btnLogin'])) {
    $usuario = $_POST['usuario']; // Captura el usuario ingresado
    $password = $_POST['password']; // Captura la contraseña ingresada

    $conn = conectarBD(); // Llama a la función que conecta a la BD

    // Busca al usuario en la base de datos
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $resultado = mysqli_query($conn, $sql);

    // Si el usuario existe
    if (mysqli_num_rows($resultado) == 1) {
        $fila = mysqli_fetch_assoc($resultado); // Obtiene los datos

        // Verifica que la contraseña ingresada sea correcta
        if (password_verify($password, $fila['password'])) {
            $_SESSION['usuario'] = $usuario; // Guarda el usuario en sesión
            header("Location: Index.php"); // Redirige al sistema principal
            exit();
        } else {
            $mensaje = "⚠️ Contraseña incorrecta."; // Mensaje de error
        }
    } else {
        $mensaje = "⚠️ Usuario no encontrado."; // Usuario no existe
    }

    mysqli_close($conn); // Cierra la conexión
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="Login.css"> <!-- Enlace al archivo CSS -->
</head>
<body>

    <!-- ENCABEZADO con logo y título -->
    <header class="encabezado">
        <img src="/Fotos/udm.png" alt="Logo UDM" class="logo">
        <h1>UNIVERSIDAD DE MATAMOROS</h1>
    </header>

    <!-- FORMULARIO -->
    <div class="form-container">
        <h2>Inicio de Sesión</h2>

        <!-- Formulario de login -->
        <form method="POST" action="">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="btnLogin">Iniciar Sesión</button>
        </form>

        <!-- Mensaje de error o bienvenida -->
        <p><?php echo $mensaje; ?></p>

        <!-- Enlace para registrarse -->
        <p>¿Eres nuevo aquí? <a href="Registro.php">Crea una cuenta</a></p>
    </div>

</body>
</html>
