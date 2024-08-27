<?php
// Obtener los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $equipo = $_POST['equipo'];

    // Verificar si el email ya respondió la encuesta
    $respuestas = file_get_contents('respuestas.txt');
    $respuestas_array = explode("\n", $respuestas);
    $ya_respondio = false;

    foreach ($respuestas_array as $respuesta) {
        $datos = explode(",", $respuesta);
        if ($datos[0] == $email) {
            $ya_respondio = true;
            break;
        }
    }

    if ($ya_respondio) {
        echo "Usted ya ha respondido la encuesta.";
    } else {
        // Agregar la respuesta al archivo
        $respuesta = $email . "," . $equipo;
        file_put_contents('respuestas.txt', $respuesta . "\n", FILE_APPEND);

        $estadisticas = actualizarEstadisticas($respuestas_array, $equipo);

        // Mostrar resultados de la encuesta
        mostrarResultados($estadisticas);
    }
}

// Función para actualizar las estadísticas de votos
function actualizarEstadisticas($respuestas_array, $equipoVotado) {
    $estadisticas = array(
        "Boca Juniors" => 0,
        "River Plate" => 0,
        "San Lorenzo" => 0,
        "Racing" => 0,
        "Independiente" => 0,
        "Otro" => 0
    );

    foreach ($respuestas_array as $respuesta) {
        $datos = explode(",", $respuesta);
        if (isset($estadisticas[$datos[1]])) {
            $estadisticas[$datos[1]]++;
        }
    }

    // Contabilizar voto del equipo seleccionado
    $estadisticas[$equipoVotado]++;

    return $estadisticas;
}

// Función para mostrar los resultados de la encuesta
function mostrarResultados($estadisticas) {
    echo "<h2>Resultados de la encuesta:</h2>";
    echo "<ul>";
    foreach ($estadisticas as $equipo => $votos) {
        echo "<li>" . $equipo . ": " . $votos . " votos</li>";
    }
    echo "</ul>";
}
?>