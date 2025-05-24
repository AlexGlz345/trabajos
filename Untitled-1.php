<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clasificación por Edad</title>
</head>
<body>
    <h1>Introduce tu edad</h1>
    <form method="post">
        <label for="edad">Edad:</label>
        <input type="number" name="edad" id="edad" required>
        <input type="submit" value="Enviar">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edad'])) {
        $edad = (int)$_POST['edad']; // Asegurarse de que es un número entero

        echo "<p>Edad ingresada: $edad</p>";

        if ($edad <= 13) {
            echo "<p>Eres un niño</p>";
        } else if ($edad >= 14 && $edad <= 17) {
            echo "<p>Eres un adolescente</p>";
        } else if ($edad >= 18 && $edad <= 25) {
            echo "<p>Eres un joven adulto</p>";
        } else if ($edad >= 26 && $edad <= 59) {
            echo "<p>Eres un adulto</p>";
        } else if ($edad >= 60 && $edad <= 100) {
            echo "<p>Eres alguien de la tercera edad</p>";
        } else {
            echo "<p>Edad no válida</p>";
        }
    }
    ?>
</body>
</html>
