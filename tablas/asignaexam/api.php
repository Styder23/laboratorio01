<?php



require '../examen/conexion.php';


// Recibir el JSON
$examenes = json_decode($_POST['json'], true);
//print_r($examenes);
print_r($_GET);

// Verificar si se recibieron datos válidos
if (!empty($examenes) && is_array($examenes)) {
    // Preparar la consulta para insertar los exámenes
    $stmt = $con->prepare("CALL Pro_asignaexam(?, ?, ?)");

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt) {
        // Iterar sobre los datos de los exámenes y ejecutar la consulta
        foreach ($examenes as $exam) {
            // Obtener los valores del examen
            $id_paciente = $exam['id']; // Ajustado al nombre correcto del campo
            $muestra = $exam['muestra']; // Ajustado al nombre correcto del campo
            $examen = $exam['examen']; // Ajustado al nombre correcto del campo

            // Asignar valores y ejecutar la consulta
            $stmt->bind_param("iii", $id_paciente, $muestra, $examen);
            $stmt->execute();
        }

        // Cerrar la consulta
        $stmt->close();
    }
}

?>
