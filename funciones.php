<?php
# Pedir usuario a estudiar
function obtener_usuario(){
    $user ="";
    while(true){
        echo "Por favor ingrese un nombre de usuario de Github: ";
        $user = trim(fgets(STDIN)); //obtener input y eliminar los espacios
        $user = strip_tags($user); // eliminar codigo html inyectado
        // Validar que el usuario existe
        $url = "https://api.github.com/users/$user";
        $options = [
            "http" => [
                "header" => "User-Agent: PHP"
            ]
            ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if(isset($http_response_header) && strpos($http_response_header[0], "200") !== false){
            break; //usuario válido
        } else {
            var_dump($http_response_header); // Ver los encabezados HTTP
            echo "\nUsuario inválido, intente nuevamente\n";
        }
    }
    
    return $user;
}
# Obtener datos

# Mostrar datos en pantalla


?>