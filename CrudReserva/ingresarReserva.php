<?php
include "../recursos/Conexion.php";
include "../recursos/FuncionesReserva.php";
include "../recursos/FuncionesPersona.php";
include "../recursos/FuncionesVuelo.php";

session_start();

$ses = (!empty($_GET['id'])) ? $_GET['id'] : 0;

if (isset($_SESSION['idUsuario']) and $ses != null) {
    header("Location:../index.php");
}

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
        
        <title>Creación de cuenta</title>        
    </head>
    <body>
        <?php if($_SESSION['idPerfil'] == 1){ ?>
        <ul class="nav nav-tabs nav justify-content-end "navbar navbar-light" style="background-color: rgb(234,219,228);"">
            <li class="nav-item">
                <a class="nav-link"  href="../menu.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link "  href="../CrudPerfil/consultarPerfil.php">Consultar Perfil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../CrudPersona/consultarPersona.php">Consultar Persona</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="../CrudVuelo/consultarVuelo.php">Consultar Vuelo</a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Consultar Reserva </a>
                <ul class="dropdown-menu">
                    <li><a href="filtrar.php">Por filtro</a></li>
                    <li class="divider"></li>
                    <li><a href="consultarReserva.php">Todas</a></li>
                    
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../login/logout.php" title="**CERRAR SESIÓN**"><img  src="../imag/cerrar.png"   alt="" width="30" height="20" ></a>
            </li>
        </ul>
        <?php }else{  ?>
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
                    <li><a href="consultarReserva.php">Todas</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../login/logout.php" title="**CERRAR SESIÓN**"><img  src="../imag/cerrar.png"   alt="" width="30" height="20" ></a>
            </li>
        </ul>
        <br><br>
        <?php }  ?>
        <?php
        if ($ses == 1) {
            ?>
            <h4>Bienvenid@ <?= $_SESSION['nombreUser'] . " " . $_SESSION['apellidoUser'] ?> Perfil -<?= $_SESSION['nombreRol'] ?> </h4>
            <?php
        }
        ?>

        <form method="POST">
            <h3 align="center">Ingreso Datos Reserva</h3> 

            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationDefault01">Vuelo</label><br>
                    <select name="aerolinea" required class="form-select" >
                        <option  value="" >--Escoja una opción--</option>
                        <?php while($filaR = mysqli_fetch_assoc($cmbVuelo)){?>
                            <option <?php 
                            echo "value='".$filaR['idvuelo']."'";
                            ?>  >
                                <?= $filaR['aerolinea']." - ".$filaR['categoria']." - $".$filaR['precio']?>
                                 </option>
                            <?php  }?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <?php  if($_SESSION['idPerfil'] == 1){  ?>
                    <label for="validationDefault01">Persona</label><br>
                    <select name="persona" required class="form-select">
                        <option  value="" >--Escoja una opción--</option>
                        <<?php while ($filaP = mysqli_fetch_assoc($cmbPersona)) { ?>
                                        <option  <?php
                                        echo "value='" . $filaP['cedula'] . "'";
                                        ?>  >
                                                <?= $filaP['nombres'] . " " . $filaP['apellidos'] ?>
                                        </option>
                                    <?php } ?>
                    </select>
                    <?php } else{ $cedula = $_SESSION['idUsuario'];?>
                    <label for="validationDefault01">Cédula Persona</label><br>
                    <input class="form-control" type="text"  readonly name="persona" value="<?php echo $cedula ?>" />
                    <?php  }?>
                </div>
            </div>    
            

            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationDefaultUsername">Asientos</label>
                    <input type="text" class="form-control" name="asientos"  required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefaultUsername">Fecha Reserva</label>
                    <input type="date" class="form-control" name="fechaReserva" value="<?php echo date("Y-m-d"); ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefaultUsername">Fecha Vuelo</label>
                    <input type="date" class="form-control" min="<?php echo date("Y-m-d"); ?>" name="fechaVuelo" required >
                </div>
            </div>
            
            <div align="center" >
            <button class="btn btn-outline-info" name="crear" type="submit" style="background-color: rgb(234,219,228);" >Guardar</button>
            <button class="btn btn-outline-info" href='consultarVuelo.php' type="reset" style="background-color: rgb(234,219,228);">Limpiar</button>
            <a href="consultarReserva.php" ><input type="button" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" value="Regresar"></a>
            </div>
        </form>




    </body>
</html>
<?php
    
if (isset($_REQUEST['crear'])) {
    
   
    $vuelo = $_REQUEST['aerolinea'];
    $persona = $_REQUEST['persona'];
    $asientos = $_REQUEST['asientos'];
    $fecha_reserva = $_REQUEST['fechaReserva'];
    $fecha_vuelo = $_REQUEST['fechaVuelo'];
    
    $cmbVueloCon = consultarVuelo($con, $vuelo);
    $filaI = mysqli_fetch_assoc($cmbVueloCon);
    
    $asientosV = $filaI['can_disponible'];
    $impuestos = $filaI['impuesto'];
    $precio = $filaI['precio'];
    
    if($asientos > $asientosV){
        echo "<script> alert('Cantidad de Asientos no disponible, Asientos disponibles: $asientosV'); "
             . "window.location.href='ingresarReserva.php';</script>";
    }else{
        $precio_reserva = (($precio * $asientos) + $impuestos);
        $cantidadAsientos = $asientosV - $asientos;
        
        
    
        if (insertarReserva($con, $vuelo, $persona, $asientos, $precio_reserva, $fecha_reserva, $fecha_vuelo)) {
            actualizarAsientos($con, $vuelo, $cantidadAsientos);
            if ($ses == 1) {
                header("Location:consultarReserva.php");
            } else {
                echo "<script> alert('Reserva ingresada de forma satisfactoria'); "
        . "window.location.href='consultarReserva.php';</script>";
            }
        } else {
            echo "<script> alert('Reserva no pudo ser ingresada'); "
        . "window.location.href='consultarPersona.php';</script>";
        }
    }
    
    
    
}
?>