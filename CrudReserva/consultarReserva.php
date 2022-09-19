<?php
session_start();
if (!isset($_SESSION['idPerfil'])) {
    header("Location:../index.php");
}

include "../recursos/Conexion.php";
include "../recursos/FuncionesPersona.php";
include "../recursos/FuncionesVuelo.php";
include "../recursos/FuncionesReserva.php";
$id_reserva = null;
$cedula = null;
if ($_SESSION['idPerfil'] != 1) {
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



        <title>Reserva</title>
        <script>
            function ConfirmDelete() {

                if (confirm('¿Está seguro que desea eliminarlo?')) {

                } else {
                    return false;
                    location:consultarReserva.php;
                }
            }

            //

            

        </script>


    </head>
    <body>
<?php if ($_SESSION['idPerfil'] == 1) { ?>
            <ul class="nav nav-tabs nav justify-content-end "navbar navbar-light" style="background-color: rgb(234,219,228);"">
                <li class="nav-item " >
                    <a class="nav-item nav-link disabled justify-content-lg-start" href="#" id="titu" >
                        <img src="../imag/reserva.png" alt="" width="20" height="20" >
                        DATOS RESERVA
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"  href="../menu.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  href="../CrudPerfil/consultarPerfil.php">Consultar Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="../CrudPersona/consultarPersona.php">Consultar Persona</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../CrudVuelo/consultarVuelo.php">Consultar Vuelo</a>
                </li>
                <li class="dropdown active">
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
                        <img src="../imag/reserva.png" alt="" width="20" height="20" >
                        DATOS RESERVA
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

        <table class="table table-bordered table-striped" >
            <thead class="table-dark">
                <tr>
                    <th>Id Reserva</th>
                    <th>Vuelo</th>
                    <th>Aerolinea</th>
                    <th>Categoría</th>
                    <th>N. Asientos</th>
                    <th>Horario</th>
                    <th>Precio</th>
                    <th>Impuesto</th>
                    <th>Precio Reserva</th>
                    <th>Cédula</th>
                    <th>Nombres Apellidos</th>
<?php
if ($_SESSION['idPerfil'] != 1) {
    echo "<th>Fecha Reserva</th>";
    echo "<th>Fecha Vuelo</th>";
}
?>
                    <th>Editar </th>
                    <?php
                    if ($_SESSION['idPerfil'] == 1) {
                        echo "<th>Eliminar</th>";
                    }
                    ?>
                </tr>
            </thead>

            <tbody>
                <?php
                $sql_registe = paginacionReserva($con);
                $result_register = mysqli_fetch_assoc($sql_registe);
                $total_registro = $result_register['total_registroReserva'];
                $por_pagina = 5;

                if (empty($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = $_GET['pagina'];
                }

                $desde = ($pagina - 1) * $por_pagina;
                $total_paginas = (int) ceil($total_registro / $por_pagina);

                if ($_SESSION['idPerfil'] != 1) {
                    $query = consultarReservaPorCedula($con, $cedula);
                } else {
                    $query = contarReserva($con, $desde, $por_pagina);
                }

                $result = mysqli_num_rows($query);

                if ($result > 0) {

                    while ($fila = mysqli_fetch_assoc($query)) { //almaceno temporal los registros de BBDD
                        $aerolineaa = consultarVuelo($con, $fila['idvuelo_r']);
                        $aerolinea = mysqli_fetch_assoc($aerolineaa);
                        $personaa = consultarPersona($con, $fila['cedula_r']);
                        $persona = mysqli_fetch_assoc($personaa);
                        ?>
                        <tr >
                            <td> <?php echo $fila['id_reserva'] ?> </td>
                            <td> <?php echo $fila['idvuelo_r'] ?> </td>
                            <td> <?php echo $aerolinea['aerolinea'] ?> </td>
                            <td> <?php echo $aerolinea['categoria'] ?> </td>
                            <td> <?php echo $fila['can_asientos'] ?> </td>
                            <td> <?php echo $aerolinea['horarios'] ?> </td>
                            <td> <?php echo $aerolinea['precio'] ?> </td>
                            <td> <?php echo $aerolinea['impuesto'] ?> </td>
                            <td> <?php echo $fila['precio_reserva'] ?> </td>
                            <td> <?php echo $fila['cedula_r'] ?> </td>
                            <td> <?php echo $persona['nombres'] . " " . $persona['apellidos'] ?> </td>
        <?php if ($_SESSION['idPerfil'] != 1) { ?>
                                <td> <?php echo $fila['fecha_reserva'] ?> </td>;
                                <td> <?php echo $fila['fecha_vuelo'] ?> </td>;
                            <?php } ?>

                            <td><a id='ed' href="editarReserva.php?idR=<?php echo $fila['id_reserva'] ?>">Editar </a> </td>
                            <?php if ($_SESSION['idPerfil'] == 1) { ?>
                                <td><a id='el' onclick="return ConfirmDelete()" href="eliminarReserva.php?id=<?php echo $fila['id_reserva'] ?>" >Eliminar</a></td>
        <?php } ?>
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
                    <?php } ?>
        </div>



        <div align="center" >
            <a href="../menu.php" ><input type="button" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" value="Regresar"></a>
            <a href="ingresarReserva.php" ><input type="button" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" value="Ingresar Reserva"></a>
            <a href="../fpdf/pdf.php" target="_blank"><input type="button" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" value="Generar Reporte"></a>

        </div>




    </body>
</html>


