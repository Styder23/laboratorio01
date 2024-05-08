<?php
// Inicia la sesión
session_start();

// Incluye la conexión a la base de datos
include_once '../conexion/conexprueba.php';

if ($_POST) {
    // Recibe el nombre de usuario y contraseña del formulario
    $usuario = $_POST['username'];
    $password = $_POST['password'];

    // Consulta SQL para obtener el usuario
    $sql = "SELECT idusuarios, usuario, contraseña,
                   CONCAT_WS(' ', p.nombres, p.apellidos) AS Persona,
                   nom_cargo, nombre, nom_red
            FROM usuarios u
            INNER JOIN personas p ON p.idpersonas = u.fk_personas
            INNER JOIN cargos c ON c.idcargos = u.fk_cargos
            INNER JOIN establecimiento e ON e.idestablecimiento = u.fk_idestablecimiento
            INNER JOIN redes r ON r.idredes = e.fk_redes
            WHERE usuario = ?";

    // Prepara la consulta SQL
    $stmt = $msqly->prepare($sql);
    // Enlaza el parámetro con la consulta
    $stmt->bind_param("s", $usuario);
    // Ejecuta la consulta
    $stmt->execute();
    // Obtiene el resultado
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        // Obtiene los datos del usuario
        $row = $result->fetch_assoc();
        $password_bd = $row['contraseña'];

        // Codifica la contraseña ingresada por el usuario
        $hashed_password = MD5($password);

        // Depuración: Muestra las contraseñas para comparar
        echo "Contraseña almacenada (MD5): " . $password_bd . "<br>";
        echo "Contraseña ingresada (MD5): " . $hashed_password . "<br>";

        // Compara las contraseñas
        if ($hashed_password === $password_bd) {
            // Inicia sesión y redirecciona
            $_SESSION['idusuarios'] = $row['idusuarios'];
            $_SESSION['Persona'] = $row['Persona'];
            $_SESSION['nom_cargo'] = $row['nom_cargo'];
            $_SESSION['nombre'] = $row['nombre'];

            header("Location: ../index.php");
            exit(); // Detiene la ejecución del script
        } else {
            echo "La contraseña no coincide";
        }
    } else {
        echo "No existe usuario";
    }
    // Cierra la consulta preparada
    $stmt->close();
}

// Cierra la conexión a la base de datos
$msqly->close();

?>



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
        
        <form id="loginForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <!-- Nombre de usuario -->
            <div class="form-group">
                <label for="username">Nombre de usuario:</label>
                <input type="text" class="form-control" id="username" name="username" required autocomplete="username">
            </div>
            
            <!-- Contraseña -->
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
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
