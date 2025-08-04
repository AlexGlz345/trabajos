<?php
session_start(); // Inicia la sesión para proteger el acceso

// Si no hay sesión activa, redirige al login
if (!isset($_SESSION['usuario'])) {
    header("Location: Login.php");
    exit();
}

include("Conexion.php"); // Conecta con la base de datos
$conn = conectarBD(); // Ejecuta la función de conexión

$mensaje = ""; // Variable para mostrar mensajes al usuario

// ------------------ AGREGAR CALIFICACIÓN ------------------
if (isset($_POST['btnAgregar'])) {
    $nombre = $_POST['nombre']; // Captura el nombre
    $grado = $_POST['grado']; // Captura el grado/grupo
    $parcial1 = $_POST['parcial1'];
    $parcial2 = $_POST['parcial2'];
    $parcial3 = $_POST['parcial3'];
    $ordinario = $_POST['ordinario'];

    // Calcula el promedio
    $promedio = round(($parcial1 + $parcial2 + $parcial3 + $ordinario) / 4, 2);

    // Determina el estatus según promedio
    if ($promedio >= 90) {
        $estatus = "Exento";
    } elseif ($promedio >= 60) {
        $estatus = "Ordinario";
    } else {
        $estatus = "Reprobado";
    }

    // Inserta el registro en la base de datos
    $sql = "INSERT INTO calificaciones (nombre_alumno, grado_grupo, parcial1, parcial2, parcial3, ordinario, promedio, estatus)
            VALUES ('$nombre', '$grado', '$parcial1', '$parcial2', '$parcial3', '$ordinario', '$promedio', '$estatus')";

    if (mysqli_query($conn, $sql)) {
        $mensaje = "✅ REGISTRO AGREGADO CORRECTAMENTE.";
    } else {
        $mensaje = "❌ ERROR AL AGREGAR: " . mysqli_error($conn);
    }
}

// ------------------ ELIMINAR ------------------
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $sql = "DELETE FROM calificaciones WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: Index.php"); // Recarga la página
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CONTROL ESCOLAR</title>
    <link rel="stylesheet" href="Index.css"> <!-- Archivo de estilos -->
</head>
<body>
    <!-- ENCABEZADO INSTITUCIONAL -->
    <header class="encabezado">
        <img src="/Fotos/udm.png" class="logo" alt="Logo Universidad">
        <h1>UNIVERSIDAD DE MATAMOROS</h1>
    </header>

    <!-- BIENVENIDA -->
    <p class="bienvenida">BIENVENIDO <?php echo strtoupper($_SESSION['usuario']); ?>, POR FAVOR INGRESA LA INFORMACIÓN QUE SE PIDE...</p>

    <!-- PRIMER CUADRO (FORMULARIO) -->
    <div class="formulario">
        <form method="POST">
            <!-- NOMBRE Y GRADO-GRUPO -->
            <div class="fila">
                <div>
                    <label for="nombre">NOMBRE DEL ALUMNO(A)</label>
                    <input type="text" name="nombre" required>
                </div>
                <div>
                    <label for="grado">GRADO Y GRUPO</label>
                    <select name="grado" required>
                        <option value="">-- SELECCIONA --</option>
                        <option>1ER TETRAMESTRE</option>
                        <option>2DO TETRAMESTRE</option>
                        <option>3ER TETRAMESTRE</option>
                        <option>4TO TETRAMESTRE</option>
                        <option>5TO TETRAMESTRE</option>
                        <option>6TO TETRAMESTRE</option>
                        <option>7MO TETRAMESTRE</option>
                        <option>8VO TETRAMESTRE</option>
                        <option>9NO TETRAMESTRE</option>
                    </select>
                </div>
            </div>

            <!-- CALIFICACIONES -->
            <h2 class="subtitulo">CALIFICACIONES</h2>
            <div class="fila">
                <input type="number" name="parcial1" placeholder="PARCIAL 1" step="0.01" required>
                <input type="number" name="parcial2" placeholder="PARCIAL 2" step="0.01" required>
                <input type="number" name="parcial3" placeholder="PARCIAL 3" step="0.01" required>
                <input type="number" name="ordinario" placeholder="ORDINARIO" step="0.01" required>
            </div>

            <!-- BOTONES -->
            <button type="submit" name="btnAgregar">AGREGAR CALIFICACIÓN</button>
            <a href="CerrarSesion.php" class="cerrar">CERRAR SESIÓN</a>
        </form>
    </div>

    <!-- MENSAJE -->
    <?php if ($mensaje != "") echo "<p class='mensaje'>$mensaje</p>"; ?>

    <!-- SEGUNDO CUADRO (TABLA) -->
    <div class="tabla">
        <h2 class="subtitulo">LISTADO DE CALIFICACIONES</h2>
        <table>
            <tr>
                <th>NOMBRE</th>
                <th>GRADO / GRUPO</th>
                <th>PRIMER PARCIAL</th>
                <th>SEGUNDO PARCIAL</th>
                <th>TERCER PARCIAL</th>
                <th>ORDINARIO</th>
                <th>PROMEDIO</th>
                <th>ESTATUS</th>
                <th>ACCIONES</th>
            </tr>

            <?php
            $sql = "SELECT * FROM calificaciones";
            $resultado = mysqli_query($conn, $sql);

            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td>" . $fila['nombre_alumno'] . "</td>";
                echo "<td>" . $fila['grado_grupo'] . "</td>";
                echo "<td>" . $fila['parcial1'] . "</td>";
                echo "<td>" . $fila['parcial2'] . "</td>";
                echo "<td>" . $fila['parcial3'] . "</td>";
                echo "<td>" . $fila['ordinario'] . "</td>";
                echo "<td>" . $fila['promedio'] . "</td>";
                
                // Estatus con colores
                $estatusColor = "";
                if ($fila['estatus'] == 'Exento') {
                    $estatusColor = "<span class='exento'>EXENTO</span>";
                } elseif ($fila['estatus'] == 'Ordinario') {
                    $estatusColor = "<span class='ordinario'>ORDINARIO</span>";
                } else {
                    $estatusColor = "<span class='reprobado'>REPROBADO</span>";
                }
                echo "<td>$estatusColor</td>";

                // Botones de Acción
                echo "<td>
                    <a href='modificar.php?id={$fila['id']}' class='btn verde'>MODIFICAR</a>
                    <a href='index.php?eliminar={$fila['id']}' class='btn rojo' onclick=\"return confirm('Deseas eliminar este registro?')\">ELIMINAR</a>
                    <a href='boleta.php?id={$fila['id']}' class='btn azul'>VISTA PREVIA</a>
                </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>