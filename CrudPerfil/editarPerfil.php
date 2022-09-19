<?php
include "../recursos/Conexion.php";
include "../recursos/FuncionesPerfil.php";
include "../Header/Header.php";

session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location:../index.php");
}

$idPerfil = $_GET['id']; //envio desde consultar 
$resultado = consultarPerfil($con, $idPerfil);

if ($fila = mysqli_fetch_assoc($resultado)) {
    ?>

    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
            <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
            <script>
                var salir = "../login/logout.php"
                function redireccionarInactivo()
                {
                    location.href = salir
                }
                setTimeout("redireccionarInactivo()", 100200200);
            </script>


            <title>Actualizar Perfil</title>             
        </head>
        <body> 
           

            <form  action="" method="POST">
                <h3 align="center">Actualizar Perfil</h3> <br>
                <div class="container">
                    <table > 
                        <div> 
                            <div >
                                <input  type="hidden" name="id" value="<?php echo $fila['id_perfil'] ?>" >
                            </div> 
                            <div class="col-md-6">    
                                <label for="validationDefaultUsername">Nombre</label>
                                <input  type="text"  name="nombre" value="<?php echo $fila['nombre_perfil'] ?>" >
                            </div>
                            <div class="col-md-6">
                                <label for="validationDefaultUsername">Descripción</label>
                                <input   type="text" name="desc" value="<?php echo $fila['descripcion_perfil'] ?>" >
                            </div>
                        </div> 

                    </table>
                </div>
                <br>
                <div align="center" class="container">
                    <div alight="rigth" class="col-md-12">
                        <button  name="actualizar" onclick="return confirm('Seguro de actualizar el registro?')" type="submit" class="btn btn-outline-info" style="background-color: rgb(234,219,228);">Actualizar</button>
                        &nbsp;&nbsp;&nbsp; &nbsp; 
                        <a href="consultarPerfil.php" ><input type="button" class="btn btn-outline-info" style="background-color: rgb(234,219,228);" value="Regresar"></a>
                    </div>
                <?php } ?>
            </div>
        </form>    
    </body>
</html>
<?php
if (isset($_POST['actualizar'])) {
    $idPerfil = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descrip = $_POST['desc'];

    $actualizar = actualizarPerfil($con, $nombre, $descrip, $idPerfil);
    if ($actualizar) {
        header("Location:consultarPerfil.php");
    } else {
        echo "<div class='invalid-feedback'>No fue posible acualizar perfil</div>";
    }
}
?>