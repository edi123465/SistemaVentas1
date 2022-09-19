<?php
include "../recursos/Conexion.php";
include "../recursos/FuncionesPerfil.php";
session_start();
if(!isset($_SESSION['idPerfil'])){
  header("Location:../index.php");
}


?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
       
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

        <script>
            function ConfirmDelete() {

                if (confirm('¿Está seguro que desea eliminarlo?')) {

                } else {
                    return false;
                    location:consultarPerfil.php;
                }
            }

            //
            var salir="../login/logout.php"
            function redireccionarInactivo()
            {
            location.href=salir
            }
            setTimeout ("redireccionarInactivo()", 120000000);
       


        </script>

        <title>Perfil</title>

    </head>
    <body>

 <header class="p-3 mb-3 border-bottom">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
                    </a>

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="../menu.php" class="nav-link px-2 link-secondary">Inicio</a></li>
                        <li><a href="../CrudPerfil/consultarPerfil.php" class="nav-link px-2 link-dark">Consultar Perfil</a></li>
                        <li><a href="../CrudPersona/consultarPersona.php" class="nav-link px-2 link-dark">Consultar Personas</a></li>
                        <li><a href="../TiendaOnline.php" class="nav-link px-2 link-dark">Visitar la tienda</a></li>
                        <li><a href="../CrudVuelo/consultarVuelo.php" class="nav-link px-2 link-dark">Consultar vuelo</a></li>
                        <li><a href="#" class="nav-link px-2 link-dark">Consultar productos</a></li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: black;"> 
                                Filtrar información
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../CrudReserva/filtrar.php">Filtrar  por cédula</a></li>
                                <li><a class="dropdown-item" href="../CrudReserva/consultarReserva.php">Filtrar todos</a></li>
                            </ul>
                        </li>

                    </ul>

                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                        <input type="hidden" class="form-control" placeholder="Search..." aria-label="Search">
                    </form>

                    <div class="dropdown text-end">
                        <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu text-small">
                            <li><a class="dropdown-item" href="#">New project...</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../login/logout.php">Cerrar Sessión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

       

        
        <div class="container">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Id </th>
                    <th>Nombre </th>
                    <th>Descripción </th>
                    <th>Editar </th>
                    <?php if($_SESSION['idPerfil'] == 1){ echo "<th>Eliminar</th>"; }     ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql_registe = paginacionPerfil($con);
                $result_register = mysqli_fetch_assoc($sql_registe);
                $total_registro = $result_register['total_registroPerfil'];
                $por_pagina = 5;

                if (empty($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = $_GET['pagina'];
                }

                $desde = ($pagina - 1) * $por_pagina;
                $total_paginas = (int) ceil($total_registro / $por_pagina);

                $query = contarPerfil($con, $desde, $por_pagina);

                $result = mysqli_num_rows($query);

                if ($result > 0) {
                    ?>
                    <?php
                    $idPerfil = null;
                    $consulta = consultarPerfil($con, $idPerfil);

                    while ($fila = mysqli_fetch_assoc($query)) { //almaceno temporal los registros de BBDD
                        ?>
                        <tr >
                            <td> <?php echo $fila['id_perfil'] ?> </td>
                            <td> <?php echo $fila['nombre_perfil'] ?> </td>
                            <td> <?php echo $fila['descripcion_perfil'] ?> </td>

                            <td><a id='ed' href="editarPerfil.php?id=<?php echo $fila['id_perfil'] ?>">Editar </a> </td>
                            <td><a id='el' onclick="return ConfirmDelete()" href="eliminarPerfil.php?id=<?php echo $fila['id_perfil'] ?>" >Eliminar</a></td>

                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
        </div>
        <div align="center"> 
            <nav  aria-label="Page navigation example">
                <ul class="pagination">
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



        
        <div align="center" >
            <a href="../menu.php" ><input type="button" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" value="Regresar"></a>
            <a href="crearPerfil.php" ><input type="button" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" value="Crear Perfil"></a>
        </div>
        
              


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

</body>
</html>


