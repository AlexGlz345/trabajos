<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Galería Simple</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f8f8f8;
        }

        h2 {
            margin-top: 30px;
            color: #333;
        }

        .galeria {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .galeria img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 2px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .galeria img:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

    <h2>Galería de Imágenes</h2>

    <div class="galeria">
        <img src="Fotos/img.png" alt="Imagen 1">
        <img src="Fotos/img1.png" alt="Imagen 2">
        <img src="Fotos/img2.png" alt="Imagen 3">
        <img src="Fotos/img3.png" alt="Imagen 4">
    </div>

</body>
</html>
