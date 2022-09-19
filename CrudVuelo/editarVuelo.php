<?php
include "../recursos/Conexion.php";
include "../recursos/FuncionesVuelo.php";
ob_start();
//session_start();
//if(!isset($_SESSION['idUsuario'])){
//  header("Location:../index.php");
//}

$idvuelo = $_GET['idV']; //envio desde consultar 
$resultado = consultarVuelo($con, $idvuelo);

$id = null;
$resultado2 = consultarVuelo($con, $id);

if ($fila = mysqli_fetch_assoc($resultado)) {
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
            <title>Actualizar Vuelo</title>             
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

            <form align="center" action="" method="POST">
                <div class="container">
                    <h3 align="center">Actualizar Vuelo</h3> <br>
                    <table align="center" class="table">
                        <thead class="table-dark">

                        </thead>
                        <tbody>
                        <div class="form-row">
                            <input type="hidden"  name="id" value="<?php echo $fila['idvuelo'] ?>" >

                            <div class="col-md-4">
                                <label for="validationDefault01">Aerolinea</label><br>
                                <select name="aerolinea" class="form-select" required>
                                    <option  value="<?php echo $fila['aerolinea'] ?>" >
                                        <?= $fila['aerolinea'] ?>
                                    </option>
                                    <option value="TAME"> TAME</option>
                                    <option value="LAN"> LAN</option>
                                    <option value="LATAM"> LATAM</option>
                                    <option value="Avianca"> Avianca</option>

                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="validationDefault02">Categoria</label><br>
                                <?php for ($i = 0; $i <= 3; $i++) {
                                    $fila2 = mysqli_fetch_assoc($resultado2);
                                    ?>
                                    <input type="radio" name="categoria" <?php
                                    echo "value='" . $fila2['categoria'] . "'";
                                    if ($fila['categoria'] == $fila2['categoria']) {
                                        echo " checked";
                                    }
                                    ?>/>
                                           <?= $fila2['categoria'] ?>   

                                <?php } ?>
                            </div>
                            <div class="col-md-4">
                                <label for="validationDefaultUsername">Asientos</label>
                                <input type="text" class="form-control" name="asientos" value="<?php echo $fila['can_disponible'] ?>"  required>
                            </div>

                            <div class="col-md-4">
                                <label for="validationDefault03">Horario</label><br>
                                <select name="horario" class="form-select">
                                    <option  value="<?php echo $fila['horarios'] ?>" >
                                        <?= $fila['horarios'] ?>
                                    </option>
                                    <option value="05:00"> 05:00</option>
                                    <option value="10:00"> 10:00</option>
                                    <option value="12:00"> 12:00</option>
                                    <option value="17:00"> 17:00</option>
                                    <option value="20:00"> 20:00</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="validationDefault04">Días</label>
                                <input type="text" name="dias" class="form-control" value="<?php echo $fila['dias'] ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="validationDefault05">Precios</label>
                                <input type="text" name="precios" class="form-control" value="<?php echo $fila['precio'] ?>" >
                            </div>
                        </div>
                        </tbody>
                    </table>
                </div>
                <div align="center" >
                    <a href="consultarVuelo.php" ><input type="button" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" value="Regresar"></a>
                    <button  name="actualizar" onclick="return confirm('Seguro de actualizar el registro?')" type="submit" class="btn btn-outline-info" style="background-color: rgb(234,219,228);">Actualizar</button>
                </div>

            <?php } ?>
        </form>    
    </body>
</html>
<?php
if (isset($_POST['actualizar'])) {
    $idvuelo = $_GET['idV'];
    $idvuelo = $_REQUEST['id'];
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

    if (actualizarVuelo($con, $aerolinea, $categoria, $can, $horarios, $dias, $precio, $impuesto, $idvuelo)) {
        header("Location:consultarVuelo.php");
        ob_end_flush();
    } else {
        echo "<script> alert('No se pudo actualizar el registro'); "
        . "window.location.href='editarVuelo.php';</script>";
    }
}
?>