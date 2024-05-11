<?php
// Incluye la conexión a la base de datos
include('../examen/conexion.php');

// Obtiene los datos del formulario
$dni = isset($_POST['dni']) ? $_POST['dni'] : '';
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
$genero = isset($_POST['genero']) ? $_POST['genero'] : '';
$edad = isset($_POST['edad']) ? $_POST['edad'] : '';
$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
$correo = isset($_POST['correo']) ? $_POST['correo'] : '';
$eess = isset($_POST['eess']) ? $_POST['eess'] : '';
$cargo = isset($_POST['cargo']) ? $_POST['cargo'] : '';
$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
$contraseña = isset($_POST['contraseña']) ? $_POST['contraseña'] : '';

// Realizamos la consulta para insertar
$sql = $con->prepare("CALL pro_Cusu(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$sql->bind_param('sssiisssiiss', $dni, $nombre, $apellidos, $genero, $edad, $telefono, $direccion, $correo, $eess, $cargo, $usuario, $contraseña);

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
