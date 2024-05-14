<?php
// Incluir el archivo de conexión a la base de datos
include '../../conexion/conec.php';

try {
    // Crear una instancia de conexión utilizando la clase ConexionDB
    $obj = new ConexionDB("localhost", "root", "", "bdlab");
    $db = $obj->conectar();

    // Consulta SQL para obtener los datos de la tabla de muestras
    $sql = "SELECT idtipomuestra, nomtip FROM tipomuestra";

    // Ejecutar la consulta
    $resultado = $db->query($sql);

    // Verificar si se obtuvieron resultados
    if ($resultado->num_rows > 0) {
        // Inicializar un array para almacenar los resultados
        $muestras = array();

        // Iterar sobre los resultados y almacenarlos en el array
        while ($fila = $resultado->fetch_assoc()) {
            $muestras[] = $fila;
        }

        // Devolver los resultados como JSON
        echo json_encode($muestras);
    } else {
        // Si no se encontraron resultados, devolver un mensaje de error
        echo json_encode(array('error' => 'No se encontraron muestras'));
    }
} catch (Exception $e) {
    // Capturar cualquier excepción y devolver un mensaje de error
    echo json_encode(array('error' => 'Error en la conexión: ' . $e->getMessage()));
}

// Cerrar la conexión
$db->close();
?>
