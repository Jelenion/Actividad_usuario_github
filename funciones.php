<?php
# Pedir usuario a estudiar
function obtener_usuario() {
    // Ciclo que se mantiene hasta obtener un usuario valido
    while (true) {
        echo "Por favor ingrese un nombre de usuario de GitHub: ";
        $user = trim(fgets(STDIN)); // eliminar espacios al inicio y final
        $user = strip_tags($user); // eliminar inyeccion html
        // url del usuario
        $url = "https://api.github.com/users/$user";
        // dar contexto especial para hacer la consulta
        $context = stream_context_create([
            "http" => [
                "header" => "User-Agent: PHP" //github no recibe consultas si no tiene como cabecera User-Agent
            ]
        ]);
        // respuesta de la consulta
        $response = @fopen($url, "r", false, $context); // lectura del url remoto con el contexto
        // respuesta obtenida
        if ($response) {
            fclose($response); //cerrar lectura
            break;
        } else {
            echo "\nUsuario inválido, intente nuevamente\n"; // si el usuario no es valido el ciclo se repite
        }
    }
    return $user; // retornar usuario
}
# Obtener datos
function obtener_datos($usuario){
    // url de usuario
    $url = "https://api.github.com/users/$usuario/events";
    // dar contexto especial para hacer la consulta
    $context = stream_context_create([
        "http" => [
            "header" => "User-Agent: PHP"
        ]
    ]);
    // respuesta de la consulta
    $response = @file_get_contents($url, false, $context);
    // validar que se obtuvieron correctamente las actividades
    if($response === false){
        echo "Error al obtener actividades\n";
        return [];
    }
    $data = json_decode($response, true);
    return $data;
}
# Mostrar datos en pantalla
function imprimir_datos($datos){
    echo "\nLISTA DE ACTIVIDADES:\n";
    // Si no hay actividades del usuario
    if(empty($datos)){
        echo "No hay actividades hechas por este usuario\n";
    } else{
        foreach($datos as $dato){
            echo "Tipo:" . (is_string($dato['type']) ? $dato['type'] : "No disponible") . "\n";
            echo "Repositorio:" . $dato['repo']['name'] . "\n";
            echo "Fecha:" . $dato['created_at'] . "\n";
            echo "---------------------------------------\n";
        }
    }
}
?>
