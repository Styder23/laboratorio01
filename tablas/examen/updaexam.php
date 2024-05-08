<?php
// Incluye la conexión a la base de datos
include('conexion.php');

// Verifica si se recibieron los datos requeridos en la solicitud POST
if (!isset($_POST['idexamen'], $_POST['examen'], $_POST['area'])) {
    echo json_encode(['status' => 'false', 'message' => 'Faltan datos en la solicitud']);
    exit;
}

// Obtiene los valores del POST de forma segura
$idexamen = intval($_POST['idexamen']);
$examen = mysqli_real_escape_string($con, $_POST['examen']);
$area = intval($_POST['area']);

// Verifica que los datos no estén vacíos o sean inválidos
if ($idexamen <= 0 || empty($examen) || $area <= 0) {
    echo json_encode(['status' => 'false', 'message' => 'Datos incompletos o inválidos']);
    exit;
}

// Manejo de excepciones para la consulta
try {
    // Prepara la declaración
    $sql = "UPDATE examen SET nomexam = ?, fk_idarea = ? WHERE idexamen = ?";
    $stmt = $con->prepare($sql);

    if (!$stmt) {
        throw new Exception('Error preparando la consulta SQL');
    }

    // Vincula los parámetros
    $stmt->bind_param('sii', $examen, $area, $idexamen);

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
