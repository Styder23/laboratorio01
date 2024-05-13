// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar elementos del DOM
    const btnAgregar = document.getElementById('agregar');
    const btnGuardar = document.getElementById('guardar');
    const lista = document.getElementById('lista');
    const dniInput = document.getElementById('dni');
    const pacienteInput = document.getElementById('paciente');
    const idPacienteInput = document.getElementById('idpaciente');
    const fechaInput = document.getElementById('fecha');
    const areaSelect = document.getElementById('area');
    const examenSelect = document.getElementById('examen');
    const muestraSelect = document.getElementById('muestra');

    // Agregar eventos
    btnAgregar.addEventListener('click', agregar);
    btnGuardar.addEventListener('click', guardar);

    // Función para agregar una fila a la tabla
    function agregar() {
        // Código para agregar una fila a la tabla
    }

// Función para guardar los datos en el servidor
function guardar() {
    // Crear un array para almacenar los datos de las filas
    const datos = [];

    // Obtener todas las filas de la tabla
    const filas = lista.querySelectorAll('tr');

    // Iterar sobre cada fila
    filas.forEach(fila => {
        // Obtener las celdas de la fila
        const celdas = fila.querySelectorAll('td');

        // Verificar si hay suficientes celdas en la fila
        if (celdas.length >= 7) { // Ajusta este número según la cantidad de celdas que esperas
            // Obtener los valores de cada celda
            const idPaciente = celdas[0].innerText; // Suponiendo que el ID del paciente está en la primera celda
            const idExamen = celdas[3].innerText;   // Suponiendo que el ID del examen está en la cuarta celda
            const idMuestra = celdas[5].innerText;  // Suponiendo que el ID de la muestra está en la sexta celda

            // Agregar los datos al array
            datos.push({
                idPaciente: idPaciente,
                idExamen: idExamen,
                idMuestra: idMuestra
            });
        } else {
            console.error('La fila no tiene suficientes celdas');
        }
    });

    // Realizar una solicitud AJAX para enviar los datos a guarda.php
    $.ajax({
        url: 'api.php', // Ajusta la URL según tu estructura de archivos
        method: 'POST',
        data: { datos: datos }, // Enviar el array de datos como JSON
        dataType: 'json',
        success: function(response) {
            // Manejar la respuesta del servidor
            console.log(response);
            // Aquí puedes mostrar un mensaje de éxito o redirigir a otra página
        },
        error: function(xhr, status, error) {
            // Manejar errores de la solicitud AJAX
            console.error(xhr.responseText);
        }
    });
}

});
