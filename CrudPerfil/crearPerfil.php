<?php 
include "../recursos/Conexion.php";
include "../recursos/FuncionesPerfil.php";

session_start();

$ses = (!empty($_GET['id'])) ? $_GET['id'] :0;

if(!isset($_SESSION['idUsuario']) and $ses !=null){
    header("Location:../index.php");
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
        <script>
        
        </script>
            
        <title>Creación de cuenta</title>        
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
                    <a class="nav-link " href="">Consultar Persona</a>
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
        
            
        <form  action="" method="POST">
                <h3 align="center">Creación de Perfil</h3> <br>
                <table align="center" > 
                    <div> 
                        <div >
                            <input  type="hidden" name="id" value="" >
                        </div> 
                        <div class="col-md-4">    
                            <label for="validationDefaultUsername">Nombre</label>
                            <input class="form-control" type="text"  name="nombre" value="" required >
                        </div>
                        <div class="col-md-4">
                            <label for="validationDefaultUsername">Descripción</label>
                            <input  class="form-control" type="text" name="desc" value="" >
                        </div>
                    </div>    
                </table>
                <br>
                <div class="col-12">
                    <a href="consultarPerfil.php" ><input type="button" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" value="Regresar"></a>
              &nbsp;&nbsp;
                    <button  name="crear"  type="submit" class="btn btn-outline-info" style="background-color: rgb(234,219,228);">Crear</button>
                </div>
            
        </form>   
    </body>
</html>
<?php 
if(isset($_REQUEST['crear'])){
    $nombre = $_REQUEST['nombre'];
    $descrip = $_REQUEST['desc'];
    
   
        if(insertarPerfil($con, $nombre, $descripcion)){
            echo "<script> alert('Perfil creado satisfactoriamente'); "
        . "window.location.href='consultarPerfil.php';</script>";
        }else{
           echo "<script> alert('No se logró crear Perfil'); "
        . "window.location.href='consultarPerfil.php';</script>";
        }
}
            

?>