<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pago de Salario</title>
</head>
<body>

<h1>Pago de Salario</h1>

<form action="" method="post">
    <label for="nombre">Empleado: </label>
    <input type="text" name="nombre" id="nombre" ><br><br>

    <label for="horas">Horas Trabajadas: </label>
    <input type="number" name="horas" id="horas"><br><br>

    <label for="categoria">Categoría: </label>
    <select name="categoria" id="categoria" required>
        <option value="450">Jefe ($900)</option>
        <option value="350">Administrativo ($500)</option>
        <option value="350">Operador ($300)</option>
        <option value="150">Practicante ($200)</option>
    </select><br><br>

    <button type="submit">Calcular salario</button>
</form>

<?php
if (isset($_POST['nombre']) && isset($_POST['horas']) && isset($_POST['categoria'])) {
    $nombre = $_POST['nombre'];
    $horas = (int)$_POST['horas'];
    $salarioHora = (float)$_POST['categoria'];

    $salarioBruto = $horas * $salarioHora;

    $descuento = $salarioBruto * 0.10;

    $salarioNeto = $salarioBruto - $descuento;

    // Resultados
    echo "<h2>Resultados</h2>";
    echo "<p>Nombre del empleado: $nombre</p>";
    echo "<p>Horas trabajadas: $horas</p>";
    echo "<p>Salario Bruto: $" . number_format($salarioBruto, 2) . "</p>";
    echo "<p>Descuento (10%): $" . number_format($descuento, 2) . "</p>";
    echo "<p>Salario Neto: $" . number_format($salarioNeto, 2) . "</p>";
}
?>

</body>
</html>