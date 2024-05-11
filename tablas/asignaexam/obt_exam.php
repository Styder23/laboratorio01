<?php
include('../../conexion/conexion.php');

// Obtener el ID del área clínica desde la solicitud GET
$Area_id = isset($_GET['Area_id']) ? intval($_GET['Area_id']) : 0;

if ($Area_id > 0) {
    // Crear una instancia de conexión utilizando la clase BD
    $conexion = BD::crearInstancia();

    // Preparar la consulta utilizando parámetros con marcadores de posición
    $consulta = $conexion->prepare("SELECT idtipoexamen, nomexamen FROM tipoexamen WHERE fk_idarea = :Area_id");

    // Vincular el parámetro con el valor proporcionado
    $consulta->bindParam(':Area_id', $Area_id, PDO::PARAM_INT);

    // Ejecutar la consulta
    $consulta->execute();

    // Obtener los resultados como un array asociativo
    $examenes = $consulta->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los exámenes en formato JSON
    echo json_encode($examenes);
} else {
    // Si no se proporcionó un ID de área válido, devolver un error
    echo json_encode(['error' => 'ID del área no válido']);
}
?>