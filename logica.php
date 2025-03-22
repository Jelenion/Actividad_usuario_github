<?php
require_once 'funciones.php';
// Llamar funciones
$usuario = obtener_usuario(); //obtener usuario
$datos = obtener_datos($usuario); //obtener las actividades del usuario
imprimir_datos($datos); //mostrar las actividades en consola
?>
