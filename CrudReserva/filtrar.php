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
<html lang="en">
    <head>
        <title>Filtro Cedula</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link href="../estilos/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>



        <script>
            function ConfirmDelete() {

                if (confirm('¿Está seguro que desea eliminarlo?')) {

                } else {
                    return false;
                    location:consultarReserva.php;
                }
            }

            //

            $(document).ready(function () {
                $("#myInput").on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    $("#myTable tr").filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });


            

        </script>

    </head>
    <body>
        <?php if ($_SESSION['idPerfil'] == 1) { ?>
            <ul class="nav nav-tabs nav justify-content-end "navbar navbar-light" style="background-color: rgb(234,219,228);"">
                <li class="nav-item " >
                    <a class="nav-item nav-link disabled justify-content-lg-start" href="#" id="titu" >
                        <img src="../imag/reserva.png" alt="" width="20" height="20" >
                        DATOS RESERVA CON FILTRO
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
                <li class="nav-item">
                    <a class="nav-link" href="../CrudReserva/consultarReserva.php">Consultar Reserva (Todas)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../login/logout.php" title="**CERRAR SESIÓN**"><img  src="../imag/cerrar.png"   alt="" width="30" height="20" ></a>
                </li>
            </ul>
        <?php } else { ?>
            <ul class="nav nav-tabs nav justify-content-end "navbar navbar-light" style="background-color: rgb(234,219,228);"">
                <li class="nav-item " >
                    <a class="nav-item nav-link disabled justify-content-lg-start" href="#" id="titu" >
                        <img src="../imag/reserva.png" alt="" width="20" height="20" >
                        DATOS RESERVA CON FILTRO
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
        <?php } ?>


        <style>
            .top{
                position:relative;
                top:0;
                left: 60%;
                width: 40%;
            }
        </style>
        <form>
            <div class="top">
                <br> 
                <input class="form-control" id="myInput" type="text" name="cedu" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" placeholder="Ingrese una cédula,nombre de la Aerolinea u otro filtro de interés">
                <br> 
            </div>



            <table class="table table-bordered table-striped" >

                <thead class="table-dark" >
                    <tr>
                        <th>Id Reserva</th>
                        <th>Cédula</th>
                        <th>Nombres Apellidos</th>
                        <th>Vuelo</th>
                        <th>Aerolinea</th>
                        <th>Categoría</th>
                        <th>N. Asientos</th>
                        <th>Horario</th>
                        <th>Precio</th>
                        <th>Impuesto</th>
                        <th>Precio Reserva</th>


                        <th>Editar </th>
                        <?php if ($_SESSION['idPerfil'] == 1) {
                            echo "<th>Eliminar</th>";
                        } ?>
                    </tr>
                </thead>

                <tbody id="myTable">
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
                        ?>
                        <?php
                        $id_reserva = null;

                        $consulta = consultarReserva($con, $id_reserva);

                        while ($fila = mysqli_fetch_assoc($query)) { //almaceno temporal los registros de BBDD
                            $aerolineaa = consultarVuelo($con, $fila['idvuelo_r']);
                            $aerolinea = mysqli_fetch_assoc($aerolineaa);
                            $personaa = consultarPersona($con, $fila['cedula_r']);
                            $persona = mysqli_fetch_assoc($personaa);
                            ?>
                            <tr >
                                <td> <?php echo $fila['id_reserva'] ?> </td>
                                <td> <?php echo $fila['cedula_r'] ?> </td>
                                <td> <?php echo $persona['nombres'] . " " . $persona['apellidos'] ?> </td>
                                <td> <?php echo $fila['idvuelo_r'] ?> </td>
                                <td> <?php echo $aerolinea['aerolinea'] ?> </td>
                                <td> <?php echo $aerolinea['categoria'] ?> </td>
                                <td> <?php echo $fila['can_asientos'] ?> </td>
                                <td> <?php echo $aerolinea['horarios'] ?> </td>
                                <td> <?php echo $aerolinea['precio'] ?> </td>
                                <td> <?php echo $aerolinea['impuesto'] ?> </td>
                                <td> <?php echo $fila['precio_reserva'] ?> </td>

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
                <input type="submit"  name="inform" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" value="Generar Reporte"></a>
            </div>




        </form>
    </body>

</html>


<div >
    <?php
    if (isset($_REQUEST['inform'])) {
        //echo "<input type='text' name='cedu'> ";
        $cedu = $_REQUEST['cedu'];
        echo "<script>window.location.href='../fpdf/pdfFiltro.php?cedula=$cedu';</script>";
    }
    ?>
</div>

