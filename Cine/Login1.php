<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $edad = intval($_POST['edad']);
        $tipoFuncion = $_POST['tipoFuncion'];
        $esEstudiante = isset($_POST['esEstudiante']);

        // Precios base
        $precios = [
            "2d" => 40,
            "3d" => 60,
            "imax" => 85,
            "vip" => 100
        ];

        $precioBase = $precios[$tipoFuncion];
        $descuento = 0;

        if ($edad <= 16) {
            $descuento = 20;
        } elseif ($edad >= 65) {
            $descuento = 25;
        } elseif ($esEstudiante) {
            $descuento = 25;
        }

        $total = $precioBase - ($precioBase * $descuento / 100);

        echo "<div class='resultado'>";
        echo "<strong>CineMax</strong><br>";
        echo "Nombre: $nombre<br>";
        echo "Edad: $edad años<br>";
        echo "Tipo de Función: " . strtoupper($tipoFuncion) . "<br>";
        echo "Precio Base: \$$precioBase<br>";
        echo "Descuento Aplicado: $descuento%<br>";
        echo "<strong>Total a Pagar: \$" . number_format($total, 2) . "</strong>";
        echo "</div>";
    }
{
    echo "<a href='Index1.html'>Volver</a>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de Compra - CineMax</title>
    <style>
        body {
            background-color:rgb(3, 62, 129);
            color: #000;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .resultado {
            border: 2px solid #000;
            padding: 30px 40px;
            text-align: center;
            border-radius: 8px;
            background-color:rgb(255, 255, 255);
        }

        .resultado strong {
            font-size: 20px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            color: #000;
            text-decoration: none;
            border: 1px solid #000;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #000;
            color:hsl(0, 0.00%, 0.00%);
        }
    </style>