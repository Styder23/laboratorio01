<?php
include('../examen/conexion.php');

// Define las columnas disponibles
$columns = [
    'idusuarios', 
    'DNI', 
    'PERSONA', 
    'GENERO', 
    'EDAD',
    'TELEFONO', 
    'DIRECCION', 
    'CORREO',
    'CARGO',
    'USUARIO',
];

// Consulta base
$sql = "SELECT * FROM v_usuario";

// Manejo de búsqueda
if (isset($_POST['search']['value'])) {
    $search_value = mysqli_real_escape_string($con, $_POST['search']['value']);
    $sql .= " WHERE DNI LIKE '%" . $search_value . "%' OR PERSONA LIKE '%" . $search_value . "%' OR CARGO LIKE '%" . $search_value . "%' OR USUARIO LIKE '%" . $search_value . "%'";
}

// Manejo de orden
if (isset($_POST['order'])) {
    $column_index = intval($_POST['order'][0]['column']);
    $column_order = mysqli_real_escape_string($con, $_POST['order'][0]['dir']);
    $sql .= " ORDER BY " . $columns[$column_index] . " " . $column_order;
} else {
    $sql .= " ORDER BY idusuarios DESC";
}

// Manejo de paginación
if (isset($_POST['length']) && $_POST['length'] != -1) {
    $start = intval($_POST['start']);
    $length = intval($_POST['length']);
    $sql .= " LIMIT " . $start . ", " . $length;
}

// Ejecuta la consulta
$result = mysqli_query($con, $sql);
if (!$result) {
    echo json_encode(['error' => 'Error en la consulta: ' . mysqli_error($con)]);
    exit;
}

// Construye el array de datos
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        $row['idusuarios'],
        $row['DNI'],
        $row['PERSONA'],
        $row['GENERO'],
        $row['EDAD'],
        $row['TELEFONO'],
        $row['DIRECCION'],
        $row['CORREO'],
        $row['CARGO'],
        $row['USUARIO'],
        '<button class="btn btn-info btn-sm editbtn" data-idusuarios="' . $row['idusuarios'] . '">Editar</button> ' .
        '<button class="btn btn-danger btn-sm deleteBtn" data-idusuarios="' . $row['idusuarios'] . '">Eliminar</button>'
    ];
}

// Prepara la respuesta
$output = [
    'draw' => intval($_POST['draw']),
    'recordsTotal' => mysqli_num_rows(mysqli_query($con, "SELECT * FROM v_usuario")),
    'recordsFiltered' => mysqli_num_rows($result),
    'data' => $data
];

// Imprime la salida JSON para depuración
echo json_encode($output);
?>
