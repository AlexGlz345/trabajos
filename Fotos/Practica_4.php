<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            font-family: Arial;padding: 20px;
            max-width: 400px;
            margin: auto;
        }
        input, select,button{
            margin: 10px 0;
        padding: 8px;
        width: 100%;
        }
    </style>
</head>
<body>
    <h1>Calculadora</h1>
    <form method="post" action=""> 

    <input type="numero" name="num1" placeholder="Primer numero" required>
    
    <input type="numero" name="num2" placeholder="Segundo numero" required>

    <select name="operacion">
    <option value="sumar">sumar</option>
    <option value="restar">resta</option>
    <option value="multiplicar">multiplicar</option>
    <option value="dividir">dividir</option>
    </select>

<button type="submit">Calcular</button>
   </form>

   <?php
   if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $num1 = floatval($_POST ["num1"]);
    $num2 = floatval($_POST ["num2"]);
    $operacion = $_POST["operacion"];
    $resultado = "";

switch ($operacion){
        case "sumar": $resultado = $num1 + $num2;
        break;
        case "restar": $resultado = $num1 - $num2;
        break;
        case "multiplicar": $resultado = $num1 * $num2;
        break;
        case "dividir": if ($num2 != 0){
            $resultado = $num1/$num2;
        }else{
            $resultado = "Error: ";
        }
        break;
default: $resultado = "operacion no valida";
}
echo "<h3> resultado: $resultado<h3>";
   } 

   ?>



    





</body>
</html>