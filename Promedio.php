<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Promedio de 3 Calificaciones</title>
</head>
<body>
    <h2>Calculadora de Promedio de Calificaciones</h2>
    <form method="post">
        <label>Calificación 1: </label>
        <input type="number" name="nota1" step="any" required><br><br>

        <label>Calificación 2: </label>
        <input type="number" name="nota2" step="any" required><br><br>

        <label>Calificación 3: </label>
        <input type="number" name="nota3" step="any" required><br><br>

        <input type="submit" name="calcular" value="Calcular Promedio">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calcular'])) {
        $nota1 = floatval($_POST['nota1']);
        $nota2 = floatval($_POST['nota2']);
        $nota3 = floatval($_POST['nota3']);

        $promedio = ($nota1 + $nota2 + $nota3) / 3;
        $promedio = round($promedio, 2);

        echo "<h3>El promedio es: $promedio</h3>";

        if ($promedio <= 69) {
            echo "<p style='color: red;'>Resultado: Reprobado</p>";
        } elseif ($promedio <= 94) {
            echo "<p style='color: blue;'>Resultado: Aprobado</p>";
        } else {
            echo "<p style='color: green;'>Resultado: Exento</p>";
        }
    }
    ?>
</body>
</html>
