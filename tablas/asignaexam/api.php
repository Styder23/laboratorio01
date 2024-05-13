<?php
// Incluir el archivo de conexión a la base de datos
include('../muestras/connection.php');

// Verificar si se recibieron datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decodificar los datos JSON recibidos del cliente
    $examData = json_decode(file_get_contents('php://input'), true);

    // Verificar si se recibieron datos válidos
    if (!empty($examData) && is_array($examData)) {
        // Preparar la consulta para insertar los exámenes
        $stmt = $con->prepare("CALL Pro_asignaexam(?, ?, ?)");

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt) {
            // Iterar sobre los datos de los exámenes y ejecutar la consulta
            foreach ($examData as $exam) {
                // Obtener los valores del examen
                $id_paciente = $exam['idPaciente']; // Ajustado al nombre correcto del campo
                $muestra = $exam['idMuestra']; // Ajustado al nombre correcto del campo
                $examen = $exam['idExamen']; // Ajustado al nombre correcto del campo

                // Asignar valores y ejecutar la consulta
                $stmt->bind_param("iii", $id_paciente, $muestra, $examen);
                $stmt->execute();
            }

            // Cerrar la consulta
            $stmt->close();

            // Respondemos al cliente con un mensaje de éxito
            echo json_encode(['success' => true]);
        } else {
            // Si no se pudo preparar la consulta, responder con un mensaje de error
            echo json_encode(['error' => 'Error al preparar la consulta']);
        }
    } else {
        // Si no se recibieron datos válidos, responder con un mensaje de error
        echo json_encode(['error' => 'Datos incorrectos']);
    }
} else {
    // Si no se recibieron datos por POST, responder con un mensaje de error
    echo json_encode(['error' => 'No se recibieron datos por POST']);
}
?>