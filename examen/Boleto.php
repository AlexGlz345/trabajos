<?php
// Inicia sesión para controlar el acceso seguro a la boleta
session_start();

// Si no hay un usuario en sesión, se redirige automáticamente al login
if (!isset($_SESSION['usuario'])) {
    header("Location: Login.php");
    exit();
}

// Conecta con la base de datos
include("Conexion.php");
$conn = conectarBD();

// Verifica que se haya pasado un ID por la URL; si no existe, redirige
if (!isset($_GET['id'])) {
    header("Location: Index.php");
    exit();
}

// Captura el ID del alumno
$id = $_GET['id'];

// Consulta los datos del alumno con ese ID específico
$sql = "SELECT * FROM calificaciones WHERE id = $id";
$resultado = mysqli_query($conn, $sql);

// Si no se encuentra el alumno o hay más de un resultado, se redirige
if (mysqli_num_rows($resultado) != 1) {
    header("Location: Index.php");
    exit();
}

// Obtiene los datos del alumno y los guarda en $fila
$fila = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta de Calificaciones</title>
    <!-- Enlace al archivo de estilos para esta vista -->
    <link rel="stylesheet" href="Boleta.css">
</head>
<body>

    <!-- Encabezado institucional con imagen y título -->
    <header class="encabezado">
        <img src="/Fotos/udm.png" alt="Logo UDM" class="logo">
        <h1>UNIVERSIDAD DE MATAMOROS</h1>
    </header>

    <!-- Contenedor principal de la boleta -->
    <div class="boleta-container">
        <h2>BOLETA DE CALIFICACIONES</h2>

        <!-- Muestra los datos personales del alumno -->
        <p><strong>Nombre del Alumno:</strong> <?php echo htmlspecialchars($fila['nombre_alumno']); ?></p>
        <p><strong>Grado/Grupo:</strong> <?php echo htmlspecialchars($fila['grado_grupo']); ?></p>

        <!-- Tabla que muestra las calificaciones -->
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

                    <!-- Aplica una clase CSS al estatus para mostrarlo con color -->
                    <td>
                        <span class="<?php echo strtolower($fila['estatus']); ?>">
                            <?php echo $fila['estatus']; ?>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Enlace para volver al listado de alumnos -->
        <a href="Index.php" class="regresar">VOLVER AL LISTADO</a>
    </div>
</body>
</html>