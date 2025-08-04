<?php
// Inicia sesión para controlar el acceso a la página
session_start();

// Si no hay usuario en sesión, se redirige al Login
if (!isset($_SESSION['usuario'])) {
    header("Location: Login.php");
    exit();
}

// Conecta a la base de datos
include("Conexion.php");
$conn = conectarBD();

// Inicializa el mensaje
$mensaje = "";

// Verifica si hay un ID en la URL, si no lo hay, regresa a Index
if (!isset($_GET['id'])) {
    header("Location: Index.php");
    exit();
}

// Captura el ID desde la URL
$id = $_GET['id'];

// Obtiene los datos actuales del alumno con ese ID
$sql = "SELECT * FROM calificaciones WHERE id=$id";
$resultado = mysqli_query($conn, $sql);

// Si el ID no existe o no devuelve un único registro, regresa a Index
if (mysqli_num_rows($resultado) != 1) {
    header("Location: Index.php");
    exit();
}

// Asocia los datos del alumno a la variable $fila
$fila = mysqli_fetch_assoc($resultado);

// Si se presiona el botón para actualizar datos
if (isset($_POST['btnActualizar'])) {
    // Captura todos los datos del formulario
    $nombre = $_POST['nombre'];
    $grado = $_POST['grado'];
    $parcial1 = $_POST['parcial1'];
    $parcial2 = $_POST['parcial2'];
    $parcial3 = $_POST['parcial3'];
    $ordinario = $_POST['ordinario'];

    // Calcula el promedio y redondea a dos decimales
    $promedio = round(($parcial1 + $parcial2 + $parcial3 + $ordinario) / 4, 2);

    // Determina el estatus según el promedio
    if ($promedio >= 90) {
        $estatus = "Exento";
    } elseif ($promedio >= 60) {
        $estatus = "Ordinario";
    } else {
        $estatus = "Reprobado";
    }

    // Actualiza los datos en la base de datos
    $sqlUpdate = "UPDATE calificaciones SET
        nombre_alumno='$nombre',
        grado_grupo='$grado',
        parcial1='$parcial1',
        parcial2='$parcial2',
        parcial3='$parcial3',
        ordinario='$ordinario',
        promedio='$promedio',
        estatus='$estatus'
        WHERE id=$id";

    // Ejecuta la actualización y muestra mensaje según el resultado
    if (mysqli_query($conn, $sqlUpdate)) {
        $mensaje = "✅ Registro actualizado correctamente.";
        // Refresca los datos mostrados del alumno
        $fila = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM calificaciones WHERE id=$id"));
    } else {
        $mensaje = "❌ Error al actualizar: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Calificación</title>
    <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" href="Modificar.css">
</head>
<body>
    <!-- Encabezado institucional -->
    <header class="encabezado">
        <img src="/Fotos/udm.png" alt="Logo UDM" class="logo">
        <h1>UNIVERSIDAD DE MATAMOROS</h1>
    </header>

    <!-- Contenedor principal del formulario -->
    <div class="form-container">
        <h2>MODIFICAR CALIFICACIÓN</h2>

        <!-- Formulario para actualizar los datos -->
        <form method="POST" action="">
            <!-- Fila que contiene nombre y grado del alumno -->
            <div class="fila">
                <div class="columna">
                    <label for="nombre">Nombre del Alumno(a):</label>
                    <input type="text" name="nombre" id="nombre" 
                           value="<?php echo htmlspecialchars($fila['nombre_alumno']); ?>" required>
                </div>
                <div class="columna">
                    <label for="grado">Grado y Grupo:</label>
                    <select name="grado" id="grado" required>
                        <?php
                        // Genera dinámicamente las opciones y marca la actual como seleccionada
                        $opciones = [
                            "1er Tetramestre", "2do Tetramestre", "3er Tetramestre",
                            "4to Tetramestre", "5to Tetramestre", "6to Tetramestre",
                            "7mo Tetramestre", "8vo Tetramestre", "9no Tetramestre"
                        ];
                        foreach ($opciones as $opcion) {
                            $selected = ($fila['grado_grupo'] == $opcion) ? 'selected' : '';
                            echo "<option value='$opcion' $selected>$opcion</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Sección de calificaciones -->
            <h3 class="titulo-secundario">CALIFICACIONES</h3>
            <div class="fila-calif">
                <div class="columna">
                    <label for="parcial1">Parcial 1:</label>
                    <input type="number" name="parcial1" step="0.01" 
                           value="<?php echo $fila['parcial1']; ?>" required>
                </div>
                <div class="columna">
                    <label for="parcial2">Parcial 2:</label>
                    <input type="number" name="parcial2" step="0.01" 
                           value="<?php echo $fila['parcial2']; ?>" required>
                </div>
                <div class="columna">
                    <label for="parcial3">Parcial 3:</label>
                    <input type="number" name="parcial3" step="0.01" 
                           value="<?php echo $fila['parcial3']; ?>" required>
                </div>
                <div class="columna">
                    <label for="ordinario">Ordinario:</label>
                    <input type="number" name="ordinario" step="0.01" 
                           value="<?php echo $fila['ordinario']; ?>" required>
                </div>
            </div>

            <!-- Botón para enviar el formulario -->
            <button type="submit" name="btnActualizar">GUARDAR CAMBIOS</button>
        </form>

        <!-- Muestra mensaje de confirmación o error -->
        <p class="mensaje"><?php echo $mensaje; ?></p>

        <!-- Enlace para regresar al Index -->
        <p><a href="Index.php" class="regresar">VOLVER AL INICIO</a></p>
    </div>
</body>
</html>