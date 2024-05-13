<?php



require '../examen/conexion.php';


// Recibir el JSON
$examenes = json_decode($_POST['json'], true);
print_r($examenes);

require '../examen/conexion.php';

// Verificar si se recibieron datos válidos
if (!empty($examenes) && is_array($examenes)) {
    // Preparar la consulta para insertar los exámenes
    $stmt = $con->prepare("INSERT INTO examen(codigomuestra,fechaentreamuestra,fk_tipomuestra,fk_tipoexamen,fk_paciente,fk_estado_e) VALUES (?,?,?,?,?,1)");

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt) {
        // Iterar sobre los datos de los exámenes y ejecutar la consulta
        foreach ($examenes as $exam) {
            // Obtener los valores del examen
            $id_paciente = $exam['id']; // Ajustado al nombre correcto del campo
            $muestra = $exam['muestra']; // Ajustado al nombre correcto del campo
            $examen = $exam['examen']; // Ajustado al nombre correcto del campo

            // Generar el código de muestra llamando a la función cod_muestra con el ID del paciente
            $stmt_cod_muestra = $con->prepare("SELECT cod_muestra(?) AS codigo_muestra");
            $stmt_cod_muestra->bind_param("i", $id_paciente);
            $stmt_cod_muestra->execute();
            $resultado_cod_muestra = $stmt_cod_muestra->get_result();
            $fila_cod_muestra = $resultado_cod_muestra->fetch_assoc();
            $cod_muestra = $fila_cod_muestra['codigo_muestra'];

            // Obtener la fecha actual en formato MySQL datetime
            $fecha = date('Y-m-d H:i:s');

            // Asignar valores y ejecutar la consulta
            $stmt->bind_param("ssiii", $cod_muestra, $fecha, $muestra, $examen, $id_paciente);
            $stmt->execute();
        }

        // Cerrar la consulta
        $stmt->close();
    }
}

?>
