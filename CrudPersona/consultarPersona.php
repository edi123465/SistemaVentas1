<?php
include "../recursos/Conexion.php";
include "../recursos/FuncionesPersona.php";
include "../recursos/FuncionesPerfil.php";

session_start();
if(!isset($_SESSION['idPerfil'])){
  header("Location:../index.php");
}
$cedula = null;
if($_SESSION['idPerfil'] != 1){
    $cedula = $_SESSION['idUsuario'];
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

        <title>Persona</title>
        <script>
            function ConfirmDelete() {

                if (confirm('¿Está seguro que desea eliminarlo?')) {

                } else {
                    return false;
                    location:consultarPersona.php;
                }
            }

            //

        
        </script>

    </head>
    <body>
        <?php if($_SESSION['idPerfil'] == 1){ ?>
        <ul class="nav nav-tabs nav justify-content-end "navbar navbar-light" style="background-color: rgb(234,219,228);"">
            <li class="nav-item " >
                <a class="nav-item nav-link disabled justify-content-lg-start" href="#" id="titu" >
                    <img src="../imag/persona.png" alt="" width="20" height="20" >
                    DATOS PERSONA
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link"  href="../menu.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  href="../CrudPerfil/consultarPerfil.php">Consultar Perfil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="">Consultar Persona</a>
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
                <a class="nav-link active" href="">Consultar Datos</a>
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
        <?php }  ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Cédula</th>
                    <th>Perfil</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Usuario</th>
                    <th>Foto</th>
                    <th>Editar </th>
                    <?php if($_SESSION['idPerfil'] == 1){ echo "<th>Eliminar</th>"; }   ?>
                </tr>
            </thead>

            <tbody>
                <?php
                $sql_registe = paginacionP($con);
                $result_register = mysqli_fetch_assoc($sql_registe);
                $total_registro = $result_register['total_registroP'];
                $por_pagina = 5;

                if (empty($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = $_GET['pagina'];
                }

                $desde = ($pagina - 1) * $por_pagina;
                $total_paginas = (int) ceil($total_registro / $por_pagina);
                
                if ($_SESSION['idPerfil'] == 1) {
                $query = contarPersona($con, $desde, $por_pagina);
                }else{
                $query = consultarPersona($con, $cedula);
                }
                $result = mysqli_num_rows($query);

                if ($result > 0) {
                    while ($fila = mysqli_fetch_assoc($query)){ 
                        
                     
                        $resultadoPerfil = consultarPerfil($con, $fila['id_perfil_p']);
                        $editarPerfil = mysqli_fetch_assoc($resultadoPerfil);
                        
                        ?>
                        <tr >
                            <td> <?php echo $fila['cedula'] ?> </td>
                            <td> <?php echo $editarPerfil['nombre_perfil'] ?> </td>
                            <td> <?php echo $fila['nombres'] ?> </td>
                            <td> <?php echo $fila['apellidos'] ?> </td>
                            <td> <?php echo $fila['direccion'] ?> </td>
                            <td> <?php echo $fila['telefono'] ?> </td>
                            <td> <?php echo $fila['email'] ?> </td>
                            <td> <?php echo $fila['usuario'] ?> </td>
                            <td><img height="50px" src="data:<?php echo $fila['tipo'] ?>;base64,<?php echo base64_encode($fila['foto']) ?>" /> </td>


                            <td><a id='ed' href="editarPersona.php?ced=<?php echo $fila['cedula'] ?>">Editar </a> </td>
                            <?php if($_SESSION['idPerfil'] == 1){ ?>
                            <td><a id='el' onclick="return ConfirmDelete()" href="eliminarPersona.php?ced=<?php echo $fila['cedula'] ?>" >Eliminar</a></td>
                            <?php   }?>
                        </tr>
                    <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <?php if ($_SESSION['idPerfil'] == 1) { ?>
        <div align="center"> 
            
            <nav  aria-label="Page navigation example">
                <ul class="pagination ">
                    <?php
                    if ($pagina != 1) {
                        ?>
                        <li class="page-item"><a class="page-link" href="?pagina=<?php echo 1; ?>">|<</a></li>
                        <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina - 1; ?>"><<</a></li>
                        <?php
                    }
                    for ($i = 1; $i <= $total_paginas; $i++) {
                        if ($i == $pagina) {
                            echo "<li class='page-item active'><a class='page-link'>" . $i . "</a></li>";
                        } else {
                            echo "<li class='page-item'><a class='page-link' href='?pagina=" . $i . "'>" . $i . "</a></li>";
                        }
                    }
                    if ($pagina != $total_paginas) {
                        ?>
                        <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina + 1; ?>">>></a></li>
                        <li class="page-item"><a class="page-link" href="?pagina=<?php echo $total_paginas; ?>">>|</a></li>
                    <?php } ?>

                </ul>
            </nav> 
            
        </div>
            <?php } ?>
        <div align="center" >
        <?php
        if ($_SESSION['idPerfil'] == 1) {
        echo "<a href='crearCuenta.php' ><input type='button' class='btn btn-outline-info' style='background-color: rgb(234,219,228);' value='Ingresar Persona'></a>
        ";
        }?>
        
            <a href="../menu.php" ><input type="button" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" value="Regresar"></a>
        </div>


        





    </body>
</html>


