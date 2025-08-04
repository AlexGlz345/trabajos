<?php
session_start(); // Inicia la sesión
if (!isset($_SESSION['usuario'])) { // Si no hay sesión iniciada
    header("Location: Login.php"); // Redirige al login
    exit();
}

include("Conexion.php"); // Incluye la conexión a la BD
$conn = conectarBD(); // Ejecuta la conexión

if (!isset($_GET['id'])) { // Si no viene el ID en la URL
    header("Location: Index.php"); // Regresa al listado
    exit();
}

$id = $_GET['id']; // Guarda el ID del alumno

// Consulta a la base de datos por ID
$sql = "SELECT * FROM calificaciones WHERE id = $id";
$resultado = mysqli_query($conn, $sql);

// Si no encuentra un único resultado
if (mysqli_num_rows($resultado) != 1) {
    header("Location: Index.php"); // Redirige al listado
    exit();
}

// Guarda los datos del alumno
$fila = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta de Calificaciones</title>
    <link rel="stylesheet" href="Boleta.css"> <!-- Enlace al estilo -->
</head>
<body>
    <!-- ENCABEZADO CON LOGO Y TÍTULO -->
    <header class="encabezado">
        <img src="/Fotos/udm.png" alt="Logo UDM" class="logo">
        <h1>UNIVERSIDAD DE MATAMOROS</h1>
    </header>

    <!-- CONTENEDOR PRINCIPAL -->
    <div class="boleta-container">
        <h2>BOLETA DE CALIFICACIONES</h2>

        <!-- DATOS DEL ALUMNO -->
        <p><strong>Nombre del Alumno:</strong> <?php echo htmlspecialchars($fila['nombre_alumno']); ?></p>
        <p><strong>Grado/Grupo:</strong> <?php echo htmlspecialchars($fila['grado_grupo']); ?></p>

        <!-- TABLA DE CALIFICACIONES -->
        <table>
            <thead>
                <tr>
                    <th>Parcial 1</th>
                    <th>Parcial 2</th>
                    <th>Parcial 3</th>
                    <th>Ordinario</th>
                    <th>Promedio</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $fila['parcial1']; ?></td>
                    <td><?php echo $fila['parcial2']; ?></td>
                    <td><?php echo $fila['parcial3']; ?></td>
                    <td><?php echo $fila['ordinario']; ?></td>
                    <td><?php echo $fila['promedio']; ?></td>

                    <!-- Texto del estatus con clase para aplicar color -->
                    <td>
                        <span class="<?php echo strtolower($fila['estatus']); ?>">
                            <?php echo $fila['estatus']; ?>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- BOTÓN DE REGRESO -->
        <a href="Index.php" class="regresar">VOLVER AL LISTADO</a>
    </div>
</body>
</html>
