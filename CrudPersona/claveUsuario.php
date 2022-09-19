<?php
require "../recursos/Conexion.php";
require "../recursos/FuncionesPersona.php";

session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location:../index.php");
}

$id_user = $_GET['idUser'];
$clave = null;
$consultar = consultarUsuario($con, $id_user, $clave);

if ($fila = mysqli_fetch_assoc($consultar)) {
    ?>


    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

            <link href="../estilos/bootstrap.css" rel="stylesheet" type="text/css"/>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
            <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
            <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

            <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">


            <script>
                function mostrarContrasena() {
                    var tipo = document.getElementById("pwdd");
                    var tipo2 = document.getElementById("pwddd");
                    if (tipo.type == "password") {
                        tipo.type = "text";
                    } else {
                        tipo.type = "password";
                    }

                    if (tipo2.type == "password") {
                        tipo2.type = "text";
                    } else {
                        tipo2.type = "password";
                    }
                }
                function mostrarContrasenaa() {

                    var tipo2 = document.getElementById("pwddd");

                    if (tipo2.type == "password") {
                        tipo2.type = "text";
                    } else {
                        tipo2.type = "password";
                    }
                }
                //

                

            </script>
            <title>Actualizar clave </title>         
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
            <br><h3 align="center">Actualizar clave</h3> <br>
            <form class="ingres"action="" method="POST">
                <div class="container">
                    <table align="center" > 
                        <div> 
                            <div >
                                <input type="hidden" name="id" value="<?php echo $fila['cedula'] ?>" />
                            </div> 
                            <div class="col-md-6">    
                                <label for="validationDefaultUsername">Nombre</label>
                                <input class="form-control" type="text"  name="nombre" value="<?php echo $fila['nombres'] ?>" readonly="" >
                            </div>
                            <div class="col-md-6">    
                                <label for="validationDefaultUsername">Apellido</label>
                                <input class="form-control" type="text"  name="apellido" value="<?php echo $fila['apellidos'] ?>" readonly="" >
                            </div>
                            <div class="col-md-6">    
                                <label for="validationDefaultUsername">Usuario</label>
                                <input class="form-control" type="text"  name="user"  value="<?php echo $fila['usuario'] ?>" readonly="">
                            </div>
                            <div class="col-md-6">    
                                <label for="validationDefaultUsername">Correo</label>
                                <input class="form-control" type="text"  name="correo" value="<?php echo $fila['email'] ?>" readonly="" >
                            </div>
                            <style>#eyee{
                                    position: relative;
                                    bottom: 23px;
                                    left: 95%;
                                }</style>
                            <div class="col-md-6">    
                                <label for="validationDefaultUsername">Clave anterior</label>
                                <input type="hidden" name="anteriorBdd" value="<?php echo $fila['clave'] ?>" />
                                <input class="form-control"  id="pwdd" type="password" name="anterior" value="" required oninvalid="setCustomValidity('Ingrese la clave del usuario')" 
                                       oninput="setCustomValidity('')">
                                <i class="fa fa-eye" aria-hidden="true"  type="button" onclick="mostrarContrasena()" id="eyee"></i>
                            </div>
                            <div class="col-md-6">    
                                <label for="validationDefaultUsername">Clave actual</label>
                                <input type="hidden" name="anteriorBdd" value="<?php echo $fila['clave'] ?>" />
                                <input class="form-control" type="password" id="pwddd" name="actual" value="" required oninvalid="setCustomValidity('Ingrese la clave a la que desea actualizar')" 
                                       oninput="setCustomValidity('')">
                                <i class="fa fa-eye" aria-hidden="true"  type="button" onclick="mostrarContrasenaa()" id="eyee"></i>
                            </div>

                        </div>


                    </table>
                </div>
                <br>
                <div align="center" >
                    <a href="consultarPersona.php" ><input type="button" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" value="Regresar"></a> 
                    <input type="submit" value="Actualizar" name="actualizar" class="btn btn-outline-info" style="background-color: rgb(234,219,228);"/>
                </div>
            <?php } ?>
        </form>
    </body>
</html>

<?php
if (isset($_POST['actualizar'])) {
    $cedula = $_POST['id'];
    $anteriorBdd = $_POST['anteriorBdd'];
    $anterior = $_POST['anterior'];
    $actual = $_POST['actual'];
    $encriptaAntes = md5($anterior);

    if ($encriptaAntes == $anteriorBdd) {
        if ($anterior == $actual) {
            echo "La clave actual es idéntica a la anterior";
        } else {
            //encripto clave actual
            $encriptar = md5($actual);
            //y actualizo clave
            if ($actualizarClave = actualizarClave($con, $encriptar, $cedula)) {
                echo "<script>alert('Clave actualizada satisfactoriamente'); "
                . "window.location.href='consultarPersona.php';</script>";
            } else {
                echo "<script>alert('Clave no se a podido actualizar'); "
                . "window.location.href='editarPersona.php';</script>";
            }
        }
    } else {
        echo "<script>alert('Clave del usuario incorrecta'); "
        . "window.location.href='consultarPersona.php';</script>";
    }
}
?>
