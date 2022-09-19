<?php
include "../recursos/Conexion.php";
include "../recursos/FuncionesVuelo.php";

session_start();

$ses = (!empty($_GET['id'])) ? $_GET['id'] : 0;

if (isset($_SESSION['idUsuario']) and $ses != null) {
    header("Location:../index.php");
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link href="../estilos/bootstrap.css" rel="stylesheet" type="text/css"/>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        <script>
             function soloNumeros(e) {
                key = e.keyCode || e.which;
                tec = String.fromCharCode(key);
                numero = "0123456789.";
                especial = ",.";
                teclado_especial = false;

                for (var i in especial) {
                    if (key == especial[i]) {
                        teclado_especial = true;
                    }

                }
                if (numero.indexOf(tec) == -1 && !teclado_especial) {
                    return false;

                }
            }
            //
        </script>
        <title>Creación de cuenta</title>        
    </head>
    <body>
        <ul class="nav nav-tabs nav justify-content-end "navbar navbar-light" style="background-color: rgb(234,219,228);"">
            <li class="nav-item">
                <a class="nav-link"  href="../menu.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  href="../CrudPerfil/consultarPerfil.php">Consultar Perfil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../CrudPersona/consultarPersona.php">Consultar Persona</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../CrudVuelo/consultarVuelo.php">Consultar Vuelo</a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Consultar Reserva </a>
                <ul class="dropdown-menu">
                    <li><a href="../CrudReserva/filtrar.php">Por filtro</a></li>
                    <li class="divider"></li>
                    <li><a href="../CrudReserva/consultarReserva.php">Todas</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../login/logout.php" title="**CERRAR SESIÓN**"><img  src="../imag/cerrar.png"   alt="" width="30" height="20" ></a>
            </li>
        </ul>
        <br><br>
        <?php
        if ($ses == 1) {
            ?>
            <h4>Bienvenid@ <?= $_SESSION['nombreUser'] . " " . $_SESSION['apellidoUser'] ?> Perfil -<?= $_SESSION['nombreRol'] ?> </h4>
            <?php
        }
        ?>

        <form method="POST">
            <h3 align="center">Ingreso Datos vuelo</h3> 
            <br>
            <table align="center" class="table">
                <thead class="table-dark">

                </thead>
                <tbody>
                <div class="form-row">
                    <div class="col-md-4">
                        <label for="validationDefault01">Aerolinea</label><br>
                        <select name="aerolinea" required class="form-select">
                            <option  value="" >--Escoja una Aerolinea--</option>
                            <option  value="TAME" >TAME</option>
                            <option value="LAN">LAN</option>
                            <option value="LATAM">LATAM</option>
                            <option value="Avianca">Avianca</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="validationDefault02">Categoria</label><br>
                        <input type="radio" name="categoria" value="economica" checked/>Económica
                        <input type="radio" name="categoria" value="media" />Media
                        <input type="radio" name="categoria" value="primera" />Primera
                    </div>
                    <div class="col-md-4">
                        <label for="validationDefaultUsername">Asientos</label>
                        <input type="text" class="form-control" name="asientos"  required onkeypress="return soloNumeros(event)" onpaste="return false">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4">
                        <label for="validationDefault03">Horario</label><br>
                        <select name="horario" class="form-select" required>
                            <option value="">--Escoja el horario--</option>
                            <option value="05:00">05:00</option>
                            <option value="10:00">10:00</option>
                            <option value="12:00">12:00</option>
                            <option value="17:00">17:00</option>
                            <option value="20:00">20:00</option>

                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="validationDefault04">Días</label>
                        <input type="text" name="dias" class="form-control" placeholder="Número de días" required onkeypress="return soloNumeros(event)" onpaste="return false">
                    </div>
                    <div class="col-md-4">
                        <label for="validationDefault05">Precios</label>
                        <input type="text" name="precios" class="form-control"  onkeypress="return soloNumeros(event)" onpaste="return false">
                    </div>
                </div>
                </tbody>
            </table>

            <div align="center" >
                <br><br>
                &nbsp;<a href="consultarVuelo.php" ><input type="button" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" value="Regresar"></a>
                &nbsp;<button  name="crear" type="submit" class="btn btn-outline-info" style="background-color: rgb(234,219,228);">Guardar</button>
                &nbsp;<button class="btn btn-dark" href='consultarVuelo.php' type="reset"  style="background-color: rgb(234,219,228);">Limpiar</button>
            </div>
        </form>




    </body>
</html>
<?php
if (isset($_REQUEST['crear'])) {
    $aerolinea = $_REQUEST['aerolinea'];
    $categoria = $_REQUEST['categoria'];
    $can = $_REQUEST['asientos'];
    $horarios = $_REQUEST['horario'];
    $dias = $_REQUEST['dias'];
    $precio = $_REQUEST['precios'];
    $impuesto = null;

    switch ($categoria) {
        case "economica":
            $impuesto = $precio * 0.05;
            break;
        case "media":
            $impuesto = $precio * 0.10;
            break;
        case "primera":
            $impuesto = $precio * 0.15;
            break;
    }

    if (insertarVuelo($con, $aerolinea, $categoria, $can, $horarios, $dias, $precio, $impuesto)) {
        if ($ses == 1) {
            header("Location:consultarVuelo.php");
        } else {
            echo "<script> alert('Vuelo ingresado correctamente'); "
            . "window.location.href='consultarVuelo.php';</script>";
        }
    } else {
        echo "<script> alert('Vuelo no se pudo ingresar'); "
            . "window.location.href='consultarVuelo.php';</script>";
    }
}
?>