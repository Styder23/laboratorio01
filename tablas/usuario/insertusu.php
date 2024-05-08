<?php 
include_once "../../conexion/conexion.php";
$conexionBD = BD::crearInstancia();

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

try {
    // Prepara la consulta para llamar al procedimiento almacenado
    $query = $conexionBD->prepare("CALL pro_Cusu(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($query === false) {
        // Mostrar el error de la preparación de la consulta
        throw new Exception('Error al preparar la consulta: ' . $conexionBD->errorInfo()[2]);
    }

    // Vincula los parámetros a la consulta
    if (!$query->execute([$dni, $nombre, $apellidos, $genero, $edad, $telefono, $direccion, $correo, $eess, $cargo, $usuario, $contraseña])) {
        // Manejador de errores de ejecución
        throw new Exception('Error al ejecutar la consulta: ' . $query->errorInfo()[2]);
    }

    // Inserción exitosa, redirige
    echo '<script>window.location.href = "../usuario/usuario.php";</script>';
} catch (Exception $e) {
    // Manejo de excepciones
    echo "Error: " . $e->getMessage();
} finally {
    // Cerrar la consulta y la conexión a la base de datos
    if (isset($query)) {
        $query->close();
    }
    if (isset($conexionBD)) {
        $conexionBD = null;
    }
}
?>

