<?php 
include_once "../../conexion/conexion.php";
$conexionBD = BD::crearInstancia();

// Obtiene los datos del formulario
$dni = isset($_POST['dni']) ? $_POST['dni'] : '';
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
$edad = isset($_POST['edad']) ? $_POST['edad'] : '';
$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
$genero = isset($_POST['genero']) ? $_POST['genero'] : '';
$correo = isset($_POST['correo']) ? $_POST['correo'] : '';
$RUC = isset($_POST['ruc']) ? $_POST['ruc'] : '';

try {
    // Prepara la consulta para llamar al procedimiento almacenado
    $query = $conexionBD->prepare("CALL pro_Cpaciente(?, ?, ?, ?, ?, ?, ?, ?)");
    if ($query === false) {
        // Mostrar el error de la preparación de la consulta
        throw new Exception('Error al preparar la consulta: ' . $conexionBD->errorInfo()[2]);
    }

    // Vincula los parámetros a la consulta
    if (!$query->execute([$dni, $nombre, $apellidos, $edad, $direccion, $genero, $correo, $RUC])) {
        // Manejador de errores de ejecución
        throw new Exception('Error al ejecutar la consulta: ' . $query->errorInfo()[2]);
    }

    // Inserción exitosa, envía respuesta JSON
    echo json_encode(['success' => true, 'message' => 'Paciente agregado correctamente']);

} catch (Exception $e) {
    // Manejo de excepciones
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
} finally {
    // Cerrar la consulta y la conexión a la base de datos
    if (isset($query)) {
        $query->closeCursor(); // Cambio realizado aquí
    }
    if (isset($conexionBD)) {
        $conexionBD = null;
    }
}
?>
