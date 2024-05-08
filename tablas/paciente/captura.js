document.addEventListener('DOMContentLoaded', function() {
    // Agregar un evento de clic a los botones de edición y eliminar
    document.addEventListener('click', function(event) {
        // Manejador de botones de edición
        const editButton = event.target.closest('.btn-modifica');
        if (editButton) {
            event.preventDefault();
            
            // Lógica para el botón de edición (ya existente)
            const idPaciente = editButton.getAttribute('data-id');
            
            // Realiza una solicitud para obtener los datos del paciente
            fetch(`./modifica.php?id=${idPaciente}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.paciente) {
                        // Llenar los campos del formulario con los datos del paciente
                        document.getElementById('dni').value = data.paciente.DNI;
                        document.getElementById('nombres').value = data.paciente.NOMBRE;
                        document.getElementById('apellidos').value = data.paciente.APELLIDO;
                        document.getElementById('edad').value = data.paciente.EDAD;
                        document.getElementById('direccion').value = data.paciente.DIRECCIÓN;
                        document.getElementById('genero').value = data.paciente.GENERO_ID;
                        document.getElementById('correo').value = data.paciente.CORREO;
                        document.getElementById('ruc').value = data.paciente.RUC;
                        document.getElementById('estado').value = data.paciente.ESTADO;

                        // Cambia el texto del botón de "Registrar" a "Modificar"
                        const submitButton = document.querySelector('#registroForm button[type="submit"]');
                        submitButton.textContent = 'Modificar';

                        // Actualiza la acción del formulario para modificar
                        document.getElementById('registroForm').action = `./actualizar.php?id=${idPaciente}`;

                        // Muestra el modal
                        const registroModal = new bootstrap.Modal(document.getElementById('registroModal'));
                        registroModal.show();
                    } else {
                        console.error('No se encontraron datos para el paciente con ID:', idPaciente);
                    }
                })
                .catch(error => {
                    console.error('Hubo un error al obtener los datos del paciente:', error);
                });
        }

        // Manejador de botones de eliminar
        const deleteButton = event.target.closest('.btn-elimina');
        if (deleteButton) {
            event.preventDefault();

            // Solicitar confirmación al usuario
            const confirmacion = confirm('¿Estás seguro de que deseas eliminar este paciente?');
            
            // Si el usuario confirma, proceder con la eliminación
            if (confirmacion) {
                // Obtener el ID del paciente asociado con el botón de eliminar
                const idPaciente = deleteButton.getAttribute('data-id');

                // Realiza una solicitud POST para eliminar el paciente
                fetch('./eliminapa.php', {
                    method: 'POST',
                    body: new URLSearchParams({ 'id': idPaciente })
                })
                .then(response => response.json())
                .then(data => {
                    // Verifica si la eliminación fue exitosa
                    if (data.mensaje === 'El paciente se eliminó correctamente') {
                        // Muestra una alerta de éxito
                        alert('Paciente eliminado con éxito');
                        
                        // Redirige a la página de índice original (index.php)
                        window.location.href = './paciente.php';
                    } else {
                        // Muestra un mensaje de error en caso de fallo
                        console.error('Error al eliminar el paciente:', data.error);
                    }
                })
                .catch(error => {
                    console.error('Error en la solicitud de eliminación:', error);
                });
            }
        }
    });
});


   // Escucha el evento de envío del formulario
document.getElementById('registroForm').addEventListener('submit', function(event) {
    // Prevenir el comportamiento predeterminado del formulario
    event.preventDefault();
    
    // Realiza una solicitud POST para modificar el paciente
    const form = event.target;
    fetch(form.action, {
        method: 'POST',
        body: new FormData(form)
    })
    .then(response => response.json())
    .then(data => {
        // Verifica si la modificación fue exitosa
        if (data.mensaje === 'El paciente se actualizó correctamente') {
            // Muestra una alerta de éxito
            alert('Paciente modificado con éxito');
            
            // Redirige a la página de índice original (index.php)
            window.location.href = 'index.php';
        } else {
            // Muestra un mensaje de error en caso de fallo
            console.error('Error al modificar el paciente:', data.error);
        }
    })
    .catch(error => {
        console.error('Error en la solicitud de modificación:', error);
    });
});
