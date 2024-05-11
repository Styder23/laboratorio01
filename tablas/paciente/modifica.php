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
$sql = "SELECT pa.idpacientes AS id,p.dni AS DNI, p.nombres as NOMBRE, p.apellidos AS APELLIDO,p.edad AS EDAD,p.direccion AS DIRECCIÓN,
g.idgenero AS GENERO,p.correo AS CORREO,pa.ruc AS ruc
FROM pacientes pa
JOIN personas p ON pa.fk_idpersona = p.idpersonas
JOIN genero g ON p.fk_idgenero = g.idgenero
WHERE idpacientes = ? LIMIT 1";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

// Si no se encuentra ningún examen
if ($result->num_rows === 0) {
    echo json_encode(['error' => 'No se encontró el paciente']);
    exit;
}

// Obtiene el resultado como un array asociativo
$row = $result->fetch_assoc();

// Devuelve el resultado como JSON
echo json_encode($row);

// Cierra la conexión
$stmt->close();
?>
