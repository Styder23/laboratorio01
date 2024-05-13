<?php
// Incluye la conexión a la base de datos
include('../tablas/examen/conexion.php');
// Verifica si se recibieron los datos requeridos en la solicitud POST
if (isset($_POST['_id'], $_POST['_dni'], $_POST['_nombres'], $_POST['_apellidos'], $_POST['_edad'], $_POST['_direccion'], $_POST['_genero'], $_POST['_correo'], $_POST['_ruc'])) {
    echo json_encode(['status' => 'false', 'message' => 'Faltan datos en la solicitud']);
    exit;
}

// Obtiene los valores del POST de forma segura
$idPaciente = intval($_POST['idPaciente']);
$dni = mysqli_real_escape_string($con, $_POST['dni']);
$nombres = mysqli_real_escape_string($con, $_POST['nombres']);
$apellidos = mysqli_real_escape_string($con, $_POST['apellidos']);
$edad = intval($_POST['edad']);
$direccion = mysqli_real_escape_string($con, $_POST['direccion']);
$genero = intval($_POST['genero']);
$correo = mysqli_real_escape_string($con, $_POST['correo']);
$ruc = mysqli_real_escape_string($con, $_POST['ruc']);

// Verifica que los datos no estén vacíos o sean inválidos
if ($idPaciente <= 0 || empty($dni) || empty($nombres) || empty($apellidos) || $edad <= 0 || empty($direccion) || empty($genero) || empty($correo) || empty($ruc)) {
    echo json_encode(['status' => 'false', 'message' => 'Datos incompletos o inválidos']);
    exit;
}

// Manejo de excepciones para la consulta
try {
    // Prepara la declaración
    $sql = "CALL pro_Uppaciente(?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);

    if (!$stmt) {
        throw new Exception('Error preparando la consulta SQL');
    }

    // Vincula los parámetros
    $stmt->bind_param('isssisiss',$idPaciente, $dni, $nombres, $apellidos, $edad, $direccion, $genero, $correo, $ruc );
    // Ejecuta la consulta
    if ($stmt->execute()) {
        echo json_encode(['status' => 'true', 'message' => 'Paciente actualizado correctamente']);
    } else {
        throw new Exception('Error al actualizar el paciente');
    }

    // Cierra la declaración
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'false', 'message' => $e->getMessage()]);
}

// Cierra la conexión a la base de datos
$con->close();
?>
