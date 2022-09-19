<?php
ob_start();
include "../recursos/Conexion.php";
include "../recursos/FuncionesReserva.php";
include "../recursos/FuncionesPersona.php";
include "../recursos/FuncionesVuelo.php";

session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location:../index.php");
}

$id_reserva = $_GET['idR']; //envio desde consultar 
$resultado = consultarReserva($con, $id_reserva);

if ($fila = mysqli_fetch_assoc($resultado)) {
    $idvuelo = null;
    $cmbVuelo = consultarVuelo($con, $idvuelo);
    $cedula = null;
    $cmbPersona = consultarPersona($con, $cedula);
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
                
            </script>
            <title>Actualizar Reserva</title>             
        </head>
        <body> 
            <?php if ($_SESSION['idPerfil'] == 1) { ?>
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
                            <li><a href="filtrar.php">Por filtro</a></li>
                            <li class="divider"></li>
                            <li><a href="../CrudReserva/consultarReserva.php">Todas</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../login/logout.php" title="**CERRAR SESIÓN**"><img  src="../imag/cerrar.png"   alt="" width="30" height="20" ></a>
                    </li>
                </ul>
                <br><br>
            <?php } else { ?>
                <ul class="nav nav-tabs nav justify-content-end "navbar navbar-light" style="background-color: rgb(234,219,228);"">
                    <li class="nav-item">
                        <a class="nav-link"  href="../menu.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="../CrudPersona/consultarPersona.php">Consultar Datos</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Consultar Reserva </a>
                        <ul class="dropdown-menu">
                            <li><a href="filtrar.php">Por filtro</a></li>
                            <li class="divider"></li>
                            <li><a href="../CrudReserva/consultarReserva.php">Todas</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../login/logout.php" title="**CERRAR SESIÓN**"><img  src="../imag/cerrar.png"   alt="" width="30" height="20" ></a>
                    </li>
                </ul>
                <br><br>
            <?php } ?>
            <form align="center" action="" method="POST">
                <div class="container">
                    <h3 align="center">Actualizar Reserva</h3> <br>
                    <table align="center" class="table">
                        <thead class="table-dark">

                        </thead>
                        <tbody>
                        <div class="form-row">
                            <input type="hidden" class="form-control" name="id" value="<?php echo $fila['id_reserva'] ?>" readonly>

                            <div class="col-md-4 mb-4">
                                <label for="validationDefault01">Vuelo</label><br>
                                <input type="text" class="form-control" name="aerolinea" value="<?= $fila['aerolinea'] . " - " . $fila['categoria'] . " - $" . $fila['precio'] ?>" readonly>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="validationDefault01">Persona</label><br>
                                <select name="persona" required class="form-select">
                                    <option  value="<?php echo $fila['cedula'] ?>" ><?= $fila['nombres'] . " " . $fila['apellidos'] ?></option>
                                    <?php while ($filaP = mysqli_fetch_assoc($cmbPersona)) { ?>
                                        <option  <?php
                                        echo "value='" . $filaP['cedula'] . "'";
                                        ?>  >
                                                <?= $filaP['nombres'] . " " . $filaP['apellidos'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="validationDefaultUsername">Asientos</label>
                                <input type="text" class="form-control" name="asientos" value="<?php echo $fila['can_asientos'] ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationDefaultUsername">Fecha Reserva</label>
                                <input type="date" class="form-control" name="fechaReserva" value="<?php echo $fila['fecha_reserva'] ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationDefaultUsername">Fecha Vuelo</label>
                                <input type="date" class="form-control" min="<?php echo $fila['fecha_reserva'] ?>" value="<?php echo $fila['fecha_vuelo'] ?>" name="fechaVuelo" required>
                            </div>
                        </div>
                        </tbody>
                    </table>

                    <div align="center" >
                        <a href="consultarReserva.php" ><input type="button" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" value="Regresar"></a>
                        <button  name="actualizar" onclick="return confirm('Seguro de actualizar el registro?')" type="submit" class="btn btn-outline-info" style="background-color: rgb(234,219,228);">Actualizar</button>
                    </div>

                <?php } ?>
            </div>
        </form>    
    </body>
</html>
<?php
if (isset($_POST['actualizar'])) {

    $id_reserva = $_REQUEST['id'];
    $persona = $_REQUEST['persona'];
    $can = $_REQUEST['asientos'];
    $fecha_vuelo = $_REQUEST['fechaVuelo'];
    $vuelo = $fila['idvuelo'];

    $cmbVueloCon = consultarVuelo($con, $vuelo);
    $filaI = mysqli_fetch_assoc($cmbVueloCon);
    $asientosV = $filaI['can_disponible'];
    $impuestos = $filaI['impuesto'];
    $precio = $filaI['precio'];

    if ($can > $asientosV) {
        echo "<script> alert('Cantidad de Asientos no disponible, Asientos disponibles: $asientosV'); "
        . "window.location.href='consultarReserva.php';</script>";
    } else {
        $precio_reserva = (($precio * $can) + $impuestos);
        $cantidadAsientos = $asientosV - $can;

        if (actualizarReserva($con, $persona, $can, $precio_reserva, $fecha_vuelo, $id_reserva)) {
            header("Location:consultarReserva.php");
            ob_end_flush();
        } else {
            echo "<script> alert('No se pudo actualizar el registro'); "
            . "window.location.href='editarReserva.php';</script>";
        }
    }
}
?>