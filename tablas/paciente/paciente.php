<?php
// Seguridad de sesiones
session_start();

// Importa la clase de conexión
require_once("../../conexion/conexion.php");

try {
    $conexionBD = BD::crearInstancia();
    
    // Realiza una consulta a la tabla `genero` para obtener las opciones disponibles
    $query = $conexionBD->query("SELECT idgenero, nom_gen FROM genero");
    $generos = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Pacientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div class="container my-4">
        <h2 class="text-center mb-4">Registro de Pacientes</h2>

        <!-- Mostrar registros y búsqueda -->
        <div class="row align-items-center mb-4">
            <!-- Sección de mostrar registros -->
            <div class="col-md-6 d-flex align-items-center">
                <label for="n_registro" class="col-form-label me-2">Mostrar:</label>
                <select name="n_registro" id="n_registro" class="form-select form-select-sm me-2">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <label for="n_registro" class="me-3">Registros</label>
            </div>

            <!-- Sección de búsqueda y botón de nuevo registro -->
            <div class="col-md-6 d-flex justify-content-end align-items-center">
                <input type="text" class="form-control me-2 w-50" name="campo" id="campo" placeholder="Buscar...">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registroModal">
                    Nuevo Registro
                </button>
            </div>
        </div>

        <!-- Tabla de resultados -->
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DNI</th>
                    <th>PACIENTE</th>
                    <th>EDAD</th>
                    <th>DIRECCIÓN</th>
                    <th>GENERO</th>
                    <th>CORREO</th>
                    <th>RUC</th>
                    <th>EDITAR</th>
                    <th>ELIMINAR</th>
                </tr>
            </thead>
            <tbody id="content">
                <!-- Los datos se insertarán aquí -->
            </tbody>
        </table>

        <!-- Controles de paginación -->
        <nav aria-label="Controles de paginación">
            <ul class="pagination justify-content-center" id="pagination">
                <!-- Los controles de paginación se insertarán aquí -->
            </ul>
        </nav>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registroModalLabel">Nuevo Registro</h5>

                </div>
                <div class="modal-body">
                    <!-- Formulario dentro del modal -->
                    <form id="registroForm" action="./crudpaciente.php" method="POST">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="inputDNI">DNI</label>
                                <input type="text" class="form-control" id="dni" name="dni" onkeyup="buscar()" required>
                                <input type="hidden" name="id" value="<?php $id ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputNombres">Nombres:</label>
                                <input type="text" class="form-control" id="nombres" name="nombres" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputNombres">Apellidos:</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edad">Edad</label>
                                <input type="number" class="form-control" id="edad" name="edad" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="direccion">direccion</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="genero">Género</label>
                                <select class="form-control" id="genero" name="genero" required>
                                    <option value="">Seleccionar Género</option>
                                    <?php
                                    // Recorre los resultados de la consulta y rellena las opciones del combo de género
                                    foreach ($generos as $genero) {
                                        echo '<option value="' . $genero['idgenero'] . '">' . $genero['nom_gen'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- Reorganización de los combos -->
                        <div class="row">


                            <div class="form-group col-md-6">
                                <label for="correo">Correo (OPCIONAL)</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ruc">RUC (Opcional)</label>
                                <input type="text" class="form-control" id="ruc" name="ruc" required>
                            </div>
                        </div><br>

                        <div class="form-row">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary" name="registro">Registrar</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal editar-->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registroModalLabel">Editar Registro</h5>

                </div>
                <div class="modal-body">
                    <!-- Formulario dentro del modal -->
                    <form id="editForm" action="modpc.php" method="POST">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="inputDNI">DNI</label>
                                <input type="text" class="form-control" id="_dni" name="_dni" onkeyup="buscar()"
                                    required>
                                <input type="hidden" name="id" id="id">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputNombres">Nombres:</label>
                                <input type="text" class="form-control" id="_nombres" name="_nombres" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputNombres">Apellidos:</label>
                                <input type="text" class="form-control" id="_apellidos" name="_apellidos" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edad">Edad</label>
                                <input type="number" class="form-control" id="_edad" name="_edad" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="direccion">direccion</label>
                                <input type="text" class="form-control" id="_direccion" name="_direccion" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="genero">Género</label>
                                <select class="form-control" id="_genero" name="_genero" required>
                                    <option value="">Seleccionar Género</option>
                                    <?php
                                    // Recorre los resultados de la consulta y rellena las opciones del combo de género
                                    foreach ($generos as $genero) {
                                        echo '<option value="' . $genero['idgenero'] . '">' . $genero['nom_gen'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- Reorganización de los combos -->
                        <div class="row">


                            <div class="form-group col-md-6">
                                <label for="correo">Correo (OPCIONAL)</label>
                                <input type="email" class="form-control" id="_correo" name="_correo" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ruc">RUC (Opcional)</label>
                                <input type="text" class="form-control" id="_ruc" name="_ruc" required>
                            </div>
                        </div><br>

                        <div class="form-row">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary" name="edit">Modificar</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="captura.js"></script>

    <!-- Script para manejar la búsqueda -->
    <script>
    // Inicializa la búsqueda y escucha los eventos
    let paginaActual = 1;
    const n_registro = document.getElementById("n_registro");
    const campo = document.getElementById("campo");
    const content = document.getElementById("content");
    const pagination = document.getElementById("pagination");

    // Función para obtener datos de la tabla
    function getData(pagina) {
        const formData = new FormData();
        formData.append("campo", campo.value);
        formData.append("n_registro", n_registro.value);
        formData.append("pagina", pagina);

        // Realiza la solicitud POST
        fetch("./Vpaciente.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Crea la tabla a partir de los datos recibidos
                let html = '';
                if (data.resultados.length > 0 && data.resultados[0].mensaje) {
                    // Si hay un mensaje especial
                    html = '<tr><td colspan="10">' + data.resultados[0].mensaje + '</td></tr>';
                } else {
                    // Si hay datos, genera filas de tabla
                    data.resultados.forEach(row => {
                        // Inicia una nueva fila para cada resultado
                        html += '<tr>';
                        html += '<td>' + row.id + '</td>';
                        html += '<td>' + row.DNI + '</td>';
                        html += '<td>' + row.PACIENTE + '</td>';
                        html += '<td>' + row.EDAD + '</td>';
                        html += '<td>' + row.DIRECCIÓN + '</td>';
                        html += '<td>' + row.GENERO + '</td>';
                        html += '<td>' + row.CORREO + '</td>';
                        html += '<td>' + row.ruc + '</td>';

                        // Genera una celda con un enlace para editar, incluyendo el ID del paciente
                        html += '<td class="text-center">';
                        html +=
                            '<a href="#" data-bs-toggle="modal" data-bs-target="#editModal" data-id="' +
                            row.id +
                            '" class="btn-modifica">';
                        html += '<img src="../../imagenes/boligrafo.png" alt="Editar"></a>';
                        html += '</td>';

                        // Genera una celda con un enlace para eliminar
                        html += '<td class="text-center">';
                        html += '<a href="#" class="btn-elimina" data-id="' + row.id + '">';
                        html += '<img src="../../imagenes/borrar.png" alt="Eliminar"></a>';
                        html += '</td>';

                        // Cierra la fila
                        html += '</tr>';
                    });
                }
                // Asigna el HTML generado al contenido
                content.innerHTML = html;

                // Actualiza los controles de paginación
                updatePagination(data.total_paginas, data.pagina_actual);
            })
            .catch(err => {
                console.error(err);
                content.innerHTML = 'Hubo un error al obtener los datos.';
            });
    }

    // Función para actualizar los controles de paginación
    function updatePagination(totalPaginas, paginaActual) {
        let paginationHTML = '';

        // Crear los controles de paginación
        for (let i = 1; i <= totalPaginas; i++) {
            paginationHTML += `<li class="page-item ${i === paginaActual ? 'active' : ''}">
                    <a class="page-link" href="javascript:void(0);" onclick="changePage(${i})">${i}</a>
                </li>`;
        }

        // Asignar los controles de paginación al elemento
        pagination.innerHTML = paginationHTML;
    }

    // Función para cambiar de página
    function changePage(page) {
        paginaActual = page;
        getData(paginaActual);
    }

    // Inicializa la función de obtener datos
    getData(paginaActual);

    // Escucha eventos en los campos de entrada
    campo.addEventListener("input", () => getData(paginaActual));
    n_registro.addEventListener("change", () => getData(paginaActual));
    </script>

    <script>
        document.getElementById('registroForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita el envío del formulario por defecto

            // Obtiene los datos del formulario
            const formData = new FormData(this);

            // Realiza la solicitud POST para agregar un nuevo paciente
            fetch('./crudpaciente.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Si se agrega correctamente, muestra una alerta de éxito
                        alert('¡Paciente agregado exitosamente!');
                        // Actualiza la tabla de pacientes
                        getData(paginaActual);
                        // Cierra el modal de registro
                        $('#registroModal').modal('hide');
                    } else {
                        // Si hay un error, muestra una alerta con el mensaje de error
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    // Si hay un error en la solicitud, muestra una alerta
                    alert('Error en la solicitud: ' + error);
                });
        });
    </script>

</body>

</html>