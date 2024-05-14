<?php
// Incluye la conexión a la base de datos
include('../examen/conexion.php');






// Verifica si se recibieron los datos requeridos en la solicitud POST
if (isset($_POST['idexa'], $_POST['fec'])) {
    echo json_encode(['status' => 'false', 'message' => 'Faltan datos en la solicitud']);
    exit;
}

// Obtiene los valores del POST de forma segura
$idexamen = intval($_POST['idexamen']);
$fecha = $_POST['fecha'];

// Manejo de excepciones para la consulta
try {
    // Prepara la declaración
    $sql = "UPDATE examen SET fechaentreamuestra = ? WHERE idexamen = ?";
    $stmt = $con->prepare($sql);

    if (!$stmt) {
        throw new Exception('Error preparando la consulta SQL');
    }

    // Vincula los parámetros
    $stmt->bind_param('si', $fecha , $idexamen);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        echo json_encode(['status' => 'true', 'message' => 'Examen actualizado con éxito']);
    } else {
        throw new Exception('Error al actualizar el examen');
    }

    // Cierra la declaración
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'false', 'message' => $e->getMessage()]);
}

// Cierra la conexión a la base de datos
$con->close();
?>
