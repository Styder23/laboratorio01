<?php
include('conexion.php');

// Define las columnas disponibles
$columns = [
    'idtipoexamen',
    'nomexamen',
    'fk_idarea',
];

// Consulta base
$sql = "SELECT COUNT(*) AS total FROM tipoexamen;";

// Ejecuta la consulta para obtener el total de registros
$totalRecords = mysqli_query($con, $sql);
$totalRecords = mysqli_fetch_assoc($totalRecords)['total'];

// Consulta para obtener los datos paginados
$sql = "SELECT * FROM tipoexamen";

// Manejo de búsqueda
if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $search_value = mysqli_real_escape_string($con, $search_value);
    $sql .= " WHERE nomexamen LIKE '%" . $search_value . "%' OR fk_idarea LIKE '%" . $search_value . "%'";
}

// Manejo de orden
if (isset($_POST['order'])) {
    $column_index = intval($_POST['order'][0]['column']);
    $column_order = mysqli_real_escape_string($con, $_POST['order'][0]['dir']);
    $sql .= " ORDER BY " . $columns[$column_index] . " " . $column_order;
} else {
    $sql .= " ORDER BY idtipoexamen DESC";
}

// Manejo de paginación
if (isset($_POST['start'], $_POST['length']) && $_POST['length'] != -1) {
    $start = intval($_POST['start']);
    $length = intval($_POST['length']);
    $sql .= " LIMIT " . $start . ", " . $length;
}

// Ejecuta la consulta para obtener los datos paginados
$result = mysqli_query($con, $sql);
if (!$result) {
    echo json_encode(['error' => 'Error en la consulta: ' . mysqli_error($con)]);
    exit;
}

// Construye el array de datos
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        $row['idtipoexamen'],
        $row['nomexamen'],
        $row['fk_idarea'],
        '<button class="btn btn-info btn-sm editbtn" data-idtipoexamen="' . $row['idtipoexamen'] . '">Editar</button> ' .
        '<button class="btn btn-danger btn-sm deleteBtn" data-idtipoexamen="' . $row['idtipoexamen'] . '">Eliminar</button>'
    ];
}

// Prepara la respuesta
$output = [
    'draw' => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
    'recordsTotal' => $totalRecords,
    'recordsFiltered' => mysqli_num_rows($result),
    'data' => $data
];

// Devuelve la respuesta como JSON
echo json_encode($output);
?>
