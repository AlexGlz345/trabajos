<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Calificaciones</title>
    <style>
        body {
            background-color: #fff;
            color: #000;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #6c6df8;
        }
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 6px;
            margin-top: 4px;
            border: 1px solid #000;
            background-color: #fff;
            color: #000;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        .radio-group {
            margin-top: 8px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 8px;
            margin-top: 20px;
            background-color: #16ff01;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .resultado p {
            margin: 8px 0;
        }

        .estado {
            font-weight: bold;
        }
    </style>
</head>
<body>

//aqui ponemos las variables y nombre de las materias y genero

<div class="formulario">
    <h2>Formulario de Calificaciones</h2>
    <form method="post">
        <label>Nombre del Alumno:</label><br>
        <input type="text" name="nombre" required><br>
        <label>Materia:</label><br>
        <select name="materia" required>
            <option value="">Seleccione una materia</option>
            <option value="Programacion">Programación</option>
            <option value="Ingles">Ingles</option>
            <option value="Seguridad">Seguridad</option>
        </select><br>

        <label>Género:</label><br>
        <input type="radio" name="genero" value="Hombre" required> Hombre
        <input type="radio" name="genero" value="Mujer"> Mujer<br><br>

//cal1 significa calificaiones y se hace un requerimiento minimo y maximo

        <label>Calificaciones:</label><br>
        <input type="number" name="cal1" required min="0" max="10" placeholder="1er Parcial"><br>
        <input type="number" name="cal2" required min="0" max="10" placeholder="2do Parcial"><br>
        <input type="number" name="cal3" required min="0" max="10" placeholder="3er Parcial"><br><br>

        <input type="submit" value="Calcular Calificación Final" class="boton">
    </form>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $materia = $_POST["materia"];
    $genero = $_POST["genero"];
    $cal1 = $_POST["cal1"];
    $cal2 = $_POST["cal2"];
    $cal3 = $_POST["cal3"];

    $promedio = round(($cal1 + $cal2 + $cal3) / 3, 1);

//aqui se ponemo el minimo y maximo del promedio con 7 y 9 y agregamos color ala palabra reprobado y aprobado

    if ($promedio <= 6) {
        $estado = "reprobado";
        $color = "red";
    } else if ($promedio >= 7 && $promedio <= 9) {
        $estado = "aprobado";
        $color = "orange";
    } else {
        $estado = "exento";
        $color = "green";
    }
//aqui agregamos un strong para las variables nombre,genero, etc y agregamos una clase para el estilo del color y que se ejecute en la palabra estado
    echo "<div class='resultado'>";
    echo "<h2>Resultado de Evaluación</h2>";
    echo "<p><strong>Nombre:</strong> $nombre</p>";
    echo "<p><strong>Género:</strong> $genero</p>";
    echo "<p><strong>Materia:</strong> $materia</p>";
    echo "<p><strong>Calificaciones:</strong> $cal1, $cal2, $cal3</p>";
    echo "<p><strong>Calificación Final:</strong> $promedio</p>";
    echo "<p class='estado' style='color:$color;'><strong>Estado:</strong> $estado</p>";
    echo "</div>";
}
?>

</body>
</html>
