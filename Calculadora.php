<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora en PHP</title>
</head>
<body>
    <h2>Calculadora Básica en PHP</h2>
    <form method="post">
        <input type="number" name="num1" placeholder="Número 1" step="any" required>
        <select name="operador">
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
        </select>
        <input type="number" name="num2" placeholder="Número 2" step="any" required>
        <input type="submit" name="calcular" value="Calcular">
    </form>

    <?php
    if (isset($_POST['calcular'])) {
        $num1 = (float) $_POST['num1'];
        $num2 = (float) $_POST['num2'];
        $operador = $_POST['operador'];
        $resultado = '';

        if ($operador == '+') {
            $resultado = $num1 + $num2;
        } elseif ($operador == '-') {
            $resultado = $num1 - $num2;
        } elseif ($operador == '*') {
            $resultado = $num1 * $num2;
        } elseif ($operador == '/') {
            if ($num2 != 0) {
                $resultado = $num1 / $num2;
            } else {
                $resultado = "Error: División por cero.";
            }
        } else {
            $resultado = "Operador inválido.";
        }

        echo "<p><strong>Resultado:</strong> $resultado</p>";
    }
    ?>
</body>
</html>
