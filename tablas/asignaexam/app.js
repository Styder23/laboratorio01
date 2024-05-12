// Declarar variables utilizando let o const
const btnAgregar = document.getElementById('agregar');
const btnGuardar = document.getElementById('guardar');
const lista = document.getElementById('lista');
const totalElement = document.getElementById('total');

let data = [];
let cant = 1; // Comenzar con ID 1

// Asignar eventos
btnAgregar.addEventListener('click', agregar);
btnGuardar.addEventListener('click', save);

// Crear un mapeo de ID de examen a nombre de examen
let examMap = {};

// Función para agregar una nueva fila
function agregar() {
    const dni = document.getElementById('dni').value;
    const paciente = document.getElementById('paciente').value;
    const exmenId = document.getElementById('exmen').value;
    const Fecha = document.getElementById('fecha').value;
    const muestra = document.getElementById('muestra').value;

    // Verificar si se seleccionó un examen
    if (!exmenId) {
        alert('Por favor, seleccione un examen.');
        return;
    }

    // Recuperar el nombre del examen utilizando el mapeo
    const exmenName = examMap[exmenId];

    // Agregar elemento a la lista de datos
    data.push({
        id: cant,
        dni: dni,
        paciente: paciente,
        exmenId: exmenId,
        exmenName: exmenName,
        Fecha:Fecha,
        muestra:muestra,
    });

    // Crear una nueva fila con valores
    const idRow = `row${cant}`;
    const fila = `
        <tr id="${idRow}">
            <td>${cant}</td> <!-- Mostrar el ID al inicio de la tabla -->
            <td>${dni}</td>
            <td>${paciente}</td>
            <td>${exmenName}</td> <!-- Mostrar el nombre del examen -->
            <td>${Fecha}</td>
            <td>${muestra}</td>
            <td>
                <button class="btn btn-danger" onclick="eliminar(${cant})">Eliminar</button>
                <button class="btn btn-warning" onclick="cantidad(${cant})">Cantidad</button>
            </td>
        </tr>
    `;

    // Agregar la fila a la tabla
    lista.insertAdjacentHTML('beforeend', fila);

    // Incrementar el contador
    cant++;

    // Actualizar el total
    suma();

    console.log(data);
}

// Función para guardar los datos en el servidor
function save() {
    const json = JSON.stringify(data);
    $.ajax({
        type: 'POST',
        url: 'api.php',
        data: { json },
        success: function(resp) {
            console.log(resp);
            location.reload(); // Recargar la página después de guardar
        },
        error: function(error) {
            console.error('Error al guardar los datos:', error);
        }
    });
}

// Scrip para obtener los exámenes de las áreas
$(document).ready(function() {
    // Evento de cambio en el combo box de área
    $('#area').on('change', function() {
        var areaId = $(this).val();
        
        // Realizar una solicitud AJAX para obtener los exámenes del área seleccionada
        $.ajax({
            url: './obt_exam.php', // Corrige la ruta de tu archivo obt_exam.php
            method: 'GET',
            data: { Area_id: areaId },
            dataType: 'json',
            success: function(response) {
                // Vaciar el combo box de exámenes
                $('#exmen').empty();

                // Actualizar el mapeo de ID de examen a nombre de examen
                examMap = {}; // Vaciar el mapeo existente
                response.forEach(function(examen) {
                    examMap[examen.idtipoexamen] = examen.nomexamen;
                    
                    // Agregar las opciones de exámenes al combo box
                    $('#exmen').append(
                        $('<option>', {
                            value: examen.idtipoexamen,
                            text: examen.nomexamen,
                        })
                    );
                });
            },
            error: function() {
                alert('Error al obtener los exámenes.');
            }
        });
    });
});

// Función para actualizar la cantidad y el total
function cantidad(row) {
    const cantidad = parseFloat(prompt('Nueva cantidad'));
    const item = data.find(item => item.id === row);
    if (item) {
        item.cantidad = cantidad;
        item.total = cantidad * item.exmen;

        // Actualizar la fila en la tabla
        const filaId = document.getElementById(`row${row}`);
        if (filaId) {
            const celdas = filaId.getElementsByTagName('td');
            celdas[3].innerHTML = cantidad;
            celdas[5].innerHTML = cantidad;
            celdas[2].innerHTML = item.total;
        }

        // Actualizar el total
        suma();
    }
}

// Función para eliminar una fila
function eliminar(row) {
    // Eliminar la fila del DOM
    const fila = document.getElementById(`row${row}`);
    if (fila) {
        fila.remove();
    }

    // Eliminar el elemento de `data`
    data = data.filter(item => item.id !== row);

    // Actualizar los IDs de las filas restantes en la tabla
    const filas = lista.getElementsByTagName('tr');
    for (let i = row + 1; i < filas.length; i++) {
        const filaId = `row${i}`;
        filas[i].setAttribute('id', filaId);
        filas[i].getElementsByTagName('td')[0].innerText = i; // Actualizar el ID en la primera celda
    }

    // Actualizar el total
    suma();
}
