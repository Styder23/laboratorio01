<?php
// Incluye la conexión a la base de datos
include('../tablas/examen/conexion.php');

// Obtiene los datos del formulario
$dni = isset($_POST['dni']) ? $_POST['dni'] : '';
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
$edad = isset($_POST['edad']) ? $_POST['edad'] : '';
$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
$genero = isset($_POST['genero']) ? $_POST['genero'] : '';
$correo = isset($_POST['correo']) ? $_POST['correo'] : '';
$ruc = isset($_POST['ruc']) ? $_POST['ruc'] : '';

//realizamos la consulta para insertar
$sql = $con->prepare("CALL pro_Cpaciente(?, ?, ?, ?, ?, ?, ?, ?)");
$sql->bind_param('sssiisss', $dni, $nombre, $apellidos, $edad, $direccion, $genero, $correo, $ruc);

$result = $sql->execute();

if ($result) {
    // Si la inserción fue exitosa
    $data = array(
        'status' => 'success',
        'message' => 'Paciente agregado correctamente'
    );
} else {
    // Si ocurrió un error
    $data = array(
        'status' => 'error',
        'message' => 'Error al agregar el paciente'
    );
}

// Devuelve la respuesta como JSON
echo json_encode($data);

// Cierra la conexión y la consulta
$sql->close();
$con->close();
?>
