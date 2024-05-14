<?php 

$conectar = new mysqli("localhost", "root", "", "bdlab");
if ($conectar->error) {
    echo 'Error de conexion ' . $conectar->error;
    exit;
}

?>