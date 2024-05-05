<?php 

$conectar = new mysqli("localhost", "root", "root", "bdlaboratorio");
if ($conectar->error) {
    echo 'Error de conexion ' . $conectar->error;
    exit;
}

?>