
<?php
// Incluye la conexión a la base de datos
include('../examen/conexion.php');

// Verifica si se recibió un ID
if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo json_encode(['error' => 'ID no proporcionado']);
    exit;
}

// Obtiene el ID del POST
$id = intval($_POST['id']);

// Consulta para obtener el examen
$sql = "SELECT idusuarios, dni as DNI,nombres AS NOMBRE, apellidos AS APELLIDO, idgenero as GENERO,edad AS EDAD, tel_ref AS TELEFONO, direccion AS DIRECCION,
correo AS CORREO, idestablecimiento AS EESS, idcargos AS CARGO,usuario AS USUARIO, contraseña as CONTRA
FROM
    usuarios u JOIN personas p ON u.fk_personas = p.idpersonas
    INNER JOIN genero g ON g.idgenero=p.fk_idgenero
    INNER JOIN cargos c ON u.fk_cargos = c.idcargos
    INNER JOIN establecimiento e ON e.idestablecimiento=u.fk_idestablecimiento
    INNER JOIN redes r ON r.idredes=e.fk_redes
WHERE idusuarios  = ? LIMIT 1";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

// Si no se encuentra ningún examen
if ($result->num_rows === 0) {
    echo json_encode(['error' => 'No se encontró el Usuario']);
    exit;
}

// Obtiene el resultado como un array asociativo
$row = $result->fetch_assoc();

// Devuelve el resultado como JSON
echo json_encode($row);

// Cierra la conexión
$stmt->close();
?>
