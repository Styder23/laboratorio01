<?php 

$conectar = new mysqli("localhost", "root", "root", "bdlab");
if ($conectar->error) {
    echo 'Error de conexion ' . $conectar->error;
    exit;
}

?>