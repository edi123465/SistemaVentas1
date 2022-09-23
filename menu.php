<?php
//esto debe ser implementado en todas las paginas del proyecto
session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location:index.php");
}
?>

<html>
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>




        <script>
            var renderPage = true;

            if (navigator.userAgent.indexOf('MSIE') !== -1
                    || navigator.appVersion.indexOf('Trident/') > 0) {
                /* Microsoft Internet Explorer detected in. */
                alert("Please view this in a modern browser such as Chrome or Microsoft Edge.");
                renderPage = false;
            }
            //
            var salir="login/logout.php"
            function redireccionarInactivo()
            {
            location.href=salir
            }
            setTimeout ("redireccionarInactivo()", 1200000);
        </script>

        <title>Ménu del sistema</title>
    </head>
    <body>
        <div id="header" class="header">
            <nav class="navbar navbar-expand-lg navbar-light text-capitalize">
                <div class="collapse navbar-collapse" id="show-menu">
                    <ul class="navbar-nav ml-auto ">
                        <li class="nav-item">
                            <a class="nav-link" href="#about">Sobre Sistema</a>
                        </li>

                        <li class="nav-item .search-container">
                            <a class="nav-link" href="./login/logout.php" title="**CERRAR SESIÓN**"><img id="cerrar" src="./imag/cerrarB.png"   alt="" width="50" height="50" ></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div    class="about_section layout_padding">
            <p align="center">Bienvenid@ <?= $_SESSION['nombreRol'] ?> - <?= $_SESSION['nombreUser'] . " " . $_SESSION['apellidoUser'] ?>

            <h3 align="center">Menu Principal</h3>

            <div class="container" >
                <div class="row tm-albums-container grid" >
                    <?php if ($_SESSION['idPerfil'] == 1) { ?>
                        <div class="col-sm-6 col-12 col-md-6 col-lg-3 col-xl-3 tm-album-col" >
                            <figure class="effect-sadie" >
                                <img src="./imag/perfilFpng.png" alt="Image" class="img-fluid"  id='uno'> 
                                <figcaption>
                                    <a href="./CrudPerfil/consultarPerfil.php" ><h2>Gestión Perfil</h2></a>
                                    <p>Permite consultar, crear, modificar y eliminar los perfiles</p>
                                </figcaption>

                            </figure>
                        </div>
                        <div class="col-sm-6 col-12 col-md-6 col-lg-3 col-xl-3 tm-album-col">
                            <figure class="effect-sadie">
                                <img src="./imag/personaaas.png" alt="Image" class="img-fluid" id='dos'>
                                <figcaption>
                                    <a href="./CrudPersona/consultarPersona.php"><h2>Gestión Personas</h2></a>
                                    <p>Permite consultar, crear, modificar, y eliminar usuarios</p>
                                </figcaption>
                            </figure>
                        </div>
                        <div class="col-sm-6 col-12 col-md-6 col-lg-3 col-xl-3 tm-album-col">
                            <figure class="effect-sadie">
                                <img src="./imag/vueloo.jpg" alt="Image" class="img-fluid" id='tres'>
                                <figcaption>
                                    <a href="./CrudVuelo/consultarVuelo.php"><h2>Gestión Vuelo</h2></a>
                                    <p>Permite consultar, crear, modificar y eliminar vuelo</p>
                                </figcaption>
                            </figure>
                        </div>
                        <div class="col-sm-6 col-12 col-md-6 col-lg-3 col-xl-3 tm-album-col">
                            <figure class="effect-sadie">
                                <img src="./imag/reservaa.png" alt="Image" class="img-fluid" id='cuatro'>
                                <figcaption>
                                    <a href="./CrudReserva/consultarReserva.php"><h2>Gestión Reserva</h2></a>
                                    <p>Permite consultar, crear, modificar, eliminar y generar reportes de reservas</p>
                                </figcaption>
                            </figure>
                        </div>
                    <?php } else { ?>
                        <?php
                        header("Location: TiendaOnline.php");
                        ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        <br><br>
        <div id="about" class="about_section layout_padding">
            <div class="container" >
                <div class="row">
                    <div class="col-md-5">
                        <h3>SISTEMA RESERVAS</h3>
                        <h3 style="text-transform: none !important">____</h3>
                        <?php if ($_SESSION['idPerfil'] == 1) { ?>
                        <p >El sistema permite llevar el control de reserva de vuelos que realizan los usuarios. 
                            La información se maneja de forma rápida y con el menor grado de
                            error. Existen 4 Secciones que permiten observar, modificar, crear y eliminar la información de perfiles, 
                            usuarios, vuelo y reservas. Además de lograr generar reportes sobre las reservas realizadas
                            <?php } else { ?>
                            <p >El sistema le permite a usted consultar sus datos de usuario,datos de vuelos y reserva de vuelos 
                                realizadas o por realizar. Además se le permite gererar un reporte sobre las reservas con filtro de fechas
                            La información se maneja de forma rápida y con el menor grado de
                            error.
                            <?php } ?>
                    </div>
                    <div class="col-md-6 offset-md-1">
                        <div class="full text_align_center">
                            <img class="img-responsive" src="./imag/reservaa.jpg" alt="#" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    

    </body>

</html>
