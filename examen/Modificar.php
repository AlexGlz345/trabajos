<?php
// Inicia sesión y verifica
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: Login.php");
    exit();
}

include("Conexion.php");
$conn = conectarBD();

$mensaje = "";

// Verifica el ID en URL, sino regresa al Index
if (!isset($_GET['id'])) {
    header("Location: Index.php");
    exit();
}

$id = $_GET['id'];

// Obtiene datos actuales del alumno con ese ID
$sql = "SELECT * FROM calificaciones WHERE id=$id";
$resultado = mysqli_query($conn, $sql);

if (mysqli_num_rows($resultado) != 1) {
    header("Location: Index.php");
    exit();
}

$fila = mysqli_fetch_assoc($resultado);

// Al Precionar el botón, se Actualiza Todo los Datos 
if (isset($_POST['btnActualizar'])) {
    $nombre = $_POST['nombre'];
    $grado = $_POST['grado'];
    $parcial1 = $_POST['parcial1'];
    $parcial2 = $_POST['parcial2'];
    $parcial3 = $_POST['parcial3'];
    $ordinario = $_POST['ordinario'];

    $promedio = round(($parcial1 + $parcial2 + $parcial3 + $ordinario) / 4, 2);

    // Determina el Estatus que Tendra el Alumno 
    if ($promedio >= 90) {
        $estatus = "Exento";
    } elseif ($promedio >= 60) {
        $estatus = "Ordinario";
    } else {
        $estatus = "Reprobado";
    }

    // Actualiza Datos en la Base
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

    if (mysqli_query($conn, $sqlUpdate)) {
        $mensaje = "✅ Registro actualizado correctamente.";
        // Refresca LOS Datos Mostrado
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
    <!-- Link a Archivo CSS Externo -->
    <link rel="stylesheet" href="Modificar.css">
</head>
<body>
    <!-- Encabezado con Logo y Texto -->
    <header class="encabezado">
        <img src="/Fotos/udm.png" alt="Logo UDM" class="logo">
        <h1>UNIVERSIDAD DE MATAMOROS</h1>
    </header>

    <!-- Cuadro Blanco para Formulario -->
    <div class="form-container">
        <h2>MODIFICAR CALIFICACIÓN</h2>

        <!-- Formulario con Método POST -->
        <form method="POST" action="">
            <!-- Fila con Nombre y Grado -->
            <div class="fila">
                <div class="columna">
                    <label for="nombre">Nombre del Alumno(a):</label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($fila['nombre_alumno']); ?>" required>
                </div>

                <div class="columna">
                    <label for="grado">Grado y Grupo:</label>
                    <select name="grado" id="grado" required>
                        <?php
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

            <!-- Título CALIFICACIONES centrado -->
            <h3 class="titulo-secundario">CALIFICACIONES</h3>

            <!-- Fila con calificaciones en columnas -->
            <div class="fila-calif">
                <div class="columna">
                    <label for="parcial1">Parcial 1:</label>
                    <input type="number" name="parcial1" step="0.01" value="<?php echo $fila['parcial1']; ?>" required>
                </div>
                <div class="columna">
                    <label for="parcial2">Parcial 2:</label>
                    <input type="number" name="parcial2" step="0.01" value="<?php echo $fila['parcial2']; ?>" required>
                </div>
                <div class="columna">
                    <label for="parcial3">Parcial 3:</label>
                    <input type="number" name="parcial3" step="0.01" value="<?php echo $fila['parcial3']; ?>" required>
                </div>
                <div class="columna">
                    <label for="ordinario">Ordinario:</label>
                    <input type="number" name="ordinario" step="0.01" value="<?php echo $fila['ordinario']; ?>" required>
                </div>
            </div>

            <button type="submit" name="btnActualizar">GUARDAR CAMBIOS</button>
        </form>

        <!-- Mensaje confirmación o Error -->
        <p class="mensaje"><?php echo $mensaje; ?></p>

        <!-- Enlace para Volver al Index -->
        <p><a href="Index.php" class="regresar">VOLVER AL INICIO</a></p>
    </div>
</body>
</html>