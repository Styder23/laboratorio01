<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Estilos personalizados -->
    <style>
        /* Estilos clínicos */
        body {
            background-color: #f4f6f9; /* Color de fondo suave */
        }
        .container {
            max-width: 400px;
            margin-top: 50px;
            padding: 20px;
            background-color: white; /* Fondo blanco para el formulario */
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15); /* Sombra para destacar el formulario */
        }
        h1 {
            color: #4a4a4a; /* Tono oscuro para el encabezado */
        }
        label {
            color: #4a4a4a; /* Tono oscuro para las etiquetas */
        }
        input[type="text"], input[type="password"] {
            margin-bottom: 10px;
        }
        .btn-primary {
            background-color: #0056b3; /* Color azul oscuro para el botón */
            border-color: #0056b3; 
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center mb-4">Iniciar sesión</h1>
        
        <form id="loginForm" action="./validar.php" method="POST">
            <!-- Nombre de usuario -->
            <div class="form-group">
                <label for="username">Nombre de usuario:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            
            <!-- Contraseña -->
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <input type="checkbox" id="showPassword" title="Mostrar/Ocultar contraseña">
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Botón de inicio de sesión -->
            <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
        </form>
    </div>

    <!-- Enlace a jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Enlace a Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Script para mostrar/ocultar la contraseña -->
    <script>
        $(document).ready(function() {
            $('#showPassword').on('change', function() {
                var passwordInput = $('#password');
                if ($(this).is(':checked')) {
                    passwordInput.attr('type', 'text');
                } else {
                    passwordInput.attr('type', 'password');
                }
            });
        });
    </script>
</body>

</html>
