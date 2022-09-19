<?php
session_start();
if(!isset($_SESSION['idPerfil'])){
  header("Location:../index.php");
}

include "../recursos/Conexion.php";
include "../recursos/FuncionesVuelo.php";
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="../estilos/bootstrap.css" rel="stylesheet" type="text/css"/>


        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        <title>Vuelo</title>
        <script>
            function ConfirmDelete() {

                if (confirm('¿Está seguro que desea eliminarlo?')) {

                } else {
                    return false;
                    location:consultarVuelo.php;
                }
            }

            //

            
        </script>
        <title>Consultar Vuelo</title>

    </head>
    <body>
        <?php if($_SESSION['idPerfil'] == 1){ ?>
        <ul class="nav nav-tabs nav justify-content-end "navbar navbar-light" style="background-color: rgb(234,219,228);"">
            <li class="nav-item " >
                <a class="nav-item nav-link disabled justify-content-lg-start" href="#" id="titu" >
                    <img src="../imag/vuelo.png" alt="" width="20" height="20" >
                    DATOS VUELO
                </a>
            </li>
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
                <a class="nav-link active" href="#">Consultar Vuelo</a>
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
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Id Vuelo </th>
                    <th>Aerolinea </th>
                    <th>Categoría </th>
                    <th>Asientos Disponibles </th>
                    <th>Horarios </th>
                    <th>Días </th>
                    <th>Precio </th>
                    <th>Impuesto </th>
                    <?php if($_SESSION['idPerfil'] == 1){ echo "<th>Editar</th>"; }    ?>
                    <?php if($_SESSION['idPerfil'] == 1){ echo "<th>Eliminar</th>"; }    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql_registe = paginacionVuelo($con);
                $result_register = mysqli_fetch_assoc($sql_registe);
                $total_registro = $result_register['total_registroVuelo'];
                $por_pagina = 5;

                if (empty($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = $_GET['pagina'];
                }

                $desde = ($pagina - 1) * $por_pagina;
                $total_paginas = (int) ceil($total_registro / $por_pagina);

                $query = contarVuelo($con, $desde, $por_pagina);

                $result = mysqli_num_rows($query);

                if ($result > 0) {
                    ?>
                    <?php
                    $idvuelo = null;
                    $consulta = consultarVuelo($con, $idvuelo);

                    while ($fila = mysqli_fetch_assoc($query)) { //almaceno temporal los registros de BBDD
                        ?>
                        <tr >
                            <td> <?php echo $fila['idvuelo'] ?> </td>
                            <td> <?php echo $fila['aerolinea'] ?> </td>
                            <td> <?php echo $fila['categoria'] ?> </td>
                            <td> <?php echo $fila['can_disponible'] ?> </td>
                            <td> <?php echo $fila['horarios'] ?> </td>
                            <td> <?php echo $fila['dias'] ?> </td>
                            <td> <?php echo $fila['precio'] ?> </td>
                            <td> <?php echo $fila['impuesto'] ?> </td>
                                <?php if($_SESSION['idPerfil'] == 1){ ?>
                            <td><a id='ed' href="editarVuelo.php?idV=<?php echo $fila['idvuelo'] ?>">Editar </a> </td>
                            <td><a id='el' onclick="return ConfirmDelete()" href="eliminarVuelo.php?idVuelo=<?php echo $fila['idvuelo'] ?>" >Eliminar</a></td>
                                <?php   }?>
                        </tr>
                    <?php }
                }
                ?>
            </tbody>
        </table>
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



        <?php
        
        ?>
        <div align="center" >
            <a href="../menu.php" ><input type="button" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" value="Regresar"></a>
            <?php if($_SESSION['idPerfil'] == 1){ ?>
            <a href="ingresarVuelo.php" ><input type="button" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" value="Ingresar Vuelo"></a>
            <?php }?>
        </div>


    </div>


</body>
</html>


