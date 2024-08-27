<!DOCTYPE html>
<html>
<head>
    <title>Encuesta de Equipos de Fútbol</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="script.js"></script>
</head>
<body>
    <div class="container">
        <img src="https://www.uncuyo.edu.ar/assets/imgs/logo_uncu23.png" alt="Logo UNCuyo">
        <h1>Elija su equipo favorito</h1>
        <form id="equipoForm" onsubmit="validarFormulario(event)" method="post" action="procesar_form.php">
            <label for="email">Ingrese su e-mail:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label>Equipo favorito:</label>
            <br>
            <input type="radio" id="bocaJuniors" name="equipo" value="Boca Juniors">
            <label for="bocaJuniors">Boca Juniors <img src="./escudos/boca_juniors.png" width="30" alt="Boca Juniors"></label>
            <br>
            <input type="radio" id="riverPlate" name="equipo" value="River Plate">
            <label for="riverPlate">River Plate <img src="./escudos/river_plate.png" width="30" alt="River Plate"></label>
            <br>
            <input type="radio" id="sanLorenzo" name="equipo" value="San Lorenzo">
            <label for="sanLorenzo">San Lorenzo <img src="./escudos/sanlorenzo_almagro.png" width="30" alt="San Lorenzo"></label>
            <br>
            <input type="radio" id="racing" name="equipo" value="Racing">
            <label for="racing">Racing <img src="./escudos/racing_club.png" width="30" alt="Racing"></label>
            <br>
            <input type="radio" id="independiente" name="equipo" value="Independiente">
            <label for="independiente">Independiente <img src="./escudos/independiente_avellaneda.png" width="30" alt="Independiente"></label>
            <br>
            <input type="radio" id="otro" name="equipo" value="Otro">
            <label for="otro">Otro</label>
            <br>
            <button type="submit">Enviar</button>
        </form>
        <div id="resultados"></div>
    </div>
</body>
</html>