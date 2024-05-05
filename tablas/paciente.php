<?php
// Seguridad de sesiones
session_start();

// Importa la clase de conexión
require_once("../conexion/conexion.php");

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
    <!-- Incluye el CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Incluye jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha384-Xje5RFsABfDT3u1LLFttHHLRM+5SBzZlAkkDbl/fI/tp74VREqP5a0J9a8YekYUN" crossorigin="anonymous">
    </script>
    <!-- Incluye select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
</head>

<body>
    <div class="container my-4">
        <h2 class="text-center mb-4">Registro de Pacientes</h2>
        <?php
            include "./modpac.php";
        ?>
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
                    <th>GENERO</th>
                    <th>CORREO</th>
                    <th>RUC</th>
                    <th>ESTADO</th>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario dentro del modal -->
                    <form id="registroForm" action="./crudpaciente.php" method="POST">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="inputDNI">DNI</label>
                                <input type="text" class="form-control" id="dni" name="dni" onkeyup="buscar()" required>
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
                            <div class="form-group col-md-6">
                                <label for="estado">Estado</label>
                                <input type="text" class="form-control" id="estado" name="estado" required>
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

    <!-- Bootstrap JS and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
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
                        html += '<tr>';
                        html += '<td>' + row.id + '</td>';
                        html += '<td>' + row.DNI + '</td>';
                        html += '<td>' + row.PACIENTE + '</td>';
                        html += '<td>' + row.EDAD + '</td>';
                        html += '<td>' + row.GENERO + '</td>';
                        html += '<td>' + row.CORREO + '</td>';
                        html += '<td>' + row.ruc + '</td>';
                        html += '<td>' + row.estado + '</td>';
                        // Añade data-id con el ID del paciente
                        html += '<td class="text-center"><a href="#" data-id="' + row.id +
                            '" data-bs-toggle="modal" data-bs-target="#registroModal"><img src="../imagenes/boligrafo.png" alt="Editar"></a></td>';
                        html +=
                            '<td class="text-center"><a href="#"><img src="../imagenes/borrar.png" alt="Eliminar"></a></td>';
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

    // Agregar evento de clic para editar paciente
    document.addEventListener('click', function(event) {
        const target = event.target;
        // Verifica si el elemento que se hizo clic es el icono de editar
        if (target.tagName === 'IMG' && target.parentElement.getAttribute('data-bs-target') === '#registroModal') {
            // Captura el ID del paciente desde el atributo data-id
            const idPaciente = target.parentElement.getAttribute('data-id');
            // Realiza la acción de cargar datos del paciente en el modal
            cargarDatosPacienteEnModal(idPaciente);
        }
    });

    // Función para cargar datos del paciente en el modal
    function cargarDatosPacienteEnModal(id) {
        // Realiza una solicitud AJAX para obtener los datos del paciente
        fetch(`./modpac.php.php?accion=seleccionar&id=${id}`) // Ajusta la URL según tu servidor
            .then(response => response.json())
            .then(data => {
                // Llena el formulario del modal con los datos del paciente
                document.getElementById('dni').value = data.dni;
                document.getElementById('nombres').value = data.nombres;
                document.getElementById('apellidos').value = data.apellidos;
                document.getElementById('edad').value = data.edad;
                document.getElementById('direccion').value = data.direccion;
                document.getElementById('genero').value = data.genero;
                document.getElementById('correo').value = data.correo;
                document.getElementById('ruc').value = data.ruc;
                document.getElementById('estado').value = data.estado;
            })
            .catch(err => {
                console.error('Error al cargar los datos del paciente:', err);
            });
    }
    </script>
    <script>
        
    </script>
</body>

</html>