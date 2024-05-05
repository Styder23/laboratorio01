<?php
require '../conexion/config.php';

// Obtener la acción y el ID del paciente desde la consulta URL
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verifica si la acción es 'seleccionar' y se proporcionó un ID válido
if ($accion === 'seleccionar' && $id > 0) {
    // Consulta SQL para obtener los datos del paciente por su ID
    $sql = "SELECT * FROM pacientes WHERE id = ?";
    $stmt = $conectar->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        // Almacena los datos del paciente
        $paciente = $resultado->fetch_assoc();
        // Envía los datos como JSON
        header('Content-Type: application/json');
        echo json_encode($paciente, JSON_UNESCAPED_UNICODE);
    } else {
        // Si no se encontró ningún paciente con el ID dado
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['error' => 'Paciente no encontrado'], JSON_UNESCAPED_UNICODE);
    }

    // Cerrar la consulta preparada
    $stmt->close();
} else {
    // Si la acción no es 'seleccionar' o el ID no es válido
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Solicitud incorrecta'], JSON_UNESCAPED_UNICODE);
}

// Cerrar la conexión
$conectar->close();
?>
