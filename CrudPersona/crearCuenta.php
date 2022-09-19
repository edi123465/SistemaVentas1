<?php
include "../recursos/Conexion.php";
include "../recursos/FuncionesPersona.php";

session_start();
$ses = (!empty($_GET['id'])) ? $_GET['id'] : 0;


if(!isset($_SESSION['idUsuario']) and $ses !=null){
  header("Location:../index.php");
}




?>

<?php
if (isset($_REQUEST['crear'])) {
    $cedula = $_REQUEST['cedula'];
    $idPerfil = 2;
    $nombres = $_REQUEST['nombres'];
    $apellidos = $_REQUEST['apellidos'];
    $direccion = $_REQUEST['direccion'];
    $telefono = $_REQUEST['telefono'];
    $correo = $_REQUEST['correo'];
    $usuario = $_REQUEST['user'];
    $clave = $_REQUEST['clave'];

    $consultarPersona = consultarUsuario($con, $usuario, null);
    $contarPersonas = $consultarPersona->num_rows;
    $consultarCedula = consultarPersona($con, $cedula);
    $contarCedulas = $consultarCedula->num_rows;
    //validar que persona no se repita

    if ($_FILES['foto']['name'] != '') {
        $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
        $tipo = $_FILES['foto']['type'];
        if ($tipo == "image/jpeg" || $tipo == "image/jpg" || $tipo == "image/png") {
            if ($contarCedulas > 0) {
                echo "<br><b><div id:'error' style='font-size: 16px; color:red';>Ya existe una cuenta con esa cédula</div>";
            } else {
                if ($contarPersonas > 0) {
                    echo "<br><b><div id:'error' style='font-size: 16px; color:red';>Ya existe una cuenta con el usuario: $usuario .... ingrese otro usuario </div>";
                } else {
                    $encriptar = md5($clave);

                    $insertar = insertarPersona($con, $cedula, $idPerfil, $nombres, $apellidos, $direccion, $telefono, $correo, $usuario, $encriptar, $foto, $tipo);
                    if ($insertar) {
                       if ($_SESSION['idPerfil'] == 1) {
                        echo "<script> alert('Cuenta creada de forma satisfactoria'); "
                        . "window.location.href='consultarPersona.php';</script>";
                        } else {
                          echo "<b><div id:'error' style='font-size: 16px; color:blue';>**Cuenta creada de forma satisfactoria**</div>";
                        }
                    } else {
                        if ($_SESSION['idPerfil'] == 1) {
                    echo "<script> alert('No se logró crear la cuenta'); "
                    . "window.location.href='consultarPersona.php';</script>";
                    }else{
                        echo "<br><b><div id:'error' style='font-size: 16px; color:red';>No se logró crear la cuenta</div>";
                    }
                    }
                }
            }
        } else {
            echo "<script> alert('Formato No permitido, ingrese una imagen'); "
            . "window.location.href='crearCuenta.php';</script>";
        }
    } else {
        if ($contarCedulas > 0) {
            echo "<br><b><div id:'error' style='font-size: 16px; color:red';>Ya existe una cuenta con esa cédula</div>";
        } else {
            if ($contarPersonas > 0) {
                echo "<br><b><div id:'error' style='font-size: 16px; color:red';>Ya existe una cuenta con el usuario: $usuario .... ingrese otro usuario </div>";
            } else {
                $encriptar = md5($clave);

                $insertar = insertarPersona($con, $cedula, $idPerfil, $nombres, $apellidos, $direccion, $telefono, $correo, $usuario, $encriptar, null, null);
                if ($insertar) {
                    if ($ses == 1) {
                    echo "<script> alert('Cuenta creada de forma satisfactoria'); "
                    . "window.location.href='consultarPersona.php';</script>";
                    } else {
                      echo "<b><div id:'error' style='font-size: 16px; color:blue';>**Cuenta creada de forma satisfactoria**</div>";
                    }
                } else {
                    if ($ses == 1) {
                    echo "<script> alert('No se logró crear la cuenta'); "
                    . "window.location.href='consultarPersona.php';</script>";
                    }else{
                    echo "<br><b><div id:'error' style='font-size: 16px; color:red';>No se logró crear la cuenta</div>";
                    }
                }
            }
        }
    }
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        
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
            function mostrarContrasena() {
                var tipo = document.getElementById("pwdd");
                if (tipo.type == "password") {
                    tipo.type = "text";
                } else {
                    tipo.type = "password";
                }
            }

            //

        
            
        
        </script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript"></script>
        <script>
            function cedulaVerificar() {
                var cedula = document.querySelector('#cedula').value;
                if (cedula.length == 10) {

                    //Obtenemos el digito de la region que sonlos dos primeros digitos
                    var digito_region = cedula.substring(0, 2);

                    //Pregunto si la region existe ecuador se divide en 24 regiones
                    if (digito_region >= 1 && digito_region <= 24) {

                        // Extraigo el ultimo digito
                        var ultimo_digito = cedula.substring(9, 10);

                        //Agrupo todos los pares y los sumo
                        var pares = parseInt(cedula.substring(1, 2)) + parseInt(cedula.substring(3, 4)) + parseInt(cedula.substring(5, 6)) + parseInt(cedula.substring(7, 8));

                        //Agrupo los impares, los multiplico por un factor de 2, si la resultante es > que 9 le restamos el 9 a la resultante
                        var numero1 = cedula.substring(0, 1);
                        var numero1 = (numero1 * 2);
                        if (numero1 > 9) {
                            var numero1 = (numero1 - 9);
                        }

                        var numero3 = cedula.substring(2, 3);
                        var numero3 = (numero3 * 2);
                        if (numero3 > 9) {
                            var numero3 = (numero3 - 9);
                        }

                        var numero5 = cedula.substring(4, 5);
                        var numero5 = (numero5 * 2);
                        if (numero5 > 9) {
                            var numero5 = (numero5 - 9);
                        }

                        var numero7 = cedula.substring(6, 7);
                        var numero7 = (numero7 * 2);
                        if (numero7 > 9) {
                            var numero7 = (numero7 - 9);
                        }

                        var numero9 = cedula.substring(8, 9);
                        var numero9 = (numero9 * 2);
                        if (numero9 > 9) {
                            var numero9 = (numero9 - 9);
                        }

                        var impares = numero1 + numero3 + numero5 + numero7 + numero9;

                        //Suma total
                        var suma_total = (pares + impares);

                        //extraemos el primero digito
                        var primer_digito_suma = String(suma_total).substring(0, 1);

                        //Obtenemos la decena inmediata
                        var decena = (parseInt(primer_digito_suma) + 1) * 10;

                        //Obtenemos la resta de la decena inmediata - la suma_total esto nos da el digito validador
                        var digito_validador = decena - suma_total;

                        //Si el digito validador es = a 10 toma el valor de 0
                        if (digito_validador == 10)
                            var digito_validador = 0;

                        //Validamos que el digito validador sea igual al de la cedula
                        if (digito_validador == ultimo_digito) {
                            
                        } else {
                            alert('la cedula:' + cedula + ' es incorrecta');
                            event.preventDefault();
                        }

                    } else {
                        // imprimimos en consola si la region no pertenece
                        alert('La cedula no pertenece a ninguna region');
                        event.preventDefault();
                    }
                } else {
                    //si la cedula tiene mas o menos de 10 digitos
                    alert('El campo Cédula es obligatorio, 10 dígitos');
                    event.preventDefault();
                }
            }
        </script>
        <title>Creación de cuenta</title>        
    </head>
    <body> 
        <?php if(isset($_SESSION['idUsuario'])){ ?>
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
        <?php }else{  ?>
        
        <br><br>
        <?php }  ?>
        <div class="overlay">
            <form align="center" action="" method="POST" enctype="multipart/form-data"> 
                <div class="container">
                    <header class="head-form">
                        <h2>Creación de cuenta </h2>
                    </header>
                    <table align="center" border="0"> 
                        <div>
                            <div class="col-md-4"> 
                                <label for="validationDefaultUsername">Cédula</label>
                                <input class="form-control" type="text" name="cedula" id="cedula" value=""   pattern=".{10,}" required maxlength="10"  onkeypress="return soloNumeros(event)" onpaste="return false" "
                                       oninvalid="setCustomValidity('El campo Cédula es obligatorio, 10 dígitos')" 
                                       oninput="setCustomValidity('')">
                            </div>
                            <div class="col-md-4">
                                <label for="validationDefaultUsername">Nombres</label>
                                <input class="form-control" type="text" name="nombres" value="" required  onkeypress="return soloLetras(event)"
                                       oninvalid="setCustomValidity('El campo Nombres es obligatorio')" 
                                       oninput="setCustomValidity('')">
                            </div>
                            <div class="col-md-4">
                                <label for="validationDefaultUsername">Apellidos</label>
                                <input class="form-control" type="text" name="apellidos" value="" required  onkeypress="return soloLetras(event)" 
                                       oninvalid="setCustomValidity('El campo Apellido es obligatorio')" 
                                       oninput="setCustomValidity('')">
                            </div>
                            <div class="col-md-4">
                                <label for="validationDefaultUsername">Dirección</label>
                                <input class="form-control" type="text" name="direccion" value="" required oninvalid="setCustomValidity('El campo Dirección es obligatorio')" 
                                       oninput="setCustomValidity('')">
                            </div>
                            <div class="col-md-4">
                                <label for="validationDefaultUsername">Teléfono Celular</label>
                                <input class="form-control" type="text" name="telefono" value=""  pattern=".{10,}" required maxlength="10"  onkeypress="return soloNumeros(event)" onpaste="return false"
                                       oninvalid="setCustomValidity('El campo celular es obligatorio, 10 dígitos')" 
                                       oninput="setCustomValidity('')">
                            </div>
                            <div class="col-md-4">
                                <label for="validationDefaultUsername">Email</label>
                                <input type="email" name="correo" class="form-control" id="exampleFormControlInput1" placeholder="ejemplo@gmail.com">
                            </div>
                            <div class="col-md-4">
                                <label for="validationDefaultUsername">Usuario</label>
                                <input class="form-control" type="text" name="user" value="" required oninvalid="setCustomValidity('Ingrese el campo Usuario')" 
                                       oninput="setCustomValidity('')">
                            </div>
                            <div class="col-md-4">
                                <style>#eyee{
                                        position: relative;
                                        bottom: 23px;
                                        left: 150px;
                                    }</style>
                                <label for="validationDefaultUsername">Clave</label>
                                <input type="password" id="pwdd" name="clave" class="form-control" id="exampleInputPassword1" required oninvalid="setCustomValidity('Ingrese el campo de clave')" 
                                       oninput="setCustomValidity('')">

                                <i class="fa fa-eye" aria-hidden="true"  type="button" onclick="mostrarContrasena()" id="eyee"></i>

                            </div>
                            <div class="col-md-4">
                                <label for="validationDefaultUsername">Foto</label>
                                <input type="file" name="foto" value="" class="form-control" id="inputGroupFile02">
                            </div>   

                            <div style="font-size: 16px; color:red; "><?php echo isset($error) ? $error : ''; ?></div>

                        </div>
                    </table>
                </div>
                <br>
                <div align="center" >
                    <button  name='crear' type="submit" id="crea" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" onclick="cedulaVerificar()">Crear Cuenta</button>
                    <button  name='limpio' type="reset" id="lim" onclick="limpiarDatos()" class="btn btn-dark" style="background-color: rgb(234,219,228);">Limpiar</button>
                </div>
                
            </form> 
                <div align="center"> 
                <?php
                $sesId = (!empty($_SESSION['idPerfil'])) ? $_SESSION['idPerfil'] : 0;
                    if(!isset($_SESSION['idUsuario'])){
                    echo "<p>¿Ya tiene una cuenta? <a href='../index.php'> Ingresa aquí!! </a></p>";
                } else {
                    echo "<a href='consultarPersona.php' ><input type='button' class='btn btn-outline-info' style='background-color: rgb(234,219,228);' value='Regresar'></a>";
                    }
                ?>
                </div>
            
                
            

        </div>
    </body>
</html>
