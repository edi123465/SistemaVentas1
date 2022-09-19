<?php
include "../recursos/Conexion.php";
include "../recursos/FuncionesPersona.php";
include "../recursos/FuncionesPerfil.php";

ob_start(); //para dirigir en caso que no funcione header

session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location:../index.php");
}

$ced = $_REQUEST['ced']; //envio desde consultar 
$resultado = consultarPersona($con, $ced);
$idPerfil = null;

$cmbPerfil = consultarPerfil($con, $idPerfil);

if ($fila = mysqli_fetch_assoc($resultado)) {
    $resultadoPerfil = consultarPerfil($con, $fila['id_perfil_p']);
    $editarPerfil = mysqli_fetch_assoc($resultadoPerfil);
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
                    numero = "0123456789";
                    especial = "";
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
                function soloLetras(e) {
                    var code;
                    if (!e)
                        var e = window.event;
                    if (e.keyCode)
                        code = e.keyCode;
                    else if (e.which)
                        code = e.which;
                    var character = String.fromCharCode(code);
                    var AllowRegex = /^[\ba-zA-Z\s-]$/;
                    if (AllowRegex.test(character))
                        return true;
                    return false;
                }
                //

                

            </script>
            <title>Actualizar Usuario/Persona</title>             
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
                    <li class="nav-item " >
                        <a class="nav-item nav-link disabled justify-content-lg-start" href="#" id="titu" >
                            <img src="../imag/persona.png" alt="" width="20" height="20" >
                            DATOS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="../menu.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="../CrudPersona/consultarPersona.php">Consultar Datos</a>
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
            <?php } ?>
            <form align="center" action="" method="POST" enctype="multipart/form-data">
                <div class="container">
                    <h3 align="center">Actualizar Usuario/Persona</h3> <br>
                    <table align="center" border="0"> 
                        <div>
                            <div>
                                <div class="col-md-4"> 
                                    <label for="validationDefaultUsername">Cédula</label>
                                    <input class="form-control" type="text" readonly  name="cedula" value="<?php echo $fila['cedula']?>" >
                                </div>
                                <div class="col-md-4"> 
                                    <label for="validationDefaultUsername">Perfil</label>
                                    <?php if ($_SESSION['idPerfil'] == 1) { ?>
                                        <select name="perfil"  class="form-select" >  
                                            <?php while ($filaPerfil = mysqli_fetch_assoc($cmbPerfil)) { ?>
                                                <option <?php
                                                echo "value='" . $filaPerfil['id_perfil'] . "'";
                                                if ($filaPerfil['id_perfil'] == $editarPerfil['id_perfil']) {
                                                    echo "selected='selected'";
                                                }
                                                ?>>
                                                        <?= $filaPerfil['nombre_perfil'] ?>   
                                                </option> 
                                            <?php } ?>
                                        </select>
                                    <?php } else {
                                        $filaPerfil = mysqli_fetch_assoc($cmbPerfil); ?>
                                        <input class="form-control" type="text"  readonly name="perfil" value="<?php echo $editarPerfil['nombre_perfil'] ?>" />
    <?php } ?>
                                </div>

                                <div class="col-md-4"> 
                                    <label for="validationDefaultUsername">Nombres</label>
                                    <input class="form-control" type="text" name="nombres" required  onkeypress="return soloLetras(event)" value="<?php echo $fila['nombres'] ?>" >
                                </div>
                            </div> 
                            <div> 
                                <div class="col-md-4"> 
                                    <label for="validationDefaultUsername">Apellidos</label>
                                    <input class="form-control" type="text" name="apellidos" required  onkeypress="return soloLetras(event)" value="<?php echo $fila['apellidos'] ?>" >
                                </div>
                                <div class="col-md-4"> 
                                    <label for="validationDefaultUsername">Dirección</label>
                                    <input class="form-control" type="text" name="direccion" value="<?php echo $fila['direccion'] ?>" >
                                </div>
                                <div class="col-md-4"> 
                                    <label for="validationDefaultUsername">Telefono</label>
                                    <input class="form-control" type="text" name="telefono" required pattern=".{10,}" required maxlength="10"  onkeypress="return soloNumeros(event)" onpaste="return false" value="<?php echo $fila['telefono'] ?>" >
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <label for="validationDefaultUsername">Email</label>
                                <input type="email" name="correo" class="form-control" id="exampleFormControlInput1" value="<?php echo $fila['email'] ?>"></td>
                            </div>

                            <div class="col-md-4"> 
                                <label for="validationDefaultUsername">Usuario</label>
                                <input class="form-control" type="text" name="usuario"  value="<?php echo $fila['usuario'] ?>" >
                            </div>
                            <div class="col-md-4"> 
                                <label for="validationDefaultUsername">Foto</label>
                                <div class="input-group mb-3">
                                    <input type="file" name="foto"  class="form-control" id="inputGroupFile02" value="<img height='50px' src='data:<?php echo $fila['tipo'] ?>;base64,<?php echo base64_encode($fila['foto']) ?>'"><img height='50px' src='data:<?php echo $fila['tipo'] ?>;base64,<?php echo base64_encode($fila['foto']) ?>' />
                                </div>
                            </div>
                        </div>
                    </table>
                </div>
                <br>
                <div class="col-12">
                    &nbsp;<a href="consultarPersona.php"><input type="button" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" value="Regresar"></a> 
                    &nbsp;<button  name="actualizar" onclick="return confirm('Seguro de actualizar el registro?')" type="submit" class="btn btn-outline-info" style="background-color: rgb(234,219,228);">Actualizar</button>
                    &nbsp;<a href="claveUsuario.php?idUser=<?php echo $fila['usuario'] ?>"><input type="button" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" value="Cambiar Clave"></a>
                </div>
<?php } ?>
        </form>    
    </body>
</html>
<?php
if (isset($_POST['actualizar'])) {
    
    $cedula = $_POST['cedula']; 
    $perfil = $_POST['perfil'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['correo'];
    $usuario = $_POST['usuario'];
    
    //$consultarPersona = consultarUsuario($con, $usuario, null);
    //$contarPersonas = $consultarPersona->num_rows;
    if ($_FILES['foto']['name'] != '') {
        $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
        $tipo = $_FILES['foto']['type'];
        if ($tipo == "image/jpeg" || $tipo == "image/jpg" || $tipo == "image/png") {
            $actualizar = actualizarPersona($con, $cedula, $perfil, $nombres, $apellidos, $direccion, $telefono, $email, $usuario, $foto, $tipo);
            if ($actualizar) {
                header("Location:consultarPersona.php");
                ob_end_flush();
            } else {
                echo "<script> alert('No se pudo actualizar el registro'); "
                . "window.location.href='consultarPersona.php';</script>";
            }
        } else {
            echo "<script> alert('Formato No permitido, ingrese una imagen'); "
            . "window.location.href='consultarPersona.php';</script>";
        }
    } else {
        
            $actualizar = actualizarPersonaS($con, $cedula, $perfil, $nombres, $apellidos, $direccion, $telefono, $email, $usuario);
            if ($actualizar) {
                header("Location:consultarPersona.php");
                ob_end_flush();
            } else {
                echo "<script> alert('No se pudo actualizar el registro'); "
                . "window.location.href='consultarPersona.php';</script>";
            }
        
    }
}
?>