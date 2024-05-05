<?php
// Recibe los datos enviados por el formulario de inicio de sesión
$Usuario = $_POST['username'];
$Password = $_POST['password'];

// Inicia la sesión
session_start();
$_SESSION['username'] = $Usuario;

// Incluye el archivo de conexión
include_once "../conexion/conexion.php";
$conexionBD = BD::crearInstancia();

// Utiliza una consulta preparada para evitar inyecciones SQL
$stmt = $conexionBD->prepare("SELECT idusuarios, usuario, contraseña, fk_cargos, nombre AS Establecimiento,concat_ws(' ',nombres, apellidos) as Usuario, r.nom_red AS RED
FROM usuarios u inner join establecimiento e on e.idestablecimiento=u.fk_idestablecimiento
inner join redes r on r.idredes=e.fk_redes
inner join personas p on p.idpersonas=u.fk_personas WHERE usuario = ? AND contraseña = ?");
$stmt->bind_param('ss', $Usuario, $Password);
$stmt->execute();

// Recupera el resultado de la consulta
$result = $stmt->get_result();
$filas = $result->fetch_assoc();

// Verifica el rol del usuario
if ($filas) {
    // Establece la sesión para el usuario
    $_SESSION['fk_cargos'] = $filas['fk_cargos'];
    $_SESSION['Usuario'] = $filas['Usuario'];
    $_SESSION['Establecimiento'] = $filas['Establecimiento'];
    $_SESSION['RED'] = $filas['RED'];
    $_SESSION['idusuarios'] = $filas['idusuarios'];

    // Redirige al usuario a la página correspondiente según su rol
    if ($filas['fk_cargos'] == 1) { // Administrador
        header("Location: ../index.php");
    } elseif ($filas['fk_cargos'] == 2) { // Empleado
        header("Location: ../panel-defunciones/index.php");
        }
} else {
    // Si las credenciales no son válidas, muestra un mensaje de error
    include("../login/login.php");
    echo "<p><h1>Error de autenticación</h1></p>";
}

// Libera el resultado de la consulta y cierra la conexión
$result->free();
$conexionBD->close();
?>
