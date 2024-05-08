document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(event) {
        // Manejador de botones de edición
        const editButton = event.target.closest('.btn-modifica');
        if (editButton) {
            event.preventDefault();

            const idUsuario = editButton.getAttribute('data-id');
            console.log('ID Usuario:', idUsuario);

            if (idUsuario && idUsuario !== 'undefined') {
                const fetchUrl = `./llenamodif.php?idusuario=${idUsuario}`;
                console.log('URL de la solicitud:', fetchUrl);

                fetch(fetchUrl)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Datos recibidos:', data);
                        if (data && data.usuario) {
                            // Llenar los campos del formulario con los datos del usuario
                            document.getElementById('dni').value = data.usuario.DNI;
                            document.getElementById('nombres').value = data.usuario.NOMBRE;
                            document.getElementById('apellidos').value = data.usuario.APELLIDO;
                            document.getElementById('genero').value = data.usuario.GENERO;
                            document.getElementById('edad').value = data.usuario.EDAD;
                            document.getElementById('telefono').value = data.usuario.TELEFONO;
                            document.getElementById('direccion').value = data.usuario.DIRECCION;
                            document.getElementById('correo').value = data.usuario.CORREO;
                            document.getElementById('eess').value = data.usuario.EESS;
                            document.getElementById('cargo').value = data.usuario.CARGO;
                            document.getElementById('usuario').value = data.usuario.USUARIO;
                            document.getElementById('contraseña').value = data.usuario.CONTRASEÑA;

                            // Cambia el texto del botón de envío a "Modificar"
                            const submitButton = document.querySelector('#registroForm button[type="submit"]');
                            submitButton.textContent = 'Modificar';

                            // Actualiza la acción del formulario para modificar
                            document.getElementById('registroForm').action = `./updateusu.php?idusuario=${idUsuario}`;

                            // Muestra el modal
                            const registroModal = new bootstrap.Modal(document.getElementById('registroModal'));
                            registroModal.show();
                        } else {
                            console.error('No se encontraron datos para el usuario con ID:', idUsuario);
                        }
                    })
                    .catch(error => {
                        console.error('Hubo un error al obtener los datos del usuario:', error);
                    });
            } else {
                console.error('ID del usuario no es válido o es "undefined". ID:', idUsuario);
            }
        }
        
        // Manejador de botones de eliminar
        const deleteButton = event.target.closest('.btn-elimina');
        if (deleteButton) {
            event.preventDefault();

            const confirmacion = confirm('¿Estás seguro de que deseas eliminar este usuario?');
            
            if (confirmacion) {
                const idUsuario = deleteButton.getAttribute('data-id');
                console.log('ID Usuario para eliminar:', idUsuario);

                if (idUsuario && idUsuario !== 'undefined') {
                    fetch('./deleteusu.php', {
                        method: 'POST',
                        body: new URLSearchParams({ 'idusuario': idUsuario })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Datos de eliminación:', data);
                        if (data.mensaje === 'El usuario se eliminó correctamente') {
                            alert('Usuario eliminado con éxito');
                            window.location.href = './usuario.php';
                        } else {
                            console.error('Error al eliminar el usuario:', data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error en la solicitud de eliminación:', error);
                    });
                } else {
                    console.error('ID del usuario no es válido o es "undefined". ID:', idUsuario);
                }
            }
        }
    });
});
