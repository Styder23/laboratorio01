<?php
// Seguridad de sesiones
session_start();
error_reporting(0);

// Obtén la sesión actual
$NomUsu = $_SESSION['Persona'];
$hospita = $_SESSION['nombre'];

// Verifica si la sesión está vacía o no está establecida
if (!isset($_SESSION['idusuarios'])) {
    // Redirige al usuario a la página de inicio de sesión
    header("Location: ./login/login.php");
//    exit(); // Finaliza la ejecución del script
}
// NO dejar poner atras y entrar
//if(!isset($_SESSION['idusuarios'])){
 //   header("Location: ./login/login.php");
//}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>Laboratorio</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <!----css3---->
    <link rel="stylesheet" href="./css/custom.css">
    <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!--google material icon-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
</head>

<body>

    <div class="wrapper">
        <div class="body-overlay"></div>


        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><a href="/panel-defunciones/index.php"><img
                            src="https://www.regionancash.gob.pe/diresa/images/logo_institucion.png"
                            class="img-fluid" /><span>DIRESA ANCASH</span></a></h3>
            </div>
            <!-- usuario y eess  -->
            <ul class="list-unstyled components">
                <li class="active">
                    <a href="#" class="dashboard"><i class="material-icons">account_circle</i><span>Usuario:
                            <?php echo $NomUsu; ?> </span></a>
                </li>
                <li class="active">
                    <a href="#" class="dashboard"><i class="material-icons">local_hospital</i><span>EESS:
                            <?php echo $hospita; ?> </span></a>
                </li>
                <hr>

                <li class="dropdown">
                    <a href="#homeSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="material-icons">add</i><span>Nuevo registro</span></a>
                    <ul class="collapse list-unstyled menu" id="homeSubmenu1">
                        <li>
                            <a href="#" onclick="cargarIframe('tablas/paciente/paciente.php')">registro Pacientes</a>

                        </li>
                        <li>
                            <a href="#" onclick="cargarIframe('tablas/examen/examen.php')">Registro Examenes</a>
                        </li>
                        <li>
                            <a href="#" onclick="cargarIframe('tablas/asignaexam/asigna.php')">Asignar Examenes</a>
                        </li>
                        <li>
                            <a href="#" onclick="cargarIframe('tablas/usuario/usuario.php')">Registro Usuarios</a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="material-icons">analytics</i><span>Reportes BI</span></a>
                    <ul class="collapse list-unstyled menu" id="pageSubmenu2">
                        <li>
                            <a href="#" onclick="cargarIframe('tablas/asignaexam/exam.php')">Page 1</a>
                        </li>
                        <li>
                            <a href="#">Page 2</a>
                        </li>
                        <li>
                            <a href="#">Page 3</a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#pageSubmenu4" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="material-icons">download</i><span>Descargas</span></a>
                    <ul class="collapse list-unstyled menu" id="pageSubmenu4">
                        <li>
                            <a href="#">Page 1</a>
                        </li>
                        <li>
                            <a href="#">Page 2</a>
                        </li>
                        <li>
                            <a href="#">Page 3</a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#pageSubmenu5" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="material-icons">person</i><span>Resultados</span></a>
                    <ul class="collapse list-unstyled menu" id="pageSubmenu5">
                        <li>
                            <a href="#">Page 1</a>
                        </li>
                        <li>
                            <a href="#">Page 2</a>
                        </li>
                        <li>
                            <a href="#">Page 3</a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="./login/cerrar.php">
                        <i class="material-icons">logout</i><span>Salir</span></a>
                </li>
        </nav>




        <!-- Page Content  -->
        <div id="content">

            <div class="top-navbar">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-mone d-none">
                            <span class="material-icons">arrow_back_ios</span>
                        </button>
                        <label for="">REGISTROS Y CONSULTA DE ANÁLISIS MÉDICOS</label>
                        <button class="d-inline-block d-lg-none ml-auto more-button" type="button"
                            data-toggle="collapse" data-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="material-icons">menu_open</span>
                        </button>
                    </div>
                </nav>
            </div>


            <div class="main-content">

                <iframe id="mainContent" style="width: 100%; height: 825px; border: none;">
                </iframe>




            </div>
        </div>
    </div>
    </div>
    </div>








    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="./js/jquery-3.3.1.slim.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/jquery-3.3.1.min.js"></script>


    <script type="text/javascript">
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
            $('#content').toggleClass('active');
        });

        $('.more-button,.body-overlay').on('click', function() {
            $('#sidebar,.body-overlay').toggleClass('show-nav');
        });

    });
    </script>

    <!-- Para mostrar la url del php segun se mueva en otras paginas -->
    <script>
    function cargarIframe(url) {
        // Cambia el 'src' del <iframe> para cargar el contenido de la URL especificada
        const iframe = document.getElementById('mainContent');
        iframe.src = url;

        // Cambia la URL de la página principal para reflejar la ruta del archivo PHP cargado
        //history.pushState(null, '', url);

    }
    </script>

</body>

</html>